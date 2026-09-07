<!-- Custom Style -->
<link rel="stylesheet" href="<?= base_url('assets/css/sidebar.css'); ?>">

<!-- Controller File -->
<?php $segment = $this->uri->segment(1); ?>

<!-- Panel Sidebar -->
<aside class="sidebar" id="sidebar">
  <!-- Panel Title -->
  <div class="brand">
    <span class="brand-mark">S</span>
    <span class="brand-name">SiPiTER</span>
  </div>
  <nav class="nav">
    <ul class="nav-list">
      <!-- Main File -->
      <?php if (permissible('hub', 'readable')) { ?>
        <li class="nav-item">
          <a href="<?= base_url('hub') ?>" class="nav-link <?= ($segment == 'hub') ? 'active' : '' ?>">
            <i class="bi bi-speedometer2 nav-icon"></i>
            <span class="nav-label">Dashboard</span>
          </a>
        </li>
      <?php } ?>
      <!-- Inti : RSUP Dr. M. Djamil Padang -->
      <?php if (permissible('rsup', 'readable')) { ?>
        <li class="nav-item">
          <a href="<?= base_url('inti') ?>" class="nav-link <?= ($segment == 'inti') ? 'active' : '' ?>">
            <i class="bi bi-hospital-fill nav-icon"></i>
            <span class="nav-label">RSUP Dr. M. Djamil Padang</span>
          </a>
        </li>
      <?php } ?>
      <!-- Dinas Kependudukan dan Pencatatan Sipil Provinsi Sumatera Barat & Kota Kabupaten -->
      <?php if (permissible('sipil', 'readable')) { ?>
        <li class="nav-item" style="display:none">
          <a href="<?= base_url('sipil') ?>" class="nav-link <?= ($segment == 'sipil') ? 'active' : '' ?>">
            <i class="bi bi-person-vcard-fill nav-icon"></i>
            <span class="nav-label">Dinas Kependudukan dan Pencatatan Sipil</span>
          </a>
        </li>
      <?php } ?>
      <!-- Dinas Sosial Provinsi Sumatera Barat & Kota Kabupaten -->
      <?php if (permissible('sosial', 'readable')) { ?>
        <li class="nav-item" style="display:none">
          <a href="<?= base_url('sosial') ?>" class="nav-link <?= ($segment == 'sosial') ? 'active' : '' ?>">
            <i class="bi bi-people-fill nav-icon"></i>
            <span class="nav-label">Dinas Sosial</span>
          </a>
        </li>
      <?php } ?>
      <!-- Badan Amil Zakat Nasional Provinsi Sumatera Barat & Kota Kabupaten -->
      <?php if (permissible('baznas', 'readable')) { ?>
        <li class="nav-item" style="display:none">
          <a href="<?= base_url('amil') ?>" class="nav-link <?= ($segment == 'amil') ? 'active' : '' ?>">
            <i class="bi bi-wallet-fill nav-icon"></i>
            <span class="nav-label">Badan Amil Zakat Nasional</span>
          </a>
        </li>
      <?php } ?>
      <!-- Badan Penyelenggara Jaminan Sosial Provinsi Sumatera Barat & Kota Kabupaten -->
      <?php if (permissible('bpjs', 'readable')) { ?>
        <li class="nav-item" style="display:none">
          <a href="javascript:void(0)" class="nav-link nav-link-disabled" title="Segera hadir" aria-disabled="true">
            <i class="bi bi-wallet-fill nav-icon"></i>
            <span class="nav-label">Badan Penyelenggara Jaminan Sosial</span>
          </a>
        </li>
      <?php } ?>
      <!-- User Aplikasi Sipiter -->
      <?php if (permissible('user', 'readable')) { ?>
        <li class="nav-item">
          <a href="<?= base_url('user') ?>" class="nav-link <?= ($segment == 'user') ? 'active' : '' ?>">
            <i class="bi bi-person-fill nav-icon"></i>
            <span class="nav-label">Data User</span>
          </a>
        </li>
      <?php } ?>
      <!-- Laporan -->
      <li class="nav-item" style="display:none">
        <a href="javascript:void(0)" class="nav-link">
          <i class="bi bi-file-fill nav-icon"></i>
          <span class="nav-label">Laporan</span>
        </a>
      </li>
    </ul>
  </nav>
</aside>