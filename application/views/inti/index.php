<!-- Custom Styling Tabel -->
<link rel="stylesheet" href="<?= base_url('assets/css/tabel.css'); ?>">
<!-- Custom Styling Modal -->
<link rel="stylesheet" href="<?= base_url('assets/css/modal.css'); ?>">

<!-- Title Panel -->
<div class="page-header">
  <p class="lead" style="font-weight:300; font-size:30px; color:black">Rumah Sakit Umum Pusat Dr. M. Djamil Padang</p>
  <p style="margin-top:10px; font-size:18px">Tabel Data Pasien Terlantar</p>
</div>

<!-- Panel Tabel -->
<div class="content">
  <!-- Specialized Filter Section -->
  <div class="filter-panel">
    <div class="filter-panel-head">
      <div class="filter-panel-title"><i class="bi bi-funnel"></i> Filter Pencarian</div>
      <button type="button" class="filter-reset-btn" id="resetFilterBtn">
        <i class="bi bi-arrow-counterclockwise"></i> Reset Filter
      </button>
    </div>
    <!-- Filter Panel -->
    <div class="filter-panel-body">
      <!-- Cari Pasien Melalui Nama -->
      <div class="filter-group filter-group-search">
        <label class="filter-group-label">Cari Nama Pasien</label>
        <div class="filter-search-wrap">
          <i class="bi bi-search"></i>
          <input type="text" id="searchName">
        </div>
      </div>
      <!-- Monthly Filter -->
      <div class="filter-group filter-group-date">
        <label class="filter-group-label">Rentang Tanggal Pendaftaran</label>
        <div class="filter-date-wrap">
          <input type="date" id="startDate">
          <span class="filter-date-sep">-</span>
          <input type="date" id="endDate">
        </div>
      </div>
      <!-- Identitas Filter -->
      <div class="filter-group filter-group-select">
        <label class="filter-group-label">Status Identitas</label>
        <select class="filter-select" id="filterIdentity">
          <option value="all">Semua</option>
          <option value="1">Punya Identitas</option>
          <option value="0">Tanpa Identitas</option>
        </select>
      </div>
      <!-- Keluarga Filter -->
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

  <!-- Table Panel -->
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
        <!-- Input Pasien Baru -->
        <a href="<?= base_url('inti/insert') ?>" type="button" class="add-btn" title="Tambah data">
          <i class="bi bi-plus-lg"></i>
        </a>
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

<!-- Modal Notif Total Pasien -->
<?php $this->load->view('modal/ranap'); ?>

<!-- Data Controller on Historia -->
<script>
  // Variable Data
  window.PASIEN_DATA_URL = '<?= base_url('inti/historia') ?>';
  // Variable Detail
  window.PASIEN_DETAIL_URL = '<?= base_url('inti/detail/') ?>';
  // Variable Delete
  window.PASIEN_DELETE_URL = '<?= base_url('inti/disable/') ?>';
</script>

<!-- Helper Mainly Script ! -->
<script src="<?= base_url('assets/js/tabel.js'); ?>"></script>