(function () {
  // ================= SECTION 1 : Referensi Elemen =================
  var form = document.querySelector('form');

  var nikInput = document.getElementById('nikInput');
  var namaInput = document.getElementById('namaInput');
  var dobInput = document.getElementById('dobInput');
  var dobHint = document.getElementById('dobHint');
  var agamaInput = document.getElementById('agamaInput');
  var usiaInput = document.getElementById('usiaInput');
  var alamatInput = document.getElementById('alamatInput');
  var kelurahanInput = document.getElementById('kelurahanInput');
  var kecamatanInput = document.getElementById('kecamatanInput');
  var kabupatenKotaInput = document.getElementById('kabupatenKotaInput');
  var datangKesiniInput = document.getElementById('datangKesiniInput');
  var kondisiInput = document.getElementById('kondisiInput');
  var tanggalMasukInput = document.getElementById('tanggalMasukInput');
  var jenisKelaminInput = document.getElementById('jenisKelaminInput');
  var statusIdentitasInput = document.getElementById('statusIdentitasInput');

  var btnResetPasien = document.getElementById('btnResetPasien');
  var btnAutofillPria = document.getElementById('btnAutofillPria');
  var btnAutofillWanita = document.getElementById('btnAutofillWanita');

  var isIdentityUnknown = false;

  var statusDijemputInput = document.getElementById('statusDijemputInput');
  var statusSelesaiInput = document.getElementById('statusSelesaiInput');
  var dijemputGateHint = document.getElementById('dijemputGateHint');
  var tglJemputInput = document.getElementById('tglJemputInput');
  var jamJemputInput = document.getElementById('jamJemputInput');
  var penjemputInput = document.getElementById('penjemputInput');
  var telephoneSosialInput = document.getElementById('telephoneSosialInput');

  var namaPengantarInput = document.getElementById('namaPengantarInput');
  var teleponPengantarInput = document.getElementById('teleponPengantarInput');
  var teleponPengantarInput2 = document.getElementById('teleponPengantarInput2');
  var lokasiDitemukanInput = document.getElementById('lokasiDitemukanInput');

  var hubunganInput = document.getElementById('hubunganInput');
  var namaKeluargaInput = document.getElementById('namaKeluargaInput');
  var statusKeluargaInput = document.getElementById('statusKeluargaInput');
  var teleponKeluargaInput = document.getElementById('teleponKeluargaInput');
  var teleponKeluargaInput2 = document.getElementById('teleponKeluargaInput2');
  var alamatKeluargaInput = document.getElementById('alamatKeluargaInput');
  var keluargaConsistencyNote = document.getElementById('keluargaConsistencyNote');

  // ================= SECTION 2 : Helper Umum =================
  function pad2(n) { return n < 10 ? '0' + n : '' + n; }

  function todayISO() {
    var d = new Date();
    return d.getFullYear() + '-' + pad2(d.getMonth() + 1) + '-' + pad2(d.getDate());
  }

  function formatGroupsOf4(digits) {
    return digits.match(/.{1,4}/g).join('-');
  }

  function bindPhoneFormatting(input, maxDigits) {
    if (!input) return;
    input.addEventListener('input', function () {
      var digits = input.value.replace(/\D/g, '').slice(0, maxDigits);
      input.value = digits.length ? formatGroupsOf4(digits) : '';
    });
  }

  // Select dikunci lewat pointer-events (bukan disabled) supaya value-nya
  // tetap ikut ke-submit.
  function lockField(el) {
    if (!el) return;
    el.classList.add('input-locked');
    el.classList.remove('input-waiting');
    if (el.tagName === 'SELECT') {
      el.style.pointerEvents = 'none';
      el.setAttribute('tabindex', '-1');
      el.setAttribute('aria-disabled', 'true');
    } else {
      el.setAttribute('readonly', 'readonly');
    }
  }

  function unlockField(el) {
    if (!el) return;
    el.classList.remove('input-locked');
    el.classList.remove('input-waiting');
    if (el.tagName === 'SELECT') {
      el.style.pointerEvents = '';
      el.removeAttribute('tabindex');
      el.removeAttribute('aria-disabled');
    } else {
      el.removeAttribute('readonly');
    }
  }

  function lockFields(list) { list.forEach(lockField); }
  function unlockFields(list) { list.forEach(unlockField); }

  // ================= SECTION 3 : Cascade Wilayah (Kabupaten/Kota > Kecamatan > Kelurahan) =================
  // Endpoint controller CI3 "Wilayah", query ke tabel lokal (bukan live
  // call ke wilayah.id). WILAYAH_API_BASE di-set inline di insert.php.
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

  function fillWilayahOptions(select, err, data, notFoundValue, notFoundLabel) {
    select.innerHTML = '';
    select.disabled = false;
    var placeholderLabel = err ? 'Gagal memuat data, coba pilih ulang' : 'Pilih ' + notFoundLabel;
    select.appendChild(buildPlaceholderOption(placeholderLabel));
    select.appendChild(buildWilayahOption(notFoundValue, notFoundLabel));
    if (err) return;
    data
      .slice()
      .sort(function (a, b) { return a.nama.localeCompare(b.nama); })
      .forEach(function (item) {
        select.appendChild(buildWilayahOption(item.nama, item.nama, item.kode));
      });
  }

  function populateKabupatenKota() {
    if (!kabupatenKotaInput) return;
    kabupatenKotaInput.innerHTML = '';
    kabupatenKotaInput.appendChild(buildPlaceholderOption('Memuat Daftar Kabupaten/Kota...'));
    kabupatenKotaInput.disabled = true;
    fetchWilayah('kota', function (err, data) {
      fillWilayahOptions(kabupatenKotaInput, err, data, 'Belum Diketahui', 'Belum Diketahui');
    });
  }

  function populateKecamatan(regencyCode) {
    if (!kecamatanInput) return;
    resetWilayahSelect(kelurahanInput, 'Pilih Kecamatan Dahulu');
    if (!regencyCode) {
      resetWilayahSelect(kecamatanInput, 'Pilih Kabupaten/Kota Dahulu');
      return;
    }
    kecamatanInput.innerHTML = '';
    kecamatanInput.appendChild(buildPlaceholderOption('Memuat Daftar Kecamatan...'));
    kecamatanInput.disabled = true;
    // Titik di kode wilayah (mis. "13.71") diganti "-" di URL, dibalikin di controller.
    fetchWilayah('kecamatan/' + encodeURIComponent(regencyCode.replace(/\./g, '-')), function (err, data) {
      fillWilayahOptions(kecamatanInput, err, data, 'Tidak Diketahui', 'Tidak Diketahui');
    });
  }

  function populateKelurahan(districtCode) {
    if (!kelurahanInput) return;
    if (!districtCode) {
      resetWilayahSelect(kelurahanInput, 'Pilih Kecamatan Dahulu');
      return;
    }
    kelurahanInput.innerHTML = '';
    kelurahanInput.appendChild(buildPlaceholderOption('Memuat Daftar Kelurahan...'));
    kelurahanInput.disabled = true;
    fetchWilayah('kelurahan/' + encodeURIComponent(districtCode.replace(/\./g, '-')), function (err, data) {
      fillWilayahOptions(kelurahanInput, err, data, 'Tidak Diketahui', 'Tidak Diketahui');
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
      populateKecamatan(selected ? selected.dataset.code : null);
    });
  }

  if (kecamatanInput) {
    kecamatanInput.addEventListener('change', function () {
      if (!kecamatanInput.value || kecamatanInput.value === 'Tidak Diketahui') {
        resetWilayahSelect(kelurahanInput, 'Pilih Kecamatan Dahulu');
        return;
      }
      var selected = kecamatanInput.options[kecamatanInput.selectedIndex];
      populateKelurahan(selected ? selected.dataset.code : null);
    });
  }

  populateKabupatenKota();
  resetWilayahSelect(kecamatanInput, 'Pilih Kabupaten/Kota Dahulu');
  resetWilayahSelect(kelurahanInput, 'Pilih Kecamatan Dahulu');

  // ================= SECTION 4 : Default Awal Form =================
  if (tanggalMasukInput) tanggalMasukInput.value = todayISO();
  if (statusSelesaiInput) lockField(statusSelesaiInput); // selalu terkunci di form insert

  if (nikInput) {
    nikInput.addEventListener('input', function () {
      var digits = nikInput.value.replace(/\D/g, '').slice(0, 16);
      nikInput.value = digits.length ? formatGroupsOf4(digits) : '';
    });
  }

  bindPhoneFormatting(teleponPengantarInput, 12);
  bindPhoneFormatting(teleponPengantarInput2, 12);
  bindPhoneFormatting(teleponKeluargaInput, 12);
  bindPhoneFormatting(teleponKeluargaInput2, 12);
  bindPhoneFormatting(telephoneSosialInput, 12);

  // ================= SECTION 5 : Panel Data Pasien =================
  var pasienAutofillFields = [nikInput, namaInput, alamatInput, kelurahanInput, kecamatanInput, kabupatenKotaInput, agamaInput, jenisKelaminInput, statusIdentitasInput];

  // Tanggal Lahir = (tahun sekarang - usia) + tanggal & bulan hari ini.
  function computeDobFromUsia() {
    if (!isIdentityUnknown) return;
    if (!usiaInput || !dobInput) return;
    var usiaVal = parseInt(usiaInput.value, 10);
    if (!isNaN(usiaVal) && usiaVal >= 0 && usiaVal <= 999) {
      var today = new Date();
      var year = today.getFullYear() - usiaVal;
      dobInput.value = year + '-' + pad2(today.getMonth() + 1) + '-' + pad2(today.getDate());
      lockField(dobInput);
      if (dobHint) dobHint.style.display = 'none';
    } else {
      dobInput.value = '';
      dobInput.classList.remove('input-locked');
      dobInput.classList.add('input-waiting');
      dobInput.setAttribute('readonly', 'readonly');
      if (dobHint) dobHint.style.display = '';
    }
  }

  if (usiaInput) {
    usiaInput.addEventListener('input', function () {
      usiaInput.value = usiaInput.value.replace(/\D/g, '').slice(0, 3);
      computeDobFromUsia();
    });
  }

  function autofillPasien(gender) {
    isIdentityUnknown = true;
    if (nikInput) nikInput.value = formatGroupsOf4('0000000000000000');
    if (namaInput) namaInput.value = 'Mr. X';
    if (alamatInput) alamatInput.value = 'Tidak Diketahui';
    if (kelurahanInput) kelurahanInput.value = 'Tidak Diketahui';
    if (kecamatanInput) kecamatanInput.value = 'Tidak Diketahui';
    if (kabupatenKotaInput) kabupatenKotaInput.value = 'Belum Diketahui';
    if (agamaInput) agamaInput.value = 'Belum Diketahui';
    if (jenisKelaminInput) jenisKelaminInput.value = gender === 'pria' ? 'Pria' : 'Wanita';
    if (statusIdentitasInput) statusIdentitasInput.value = '0';
    lockFields(pasienAutofillFields);
    computeDobFromUsia();

    if (datangKesiniInput) {
      datangKesiniInput.value = 'Diantar';
      lockField(datangKesiniInput);
      applyPengantarFromDatang();
    }
    if (statusKeluargaInput) {
      statusKeluargaInput.value = '0';
      applyKeluargaFromStatus();
    }

    if (usiaInput) usiaInput.focus();
  }

  function resetPasien() {
    isIdentityUnknown = false;
    if (nikInput) nikInput.value = '';
    if (namaInput) namaInput.value = '';
    if (agamaInput) agamaInput.selectedIndex = 0;
    if (usiaInput) usiaInput.value = '';
    if (alamatInput) alamatInput.value = '';
    if (kelurahanInput) kelurahanInput.value = '';
    if (kecamatanInput) kecamatanInput.value = '';
    if (kabupatenKotaInput) kabupatenKotaInput.selectedIndex = 0;
    if (datangKesiniInput) {
      datangKesiniInput.selectedIndex = 0;
      unlockField(datangKesiniInput);
      applyPengantarFromDatang();
    }
    if (kondisiInput) kondisiInput.selectedIndex = 0;
    if (jenisKelaminInput) jenisKelaminInput.selectedIndex = 0;
    if (statusIdentitasInput) statusIdentitasInput.value = '1';
    if (statusKeluargaInput) {
      statusKeluargaInput.value = '1';
      applyKeluargaFromStatus();
    }
    unlockFields(pasienAutofillFields);
    unlockField(dobInput);
    if (dobHint) dobHint.style.display = 'none';
    // Tanggal Masuk & Tanggal Lahir sengaja tidak ikut dikosongkan.
  }

  if (btnAutofillPria) btnAutofillPria.addEventListener('click', function () { autofillPasien('pria'); });
  if (btnAutofillWanita) btnAutofillWanita.addEventListener('click', function () { autofillPasien('wanita'); });
  if (btnResetPasien) btnResetPasien.addEventListener('click', resetPasien);

  // ================= SECTION 6 : Panel Sosial (Gerbang Dijemput) =================
  var penjemputanDetailFields = [tglJemputInput, jamJemputInput, penjemputInput, telephoneSosialInput];

  function applyDijemputState() {
    if (!statusDijemputInput) return;
    if (statusDijemputInput.value === '1') {
      unlockFields(penjemputanDetailFields);
    } else {
      if (tglJemputInput) tglJemputInput.value = '';
      if (jamJemputInput) jamJemputInput.value = '';
      if (penjemputInput) penjemputInput.value = '';
      if (telephoneSosialInput) telephoneSosialInput.value = '';
      lockFields(penjemputanDetailFields);
    }
  }

  if (statusDijemputInput) statusDijemputInput.addEventListener('change', applyDijemputState);

  // Gerbang tingkat 1: Status Dijemput cuma bisa diubah kalau Status
  // Penanganan Medis "Selesai" — di form insert ini selalu terkunci
  // "Belum Selesai", jadi blok penjemputan sengaja gak tersentuh di sini.
  function applyDijemputAccessFromSelesai() {
    if (!statusSelesaiInput || !statusDijemputInput) return;
    if (statusSelesaiInput.value === '1') {
      unlockField(statusDijemputInput);
      if (dijemputGateHint) dijemputGateHint.style.display = 'none';
    } else {
      statusDijemputInput.value = '0';
      lockField(statusDijemputInput);
      if (dijemputGateHint) dijemputGateHint.style.display = '';
    }
    applyDijemputState();
  }

  if (statusSelesaiInput) statusSelesaiInput.addEventListener('change', applyDijemputAccessFromSelesai);

  applyDijemputAccessFromSelesai();

  // ================= SECTION 7 : Panel Pengantar =================
  // Mengikuti "Datang Kesini": pilih "Sendiri" -> autofill & kunci; selain
  // itu -> kosongkan & buka kunci.
  var pengantarLockedInputs = [namaPengantarInput, teleponPengantarInput, teleponPengantarInput2, lokasiDitemukanInput];

  function applyPengantarFromDatang() {
    if (!datangKesiniInput) return;
    if (datangKesiniInput.value === 'Sendiri') {
      if (namaPengantarInput) namaPengantarInput.value = 'Pasien Sendiri';
      if (teleponPengantarInput) teleponPengantarInput.value = '0000-0000-0000';
      if (teleponPengantarInput2) teleponPengantarInput2.value = '0000-0000-0000';
      if (lokasiDitemukanInput) lokasiDitemukanInput.value = 'Pasien Tiba Sendiri';
      lockFields(pengantarLockedInputs);
    } else {
      if (namaPengantarInput) namaPengantarInput.value = '';
      if (teleponPengantarInput) teleponPengantarInput.value = '';
      if (teleponPengantarInput2) teleponPengantarInput2.value = '';
      if (lokasiDitemukanInput) lokasiDitemukanInput.value = '';
      unlockFields(pengantarLockedInputs);
    }
  }

  if (datangKesiniInput) datangKesiniInput.addEventListener('change', applyPengantarFromDatang);

  // ================= SECTION 8 : Panel Keluarga =================
  // Status Keluarga (sosial[keluarga]) adalah satu sumber kebenaran untuk
  // seisi panel ini, supaya keduanya gak pernah kontradiksi.
  var keluargaLockedInputs = [hubunganInput, namaKeluargaInput, teleponKeluargaInput, teleponKeluargaInput2, alamatKeluargaInput, statusKeluargaInput];

  function applyKeluargaFromStatus() {
    if (!statusKeluargaInput) return;
    if (statusKeluargaInput.value === '0') {
      if (hubunganInput) hubunganInput.value = 'Lain';
      if (namaKeluargaInput) namaKeluargaInput.value = 'Tidak Ada Keluarga';
      if (teleponKeluargaInput) teleponKeluargaInput.value = formatGroupsOf4('000000000000');
      if (teleponKeluargaInput2) teleponKeluargaInput2.value = formatGroupsOf4('000000000000');
      if (alamatKeluargaInput) alamatKeluargaInput.value = 'Tidak Diketahui Informasi Pasti Alamat Keluarga Pasien';
      lockFields(keluargaLockedInputs);
    } else {
      unlockFields(keluargaLockedInputs);
    }
    checkKeluargaCompleteness();
  }

  // "Lengkap" = Hubungan+Nama+Telepon+Alamat semua terisi, atau semua kosong.
  // Terisi sebagian -> tampilkan pengingat lembut (gak menghalangi submit).
  // Telepon Kedua opsional, sengaja gak dihitung.
  function checkKeluargaCompleteness() {
    if (!keluargaConsistencyNote || !statusKeluargaInput) return;
    if (statusKeluargaInput.value === '0') {
      keluargaConsistencyNote.style.display = 'none';
      return;
    }
    var hasHubungan = !!(hubunganInput && hubunganInput.selectedIndex > 0);
    var hasNama = !!(namaKeluargaInput && namaKeluargaInput.value.trim());
    var hasTelepon = !!(teleponKeluargaInput && teleponKeluargaInput.value.trim());
    var hasAlamat = !!(alamatKeluargaInput && alamatKeluargaInput.value.trim());
    var filledCount = [hasHubungan, hasNama, hasTelepon, hasAlamat].filter(Boolean).length;
    var isPartial = filledCount > 0 && filledCount < 4;
    keluargaConsistencyNote.style.display = isPartial ? '' : 'none';
  }

  if (statusKeluargaInput) statusKeluargaInput.addEventListener('change', applyKeluargaFromStatus);
  if (hubunganInput) hubunganInput.addEventListener('change', checkKeluargaCompleteness);
  if (namaKeluargaInput) namaKeluargaInput.addEventListener('input', checkKeluargaCompleteness);
  if (teleponKeluargaInput) teleponKeluargaInput.addEventListener('input', checkKeluargaCompleteness);
  if (alamatKeluargaInput) alamatKeluargaInput.addEventListener('input', checkKeluargaCompleteness);

  applyKeluargaFromStatus();

  // ================= SECTION 9 : Submit — Bersihkan Format & Cegah Kirim Ganda =================
  // Strip "-" dari NIK/telepon sebelum dikirim, supaya yang tersimpan cuma digit murni.
  var btnSubmit = form ? form.querySelector('.btn-submit') : null;

  if (form) {
    form.addEventListener('submit', function () {
      if (nikInput) nikInput.value = nikInput.value.replace(/\D/g, '');
      if (teleponPengantarInput) teleponPengantarInput.value = teleponPengantarInput.value.replace(/\D/g, '');
      if (teleponPengantarInput2) teleponPengantarInput2.value = teleponPengantarInput2.value.replace(/\D/g, '');
      if (teleponKeluargaInput) teleponKeluargaInput.value = teleponKeluargaInput.value.replace(/\D/g, '');
      if (teleponKeluargaInput2) teleponKeluargaInput2.value = teleponKeluargaInput2.value.replace(/\D/g, '');
      if (telephoneSosialInput) telephoneSosialInput.value = telephoneSosialInput.value.replace(/\D/g, '');

      if (btnSubmit) {
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="bi bi-hourglass-split"></i> Mengirim...';
      }
    });
  }

  // ================= SECTION 10 : Tombol "Ulang" (Perbaikan Native Reset) =================
  // Native reset cuma balikin VALUE ke default HTML, gak tahu soal locking
  // (readonly/pointer-events) atau state JS (isIdentityUnknown). Tanpa ini,
  // klik "Ulang" setelah Autofill bisa ninggalin field kosong tapi terkunci
  // selamanya. Solusi: biarkan reset native jalan dulu, baru susun ulang
  // semua status locking dari nol lewat setTimeout(0).
  if (form) {
    form.addEventListener('reset', function () {
      setTimeout(function () {
        isIdentityUnknown = false;
        unlockFields(pasienAutofillFields);
        if (dobInput) {
          dobInput.classList.remove('input-locked', 'input-waiting');
          dobInput.removeAttribute('readonly');
        }
        if (dobHint) dobHint.style.display = 'none';

        if (tanggalMasukInput) tanggalMasukInput.value = todayISO();

        // Opsi wilayah hasil injeksi JS gak dipahami native reset -> ambil ulang dari awal.
        populateKabupatenKota();
        resetWilayahSelect(kecamatanInput, 'Pilih Kabupaten/Kota Dahulu');
        resetWilayahSelect(kelurahanInput, 'Pilih Kecamatan Dahulu');

        unlockField(datangKesiniInput);

        applyPengantarFromDatang();
        applyKeluargaFromStatus();

        if (statusSelesaiInput) lockField(statusSelesaiInput);
        applyDijemputAccessFromSelesai();

        if (btnSubmit) {
          btnSubmit.disabled = false;
          btnSubmit.innerHTML = '<i class="bi bi-sd-card"></i> Kirim';
        }
      }, 0);
    });
  }
})();