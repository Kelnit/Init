<!-- Final -->

<!-- Custom Styling -->
<link rel="stylesheet" href="assets/css/profile.css">

<!-- Panel Profile -->
<div class="profile-page">
  <!-- Panel Info -->
  <section class="hero">
    <div class="hero-rays"></div>
    <div class="hero-dot"></div>
    <div class="hero-inner">
      <span class="hero-kicker"><i class="bi bi-person-fill"></i>Data Diri</span>
      <!-- Nama Pasien -->
      <p class="lead hero-name">
        <?php echo htmlspecialchars($result['fullname']); ?>
      </p>
      <br>
      <div class="hero-grid">
        <!-- Nomor Induk Kependudukan -->
        <div class="hero-stat">
          <div class="hero-stat-icon"><i class="bi bi-person-vcard"></i></div>
          <div><div class="hero-stat-cap">Nomor Induk Kependudukan</div><div class="hero-stat-val nik-display">
            <?php echo htmlspecialchars($result['nik']); ?>
          </div></div>
        </div>
        <!-- Nomor Induk Pegawai -->
        <div class="hero-stat">
          <div class="hero-stat-icon"><i class="bi bi-person-vcard"></i></div>
          <div><div class="hero-stat-cap">Nomor Induk Pegawai</div><div class="hero-stat-val nip-display">
            <?php echo htmlspecialchars($result['nip']); ?>
          </div></div>
        </div>
        <!-- Telefon -->
        <div class="hero-stat">
          <div class="hero-stat-icon"><i class="bi bi-telephone"></i></div>
          <div><div class="hero-stat-cap">Telepon</div><div class="hero-stat-val">
            <?php echo htmlspecialchars($result['phone']); ?>
          </div></div>
        </div>
        <!-- Departemen (join roleKey -> role) -->
        <div class="hero-stat">
          <div class="hero-stat-icon"><i class="bi bi-briefcase"></i></div>
          <div><div class="hero-stat-cap">Departemen</div><div class="hero-stat-val">
            <?php echo htmlspecialchars(roletounit($result['roleKey'])); ?>
          </div></div>
        </div>
      </div>
      <!-- Unit -->
      <div class="hero-stat" style="margin-top: 15px;">
        <div class="hero-stat-icon"><i class="bi bi-geo-alt"></i></div>
        <div><div class="hero-stat-cap">Unit</div><div class="hero-stat-val">
          <?php echo htmlspecialchars($result['unit']); ?>
        </div></div>
      </div>
    </div>
  </section>

  <!-- Double Column Kiri Kanan -->
  <form method="post" action="<?= base_url('profile/publish'); ?>" id="profileForm">
    <section class="section">
      <div class="section-head">
        <div class="section-head-left">
          <div class="section-icon"><i class="bi bi-person-lines-fill"></i></div>
          <div>
            <h2>Informasi Dasar</h2>
          </div>
        </div>
        <!-- Pencil : Double Behavior -->
        <button type="button" class="edit-btn" id="btnToggleEdit" onclick="toggleEdit()">
          <i class="bi bi-pencil"></i>
        </button>
      </div>
      <div class="field field-full" style="margin-bottom:10px; display:none">
        <label>Staff Primary Key</label>
        <input type="text" name="kode" class="box" value="<?php echo htmlspecialchars($result['kode']); ?>" readonly>
      </div>
      <div class="grid2">
        <!-- Nomor Induk Kependudukan -->
        <div class="field">
          <label>Nomor Induk Kependudukan</label>
          <input type="text" name="nik" id="nikInput" class="box editable" value="<?php echo htmlspecialchars($result['nik']); ?>" readonly>
        </div>
        <!-- Nomor Induk Pegawai -->
        <div class="field">
          <label>Nomor Induk Pegawai</label>
          <input type="text" name="nip" id="nipInput" class="box editable" value="<?php echo htmlspecialchars($result['nip']); ?>" readonly>
        </div>
        <!-- Nama Profile -->
        <div class="field">
          <label>Nama Lengkap</label>
          <input type="text" name="fullname" class="box editable" value="<?php echo htmlspecialchars($result['fullname']); ?>" readonly>
        </div>
        <!-- Jenis Kelamin -->
        <div class="field">
          <label>Jenis Kelamin</label>
          <select name="gender" class="editable" disabled>
            <option value="Pria" <?php echo ($result['gender'] == 'Pria') ? 'selected' : ''; ?>>Pria</option>
            <option value="Wanita" <?php echo ($result['gender'] == 'Wanita') ? 'selected' : ''; ?>>Wanita</option>
          </select>
        </div>
        <!-- Electronic Mail -->
        <div class="field">
          <label>Electronic Mail</label>
          <input type="text" name="email" class="box editable" value="<?php echo htmlspecialchars($result['email']); ?>" readonly>
        </div>
        <!-- Telephone -->
        <div class="field">
          <label>Telephone</label>
          <input type="text" name="phone" class="box editable" value="<?php echo htmlspecialchars($result['phone']); ?>" readonly>
        </div>
      </div>
      <!-- Unit -->
      <div class="field field-full" style="margin-top:18px">
        <label>Unit</label>
        <select name="unit" disabled>
          <option value="Sumatera Barat" <?php echo ($result['unit'] == 'Sumatera Barat') ? 'selected' : ''; ?>>Sumatera Barat</option>
          <option value="Kota Padang" <?php echo ($result['unit'] == 'Kota Padang') ? 'selected' : ''; ?>>Kota Padang</option>
        </select>
      </div>
      <!-- Tombol Kegiatan -->
      <div class="actions" id="profileActions" style="display: none;">
        <!-- Batal -->
        <button type="reset" class="btn btn-soft" onclick="toggleEdit()">
          Batal
        </button>
        <!-- Kirim -->
        <button type="submit" class="btn btn-care">
          Kirim
        </button>
      </div>
    </section>
  </form>
</div>

<!-- Double Behavior Helper Script -->
<script>
function toggleEdit() {
  const inputs = document.querySelectorAll('.editable');
  const actions = document.getElementById('profileActions');
  const btn = document.getElementById('btnToggleEdit');
  const isEditing = btn.dataset.editing === 'true';

  if (isEditing) {
    inputs.forEach(i => {i.setAttribute('readonly', true); i.setAttribute('disabled', true);});
    actions.style.display = 'none';
    btn.innerHTML = '<i class="bi bi-pencil"></i>';
    btn.dataset.editing = 'false';
  } else {
    inputs.forEach(i => {i.removeAttribute('readonly'); i.removeAttribute('disabled');});
    actions.style.display = 'flex';
    btn.innerHTML = '<i class="bi bi-eye"></i>';
    btn.dataset.editing = 'true';
  }
}
</script>