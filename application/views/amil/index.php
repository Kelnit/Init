<!-- Custom Styling -->
<link rel="stylesheet" href="<?= base_url('assets/css/tabel.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/modal.css'); ?>">

<!-- Title Panel -->
<div class="page-header">
  <p class="lead" style="font-weight:300; font-size:30px; color:black">Dinas Sosial</p>
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
      <!-- Rentang Tanggal Pendaftaran -->
      <div class="filter-group filter-group-date">
        <label class="filter-group-label">Rentang Tanggal Pendaftaran</label>
        <div class="filter-date-wrap">
          <input type="date" id="startDate">
          <span class="filter-date-sep">-</span>
          <input type="date" id="endDate">
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
          <th class="text-center">Kode Rekam Medis</th>
          <th class="text-center">Nama Pasien</th>
          <th class="sortable" data-col="datang">Datang Kesini <i class="bi bi-arrow-down-up sort-icon"></i></th>
          <th class="sortable" data-col="kondisi">Kondisi <i class="bi bi-arrow-down-up sort-icon"></i></th>
          <th class="sortable" data-col="regisdate">Tanggal Masuk <i class="bi bi-arrow-down-up sort-icon"></i></th>
          <th class="text-center">Jenis Kelamin</th>
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
  window.PASIEN_DATA_URL = '<?= base_url('amil/historia') ?>';
  // Variable Detail
  window.PASIEN_DETAIL_URL = '<?= base_url('sosial/detail/') ?>';
</script>

<!-- Helper Mainly Script ! -->
<script src="<?= base_url('assets/js/notabel.js'); ?>"></script>