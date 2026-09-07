<!-- Final -->

<!-- Custom Style -->
<link rel="stylesheet" href="<?= base_url('assets/css/topbar.css'); ?>">

<!-- Top Bar -->
<header class="topbar">
  <!-- Toggle Kiri -->
  <div class="topbar-left">
    <button type="button" class="icon-btn" id="sidebarToggle">
      <i class="bi bi-grid-1x2-fill"></i>
    </button>
  </div>
  <!-- Top Bar Kanan -->
  <div class="topbar-right">
    <div class="profile">
      <button type="button" class="profile-trigger" id="profileTrigger">
        <span class="profile-name"><?= $this->session->userdata('name'); ?></span>
      </button>
      <div class="profile-dropdown" id="profileDropdown">
        <!-- Profile -->
        <a href="<?= base_url('profile') ?>" class="profile-item">
          <i class="bi bi-person-circle"></i>
          Profil
        </a>
        <!-- Ganti Kata Sandi -->
        <a href="<?= base_url('profile/password') ?>" class="profile-item">
          <i class="bi bi-key-fill"></i>
          Tukar Kata Sandi
        </a>
        <div class="profile-divider"></div>
        <!-- Keluar -->
        <a href="<?= base_url('auth/logout') ?>" class="profile-item profile-item-danger">
          <i class="bi bi-box-arrow-right"></i>
          Keluar
        </a>
      </div>
    </div>
  </div>
</header>