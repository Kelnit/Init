<!-- Custom Panel Helper -->
<?php $canEditSosial = (string) ($sosial['selesai'] ?? '0') === '1'; ?>

<!-- Custom Styling -->
<link rel="stylesheet" href="<?= base_url('assets/css/insert.css'); ?>">

<!-- Detail Dinsos : Hanya Panel Sosial Jadi Input Field -->
<div class="form-wrap">
  <div class="panel" id="pasienPanel">
    <div class="panel-head">
      <div>
        <h2>Data Pasien</h2>
        <p class="lead" style="margin-top:10px">Informasi Identitas dan Kondisi Pasien</p>
      </div>
    </div>
    <div class="form-grid">
      <div class="field field-full field-code">
        <label for="kodePasienInput">Kode Pasien</label>
        <input type="text" id="kodePasienInput" value="<?= $patient['kode'] ?>" readonly>
      </div>
      <div class="field">
        <label for="mrnInput">Nomor Rekam Medis</label>
        <input type="text" id="mrnInput" value="<?= $patient['mrn'] ?>" readonly>
      </div>
      <div class="field">
        <label for="nikInput">Nomor Induk Kependudukan</label>
        <input type="text" id="nikInput" value="<?= $patient['nik'] ?>" readonly>
      </div>
      <div class="field">
        <label for="namaInput">Nama Pasien</label>
        <input type="text" id="namaInput" value="<?= $patient['fullname'] ?>" readonly>
      </div>
      <div class="field">
        <label for="jenisKelaminInput">Jenis Kelamin</label>
        <select id="jenisKelaminInput" disabled>
          <option <?= $patient['gender'] === 'Pria' ? 'selected' : '' ?>>Pria</option>
          <option <?= $patient['gender'] === 'Wanita' ? 'selected' : '' ?>>Wanita</option>
        </select>
      </div>
      <div class="field">
        <label for="kondisiInput">Kondisi Ketika Tiba</label>
        <select id="kondisiInput" disabled>
          <option <?= $patient['kondisi'] === 'Hidup' ? 'selected' : '' ?>>Hidup</option>
          <option <?= $patient['kondisi'] === 'Meninggal' ? 'selected' : '' ?>>Meninggal</option>
        </select>
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
        <label for="alamatInput">Alamat</label>
        <input type="text" id="alamatInput" value="<?= $patient['alamat'] ?>" readonly>
      </div>
    </div>
  </div>

  <form action="<?php echo base_url('inti/resocial'); ?>" method="POST" class="panel-form" id="formSosial" data-panel-form="sosial">
    <input type="hidden" name="patientKode" value="<?= $patient['kode'] ?>">
    <div class="panel" id="sosialPanel">
      <div class="panel-head page-header-with-badge">
        <div>
          <h2>Data Sosial</h2>
          <p class="lead" style="margin-top:10px">Progress Penanganan Kasus Pasien</p>
        </div>
        <?php if ($canEditSosial): ?>
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
        <?php else: ?>
          <span class="field-hint">Belum Selesai Penanganan Medis</span>
        <?php endif; ?>
      </div>
      <div class="form-grid form-grid-last">
        <div class="field field-full field-code">
          <label for="kodeSosialInput">Kode Data Sosial</label>
          <input type="text" name="sosial[patientKey]" id="kodeSosialInput" value="<?= $sosial['patientKey'] ?? '' ?>" readonly>
        </div>
        <div class="field">
          <label for="tanggalMasukInput">Tanggal Masuk</label>
          <input type="date" name="sosial[regisdate]" id="tanggalMasukInput" value="<?= safe_date($sosial['regisdate'] ?? '') ?>" readonly>
        </div>
        <div class="field">
          <label for="statusIdentitasInput">Status Identitas</label>
          <select name="sosial[identity]" id="statusIdentitasInput" class="select-plain select-status field-editable">
            <option value="1" <?= (string) ($sosial['identity'] ?? '1') === '1' ? 'selected' : '' ?>>Identitas Diketahui</option>
            <option value="0" <?= (string) ($sosial['identity'] ?? '1') === '0' ? 'selected' : '' ?>>Identitas Tidak Diketahui</option>
          </select>
        </div>
        <div class="field">
          <label for="statusKeluargaInput">Status Keluarga</label>
          <select name="sosial[keluarga]" id="statusKeluargaInput" class="select-plain select-status field-editable">
            <option value="1" <?= (string) ($sosial['keluarga'] ?? '1') === '1' ? 'selected' : '' ?>>Pasien Punya Keluarga</option>
            <option value="0" <?= (string) ($sosial['keluarga'] ?? '1') === '0' ? 'selected' : '' ?>>Pasien Tanpa Keluarga</option>
          </select>
        </div>
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

        <div class="field field-full">
          <label for="statusDijemputInput">Status Dijemput</label>
          <select name="sosial[dijemput]" id="statusDijemputInput" class="select-plain select-status">
            <option value="0" <?= (string) ($sosial['dijemput'] ?? '0') === '0' ? 'selected' : '' ?>>Belum Dijemput</option>
            <option value="1" <?= (string) ($sosial['dijemput'] ?? '0') === '1' ? 'selected' : '' ?>>Sudah Dijemput</option>
          </select>
          <small class="field-hint" id="dijemputGateHint">Menunggu Status Penanganan Medis "Selesai Ditangani"</small>
        </div>
        <div class="field">
          <label for="tglJemputInput">Tanggal Jemput</label>
          <input type="date" name="sosial[tgljemput]" id="tglJemputInput" value="<?= safe_date($sosial['tgljemput'] ?? '') ?>" readonly>
        </div>
        <div class="field">
          <label for="jamJemputInput">Jam Jemput</label>
          <input type="time" name="sosial[jamjemput]" id="jamJemputInput" value="<?= $sosial['jamjemput'] ?? '' ?>" readonly>
        </div>
        <div class="field">
          <label for="penjemputInput">Siapa Melakukan Penjemputan</label>
          <input type="text" name="sosial[penjemput]" id="penjemputInput" value="<?= $sosial['penjemput'] ?? '' ?>" readonly>
        </div>
        <div class="field">
          <label for="telephoneSosialInput">Telepon</label>
          <input type="text" name="sosial[telephone]" id="telephoneSosialInput" maxlength="14" value="<?= $sosial['telephone'] ?? '' ?>" readonly>
        </div>
      </div>
    </div>
  </form>

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
      <div class="field field-full">
        <label for="lokasiDitemukanInput">Lokasi Ditemukan</label>
        <input type="text" id="lokasiDitemukanInput" value="<?= $pengantar['lokasi'] ?? '' ?>" readonly>
      </div>
    </div>
  </div>

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
        <select id="hubunganInput" disabled>
          <?= rolerFamily($keluarga['hubungan'] ?? null) ?>
        </select>
      </div>
      <div class="field">
        <label for="namaKeluargaInput">Nama</label>
        <input type="text" id="namaKeluargaInput" value="<?= $keluarga['nama'] ?? '' ?>" readonly>
      </div>
      <div class="field">
        <label for="teleponKeluargaInput">Nomor Telepon Keluarga</label>
        <input type="text" id="teleponKeluargaInput" value="<?= $keluarga['telephone'] ?? '' ?>" readonly>
      </div>
      <div class="field field-full">
        <label for="alamatKeluargaInput">Alamat Keluarga</label>
        <input type="text" id="alamatKeluargaInput" value="<?= $keluarga['alamat'] ?? '' ?>" readonly>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/detail.js'); ?>"></script>