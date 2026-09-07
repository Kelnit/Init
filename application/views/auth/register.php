<!-- Custom Style -->
<link rel="stylesheet" href="<?= base_url('assets/css/auth.css'); ?>">

<!-- Daftar Panel -->
<div class="auth-wrapper">
  <div class="auth-card auth-card-register">
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
      <h1 class="auth-title">Buat Akun</h1>
      <p class="auth-subtitle">Daftar Untuk Mulai Menggunakan Sistem</p>
      <form action="<?php echo base_url('auth/publish'); ?>" method="POST" id="registerForm">
        <!-- Fullname -->
        <div class="auth-field auth-field-full">
          <label class="auth-label">Nama Lengkap</label>
          <div class="auth-input-wrap">
            <i class="bi bi-person auth-icon-lead"></i>
            <input type="text" name="fullname" required>
          </div>
        </div>
        <!-- Nomor Induk Kependudukan -->
        <div class="auth-grid-2">
          <div class="auth-field">
            <label class="auth-label">Nomor Induk Kependudukan</label>
            <div class="auth-input-wrap">
              <i class="bi bi-card-text auth-icon-lead"></i>
              <input type="text" name="nik" required>
            </div>
          </div>
          <!-- Nomor Induk Pegawai -->
          <div class="auth-field">
            <label class="auth-label">Nomor Induk Pegawai</label>
            <div class="auth-input-wrap">
              <i class="bi bi-card-text auth-icon-lead"></i>
              <input type="text" name="nip" required>
            </div>
          </div>
        </div>
        <!-- Email & Nomor Telepon -->
        <div class="auth-grid-2">
          <div class="auth-field">
            <label class="auth-label">Electronic Mail</label>
            <div class="auth-input-wrap">
              <i class="bi bi-envelope auth-icon-lead"></i>
              <input type="email" name="email" required>
            </div>
          </div>
          <div class="auth-field">
            <label class="auth-label">Nomor Telepon</label>
            <div class="auth-input-wrap">
              <i class="bi bi-telephone auth-icon-lead"></i>
              <input type="tel" name="phone" required>
            </div>
          </div>
        </div>
        <!-- Jenis Kelamin -->
        <div class="auth-field auth-field-full">
          <label class="auth-label">Jenis Kelamin</label>
          <div class="auth-input-wrap">
            <i class="bi bi-gender-ambiguous auth-icon-lead"></i>
            <select name="gender" required>
              <option disabled selected>Pilih Jenis Kelamin</option>
              <option value="Pria">Pria</option>
              <option value="Wanita">Wanita</option>
            </select>
          </div>
        </div>
        <!-- Instansi -->
        <div class="auth-field auth-field-full">
          <label class="auth-label">Instansi</label>
          <div class="auth-input-wrap">
            <i class="bi bi-building auth-icon-lead"></i>
            <select name="roleKey" id="auth-instansi" required>
              <option disabled selected>Pilih Instansi</option>
              <option value="2">RSUP Dr. M. Djamil Padang</option>
              <option value="3">Dinas Kependudukan dan Catatan Sipil</option>
              <option value="4">Dinas Sosial</option>
              <option value="5">Badan Amil Zakat Nasional</option>
            </select>
          </div>
        </div>
        <!-- Unit -->
        <div class="auth-field auth-field-full" id="auth-wilayah-wrap" style="display: none;">
          <label class="auth-label">Unit</label>
          <div class="auth-input-wrap">
            <i class="bi bi-geo-alt auth-icon-lead"></i>
            <select name="unit" id="auth-wilayah">
              <option disabled selected>Pilih Unit</option>
            </select>
          </div>
        </div>
        <!-- Kata Sandi -->
        <div class="auth-grid-2">
          <div class="auth-field">
            <label class="auth-label">Kata Sandi</label>
            <div class="auth-input-wrap">
              <i class="bi bi-lock auth-icon-lead"></i>
              <input type="password" name="password" id="auth-pw-register" required>
              <button type="button" class="auth-eye-btn" onclick="authOnToggleKataSandi('auth-pw-register', this)">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
          <!-- Konfirmasi Kata Sandi -->
          <div class="auth-field">
            <label class="auth-label">Konfirmasi Kata Sandi</label>
            <div class="auth-input-wrap">
              <i class="bi bi-lock-fill auth-icon-lead"></i>
              <input type="password" id="auth-pw-confirm" required>
              <button type="button" class="auth-eye-btn" onclick="authOnToggleKataSandi('auth-pw-confirm', this)">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Panel Fail -->
        <div id="auth-pw-error" class="auth-error-text"></div>
        <!-- Kirim -->
        <button type="submit" class="auth-submit-btn">Daftar</button>
      </form>
      <!-- Sign In -->
      <p class="auth-foot-link">Sudah Punya Akun ? <a href="<?= base_url('') ?>">Sign In</a></p>
    </div>
  </div>
</div>

<!-- Helper Script -->
<script src="<?= base_url('assets/js/auth.js'); ?>"></script>