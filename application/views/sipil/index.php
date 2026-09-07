<!-- Custom Styling -->
<link rel="stylesheet" href="<?= base_url('assets/css/tabel.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/modal.css'); ?>">

<!-- Title Panel -->
<div class="page-header">
  <p class="lead" style="font-weight:300; font-size:30px; color:black">Dinas Kependudukan dan Pencatatan Sipil</p>
  <p style="margin-top:10px; font-size:18px">Tabel Data Pasien Terlantar</p>
</div>

<!-- Panel Tabel -->
<div class="content">

  <!-- Filter Pencarian -->
  <div class="filter-panel">
    <div class="filter-panel-head">
      <div class="filter-panel-title"><i class="bi bi-funnel"></i> Filter Pencarian</div>
      <button type="button" class="filter-reset-btn" id="resetFilterBtn">
        <i class="bi bi-arrow-counterclockwise"></i> Reset Filter
      </button>
    </div>
    <div class="filter-panel-body">
      <!-- Cari Nama Pasien -->
      <div class="filter-group filter-group-search">
        <label class="filter-group-label">Cari Nama Pasien</label>
        <div class="filter-search-wrap">
          <i class="bi bi-search"></i>
          <input type="text" id="searchName">
        </div>
      </div>
      <!-- Monthly Filter -->
      <div class="filter-group filter-group-date">
        <div class="filter-date-wrap">
          <div class="filter-date-field">
            <label class="filter-group-label">Mulai Tanggal</label>
            <input type="date" id="startDate">
          </div>
          <span class="filter-date-sep">-</span>
          <div class="filter-date-field">
            <label class="filter-group-label">Sampai Tanggal</label>
            <input type="date" id="endDate">
          </div>
        </div>
      </div>
      <!-- Status Identitas -->
      <div class="filter-group filter-group-select">
        <label class="filter-group-label">Status Identitas</label>
        <select class="filter-select" id="filterIdentity">
          <option value="all">Semua</option>
          <option value="1">Punya Identitas</option>
          <option value="0">Tanpa Identitas</option>
        </select>
      </div>
      <!-- Status Keluarga -->
      <div class="filter-group filter-group-select">
        <label class="filter-group-label">Status Keluarga</label>
        <select class="filter-select" id="filterKeluarga">
          <option value="all">Semua</option>
          <option value="1">Punya Keluarga</option>
          <option value="0">Tanpa Keluarga</option>
        </select>
      </div>
    </div>
  </div>

  <!-- Panel Tabel Data -->
  <div class="panel">

    <!-- Panel Toolbar -->
    <div class="panel-toolbar">
      <div class="rows-picker">
        <span class="rp-label">Tampilkan Data :</span>
        <div class="rp-select-wrap">
          <i class="bi bi-table"></i>
          <!-- Tampilkan Berapa Baris Data -->
          <select class="rp-select" id="rowsPerPage">
            <option value="5" selected>5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Tabel -->
    <table class="data-table">
      <thead>
        <tr>
          <!-- Kode Rekam Medis -->
          <th class="text-center" data-th="no_rm">Kode Rekam Medis</th>
          <!-- Fullname -->
          <th class="text-center" data-th="nama">Nama Pasien</th>
          <!-- Datang Kesini -->
          <th class="sortable" data-col="datang_kesini" data-th="datang_kesini">
            Datang Kesini <i class="bi bi-arrow-down-up sort-icon"></i>
          </th>
          <!-- Kondisi Tiba Pasien -->
          <th class="sortable" data-col="kondisi" data-th="kondisi">
            Kondisi <i class="bi bi-arrow-down-up sort-icon"></i>
          </th>
          <!-- Tanggal Masuk -->
          <th class="sortable" data-col="tanggal_masuk" data-th="tanggal_masuk">
            Tanggal Masuk <i class="bi bi-arrow-down-up sort-icon"></i>
          </th>
          <!-- Jenis Kelamin -->
          <th class="text-center" data-th="jenis_kelamin">Jenis Kelamin</th>
          <!-- Panel Aksi -->
          <th class="col-action"></th>
        </tr>
      </thead>
      <tbody id="tableBody">
        <tr class="empty-row">
          <td colspan="7" class="empty-state">Belum Ada Pasien Terlantar</td>
        </tr>
      </tbody>
    </table>

    <!-- Halaman -->
    <div class="panel-foot">
      <div class="pager" id="pagerContainer"></div>
    </div>
  </div>
</div>

<!-- Data Controller on Historia -->
<script>
  // Variable Data
  window.PASIEN_DATA_URL = '<?= base_url('sipil/historia') ?>';
  // Variable Detail
  window.PASIEN_DETAIL_URL = '<?= base_url('sipil/detail/') ?>';
</script>

<!-- Helper Mainly Script ! -->
<script src="<?= base_url('assets/js/notabel.js'); ?>"></script>