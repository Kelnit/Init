// Section 0 : Apabila Halaman Main File Telah Ready
document.addEventListener('DOMContentLoaded', function () {
  // Section 1 : Variable
  const startInput = document.getElementById('startDate');
  const endInput = document.getElementById('endDate');
  const searchInput = document.getElementById('searchName');
  const rowsSelect = document.getElementById('rowsPerPage');
  const resetBtn = document.getElementById('resetFilterBtn');
  const tableBody = document.getElementById('tableBody');
  const pagerContainer = document.getElementById('pagerContainer');
  const totalCounter = document.getElementById('totalCounter');
  const sortHeaders = document.querySelectorAll('.data-table thead th.sortable');
  const identitySelect = document.getElementById('filterIdentity');
  const keluargaSelect = document.getElementById('filterKeluarga');
  let masterData = [];
  let currentData = [];
  let currentPage = 1;
  let perPage = parseInt(rowsSelect.value, 10);
  let sortColumn = null;
  let sortDir = 'asc';
  let filters = { search: '', identity: 'all', keluarga: 'all' };
  let searchDebounce = null;

  if (!tableBody || !window.PASIEN_DATA_URL) return;

  // Section 2 : Helper Format & Tampilan
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

  function formatDateInput(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  }

  function renderKondisiBadge(kondisi) {
    return kondisi === 'Meninggal'
      ? '<span class="kondisi-meninggal">Meninggal</span>'
      : '<span class="kondisi-hidup">Hidup</span>';
  }

  // Section 3 : Filter Default
  function setDefaultDateRange() {
    const today = new Date();
    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    const startOfNextMonth = new Date(today.getFullYear(), today.getMonth() + 1, 1);
    startInput.value = formatDateInput(startOfMonth);
    endInput.value = formatDateInput(startOfNextMonth);
  }

  function resetFilters() {
    setDefaultDateRange();
    searchInput.value = '';
    identitySelect.value = 'all';
    keluargaSelect.value = 'all';
    filters = { search: '', identity: 'all', keluarga: 'all' };
    applyFilters();
  }

  // Section 4 : Ambil Data
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
          _regisdate: normalizeDate(row.regisdate),
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
        <td colspan="7" class="empty-state">${message}</td>
      </tr>`;
    if (totalCounter) totalCounter.textContent = message;
  }

  // Section 5 : Filter & Order
  function applyFilters() {
    const start = startInput.value;
    const end = endInput.value;
    const query = filters.search.trim().toLowerCase();
    currentData = masterData.filter(row => {
      const inDateRange = (!start || !end) || (row._regisdate >= start && row._regisdate <= end);
      const matchesSearch = !query || row._searchName.includes(query);
      const matchesIdentity = filters.identity === 'all' || String(row.identity) === filters.identity;
      const matchesKeluarga = filters.keluarga === 'all' || String(row.keluarga) === filters.keluarga;
      return inDateRange && matchesSearch && matchesIdentity && matchesKeluarga;
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

  // Section 6 : Render, Tabel, Page, Counter
  function renderTable() {
    if (currentData.length === 0) {
      showMessage('Tidak Ada Data Pasien Terlantar Ditemukan');
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

  function renderRows(rows) {
    const fragment = document.createDocumentFragment();
    rows.forEach(row => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td class="text-center" data-th="no_rm">${escapeHtml(row.mrn)}</td>
        <td class="text-center" data-th="nama">${escapeHtml(row.fullname)}</td>
        <td class="text-center" data-th="datang_kesini">${escapeHtml(row.datang)}</td>
        <td class="text-center" data-th="kondisi">${renderKondisiBadge(row.kondisi)}</td>
        <td class="text-center" data-th="tanggal_masuk">${escapeHtml(row.regisdate)}</td>
        <td class="text-center" data-th="jenis_kelamin">${escapeHtml(row.gender)}</td>
        <td class="col-action text-center">
          <a type="button" class="row-action" onclick="openTujuanRanap('${row.kode}', '${row.mrn}', '${row.fullname}', '${row.lokasi}')">
            <i class="bi bi-door-closed"></i>
          </a>
          <a href="${window.PASIEN_DETAIL_URL}${row.kode}" class="row-action"><i class="bi bi-eye"></i></a>
          <a href="${window.PASIEN_DELETE_URL}${row.kode}" class="row-action"><i class="bi bi-trash"></i></a>
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

  // Section 7 : Event Bindings | Tabel Interaktif Sesuai Filter User
  startInput.addEventListener('change', applyFilters);
  endInput.addEventListener('change', applyFilters);

  searchInput.addEventListener('input', function () {
    clearTimeout(searchDebounce);
    const value = this.value;
    searchDebounce = setTimeout(() => {
      filters.search = value;
      applyFilters();
    }, 250);
  });

  identitySelect.addEventListener('change', function () {
    filters.identity = this.value;
    applyFilters();
  });

  keluargaSelect.addEventListener('change', function () {
    filters.keluarga = this.value;
    applyFilters();
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

  // Section 8 : Init
  setDefaultDateRange();
  loadData();
});

// Section 9 : Modal Tujuan Ranap
function openTujuanRanap(kode, mrn, nama, lokasi) {
  var mrni = '01010101';
  document.getElementById('tujuanRanapKode').value = kode;
  document.getElementById('tujuanRanapMrn').value = mrni;
  document.getElementById('tujuanRanapNama').value = nama;
  document.getElementById('tujuanRanapLokasiSaatIni').value = lokasi;

  var select = document.getElementById('tujuanRanapSelect');

  select.selectedIndex = 0;

  Array.prototype.forEach.call(select.options, function (opt) {
    opt.hidden = false;
    opt.disabled = opt.value === '';
  });

  Array.prototype.forEach.call(select.options, function (opt) {
    if (opt.value === lokasi) {
      opt.hidden = true;
      opt.disabled = true;
    }
  });

  document.getElementById('tujuanRanapModal').showModal();
}

function closeTujuanRanap() {
  // ?
  document.getElementById('tujuanRanapModal').close();
}