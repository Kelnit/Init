<!-- Custom Style -->
<link rel="stylesheet" href="<?= base_url('assets/css/auth.css'); ?>">

<!-- Tombol Petunjuk Teknis — Icon Only, Fixed Pojok Kanan Bawah -->
<a href="<?= base_url('assets/docs/juknis.pdf') ?>" target="_blank" class="auth-help-btn">
  <i class="bi bi-question-circle-fill"></i>
</a>

<!-- Sign In Panel -->
<div class="auth-wrapper">
  <div class="auth-card auth-card-login">
    <!-- Panel Brand -->
    <div class="auth-brand-panel">
      <div class="auth-brand-logo-badge">
        <img src="<?= base_url('assets/sipiter-logo.webp') ?>" alt="Logo Sipiter">
      </div>
      <!-- Title Aplikasi -->
      <div class="auth-brand-panel-copy">
        <strong>SiPiTER</strong>
        <span>Sistem Informasi Pasien Terlantar</span>
      </div>
    </div>
    <!-- Panel Form -->
    <div class="auth-form-panel">
      <h1 class="auth-title">Selamat Datang</h1>
      <p class="auth-subtitle">Silakan Melakukan Sign In</p>
      <form action="<?php echo base_url('auth/login'); ?>" method="POST">
        <!-- Nomor Induk Kependudukan -->
        <div class="auth-field">
          <label class="auth-label">Nomor Induk Kependudukan</label>
          <div class="auth-input-wrap">
            <i class="bi bi-person auth-icon-lead"></i>
            <input type="text" name="usernik" required>
          </div>
        </div>
        <!-- Kata Sandi -->
        <div class="auth-field">
          <label class="auth-label">Kata Sandi</label>
          <div class="auth-input-wrap">
            <i class="bi bi-lock auth-icon-lead"></i>
            <input type="password" name="password" id="auth-pw-login" required>
            <button type="button" class="auth-eye-btn" onclick="authOnToggleKataSandi('auth-pw-login', this)">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>
        <!-- Kirim -->
        <button type="submit" class="auth-submit-btn">Sign In</button>
      </form>
      <!-- Belum Punya Akun -->
      <p class="auth-foot-link">Belum Punya Akun ? <a href="<?= base_url('auth/register') ?>">Silahkan Mendaftar</a></p>
    </div>
  </div>
</div>

<!-- Helper Script -->
<script src="<?= base_url('assets/js/auth.js'); ?>"></script>