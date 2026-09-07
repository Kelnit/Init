document.addEventListener('DOMContentLoaded', function () {
  // ================= SECTION 1 : Referensi Elemen & State =================
  const searchInput = document.getElementById('searchName');
  const rowsSelect = document.getElementById('rowsPerPage');
  const resetBtn = document.getElementById('resetFilterBtn');
  const tableBody = document.getElementById('tableBody');
  const pagerContainer = document.getElementById('pagerContainer');
  const totalCounter = document.getElementById('totalCounter');
  const sortHeaders = document.querySelectorAll('.data-table thead th.sortable');
  const statusGroup = document.getElementById('filterStatusSosial');
  const statusButtons = statusGroup ? Array.prototype.slice.call(statusGroup.querySelectorAll('.dinsos-filter-button')) : [];

  let masterData = [];
  let currentData = [];
  let currentPage = 1;
  let perPage = parseInt(rowsSelect.value, 10);
  let sortColumn = null;
  let sortDir = 'asc';
  let filters = { search: '', status: 'all' };
  let searchDebounce = null;

  if (!tableBody || !window.PASIEN_DATA_URL) return;

  // ================= SECTION 2 : Helper Format & Tampilan =================
  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;');
  }

  function normalizeDate(value) {
    if (!value) return '';
    return String(value).slice(0, 10);
  }

  // Selisih hari dari tglselesai sampai hari ini. null kalau tglselesai kosong.
  function daysSince(dateStr) {
    if (!dateStr) return null;
    const then = new Date(normalizeDate(dateStr) + 'T00:00:00');
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const diffMs = today - then;
    return Math.floor(diffMs / (1000 * 60 * 60 * 24));
  }

  function renderYesNoBadge(isYes, yesLabel, noLabel) {
    return isYes
      ? `<span class="kondisi-hidup">${yesLabel}</span>`
      : `<span class="kondisi-meninggal">${noLabel}</span>`;
  }

  function renderKondisiBadge(kondisi) {
    return kondisi === 'Meninggal'
      ? '<span class="kondisi-meninggal">Meninggal</span>'
      : '<span class="kondisi-hidup">Hidup</span>';
  }

  // ================= SECTION 3 : Filter Default & Reset =================
  function setActiveStatusButton(value) {
    statusButtons.forEach(btn => {
      btn.classList.toggle('dinsos-filter-button-active', btn.dataset.status === value);
    });
  }

  function resetFilters() {
    searchInput.value = '';
    setActiveStatusButton('all');
    filters = { search: '', status: 'all' };
    applyFilters();
  }

  // ================= SECTION 4 : Ambil Data =================
  function loadData() {
    showMessage('Waiting...');
    fetch(window.PASIEN_DATA_URL)
      .then(response => {
        if (!response.ok) throw new Error(`Tidak Dapat Memuat Data (${response.status})`);
        return response.json();
      })
      .then(data => {
        masterData = data.map(row => ({
          ...row,
          _searchName: (row.fullname || '').toLowerCase(),
          _tglselesai: normalizeDate(row.tglselesai),
        }));
        applyFilters();
      })
      .catch(error => {
        showMessage(`Tidak Dapat Memuat Data : ${escapeHtml(error.message)}`);
        pagerContainer.innerHTML = '';
      });
  }

  function showMessage(message) {
    tableBody.innerHTML = `
      <tr class="empty-row">
        <td colspan="8" class="empty-state">${message}</td>
      </tr>`;
    if (totalCounter) totalCounter.textContent = message;
  }

  // ================= SECTION 5 : Filtering & Sorting =================
  // Durasi cuma berlaku buat pasien yang statusnya sudah "Selesai
  // Ditangani" (selesai = 1/true) dan punya tglselesai. Yang belum
  // selesai otomatis gak match filter durasi manapun kecuali "Semua".
  function applyFilters() {
    const query = filters.search.trim().toLowerCase();
    currentData = masterData.filter(row => {
      const matchesSearch = !query || row._searchName.includes(query);
      const matchesStatus = filters.status === 'all'
        || (filters.status === 'identity' && String(row.identity) === '1')
        || (filters.status === 'keluarga' && String(row.keluarga) === '1');
      return matchesSearch && matchesStatus;
    });
    applySort({ toggleDirection: false });
    currentPage = 1;
    renderTable();
  }

  function applySort({ toggleDirection = true } = {}) {
    if (!sortColumn) return;
    if (toggleDirection) {
      sortDir = sortDir === 'asc' ? 'desc' : 'asc';
    }
    const column = sortColumn;
    const direction = sortDir === 'asc' ? 1 : -1;
    currentData = currentData.slice().sort((a, b) => {
      const valA = typeof a[column] === 'string' ? a[column].toLowerCase() : a[column];
      const valB = typeof b[column] === 'string' ? b[column].toLowerCase() : b[column];
      if (valA < valB) return -1 * direction;
      if (valA > valB) return 1 * direction;
      return 0;
    });
    updateSortIcons();
  }

  function updateSortIcons() {
    sortHeaders.forEach(header => {
      const icon = header.querySelector('.sort-icon');
      const isActive = header.dataset.col === sortColumn;
      header.classList.toggle('sorted', isActive);
      icon.className = isActive
        ? `bi sort-icon ${sortDir === 'asc' ? 'bi-sort-up-alt' : 'bi-sort-down'}`
        : 'bi bi-arrow-down-up sort-icon';
    });
  }

  function handleSortHeaderClick(header) {
    const column = header.dataset.col;
    if (sortColumn === column) {
      applySort({ toggleDirection: true });
    } else {
      sortColumn = column;
      sortDir = 'asc';
      applySort({ toggleDirection: false });
    }
    currentPage = 1;
    renderTable();
  }

  // ================= SECTION 6 : Render Tabel, Pagination & Counter =================
  function renderTable() {
    if (currentData.length === 0) {
      showMessage('Tidak Ada Data Pasien Ditemukan');
      pagerContainer.innerHTML = '';
      return;
    }
    const totalPages = Math.ceil(currentData.length / perPage);
    currentPage = Math.min(Math.max(currentPage, 1), totalPages);
    const startIndex = (currentPage - 1) * perPage;
    const pageData = currentData.slice(startIndex, startIndex + perPage);
    renderRows(pageData);
    renderPagination(totalPages);
    renderCounter(pageData.length);
  }

  // Kolom : Nama, Kondisi, Identitas, Keluarga, Selesai Medis, Tanggal
  // Selesai, Kabupaten/Kota, lalu link Detail.
  function renderRows(rows) {
    const fragment = document.createDocumentFragment();
    rows.forEach(row => {
      const tr = document.createElement('tr');
      const isIdentitas = String(row.identity) === '1' || row.identity === true;
      const isKeluarga = String(row.keluarga) === '1' || row.keluarga === true;
      const isSelesai = String(row.selesai) === '1' || row.selesai === true;
      const tglSelesaiText = row._tglselesai ? row._tglselesai : '-';

      tr.innerHTML = `
        <td class="text-center" data-th="nama">${escapeHtml(row.fullname)}</td>
        <td class="text-center" data-th="kondisi">${renderKondisiBadge(row.kondisi)}</td>
        <td class="text-center" data-th="identitas">${renderYesNoBadge(isIdentitas, 'Punya', 'Tanpa')}</td>
        <td class="text-center" data-th="keluarga">${renderYesNoBadge(isKeluarga, 'Punya', 'Tanpa')}</td>
        <td class="text-center" data-th="selesai_medis">${renderYesNoBadge(isSelesai, 'Selesai', 'Belum')}</td>
        <td class="text-center" data-th="tanggal_selesai">${escapeHtml(tglSelesaiText)}</td>
        <td class="text-center" data-th="kabupaten_kota">${escapeHtml(row.kota || '-')}</td>
        <td class="col-action text-center">
          <a href="${window.PASIEN_DETAIL_URL}${row.kode}" class="row-action"><i class="bi bi-eye"></i></a>
        </td>`;
      fragment.appendChild(tr);
    });
    tableBody.innerHTML = '';
    tableBody.appendChild(fragment);
  }

  function renderPagination(totalPages) {
    pagerContainer.innerHTML = '';
    if (totalPages <= 1) return;
    const fragment = document.createDocumentFragment();
    for (let page = 1; page <= totalPages; page++) {
      const button = document.createElement('button');
      button.textContent = page;
      button.classList.toggle('active', page === currentPage);
      button.addEventListener('click', () => {
        currentPage = page;
        renderTable();
      });
      fragment.appendChild(button);
    }
    pagerContainer.appendChild(fragment);
  }

  function renderCounter(shownCount) {
    if (!totalCounter) return;
    const totalFiltered = currentData.length;
    const totalAll = masterData.length;
    const filterNote = totalFiltered !== totalAll
      ? ` (difilter dari total ${totalAll} data)`
      : '';
    totalCounter.textContent = `Menampilkan ${shownCount} dari ${totalFiltered} data${filterNote}`;
  }

  // ================= SECTION 7 : Event Bindings | Tabel Interaktif Sesuai Filter User =================
  searchInput.addEventListener('input', function () {
    clearTimeout(searchDebounce);
    const value = this.value;
    searchDebounce = setTimeout(() => {
      filters.search = value;
      applyFilters();
    }, 250);
  });

  statusButtons.forEach(btn => {
    btn.addEventListener('click', function () {
      filters.status = this.dataset.status;
      setActiveStatusButton(this.dataset.status);
      applyFilters();
    });
  });

  resetBtn.addEventListener('click', resetFilters);

  rowsSelect.addEventListener('change', function () {
    perPage = parseInt(this.value, 10);
    currentPage = 1;
    renderTable();
  });

  sortHeaders.forEach(header => {
    header.addEventListener('click', () => handleSortHeaderClick(header));
  });

  // ================= SECTION 8 : Inisialisasi =================
  loadData();
});