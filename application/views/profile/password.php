<!-- Final -->

<!-- Custom Styling -->
<link rel="stylesheet" href="<?= base_url('assets/css/profile.css'); ?>">

<!-- Panel Kata Sandi -->
<div class="password-page">
  <section class="password-card">
    <div class="section-head">
      <div class="section-head-left">
        <!-- Title -->
        <div class="section-icon"><i class="bi bi-shield-lock"></i></div>
        <div>
          <h2>Panel Perubahan Password</h2>
          <span>Perbarui Kata Sandi Akun Anda</span>
        </div>
      </div>
    </div>

    <!-- Panel Input Publish -->
    <form method="post" action="<?= base_url('profile/paslish'); ?>" id="passwordForm">
      <!-- Nomor Induk Kependudukan -->
      <div class="field">
        <label>Nomor Induk Kependudukan</label>
        <input type="text" class="box" name="nik" value="<?= $this->session->userdata('usernik'); ?>" readonly>
      </div>
      <!-- Kata Sandi Baru -->
      <div class="field">
        <label style="padding-top:15px">Password Baru</label>
        <div class="input-group">
          <input type="password" class="box" id="password" name="password" required>
          <span class="password-toggle" onclick="authOnToggleKataSandi('password', this)">
            <i class="bi bi-eye"></i>
          </span>
        </div>
      </div>
      <!-- Konfirmasi Ulang Kata Sandi -->
      <div class="field">
        <label style="padding-top:15px">Konfirmasi Ulang Password</label>
        <div class="input-group">
          <input type="password" class="box" id="confirmPassword" required>
          <span class="password-toggle" onclick="authOnToggleKataSandi('confirmPassword', this)">
            <i class="bi bi-eye"></i>
          </span>
        </div>
        <!-- Pesan Tidak Sama -->
        <small id="passwordError" class="form-error"></small>
      </div>
      <!-- Button Kirim -->
      <div class="actions">
        <button type="submit" class="btn btn-care">
          Simpan Kata Sandi Baru
        </button>
      </div>
    </form>
  </section>
</div>

<!-- Helper Script -->
<script src="<?= base_url('assets/js/auth.js'); ?>"></script>

<!-- Helper Behavior Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  var pwNew = document.getElementById('password');
  var pwConfirm = document.getElementById('confirmPassword');
  var pwError = document.getElementById('passwordError');
  var passwordForm = document.getElementById('passwordForm');
  if (!pwNew || !pwConfirm || !pwError || !passwordForm) return;
  function cekKecocokan() {
    if (pwConfirm.value && pwConfirm.value !== pwNew.value) {
      pwError.textContent = 'Kata Sandi Tidak Sama !';
      pwConfirm.classList.add('is-invalid');
    } else {
      pwError.textContent = '';
      pwConfirm.classList.remove('is-invalid');
    }
  }
  pwConfirm.addEventListener('input', cekKecocokan);
  pwNew.addEventListener('input', cekKecocokan);
  passwordForm.addEventListener('submit', function (e) {
    if (pwNew.value !== pwConfirm.value) {
      e.preventDefault();
      pwError.textContent = 'Pastikan Kata Sandi Sudah Cocok Sebelum Disimpan !';
      pwConfirm.focus();
    }
  });
});
</script>