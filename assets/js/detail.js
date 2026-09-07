(function () {
  // Section 1 : Lock & Unlock Primitif
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

  // Section 2 : Snapshot & Restore Field
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

  // Section 3 : Format Telephone
  function formatPhone(input, maxDigits) {
    if (!input) return;
    input.addEventListener('input', function () {
      var digits = input.value.replace(/\D/g, '').slice(0, maxDigits);
      input.value = digits.length ? digits.match(/.{1,4}/g).join('-') : '';
    });
  }

  // Section 4 : Engine Toggle Panel (Pensil / Batal / Kirim )
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

  // Section 5 : Wilayah
  var kabupatenKotaInput = document.getElementById('kabupatenKotaInput');

  var kecamatanInput = document.getElementById('kecamatanInput');
  
  var kelurahanInput = document.getElementById('kelurahanInput');
  
  var WILAYAH_API_BASE = (typeof window !== 'undefined' && window.WILAYAH_API_BASE) || 'wilayah';

  function buildWilayahOption(value, label, code) {
    var opt = document.createElement('option');
    opt.value = value;
    opt.textContent = label;
    if (code) opt.dataset.code = code;
    return opt;
  }

  function buildPlaceholderOption(label) {
    var opt = buildWilayahOption('', label);
    opt.disabled = true;
    opt.selected = true;
    return opt;
  }

  function resetWilayahSelect(select, placeholderLabel) {
    if (!select) return;
    select.innerHTML = '';
    select.appendChild(buildPlaceholderOption(placeholderLabel));
    select.appendChild(buildWilayahOption('Tidak Diketahui', 'Tidak Diketahui'));
    select.disabled = true;
  }

  function fetchWilayah(endpointPath, callback) {
    fetch(WILAYAH_API_BASE + '/' + endpointPath)
      .then(function (res) {
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.json();
      })
      .then(function (json) { callback(null, Array.isArray(json) ? json : []); })
      .catch(function (err) { callback(err); });
  }

  function fillWilayahOptions(select, err, data, notFoundValue, notFoundLabel, currentValue) {
    select.innerHTML = '';
    select.disabled = false;
    var placeholderLabel = err ? 'Gagal memuat data, coba pilih ulang' : 'Pilih ' + notFoundLabel;
    select.appendChild(buildPlaceholderOption(placeholderLabel));
    select.appendChild(buildWilayahOption(notFoundValue, notFoundLabel));
    var matched = null;
    if (!err) {
      data.slice().sort(function (a, b) { return a.nama.localeCompare(b.nama); }).forEach(function (item) {
        var opt = buildWilayahOption(item.nama, item.nama, item.kode);
        if (currentValue && item.nama === currentValue) {
          opt.selected = true;
          matched = opt;
        }
        select.appendChild(opt);
      });
    }
    return matched;
  }

  function populateKabupatenKotaFor(select, currentValue, onDone) {
    if (!select) return;
    select.innerHTML = '';
    select.appendChild(buildPlaceholderOption('Memuat Daftar Kabupaten/Kota...'));
    select.disabled = true;
    fetchWilayah('kota', function (err, data) {
      var matched = fillWilayahOptions(select, err, data, 'Belum Diketahui', 'Belum Diketahui', currentValue);
      if (onDone) onDone(matched);
    });
  }

  function populateKecamatanFor(select, regencyCode, currentValue, onDone) {
    if (!select) return;
    if (!regencyCode) {
      resetWilayahSelect(select, 'Pilih Kabupaten/Kota Dahulu');
      if (onDone) onDone(null);
      return;
    }
    select.innerHTML = '';
    select.appendChild(buildPlaceholderOption('Memuat Daftar Kecamatan...'));
    select.disabled = true;
    fetchWilayah('kecamatan/' + encodeURIComponent(regencyCode.replace(/\./g, '-')), function (err, data) {
      var matched = fillWilayahOptions(select, err, data, 'Tidak Diketahui', 'Tidak Diketahui', currentValue);
      if (onDone) onDone(matched);
    });
  }

  function populateKelurahanFor(select, districtCode, currentValue) {
    if (!select) return;
    if (!districtCode) {
      resetWilayahSelect(select, 'Pilih Kecamatan Dahulu');
      return;
    }
    select.innerHTML = '';
    select.appendChild(buildPlaceholderOption('Memuat Daftar Kelurahan...'));
    select.disabled = true;
    fetchWilayah('kelurahan/' + encodeURIComponent(districtCode.replace(/\./g, '-')), function (err, data) {
      fillWilayahOptions(select, err, data, 'Tidak Diketahui', 'Tidak Diketahui', currentValue);
    });
  }

  if (kabupatenKotaInput) {
    kabupatenKotaInput.addEventListener('change', function () {
      if (!kabupatenKotaInput.value || kabupatenKotaInput.value === 'Belum Diketahui') {
        resetWilayahSelect(kecamatanInput, 'Pilih Kabupaten/Kota Dahulu');
        resetWilayahSelect(kelurahanInput, 'Pilih Kecamatan Dahulu');
        return;
      }
      var selected = kabupatenKotaInput.options[kabupatenKotaInput.selectedIndex];
      populateKecamatanFor(kecamatanInput, selected ? selected.dataset.code : null, null);
    });
  }

  if (kecamatanInput) {
    kecamatanInput.addEventListener('change', function () {
      if (!kecamatanInput.value || kecamatanInput.value === 'Tidak Diketahui') {
        resetWilayahSelect(kelurahanInput, 'Pilih Kecamatan Dahulu');
        return;
      }
      var selected = kecamatanInput.options[kecamatanInput.selectedIndex];
      populateKelurahanFor(kelurahanInput, selected ? selected.dataset.code : null, null);
    });
  }

  var wilayahResolved = false;
  function resolveWilayahChain() {
    if (wilayahResolved || !kabupatenKotaInput) return;
    wilayahResolved = true;
    var savedKota = kabupatenKotaInput.dataset.current || '';
    var savedKecamatan = kecamatanInput ? kecamatanInput.dataset.current || '' : '';
    var savedKelurahan = kelurahanInput ? kelurahanInput.dataset.current || '' : '';
    populateKabupatenKotaFor(kabupatenKotaInput, savedKota, function (matchedKota) {
      var regencyCode = matchedKota ? matchedKota.dataset.code : null;
      populateKecamatanFor(kecamatanInput, regencyCode, savedKecamatan, function (matchedKecamatan) {
        var districtCode = matchedKecamatan ? matchedKecamatan.dataset.code : null;
        populateKelurahanFor(kelurahanInput, districtCode, savedKelurahan);
      });
    });
  }

  // Section 6 : Panel Data Pasien
  var pasienEditable = fieldsIn('pasienPanel', '.field-editable');
  var pasienAll = fieldsIn('pasienPanel', 'input, select');

  bindPanel('pasien', pasienAll, {
    onOpen: function () {
      unlockAll(pasienEditable);
      resolveWilayahChain();
    },
    onClose: function () { lockAll(pasienEditable); }
  });

  // Section 7 : Panel Data Sosial
  var tanggalMasukInput = document.getElementById('tanggalMasukInput');
  var statusIdentitasInput = document.getElementById('statusIdentitasInput');
  var statusKeluargaInput = document.getElementById('statusKeluargaInput');
  var statusSelesaiInput = document.getElementById('statusSelesaiInput');
  var statusDijemputInput = document.getElementById('statusDijemputInput');
  var dijemputGateHint = document.getElementById('dijemputGateHint');
  var tglJemputInput = document.getElementById('tglJemputInput');
  var jamJemputInput = document.getElementById('jamJemputInput');
  var penjemputInput = document.getElementById('penjemputInput');
  var telephoneSosialInput = document.getElementById('telephoneSosialInput');

  formatPhone(telephoneSosialInput, 12);

  var sosialDirect = [statusIdentitasInput, statusKeluargaInput, statusSelesaiInput].filter(Boolean);

  var penjemputanDetail = [tglJemputInput, jamJemputInput, penjemputInput, telephoneSosialInput].filter(Boolean);
  
  var sosialAll = fieldsIn('sosialPanel', 'input, select');

  function applyDijemputState() {
    if (!statusDijemputInput) return;
    if (statusDijemputInput.value === '1') {
      unlockAll(penjemputanDetail);
    } else {
      penjemputanDetail.forEach(function (el) { el.value = ''; });
      lockAll(penjemputanDetail);
    }
  }

  function applyDijemputAccess() {
    if (!statusSelesaiInput || !statusDijemputInput) return;
    if (statusSelesaiInput.value === '1') {
      setLocked(statusDijemputInput, false);
      if (dijemputGateHint) dijemputGateHint.style.display = 'none';
    } else {
      statusDijemputInput.value = '0';
      setLocked(statusDijemputInput, true);
      if (dijemputGateHint) dijemputGateHint.style.display = '';
    }
    applyDijemputState();
  }

  if (statusSelesaiInput) statusSelesaiInput.addEventListener('change', applyDijemputAccess);

  if (statusDijemputInput) statusDijemputInput.addEventListener('change', applyDijemputState);

  bindPanel('sosial', sosialAll, {
    onOpen: function () {
      unlockAll(sosialDirect);
      applyDijemputAccess();
    },
    onClose: function () {
      lockAll(sosialDirect);
      if (statusDijemputInput) setLocked(statusDijemputInput, true);
      if (dijemputGateHint) dijemputGateHint.style.display = '';
      lockAll(penjemputanDetail);
    }
  });

  // Section 8 : Panel Data Keluarga
  var hubunganInput = document.getElementById('hubunganInput');
  
  var namaKeluargaInput = document.getElementById('namaKeluargaInput');
  
  var teleponKeluargaInput = document.getElementById('teleponKeluargaInput');
  
  var teleponKeluargaInput2 = document.getElementById('teleponKeluargaInput2');
  
  var alamatKeluargaInput = document.getElementById('alamatKeluargaInput');
  
  var keluargaNoFamilyHint = document.getElementById('keluargaNoFamilyHint');

  formatPhone(teleponKeluargaInput, 12);

  formatPhone(teleponKeluargaInput2, 12);

  var keluargaEditable = [hubunganInput, namaKeluargaInput, teleponKeluargaInput, teleponKeluargaInput2, alamatKeluargaInput].filter(Boolean);

  var keluargaToggle = bindPanel('keluarga', keluargaEditable, {
    // ?
    onOpen: function () { unlockAll(keluargaEditable); },
    // ?
    onClose: function () { lockAll(keluargaEditable); }
  });

  function applyKeluargaEditability() {
    if (!statusKeluargaInput || !keluargaToggle) return;
    if (statusKeluargaInput.value === '1') {
      keluargaToggle.editBtn.style.display = '';
      if (keluargaNoFamilyHint) keluargaNoFamilyHint.style.display = 'none';
    } else {
      keluargaToggle.close(true);
      keluargaToggle.editBtn.style.display = 'none';
      if (keluargaNoFamilyHint) keluargaNoFamilyHint.style.display = '';
    }
  }

  if (statusKeluargaInput) statusKeluargaInput.addEventListener('change', applyKeluargaEditability);

  // Section 9 : Kondisi Awal
  lockAll(pasienEditable);
  lockAll(sosialDirect);
  lockAll(penjemputanDetail);
  lockAll(keluargaEditable);
  applyDijemputAccess();
  applyKeluargaEditability();
})();