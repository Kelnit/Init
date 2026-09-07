<!-- Custom Styling -->
<link rel="stylesheet" href="<?= base_url('assets/css/insert.css'); ?>">

<!-- Panel Selesai !? -->
<?php if ((string) ($sosial['selesai'] ?? '0') === '1'): ?>
  <div class="page-status-banner page-status-banner-selesai">
    <i class="bi bi-check-circle-fill"></i>
    Kasus Pasien ini Sudah Selesai Ditangani !
  </div>
<?php endif; ?>

<!-- Panel Detail -->
<div class="form-wrap">
  <!-- I -->
  <form action="<?php echo base_url('inti/repatient'); ?>" method="POST" class="panel-form" id="formPasien" data-panel-form="pasien">
    <div class="panel" id="pasienPanel">
      <!-- Panel Title -->
      <div class="panel-head page-header-with-badge">
        <div>
          <h2>Data Pasien</h2>
          <p class="lead" style="margin-top:10px">Informasi Identitas dan Kondisi Pasien</p>
        </div>
        <!-- Aksi Panel : Pensil <-> Batal & Kirim -->
        <div class="panel-head-actions" data-panel-actions="pasien">
          <button type="button" class="btn-panel-icon btn-panel-edit" data-edit-panel="pasien">
            <i class="bi bi-pencil"></i>
          </button>
          <button type="button" class="btn-panel-icon btn-panel-cancel" data-cancel-panel="pasien" style="display:none">
            <i class="bi bi-x-lg"></i>
          </button>
          <button type="submit" class="btn-panel-icon btn-panel-save" data-submit-panel="pasien" style="display:none">
            <i class="bi bi-check-lg"></i>
          </button>
        </div>
      </div>
      <div class="form-grid">
        <!-- Kode Pasien -->
        <div class="field field-full field-code">
          <label for="kodePasienInput"> Kode Pasien</label>
          <input type="text" name="patient[kode]" id="kodePasienInput" value="<?= $patient['kode'] ?>" readonly>
        </div>
        <!-- Nomor Rekam Medis -->
        <div class="field">
          <label for="mrnInput">Nomor Rekam Medis</label>
          <input type="text" name="patient[mrn]" id="mrnInput" maxlength="9" value="<?= $patient['mrn'] ?>" readonly>
        </div>
        <!-- Nomor Induk Kependudukan -->
        <div class="field">
          <label for="nikInput">Nomor Induk Kependudukan</label>
          <input type="text" name="patient[nik]" id="nikInput" maxlength="19" value="<?= $patient['nik'] ?>" readonly>
        </div>
        <!-- Fullname -->
        <div class="field">
          <label for="namaInput">Nama Pasien</label>
          <input type="text" name="patient[fullname]" id="namaInput" class="field-editable" value="<?= $patient['fullname'] ?>" readonly>
        </div>
        <!-- Jenis Kelamin -->
        <div class="field">
          <label for="jenisKelaminInput">Jenis Kelamin</label>
          <div class="select-wrap">
            <i class="bi bi-gender-ambiguous"></i>
            <select name="patient[gender]" id="jenisKelaminInput" class="field-editable" required>
              <option disabled <?= empty($patient['gender']) ? 'selected' : '' ?>>Pilih Jenis Kelamin</option>
              <option <?= $patient['gender'] === 'Pria' ? 'selected' : '' ?>>Pria</option>
              <option <?= $patient['gender'] === 'Wanita' ? 'selected' : '' ?>>Wanita</option>
            </select>
          </div>
        </div>
        <!-- Tanggal Lahir -->
        <div class="field" id="dobField">
          <label for="dobInput">Tanggal Lahir</label>
          <input type="date" name="patient[dob]" id="dobInput" class="field-editable" value="<?= safe_date($patient['dob'] ?? '') ?>" readonly>
        </div>
        <!-- Perkiraan Usia -->
        <div class="field field-required">
          <label for="usiaInput">Perkiraan Usia Pasien</label>
          <input type="text" name="patient[usia]" id="usiaInput" class="field-editable" required inputmode="numeric" maxlength="3" value="<?= $patient['usia'] ?>" readonly>
        </div>
        <!-- Agama Pasien -->
        <div class="field">
          <label for="agamaInput">Agama Pasien</label>
          <div class="select-wrap">
            <i class="bi bi-book-half"></i>
            <select name="patient[agama]" id="agamaInput" class="field-editable" required>
              <?= rolerReligion($patient['agama'] ?? null) ?>
            </select>
          </div>
        </div>
        <!-- Datang Kesini -->
        <div class="field">
          <label for="datangKesiniInput">Datang Kesini</label>
          <div class="select-wrap">
            <i class="bi bi-signpost-split"></i>
            <select name="patient[datang]" id="datangKesiniInput" required>
              <option disabled <?= empty($patient['datang']) ? 'selected' : '' ?>>Pilih Datang Kesini</option>
              <option <?= $patient['datang'] === 'Diantar' ? 'selected' : '' ?>>Diantar</option>
              <option <?= $patient['datang'] === 'Sendiri' ? 'selected' : '' ?>>Sendiri</option>
            </select>
          </div>
        </div>
        <!-- Kondisi Ketika Tiba -->
        <div class="field">
          <label for="kondisiInput">Kondisi Ketika Tiba</label>
          <div class="select-wrap">
            <i class="bi bi-activity"></i>
            <select name="patient[kondisi]" id="kondisiInput" class="field-editable" required>
              <option disabled <?= empty($patient['kondisi']) ? 'selected' : '' ?>>Pilih Kondisi Kedatangan Pasien</option>
              <option <?= $patient['kondisi'] === 'Hidup' ? 'selected' : '' ?>>Hidup</option>
              <option <?= $patient['kondisi'] === 'Meninggal' ? 'selected' : '' ?>>Meninggal</option>
            </select>
          </div>
        </div>
        <!-- Lokasi -->
        <div class="field">
          <label for="lokasiInput">Lokasi</label>
          <input type="text" name="patient[lokasi]" id="lokasiInput" class="field-editable" value="<?= $patient['lokasi'] ?? '' ?>" readonly>
        </div>
        <!-- Alamat : Kabupaten Kota -->
        <div class="field">
          <label for="kabupatenKotaInput">Kabupaten Kota</label>
          <div class="select-wrap">
            <i class="bi bi-geo-alt"></i>
            <select name="patient[kota]" id="kabupatenKotaInput" class="field-editable" data-current="<?= htmlspecialchars($patient['kota'] ?? '') ?>" required>
              <option value="<?= htmlspecialchars($patient['kota'] ?? '') ?>" selected><?= htmlspecialchars($patient['kota'] ?? '') ?></option>
            </select>
          </div>
        </div>
        <!-- Alamat : Kecamatan -->
        <div class="field">
          <label for="kecamatanInput">Kecamatan</label>
          <div class="select-wrap">
            <i class="bi bi-signpost"></i>
            <select name="patient[kecamatan]" id="kecamatanInput" class="field-editable" data-current="<?= htmlspecialchars($patient['kecamatan'] ?? '') ?>" required>
              <option value="<?= htmlspecialchars($patient['kecamatan'] ?? '') ?>" selected><?= htmlspecialchars($patient['kecamatan'] ?? '') ?></option>
            </select>
          </div>
        </div>
        <!-- Alamat : Kelurahan -->
        <div class="field">
          <label for="kelurahanInput">Kelurahan</label>
          <div class="select-wrap">
            <i class="bi bi-houses"></i>
            <select name="patient[kelurahan]" id="kelurahanInput" class="field-editable" data-current="<?= htmlspecialchars($patient['kelurahan'] ?? '') ?>" required>
              <option value="<?= htmlspecialchars($patient['kelurahan'] ?? '') ?>" selected><?= htmlspecialchars($patient['kelurahan'] ?? '') ?></option>
            </select>
          </div>
        </div>
        <!-- Alamat : Jalan / RT-RW -->
        <div class="field">
          <label for="alamatInput">Alamat</label>
          <input type="text" name="patient[alamat]" id="alamatInput" class="field-editable" value="<?= $patient['alamat'] ?>" readonly>
        </div>
      </div>
    </div>
  </form>

  <!-- II - Panel Data Sosial -->
  <form action="<?php echo base_url('inti/resocial'); ?>" method="POST" class="panel-form" id="formSosial" data-panel-form="sosial">
    <div class="panel" id="sosialPanel">
      <div class="panel-head page-header-with-badge">
        <div>
          <h2>Data Sosial</h2>
          <p class="lead" style="margin-top:10px">Progress Penanganan Kasus Pasien</p>
        </div>
        <div class="panel-head-actions" data-panel-actions="sosial">
          <button type="button" class="btn-panel-icon btn-panel-edit" data-edit-panel="sosial" title="Ubah Data Sosial" aria-label="Ubah Data Sosial">
            <i class="bi bi-pencil"></i>
          </button>
          <button type="button" class="btn-panel-icon btn-panel-cancel" data-cancel-panel="sosial" title="Batal" aria-label="Batal" style="display:none">
            <i class="bi bi-x-lg"></i>
          </button>
          <button type="submit" class="btn-panel-icon btn-panel-save" data-submit-panel="sosial" title="Kirim" aria-label="Kirim" style="display:none">
            <i class="bi bi-check-lg"></i>
          </button>
        </div>
      </div>
      <div class="form-grid form-grid-last">
        <!-- Kode Sosial -->
        <div class="field field-full field-code">
          <label for="kodeSosialInput"> Kode Data Sosial</label>
          <input type="text" name="sosial[patientKey]" id="kodeSosialInput" value="<?= $sosial['patientKey'] ?? '' ?>" readonly>
        </div>
        <!-- Tanggal Masuk -->
        <div class="field">
          <label for="tanggalMasukInput">Tanggal Masuk</label>
          <input type="date" name="sosial[regisdate]" id="tanggalMasukInput" value="<?= $sosial['regisdate'] ?? '' ?>" readonly>
        </div>
        <!-- Status Identitas -->
        <div class="field">
          <label for="statusIdentitasInput">Status Identitas</label>
          <select name="sosial[identity]" id="statusIdentitasInput" class="select-plain select-status field-editable">
            <option value="1" <?= (string) ($sosial['identity'] ?? '1') === '1' ? 'selected' : '' ?>>Identitas Diketahui</option>
            <option value="0" <?= (string) ($sosial['identity'] ?? '1') === '0' ? 'selected' : '' ?>>Identitas Tidak Diketahui</option>
          </select>
        </div>
        <!-- Status Keluarga -->
        <div class="field">
          <label for="statusKeluargaInput">Status Keluarga</label>
          <select name="sosial[keluarga]" id="statusKeluargaInput" class="select-plain select-status field-editable">
            <option value="1" <?= (string) ($sosial['keluarga'] ?? '1') === '1' ? 'selected' : '' ?>>Pasien Punya Keluarga</option>
            <option value="0" <?= (string) ($sosial['keluarga'] ?? '1') === '0' ? 'selected' : '' ?>>Pasien Tanpa Keluarga</option>
          </select>
        </div>
        <!-- Status Penanganan Medis -->
        <div class="field">
          <label for="statusSelesaiInput">Status Penanganan Medis</label>
          <select name="sosial[selesai]" id="statusSelesaiInput" class="select-plain select-status field-editable">
            <option value="0" <?= (string) ($sosial['selesai'] ?? '0') === '0' ? 'selected' : '' ?>>Belum Selesai Ditangani</option>
            <option value="1" <?= (string) ($sosial['selesai'] ?? '0') === '1' ? 'selected' : '' ?>>Sudah Selesai Ditangani</option>
          </select>
        </div>

        <div class="sosial-divider">
          <span>Detail Penjemputan</span>
          <p>Status Dijemput Baru Bisa Diubah Setelah Status Penanganan Medis "Selesai Ditangani"</p>
        </div>

        <!-- Status Dijemput -->
        <div class="field field-full">
          <label for="statusDijemputInput">Status Dijemput</label>
          <select name="sosial[dijemput]" id="statusDijemputInput" class="select-plain select-status">
            <option value="0" <?= (string) ($sosial['dijemput'] ?? '0') === '0' ? 'selected' : '' ?>>Belum Dijemput</option>
            <option value="1" <?= (string) ($sosial['dijemput'] ?? '0') === '1' ? 'selected' : '' ?>>Sudah Dijemput</option>
          </select>
          <small class="field-hint" id="dijemputGateHint">Menunggu Status Penanganan Medis "Selesai Ditangani"</small>
        </div>
        <!-- Tanggal Penjemputan -->
        <div class="field">
          <label for="tglJemputInput">Tanggal Jemput</label>
          
          <input type="date" name="sosial[tgljemput]" id="tglJemputInput" value="<?= safe_date($sosial['tgljemput'] ?? '') ?>" readonly>
        </div>
        <!-- Pukul Berapa Penjemputan -->
        <div class="field">
          <label for="jamJemputInput">Jam Jemput</label>
          <input type="time" name="sosial[jamjemput]" id="jamJemputInput" value="<?= $sosial['jamjemput'] ?? '' ?>" readonly>
        </div>
        <!-- Siapa Melakukan Penjemputan -->
        <div class="field">
          <label for="penjemputInput">Siapa Melakukan Penjemputan</label>
          <input type="text" name="sosial[penjemput]" id="penjemputInput" value="<?= $sosial['penjemput'] ?? '' ?>" readonly>
        </div>
        <!-- Telephone Penjemput -->
        <div class="field">
          <label for="telephoneSosialInput">Telepon</label>
          <input type="text" name="sosial[telephone]" id="telephoneSosialInput" maxlength="14" value="<?= $sosial['telephone'] ?? '' ?>" readonly>
        </div>
      </div>
    </div>
  </form>

  <!-- III - Panel Data Pengantar -->
  <form action="<?php echo base_url('inti/redeliver'); ?>" method="POST" class="panel-form" id="formPengantar" data-panel-form="pengantar">
    <div class="panel" id="pengantarPanel">
      <div class="panel-head">
        <div>
          <h2>Data Pengantar</h2>
          <p class="lead" style="margin-top:10px">Informasi Pihak Pengantar Pasien</p>
        </div>
      </div>
      <div class="form-grid form-grid-last">
        <div class="field field-full field-code">
          <label for="kodePengantarInput">Kode Data Pengantar</label>
          <input type="text" name="pengantar[patientKey]" id="kodePengantarInput" value="<?= $pengantar['patientKey'] ?? '' ?>" readonly>
        </div>
        <div class="field field-full">
          <label for="namaPengantarInput">Nama Yang Mengantar</label>
          <input type="text" id="namaPengantarInput" value="<?= $pengantar['nama'] ?? '' ?>" readonly>
        </div>
        <div class="field">
          <label for="teleponPengantarInput">Nomor Telepon Yang Dapat Dihubungi</label>
          <input type="text" id="teleponPengantarInput" value="<?= $pengantar['telephone'] ?? '' ?>" readonly>
        </div>
        <div class="field">
          <label for="teleponPengantarInput2">Nomor Telepon Kedua <span class="label-optional">(Opsional)</span></label>
          <input type="text" id="teleponPengantarInput2" value="<?= $pengantar['telephonetwo'] ?? '' ?>" readonly>
        </div>
        <div class="field field-full">
          <label for="lokasiDitemukanInput">Lokasi Ditemukan</label>
          <input type="text" id="lokasiDitemukanInput" value="<?= $pengantar['lokasi'] ?? '' ?>" readonly>
        </div>
      </div>
    </div>
  </form>

  <!-- IV - Panel Data Keluarga -->
  <form action="<?php echo base_url('inti/refamilia'); ?>" method="POST" class="panel-form" id="formKeluarga" data-panel-form="keluarga">
    <div class="panel" id="keluargaPanel">
      <div class="panel-head page-header-with-badge">
        <div>
          <h2>Data Keluarga</h2>
          <p class="lead" style="margin-top:10px">Informasi Kontak Keluarga Pasien</p>
        </div>
        <div class="panel-head-actions" data-panel-actions="keluarga">
          <button type="button" class="btn-panel-icon btn-panel-edit" data-edit-panel="keluarga" title="Ubah Data Keluarga" aria-label="Ubah Data Keluarga">
            <i class="bi bi-pencil"></i>
          </button>
          <button type="button" class="btn-panel-icon btn-panel-cancel" data-cancel-panel="keluarga" title="Batal" aria-label="Batal" style="display:none">
            <i class="bi bi-x-lg"></i>
          </button>
          <button type="submit" class="btn-panel-icon btn-panel-save" data-submit-panel="keluarga" title="Kirim" aria-label="Kirim" style="display:none">
            <i class="bi bi-check-lg"></i>
          </button>
        </div>
        <!-- Panel Keluarga Panel Sosial -->
        <small class="field-hint" id="keluargaNoFamilyHint" style="display:none">Pasien Berstatus "Tanpa Keluarga" - Panel ini Tidak Bisa Diedit</small>
      </div>
      <div class="form-grid form-grid-last">
        <div class="field field-full field-code">
          <label for="kodeKeluargaInput">Kode Data Keluarga</label>
          <input type="text" name="keluarga[patientKey]" id="kodeKeluargaInput" value="<?= $keluarga['patientKey'] ?? '' ?>" readonly>
        </div>
        <div class="field">
          <label for="hubunganInput">Hubungan Keluarga</label>
          <div class="select-wrap">
            <i class="bi bi-people"></i>
           <select name="keluarga[hubungan]" id="hubunganInput" required>
              <?= rolerFamily($keluarga['hubungan'] ?? null) ?>
            </select>
          </div>
        </div>
        <div class="field">
          <label for="namaKeluargaInput">Nama</label>
          <input type="text" name="keluarga[nama]" id="namaKeluargaInput" value="<?= $keluarga['nama'] ?? '' ?>" readonly>
        </div>
        <div class="field">
          <label for="teleponKeluargaInput">Nomor Telepon Keluarga</label>
          <input type="text" name="keluarga[telephone]" id="teleponKeluargaInput" maxlength="14" value="<?= $keluarga['telephone'] ?? '' ?>" readonly>
        </div>
        <div class="field">
          <label for="teleponKeluargaInput2">Nomor Telepon Kedua</label>
          <input type="text" name="keluarga[telephonetwo]" id="teleponKeluargaInput2" maxlength="14" value="<?= $keluarga['telephonetwo'] ?? '' ?>" readonly>
        </div>
        <div class="field field-full">
          <label for="alamatKeluargaInput">Alamat Keluarga</label>
          <input type="text" name="keluarga[alamat]" id="alamatKeluargaInput" value="<?= $keluarga['alamat'] ?? '' ?>" readonly>
        </div>
      </div>
    </div>
  </form>

  <!-- V - Panel File -->
  <form action="<?php echo base_url('inti/publifile'); ?>" method="POST" class="panel-form dokumen-form" id="formDokumen" data-panel-form="dokumen" enctype="multipart/form-data">
    <div class="panel dokumen-panel" id="dokumenPanel">
      <div class="panel-head page-header-with-badge">
        <div>
          <h2>File Pendukung</h2>
          <p class="lead" style="margin-top:10px">Input File Terkait Pengurusan Pasien Terlantar</p>
        </div>
        <div class="panel-head-actions" data-panel-actions="dokumen">
          <button type="button" class="btn-panel-icon btn-panel-edit" data-edit-panel="dokumen">
            <i class="bi bi-pencil"></i>
          </button>
          <button type="button" class="btn-panel-icon btn-panel-cancel" data-cancel-panel="dokumen" style="display:none">
            <i class="bi bi-x-lg"></i>
          </button>
          <button type="submit" class="btn-panel-icon btn-panel-save" data-submit-panel="dokumen" style="display:none">
            <i class="bi bi-check-lg"></i>
          </button>
        </div>
        <!-- Panel Keluarga Panel Sosial -->
      </div>
      <div class="form-grid dokumen-grid">
        <!-- Kode Pasien (Full Width) -->
        <div class="field field-full field-code dokumen-field-code">
          <label for="kodeDokumenInput">Kode Pasien</label>
          <input type="text" name="dokumen[patientKey]" id="kodeDokumenInput" class="dokumen-input-code" value="<?= $dokumen['patientKey'] ?? '' ?>" readonly>
        </div>

        <!-- Dummy File 1 -->
        <div class="field dokumen-field-file">
          <label for="dokumenFile1Input">Dokumen 1 <span class="label-optional">(Contoh: KTP)</span></label>
          <div class="dokumen-file-wrap">
            <i class="bi bi-file-earmark-arrow-up dokumen-file-icon"></i>
            <input type="file" name="dokumen[file1]" id="dokumenFile1Input" class="dokumen-input-file field-editable" disabled>
          </div>
        </div>

        <!-- Dummy File 2 -->
        <div class="field dokumen-field-file">
          <label for="dokumenFile2Input">Dokumen 2 <span class="label-optional">(Contoh: Kartu Keluarga)</span></label>
          <div class="dokumen-file-wrap">
            <i class="bi bi-file-earmark-arrow-up dokumen-file-icon"></i>
            <input type="file" name="dokumen[file2]" id="dokumenFile2Input" class="dokumen-input-file field-editable" disabled>
          </div>
        </div>

        <!-- Dummy File 3 -->
        <div class="field dokumen-field-file">
          <label for="dokumenFile3Input">Dokumen 3 <span class="label-optional">(Contoh: Surat Keterangan)</span></label>
          <div class="dokumen-file-wrap">
            <i class="bi bi-file-earmark-arrow-up dokumen-file-icon"></i>
            <input type="file" name="dokumen[file3]" id="dokumenFile3Input" class="dokumen-input-file field-editable" disabled>
          </div>
        </div>

        <!-- Dummy File 4 -->
        <div class="field dokumen-field-file">
          <label for="dokumenFile4Input">Dokumen 4 <span class="label-optional">(Contoh: Lainnya)</span></label>
          <div class="dokumen-file-wrap">
            <i class="bi bi-file-earmark-arrow-up dokumen-file-icon"></i>
            <input type="file" name="dokumen[file4]" id="dokumenFile4Input" class="dokumen-input-file field-editable" disabled>
          </div>
        </div>
      </div>
    </div>
  </form>
  
</div>

<!-- Custom Script -->
<script>
  // Helper Alamat Wilayah
  var WILAYAH_API_BASE = "<?= base_url('wilayah'); ?>";
</script>

<script src="<?= base_url('assets/js/detail.js'); ?>"></script>