<!-- Custom Styling -->
<link rel="stylesheet" href="<?= base_url('assets/css/user.css'); ?>">

<!-- Kembali -->
<a href="<?= base_url('user') ?>" class="btn-back">
  <i class="bi bi-door-open"></i> Kembali
</a>

<!-- Panel Detail User -->
<div class="form-wrap">
  <form action="<?= base_url('user/publish') ?>" method="POST" id="userForm" data-panel-form="user">
    <input type="hidden" name="kode" value="<?= $result['kode'] ?>">
    <div class="panel" id="userPanel">
      <div class="panel-head page-header-with-badge">
        <div>
          <h2>Data User</h2>
          <p>Detail Akun Pengguna</p>
        </div>
        <div class="panel-head-actions" data-panel-actions="user">
          <button type="button" class="btn-panel-icon btn-panel-edit" data-edit-panel="user">
            <i class="bi bi-pencil"></i>
          </button>
          <button type="button" class="btn-panel-icon btn-panel-cancel" data-cancel-panel="user" style="display:none">
            <i class="bi bi-x-lg"></i>
          </button>
          <button type="submit" class="btn-panel-icon btn-panel-save" data-submit-panel="user" style="display:none">
            <i class="bi bi-check-lg"></i>
          </button>
        </div>
      </div>

      <div class="form-grid form-grid-last">
        <!-- Nama Lengkap -->
        <div class="auth-field field-full">
          <label class="auth-label">Nama Lengkap</label>
          <div class="auth-input-wrap">
            <i class="bi bi-person auth-icon-lead"></i>
            <input type="text" name="fullname" id="userFullnameInput" class="field-editable" value="<?= $result['fullname'] ?>" readonly>
          </div>
        </div>

        <!-- Nomor Induk Kependudukan -->
        <div class="auth-field">
          <label class="auth-label">Nomor Induk Kependudukan</label>
          <div class="auth-input-wrap">
            <i class="bi bi-card-text auth-icon-lead"></i>
            <input type="text" name="nik" id="userNikInput" value="<?= $result['nik'] ?>" readonly>
          </div>
        </div>

        <!-- Nomor Induk Pegawai -->
        <div class="auth-field">
          <label class="auth-label">Nomor Induk Pegawai</label>
          <div class="auth-input-wrap">
            <i class="bi bi-card-text auth-icon-lead"></i>
            <input type="text" name="nip" id="userNipInput" value="<?= $result['nip'] ?>" readonly>
          </div>
        </div>

        <!-- Electronic Mail -->
        <div class="auth-field">
          <label class="auth-label">Electronic Mail</label>
          <div class="auth-input-wrap">
            <i class="bi bi-envelope auth-icon-lead"></i>
            <input type="email" name="email" id="userEmailInput" class="field-editable" value="<?= $result['email'] ?>" readonly>
          </div>
        </div>

        <!-- Telephone -->
        <div class="auth-field">
          <label class="auth-label">Nomor Telepon</label>
          <div class="auth-input-wrap">
            <i class="bi bi-telephone auth-icon-lead"></i>
            <input type="tel" name="phone" id="userPhoneInput" class="field-editable" value="<?= $result['phone'] ?>" readonly>
          </div>
        </div>

        <!-- Gender -->
        <div class="auth-field">
          <label class="auth-label">Jenis Kelamin</label>
          <div class="auth-input-wrap">
            <i class="bi bi-gender-ambiguous auth-icon-lead"></i>
            <select name="gender" id="userGenderInput" class="field-editable" required>
              <option value="Pria" <?= $result['gender'] === 'Pria' ? 'selected' : '' ?>>Pria</option>
              <option value="Wanita" <?= $result['gender'] === 'Wanita' ? 'selected' : '' ?>>Wanita</option>
            </select>
          </div>
        </div>

        <!-- Role Key & Instansi -->
        <div class="auth-field">
          <label class="auth-label">Instansi</label>
          <div class="auth-input-wrap">
            <i class="bi bi-building auth-icon-lead"></i>
            <select name="roleKey" id="userInstansiInput" disabled>
              <option value="2" <?= (string) $result['roleKey'] === '2' ? 'selected' : '' ?>>RSUP Dr. M. Djamil Padang</option>
              <option value="3" <?= (string) $result['roleKey'] === '3' ? 'selected' : '' ?>>Dinas Kependudukan dan Catatan Sipil</option>
              <option value="4" <?= (string) $result['roleKey'] === '4' ? 'selected' : '' ?>>Dinas Sosial</option>
              <option value="5" <?= (string) $result['roleKey'] === '5' ? 'selected' : '' ?>>Badan Amil Zakat Nasional</option>
            </select>
          </div>
        </div>

        <!-- Unit -->
        <div class="auth-field field-full" id="userUnitWrap" style="<?= empty($result['unit']) ? 'display:none' : '' ?>">
          <label class="auth-label">Unit</label>
          <div class="auth-input-wrap">
            <i class="bi bi-geo-alt auth-icon-lead"></i>
            <select name="unit" id="userUnitInput" class="field-editable" disabled>
              <option value="<?= $result['unit'] ?? '' ?>" selected><?= $result['unit'] ?? '' ?></option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<!-- Helper Script -->
<script>
(function () {
  function setLocked(el, locked) {
    if (!el) return;
    el.classList.toggle('input-locked', locked);
    if (el.tagName === 'SELECT') {
      el.style.pointerEvents = locked ? 'none' : '';
      if (locked) {
        el.setAttribute('tabindex', '-1');
        el.setAttribute('aria-disabled', 'true');
      } else {
        el.removeAttribute('tabindex');
        el.removeAttribute('aria-disabled');
      }
    } else if (locked) {
      el.setAttribute('readonly', 'readonly');
    } else {
      el.removeAttribute('readonly');
    }
  }

  function lockAll(list) { list.forEach(function (el) { setLocked(el, true); }); }

  function unlockAll(list) { list.forEach(function (el) { setLocked(el, false); }); }

  function snapshot(fields) {
    var map = {};
    fields.forEach(function (el) { if (el) map[el.id] = el.value; });
    return map;
  }

  function restore(fields, map) {
    fields.forEach(function (el) {
      if (el && Object.prototype.hasOwnProperty.call(map, el.id)) el.value = map[el.id];
    });
  }

  function fieldsIn(panelId, selector) {
    var panel = document.getElementById(panelId);
    return panel ? Array.prototype.slice.call(panel.querySelectorAll(selector)) : [];
  }

  function bindPanel(name, snapshotFields, hooks) {
    hooks = hooks || {};
    var editBtn = document.querySelector('[data-edit-panel="' + name + '"]');
    if (!editBtn) return null;
    var cancelBtn = document.querySelector('[data-cancel-panel="' + name + '"]');
    var saveBtn = document.querySelector('[data-submit-panel="' + name + '"]');
    var panelEl = editBtn.closest('.panel');
    var snap = {};

    function open() {
      snap = snapshot(snapshotFields);
      if (hooks.onOpen) hooks.onOpen();
      editBtn.style.display = 'none';
      if (cancelBtn) cancelBtn.style.display = '';
      if (saveBtn) saveBtn.style.display = '';
      if (panelEl) panelEl.classList.add('panel--editing');
    }

    function close(shouldRestore) {
      if (shouldRestore) restore(snapshotFields, snap);
      if (hooks.onClose) hooks.onClose();
      editBtn.style.display = '';
      if (cancelBtn) cancelBtn.style.display = 'none';
      if (saveBtn) saveBtn.style.display = 'none';
      if (panelEl) panelEl.classList.remove('panel--editing');
    }

    editBtn.addEventListener('click', open);

    if (cancelBtn) cancelBtn.addEventListener('click', function () { close(true); });

    return { open: open, close: close, editBtn: editBtn };
  }

  var userEditable = fieldsIn('userPanel', '.field-editable');
  
  var userAll = fieldsIn('userPanel', 'input, select');

  bindPanel('user', userAll, {
    onOpen: function () { unlockAll(userEditable); },
    onClose: function () { lockAll(userEditable); }
  });

  lockAll(userEditable);
})();
</script>

<script src="<?= base_url('assets/js/auth.js'); ?>"></script>