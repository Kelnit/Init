<!-- Custom Styling -->
<link rel="stylesheet" href="<?= base_url('assets/css/user.css'); ?>">

<!-- Kembali -->
<a href="<?= base_url('user') ?>" class="btn-back">
  <i class="bi bi-door-open"></i> Kembali
</a>

<!-- Panel Input -->
<div class="form-wrap">
  <form action="<?= base_url('auth/publish') ?>" method="POST" id="registerForm">
    <div class="panel">
      <div class="panel-head">
        <h2>Data User</h2>
        <p>Lengkapi Seluruh Data Input</p>
      </div>

      <div class="form-grid form-grid-last">
        <!-- Nama Lengkap -->
        <div class="auth-field field-full field-required">
          <label class="auth-label">Nama Lengkap</label>
          <div class="auth-input-wrap">
            <i class="bi bi-person auth-icon-lead"></i>
            <input type="text" name="fullname" required>
          </div>
        </div>

        <!-- NIK -->
        <div class="auth-field field-required">
          <label class="auth-label">Nomor Induk Kependudukan</label>
          <div class="auth-input-wrap">
            <i class="bi bi-card-text auth-icon-lead"></i>
            <input type="text" name="nik" required>
          </div>
        </div>

        <!-- NIP -->
        <div class="auth-field field-required">
          <label class="auth-label">Nomor Induk Pegawai</label>
          <div class="auth-input-wrap">
            <i class="bi bi-card-text auth-icon-lead"></i>
            <input type="text" name="nip" required>
          </div>
        </div>

        <!-- Email -->
        <div class="auth-field field-required">
          <label class="auth-label">Electronic Mail</label>
          <div class="auth-input-wrap">
            <i class="bi bi-envelope auth-icon-lead"></i>
            <input type="email" name="email" required>
          </div>
        </div>

        <!-- Phone -->
        <div class="auth-field field-required">
          <label class="auth-label">Nomor Telepon</label>
          <div class="auth-input-wrap">
            <i class="bi bi-telephone auth-icon-lead"></i>
            <input type="tel" name="phone" required>
          </div>
        </div>

        <!-- Gender -->
        <div class="auth-field field-required">
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
        <div class="auth-field field-required">
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
        <div class="auth-field field-full field-required" id="auth-wilayah-wrap" style="display: none;">
          <label class="auth-label">Unit</label>
          <div class="auth-input-wrap">
            <i class="bi bi-geo-alt auth-icon-lead"></i>
            <select name="unit" id="auth-wilayah">
              <option disabled selected>Pilih Unit</option>
            </select>
          </div>
        </div>

        <!-- Kata Sandi -->
        <div class="auth-field field-required">
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
        <div class="auth-field field-required">
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

      <div id="auth-pw-error" class="auth-error-text" style="padding: 0 28px 20px;"></div>

      <div class="form-actions">
        <button type="reset" class="btn-reset">
          <i class="bi bi-arrow-counterclockwise"></i> Reset
        </button>
        <button type="submit" class="btn-submit">
          <i class="bi bi-check-lg"></i> Simpan
        </button>
      </div>
    </div>
  </form>
</div>

<!-- Helper Script -->
<script src="<?= base_url('assets/js/auth.js'); ?>"></script>