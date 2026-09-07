<!-- Custom Styling -->
<link rel="stylesheet" href="<?= base_url('assets/css/insert.css'); ?>">

<!-- Detail Dukcapil : Panel Pasien & Nomor Induk Kependudukan Saja -->
<div class="form-wrap">
  <form action="<?php echo base_url('sipil/repatient'); ?>" method="POST" class="panel-form" id="formPasien" data-panel-form="pasien">
    <div class="panel" id="pasienPanel">
      <div class="panel-head page-header-with-badge">
        <div>
          <h2>Data Pasien</h2>
          <p class="lead" style="margin-top:10px">Informasi Identitas dan Kondisi Pasien</p>
        </div>
        <div class="panel-head-actions" data-panel-actions="pasien">
          <button type="button" class="btn-panel-icon btn-panel-edit" data-edit-panel="pasien" title="Ubah NIK" aria-label="Ubah NIK">
            <i class="bi bi-pencil"></i>
          </button>
          <button type="button" class="btn-panel-icon btn-panel-cancel" data-cancel-panel="pasien" title="Batal" aria-label="Batal" style="display:none">
            <i class="bi bi-x-lg"></i>
          </button>
          <button type="submit" class="btn-panel-icon btn-panel-save" data-submit-panel="pasien" title="Kirim" aria-label="Kirim" style="display:none">
            <i class="bi bi-check-lg"></i>
          </button>
        </div>
      </div>
      <div class="form-grid">
        <div class="field field-full field-code">
          <label for="kodePasienInput">Kode Pasien</label>
          <input type="text" name="patient[kode]" id="kodePasienInput" value="<?= $patient['kode'] ?>" readonly>
        </div>
        <div class="field">
          <label for="mrnInput">Nomor Rekam Medis</label>
          <input type="text" id="mrnInput" maxlength="9" value="<?= $patient['mrn'] ?>" readonly>
        </div>
        <!-- Nomor Induk Kependudukan : The Only Available One -->
        <div class="field">
          <label for="nikInput">Nomor Induk Kependudukan</label>
          <input type="text" name="patient[nik]" id="nikInput" class="field-editable" maxlength="19" value="<?= $patient['nik'] ?>" readonly>
        </div>
        <div class="field">
          <label for="namaInput">Nama Pasien</label>
          <input type="text" id="namaInput" value="<?= $patient['fullname'] ?>" readonly>
        </div>
        <div class="field">
          <label for="jenisKelaminInput">Jenis Kelamin</label>
          <div class="select-wrap">
            <i class="bi bi-gender-ambiguous"></i>
            <select id="jenisKelaminInput" disabled>
              <option <?= $patient['gender'] === 'Pria' ? 'selected' : '' ?>>Pria</option>
              <option <?= $patient['gender'] === 'Wanita' ? 'selected' : '' ?>>Wanita</option>
            </select>
          </div>
        </div>
        <div class="field">
          <label for="dobInput">Tanggal Lahir</label>
          <input type="date" id="dobInput" value="<?= safe_date($patient['dob'] ?? '') ?>" readonly>
        </div>
        <div class="field">
          <label for="usiaInput">Perkiraan Usia Pasien</label>
          <input type="text" id="usiaInput" value="<?= $patient['usia'] ?>" readonly>
        </div>
        <div class="field">
          <label for="agamaInput">Agama Pasien</label>
          <div class="select-wrap">
            <i class="bi bi-book-half"></i>
            <select id="agamaInput" disabled>
              <?= rolerReligion($patient['agama'] ?? null) ?>
            </select>
          </div>
        </div>
        <div class="field">
          <label for="datangKesiniInput">Datang Kesini</label>
          <div class="select-wrap">
            <i class="bi bi-signpost-split"></i>
            <select id="datangKesiniInput" disabled>
              <option <?= $patient['datang'] === 'Diantar' ? 'selected' : '' ?>>Diantar</option>
              <option <?= $patient['datang'] === 'Sendiri' ? 'selected' : '' ?>>Sendiri</option>
            </select>
          </div>
        </div>
        <div class="field">
          <label for="kondisiInput">Kondisi Ketika Tiba</label>
          <div class="select-wrap">
            <i class="bi bi-activity"></i>
            <select id="kondisiInput" disabled>
              <option <?= $patient['kondisi'] === 'Hidup' ? 'selected' : '' ?>>Hidup</option>
              <option <?= $patient['kondisi'] === 'Meninggal' ? 'selected' : '' ?>>Meninggal</option>
            </select>
          </div>
        </div>
        <div class="field">
          <label for="lokasiInput">Lokasi</label>
          <input type="text" id="lokasiInput" value="<?= $patient['lokasi'] ?? '' ?>" readonly>
        </div>
        <div class="field">
          <label for="kabupatenKotaInput">Kabupaten Kota</label>
          <input type="text" id="kabupatenKotaInput" value="<?= $patient['kota'] ?? '' ?>" readonly>
        </div>
        <div class="field">
          <label for="kecamatanInput">Kecamatan</label>
          <input type="text" id="kecamatanInput" value="<?= $patient['kecamatan'] ?? '' ?>" readonly>
        </div>
        <div class="field">
          <label for="kelurahanInput">Kelurahan</label>
          <input type="text" id="kelurahanInput" value="<?= $patient['kelurahan'] ?? '' ?>" readonly>
        </div>
        <div class="field">
          <label for="alamatInput">Alamat</label>
          <input type="text" id="alamatInput" value="<?= $patient['alamat'] ?>" readonly>
        </div>
      </div>
    </div>
  </form>

  <!-- Panel Sosial -->
  <div class="panel" id="sosialPanel">
    <div class="panel-head">
      <div>
        <h2>Data Sosial</h2>
        <p class="lead" style="margin-top:10px">Progress Penanganan Kasus Pasien</p>
      </div>
    </div>
    <div class="form-grid form-grid-last">
      <div class="field">
        <label for="tanggalMasukInput">Tanggal Masuk</label>
        <input type="date" id="tanggalMasukInput" value="<?= safe_date($sosial['regisdate'] ?? '') ?>" readonly>
      </div>
      <div class="field">
        <label for="statusIdentitasInput">Status Identitas</label>
        <select id="statusIdentitasInput" class="select-plain select-status" disabled>
          <option value="1" <?= (string) ($sosial['identity'] ?? '1') === '1' ? 'selected' : '' ?>>Identitas Diketahui</option>
          <option value="0" <?= (string) ($sosial['identity'] ?? '1') === '0' ? 'selected' : '' ?>>Identitas Tidak Diketahui</option>
        </select>
      </div>
      <div class="field">
        <label for="statusKeluargaInput">Status Keluarga</label>
        <select id="statusKeluargaInput" class="select-plain select-status" disabled>
          <option value="1" <?= (string) ($sosial['keluarga'] ?? '1') === '1' ? 'selected' : '' ?>>Pasien Punya Keluarga</option>
          <option value="0" <?= (string) ($sosial['keluarga'] ?? '1') === '0' ? 'selected' : '' ?>>Pasien Tanpa Keluarga</option>
        </select>
      </div>
      <div class="field">
        <label for="statusSelesaiInput">Status Penanganan Medis</label>
        <select id="statusSelesaiInput" class="select-plain select-status" disabled>
          <option value="0" <?= (string) ($sosial['selesai'] ?? '0') === '0' ? 'selected' : '' ?>>Belum Selesai Ditangani</option>
          <option value="1" <?= (string) ($sosial['selesai'] ?? '0') === '1' ? 'selected' : '' ?>>Sudah Selesai Ditangani</option>
        </select>
      </div>
    </div>
  </div>

  <!-- Panel Pengantar -->
  <div class="panel" id="pengantarPanel">
    <div class="panel-head">
      <div>
        <h2>Data Pengantar</h2>
        <p class="lead" style="margin-top:10px">Informasi Pihak Pengantar Pasien</p>
      </div>
    </div>
    <div class="form-grid form-grid-last">
      <div class="field field-full">
        <label for="namaPengantarInput">Nama Yang Mengantar</label>
        <input type="text" id="namaPengantarInput" value="<?= $pengantar['nama'] ?? '' ?>" readonly>
      </div>
      <div class="field">
        <label for="teleponPengantarInput">Nomor Telepon Yang Dapat Dihubungi</label>
        <input type="text" id="teleponPengantarInput" value="<?= $pengantar['telephone'] ?? '' ?>" readonly>
      </div>
      <div class="field">
        <label for="teleponPengantarInput2">Nomor Telepon Kedua</label>
        <input type="text" id="teleponPengantarInput2" value="<?= $pengantar['telephonetwo'] ?? '' ?>" readonly>
      </div>
      <div class="field field-full">
        <label for="lokasiDitemukanInput">Lokasi Ditemukan</label>
        <input type="text" id="lokasiDitemukanInput" value="<?= $pengantar['lokasi'] ?? '' ?>" readonly>
      </div>
    </div>
  </div>

  <!-- Panel Keluarga -->
  <div class="panel" id="keluargaPanel">
    <div class="panel-head">
      <div>
        <h2>Data Keluarga</h2>
        <p class="lead" style="margin-top:10px">Informasi Kontak Keluarga Pasien</p>
      </div>
    </div>
    <div class="form-grid form-grid-last">
      <div class="field">
        <label for="hubunganInput">Hubungan Keluarga</label>
        <div class="select-wrap">
          <i class="bi bi-people"></i>
          <select id="hubunganInput" disabled>
            <?= rolerFamily($keluarga['hubungan'] ?? null) ?>
          </select>
        </div>
      </div>
      <div class="field">
        <label for="namaKeluargaInput">Nama</label>
        <input type="text" id="namaKeluargaInput" value="<?= $keluarga['nama'] ?? '' ?>" readonly>
      </div>
      <div class="field">
        <label for="teleponKeluargaInput">Nomor Telepon Keluarga</label>
        <input type="text" id="teleponKeluargaInput" value="<?= $keluarga['telephone'] ?? '' ?>" readonly>
      </div>
      <div class="field">
        <label for="teleponKeluargaInput2">Nomor Telepon Kedua</label>
        <input type="text" id="teleponKeluargaInput2" value="<?= $keluarga['telephonetwo'] ?? '' ?>" readonly>
      </div>
      <div class="field field-full">
        <label for="alamatKeluargaInput">Alamat Keluarga</label>
        <input type="text" id="alamatKeluargaInput" value="<?= $keluarga['alamat'] ?? '' ?>" readonly>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/detail.js'); ?>"></script>