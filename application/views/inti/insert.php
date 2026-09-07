<!-- Custom Styling -->
<link rel="stylesheet" href="<?= base_url('assets/css/insert.css'); ?>">

<!-- Panel Input -->
<div class="form-wrap">
  <form action="<?php echo base_url('inti/publish'); ?>" method="POST">
    <!-- I - Panel Data Pribadi Pasien -->
    <div class="panel">
      <!-- Panel Title -->
      <div class="panel-head page-header-with-badge">
        <div>
          <h2>Data Pasien</h2>
          <p class="lead" style="margin-top:10px">Informasi Identitas dan Kondisi Pasien</p>
        </div>
        <!-- Aksi Cepat : Reset & Autofill Pasien Terlantar -->
        <div class="panel-head-actions">
          <!-- I -->
          <button type="button" class="btn-panel-icon btn-panel-reset" id="btnResetPasien">
            <!-- Kembali -->
            <i class="bi bi-arrow-counterclockwise"></i>
          </button>
          <!-- II -->
          <button type="button" class="btn-panel-icon btn-panel-male" id="btnAutofillPria">
            <!-- Male -->
            <i class="bi bi-gender-male"></i>
          </button>
          <!-- III -->
          <button type="button" class="btn-panel-icon btn-panel-female" id="btnAutofillWanita">
            <!-- Female -->
            <i class="bi bi-gender-female"></i>
          </button>
        </div>
      </div>
      <!-- Input Panel I -->
      <div class="form-grid">
        <!-- Nomor Rekam Medis -->
        <div class="field">
          <label for="mrnInput">Nomor Rekam Medis</label>
          <input type="text" name="patient[mrn]" id="mrnInput" maxlength="9" class="input-locked" readonly>
        </div>
        <!-- Nomor Induk Kependudukan -->
        <div class="field">
          <label for="nikInput">Nomor Induk Kependudukan</label>
          <input type="text" name="patient[nik]" id="nikInput" maxlength="19">
        </div>
        <!-- Fullname -->
        <div class="field">
          <label for="namaInput">Nama Pasien</label>
          <input type="text" name="patient[fullname]" id="namaInput">
        </div>
        <!-- Jenis Kelamin -->
        <div class="field">
          <label for="jenisKelaminInput">Jenis Kelamin</label>
          <div class="select-wrap">
            <i class="bi bi-gender-ambiguous"></i>
            <select name="patient[gender]" id="jenisKelaminInput" required>
              <option selected disabled>Pilih Jenis Kelamin</option>
              <option>Pria</option>
              <option>Wanita</option>
            </select>
          </div>
        </div>
        <!-- Tanggal Lahir : Default Manual | Apabila Button Autofill : Disable : Tahun Saat Ini - Perkiraan Usia -->
        <div class="field" id="dobField">
          <label for="dobInput">Tanggal Lahir</label>
          <input type="date" name="patient[dob]" id="dobInput">
          <small class="field-hint" id="dobHint" style="display:none">Menunggu Perkiraan Usia diisi</small>
        </div>
        <!-- Perkiraan Usia -->
        <div class="field field-required">
          <label for="usiaInput">Perkiraan Usia Pasien</label>
          <input type="text" name="patient[usia]" id="usiaInput" required inputmode="numeric" maxlength="3">
        </div>
        <!-- Agama Pasien -->
        <div class="field">
          <label for="agamaInput">Agama Pasien</label>
          <div class="select-wrap">
            <i class="bi bi-book-half"></i>
            <select name="patient[agama]" id="agamaInput" required>
              <option selected disabled>Pilih Agama</option>
              <option value="Islam">Islam</option>
              <option value="Kristen">Kristen</option>
              <option value="Protestan">Protestan</option>
              <option value="Katolik">Katolik</option>
              <option value="Hindu">Hindu</option>
              <option value="Buddha">Buddha</option>
              <option value="Konghucu">Konghucu</option>
              <option value="Belum Diketahui">Belum Diketahui</option>
            </select>
          </div>
        </div>
        <!-- Datang Kesini -->
        <div class="field">
          <label for="datangKesiniInput">Datang Kesini</label>
          <div class="select-wrap">
            <i class="bi bi-signpost-split"></i>
            <select name="patient[datang]" id="datangKesiniInput" required>
              <option selected disabled>Pilih Datang Kesini</option>
              <option>Diantar</option>
              <option>Sendiri</option>
            </select>
          </div>
        </div>
        <!-- Kondisi Ketika Tiba -->
        <div class="field field-full">
          <label for="kondisiInput">Kondisi Ketika Tiba</label>
          <div class="select-wrap">
            <i class="bi bi-activity"></i>
            <select name="patient[kondisi]" id="kondisiInput" required>
              <option selected disabled>Pilih Kondisi Kedatangan Pasien</option>
              <option>Hidup</option>
              <option>Meninggal</option>
            </select>
          </div>
        </div>
        <!-- Alamat Multi Field Input : Kabupaten & Kota -->
        <div class="field">
          <label for="kabupatenKotaInput">Kabupaten Kota</label>
          <div class="select-wrap">
            <i class="bi bi-geo-alt"></i>
            <select name="patient[kota]" id="kabupatenKotaInput" required>
              <option value="" selected disabled>Pilih Kabupaten Kota</option>
            </select>
          </div>
        </div>
        <!-- Alamat Multi Field Input : Kecamatan -->
        <div class="field">
          <label for="kecamatanInput">Kecamatan</label>
          <div class="select-wrap">
            <i class="bi bi-signpost"></i>
            <select name="patient[kecamatan]" id="kecamatanInput" required disabled>
              <option value="" selected disabled>Pilih Kabupaten/Kota Dahulu</option>
            </select>
          </div>
        </div>
        <!-- Alamat Multi Field Input : Kelurahan -->
        <div class="field">
          <label for="kelurahanInput">Kelurahan</label>
          <div class="select-wrap">
            <i class="bi bi-houses"></i>
            <select name="patient[kelurahan]" id="kelurahanInput" required disabled>
              <option value="" selected disabled>Pilih Kecamatan Dahulu</option>
            </select>
          </div>
        </div>
        <!-- Alamat Multi Field Input : Alamat Jalan -->
        <div class="field">
          <label for="alamatInput">Alamat</label>
          <input type="text" name="patient[alamat]" id="alamatInput">
        </div>
      </div>
    </div>

    <!-- II - Panel Data Social -->
    <div class="panel" id="sosialPanel">
      <div class="panel-head">
        <div>
          <h2>Data Sosial</h2>
          <p class="lead" style="margin-top:10px">Progress Penanganan Kasus Pasien</p>
        </div>
      </div>
      <div class="form-grid form-grid-last">
        <!-- Tanggal Masuk : Autofill Tapi Editable -->
        <div class="field">
          <label for="tanggalMasukInput">Tanggal Masuk</label>
          <input type="date" name="sosial[regisdate]" id="tanggalMasukInput">
        </div>
        <!-- Status Identitas -->
        <div class="field">
          <label for="statusIdentitasInput">Status Identitas</label>
          <select name="sosial[identity]" id="statusIdentitasInput" class="select-plain select-status">
            <option value="1" selected>Identitas Diketahui</option>
            <option value="0">Identitas Tidak Diketahui</option>
          </select>
        </div>
        <!-- Status Keluarga -->
        <div class="field">
          <label for="statusKeluargaInput">Status Keluarga</label>
          <select name="sosial[keluarga]" id="statusKeluargaInput" class="select-plain select-status">
            <option value="1" selected>Pasien Punya Keluarga</option>
            <option value="0">Pasien Tanpa Keluarga</option>
          </select>
        </div>
        <!-- Status Penanganan Medis -->
        <div class="field">
          <label for="statusSelesaiInput">Status Penanganan Medis</label>
          <select name="sosial[selesai]" id="statusSelesaiInput" class="select-plain select-status">
            <option value="0" selected>Belum Selesai Ditangani</option>
            <option value="1">Sudah Selesai Ditangani</option>
          </select>
        </div>

        <!-- Detail Penjemputan -->
        <div class="sosial-divider">
          <span>Detail Penjemputan</span>
          <p>Status Dijemput Baru Bisa Diubah Setelah Status Penanganan Medis "Selesai Ditangani"</p>
        </div>

        <!-- Status Dijemput -->
        <div class="field field-full">
          <label for="statusDijemputInput">Status Dijemput</label>
          <select name="sosial[dijemput]" id="statusDijemputInput" class="select-plain select-status">
            <option value="0" selected>Belum Dijemput</option>
            <option value="1">Sudah Dijemput</option>
          </select>
          <small class="field-hint" id="dijemputGateHint">Menunggu Status Penanganan Medis "Selesai Ditangani"</small>
        </div>
        <!-- Tanggal Jemput -->
        <div class="field">
          <label for="tglJemputInput">Tanggal Jemput</label>
          <input type="date" name="sosial[tgljemput]" id="tglJemputInput">
        </div>
        <!-- Jam Jemput -->
        <div class="field">
          <label for="jamJemputInput">Jam Jemput</label>
          <input type="time" name="sosial[jamjemput]" id="jamJemputInput">
        </div>
        <!-- Penjemput -->
        <div class="field">
          <label for="penjemputInput">Siapa Melakukan Penjemputan</label>
          <input type="text" name="sosial[penjemput]" id="penjemputInput">
        </div>
        <!-- Telephone -->
        <div class="field">
          <label for="telephoneSosialInput">Telepon</label>
          <input type="text" name="sosial[telephone]" id="telephoneSosialInput" maxlength="14">
        </div>
      </div>
    </div>

    <!-- III - Panel Data Pengantar Pasien -->
    <div class="panel" id="pengantarPanel">
      <div class="panel-head">
        <div>
          <h2>Data Pengantar</h2>
          <p class="lead" style="margin-top:10px">Informasi Pihak Pengantar Pasien</p>
        </div>
      </div>
      <div class="form-grid form-grid-last">
        <!-- Nama Pengantar Pasien -->
        <div class="field field-full">
          <label for="namaPengantarInput">Nama Yang Mengantar</label>
          <input type="text" name="pengantar[nama]" id="namaPengantarInput">
        </div>
        <!-- Telephone Pengantar : Side to Side -->
        <div class="field">
          <label for="teleponPengantarInput">Nomor Telepon Yang Dapat Dihubungi</label>
          <input type="text" name="pengantar[telephone]" id="teleponPengantarInput" maxlength="14">
        </div>
        <!-- Telephone Pengantar : Side to Side -->
        <div class="field">
          <label for="teleponPengantarInput2">Nomor Telepon Kedua</label>
          <input type="text" name="pengantar[telephonetwo]" id="teleponPengantarInput2" maxlength="14">
        </div>
        <!-- Keterangan Penemuan Lokasi Pasien Terlantar -->
        <div class="field field-full">
          <label for="lokasiDitemukanInput">Lokasi Ditemukan</label>
          <input type="text" name="pengantar[lokasi]" id="lokasiDitemukanInput">
        </div>
      </div>
    </div>

    <!-- IV - Panel Data Keluarga Pasien -->
    <div class="panel" id="keluargaPanel">
      <div class="panel-head">
        <div>
          <h2>Data Keluarga</h2>
          <p class="lead" style="margin-top:10px">Informasi Kontak Keluarga Pasien</p>
        </div>
      </div>
      <div class="form-grid form-grid-last">
        <!-- Panel Keluarga -->
        <div class="consistency-note field-full" id="keluargaConsistencyNote" style="display:none">
          <i class="bi bi-exclamation-circle"></i>
          Data Keluarga Masih Terisi Sebagian - Lengkapi Semua atau Tandai "Tidak Ada Keluarga" Pada Panel Sosial
        </div>
        <!-- Hubungan Keluarga -->
        <div class="field">
          <label for="hubunganInput">Hubungan Keluarga</label>
          <div class="select-wrap">
            <i class="bi bi-people"></i>
            <select name="keluarga[hubungan]" id="hubunganInput" required>
              <option value="" selected disabled>Pilih Hubungan Keluarga</option>
              <option>Ayah</option>
              <option>Ibu</option>
              <option>Saudara Kandung</option>
              <option>Kakek</option>
              <option>Nenek</option>
              <option>Lain</option>
            </select>
          </div>
        </div>
        <!-- Nama Keluarga -->
        <div class="field">
          <label for="namaKeluargaInput">Nama</label>
          <input type="text" name="keluarga[nama]" id="namaKeluargaInput">
        </div>
        <!-- Telephone Keluarga -->
        <div class="field">
          <label for="teleponKeluargaInput">Nomor Telepon Keluarga</label>
          <input type="text" name="keluarga[telephone]" id="teleponKeluargaInput" maxlength="14">
        </div>
        <!-- Telephone Keluarga Kedua -->
        <div class="field">
          <label for="teleponKeluargaInput2">Nomor Telepon Kedua</label>
          <input type="text" name="keluarga[telephonetwo]" id="teleponKeluargaInput2" maxlength="14">
        </div>
        <!-- Alamat Keluarga -->
        <div class="field field-full">
          <label for="alamatKeluargaInput">Alamat Keluarga</label>
          <input type="text" name="keluarga[alamat]" id="alamatKeluargaInput">
        </div>
      </div>
    </div>

    <!-- Multi Button -->
    <div class="form-actions">
      <!-- Batal Seluruh -->
      <button type="reset" class="btn-reset">
        <i class="bi bi-arrow-counterclockwise"></i>
        Ulang
      </button>
      <!-- Kirim -->
      <button type="submit" class="btn-submit">
        <i class="bi bi-sd-card"></i>
        Kirim
      </button>
    </div>
  </form>
</div>


<!-- Custom Script -->
<script>
  // Helper Alamat Wilayah
  var WILAYAH_API_BASE = "<?= base_url('wilayah'); ?>";
</script>

<!-- Helper Script -->
<script src="<?= base_url('assets/js/insert.js'); ?>"></script>