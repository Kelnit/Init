var authWarnaAktif = '#2196F3';

function authToggleKataSandi(inputId, btn) {
  var input = document.getElementById(inputId);
  var isHidden = input.type === 'password';
  input.type = isHidden ? 'text' : 'password';
  return isHidden;
}

function authOnToggleKataSandi(inputId, btn) {
  var terlihat = authToggleKataSandi(inputId, btn);
  var icon = btn.querySelector('i');
  btn.style.color = terlihat ? authWarnaAktif : '';
  icon.className = terlihat ? 'bi bi-eye-slash' : 'bi bi-eye';
}

document.addEventListener('DOMContentLoaded', function () {
  var instansiSelect = document.getElementById('auth-instansi');
  var wilayahWrap = document.getElementById('auth-wilayah-wrap');
  var wilayahSelect = document.getElementById('auth-wilayah');
  if (!instansiSelect || !wilayahWrap) return;

  var unitOptionsByInstansi = {
    '2': {
      label: 'Unit',
      placeholder: 'Pilih Unit',
      options: [
        'Instalasi Gawat Darurat',
        'Tata Usaha',
        'Instalasi Rekam Medis',
        'Instalasi Sistem Informasi Manajemen Rumah Sakit'
      ]
    },
    '3': {
      label: 'Unit',
      placeholder: 'Pilih Unit',
      options: [
        'Sumatera Barat',
        'Kota Padang',
        'Kota Padang Panjang',
        'Kota Pariaman',
        'Kota Payakumbuh',
        'Kota Bukittinggi',
        'Kota Sawahlunto',
        'Kota Solok',
        'Kabupaten Agam',
        'Kabupaten Dharmasraya',
        'Kabupaten Kepulauan Mentawai',
        'Kabupaten Lima Puluh Kota',
        'Kabupaten Padang Pariaman',
        'Kabupaten Pasaman',
        'Kabupaten Pasaman Barat',
        'Kabupaten Pesisir Selatan',
        'Kabupaten Sijunjung',
        'Kabupaten Solok',
        'Kabupaten Solok Selatan',
        'Kabupaten Tanah Datar'
      ]
    }
  };
  unitOptionsByInstansi['4'] = unitOptionsByInstansi['3'];
  unitOptionsByInstansi['5'] = unitOptionsByInstansi['3'];

  var wilayahLabel = wilayahWrap.querySelector('.auth-label');

  function authIsiOpsiUnit(config) {
    wilayahSelect.innerHTML = '';
    var placeholderOpt = document.createElement('option');
    placeholderOpt.disabled = true;
    placeholderOpt.selected = true;
    placeholderOpt.textContent = config.placeholder;
    wilayahSelect.appendChild(placeholderOpt);
    config.options.forEach(function (opt) {
      var el = document.createElement('option');
      el.value = opt;
      el.textContent = opt;
      wilayahSelect.appendChild(el);
    });
    if (wilayahLabel) wilayahLabel.textContent = config.label;
  }

  instansiSelect.addEventListener('change', function () {
    var config = unitOptionsByInstansi[this.value];
    var perluWilayah = !!config;
    wilayahWrap.style.display = perluWilayah ? 'block' : 'none';
    wilayahSelect.required = perluWilayah;
    if (perluWilayah) {
      authIsiOpsiUnit(config);
    } else {
      wilayahSelect.innerHTML = '<option disabled selected>Pilih Unit</option>';
    }
  });
  var pwInput = document.getElementById('auth-pw-register');
  var confirmInput = document.getElementById('auth-pw-confirm');
  var errBox = document.getElementById('auth-pw-error');
  if (pwInput && confirmInput && errBox) {
    confirmInput.addEventListener('input', function () {
      if (this.value && this.value !== pwInput.value) {
        errBox.textContent = 'Kata Sandi Tidak Sama !';
      } else {
        errBox.textContent = '';
      }
    });
  }
  var registerForm = document.getElementById('registerForm');
  function authTampilkanErrorField(field, pesan) {
    var wrap = field.closest('.auth-field') || field.parentElement;
    var errEl = wrap.querySelector('.auth-field-error');
    if (!errEl) {
      errEl = document.createElement('div');
      errEl.className = 'auth-error-text auth-field-error';
      wrap.appendChild(errEl);
    }
    errEl.textContent = pesan || '';
  }
  function authBersihkanErrorField(field) {
    authTampilkanErrorField(field, '');
  }
  function authValidasiFormRegister() {
    var wajibDiisi = registerForm.querySelectorAll('[required]');
    var semuaValid = true;
    var fieldPertamaSalah = null;
    wajibDiisi.forEach(function (field) {
      var kosong = !field.value || (field.tagName === 'SELECT' && field.selectedIndex <= 0);
      if (kosong) {
        authTampilkanErrorField(field, 'Kolom Ini Wajib Diisi !');
        semuaValid = false;
        if (!fieldPertamaSalah) fieldPertamaSalah = field;
      } else {
        authBersihkanErrorField(field);
      }
    });
    if (fieldPertamaSalah) {
      fieldPertamaSalah.scrollIntoView({ behavior: 'smooth', block: 'center' });
      fieldPertamaSalah.focus();
    }
    return semuaValid;
  }
  if (registerForm) {
    registerForm.querySelectorAll('[required]').forEach(function (field) {
      var event = field.tagName === 'SELECT' ? 'change' : 'input';
      field.addEventListener(event, function () {
        authBersihkanErrorField(field);
      });
    });
  }
  if (registerForm) {
    registerForm.addEventListener('submit', function (e) {
      var wajibOk = authValidasiFormRegister();
      var pass = pwInput.value;
      var confirm = confirmInput.value;
      if (pass !== confirm) {
        e.preventDefault();
        errBox.textContent = 'Pastikan Kata Sandi Sudah Cocok Sebelum Mendaftar !';
        return;
      }
      if (!wajibOk) {
        e.preventDefault();
      }
    });
  }
});