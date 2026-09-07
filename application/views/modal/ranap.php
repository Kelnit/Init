<dialog id="tujuanRanapModal" class="notif-modal">
  <div class="notif-icon" style="background:#e7f0f7; color:#2f6690;">
    <i class="bi bi-hospital"></i>
  </div>
  <h3 class="notif-title" style="text-align:center;">Tujuan Ranap</h3>
  <p class="notif-message" style="text-align:center;">Tentukan Instalasi Rawat Inap Tujuan Pasien</p>

  <form action="<?= base_url('inti/lokasi') ?>" method="POST" id="tujuanRanapForm">
    <div class="tujuan-field" style="display:none">
      <label>Kode</label>
      <div class="tujuan-select-wrap">
        <i class="bi bi-upc-scan"></i>
        <input type="text" name="kode" id="tujuanRanapKode" readonly class="tujuan-locked-input">
      </div>
    </div>

    <div class="tujuan-field">
      <label>No. Rekam Medis</label>
      <div class="tujuan-select-wrap">
        <i class="bi bi-credit-card-2-front"></i>
        <input type="text" id="tujuanRanapMrn" readonly class="tujuan-locked-input">
      </div>
    </div>

    <div class="tujuan-field">
      <label>Nama Pasien</label>
      <div class="tujuan-select-wrap">
        <i class="bi bi-person"></i>
        <input type="text" id="tujuanRanapNama" readonly class="tujuan-locked-input">
      </div>
    </div>

    <div class="tujuan-field">
      <label>Lokasi Rawat Saat Ini</label>
      <div class="tujuan-select-wrap">
        <i class="bi bi-geo-alt"></i>
        <input type="text" id="tujuanRanapLokasiSaatIni" readonly class="tujuan-locked-input">
      </div>
    </div>

    <div class="tujuan-field">
      <label>Pindah Rawat Ke</label>
      <div class="tujuan-select-wrap">
        <i class="bi bi-building"></i>
        <select name="lokasi" id="tujuanRanapSelect" required>
          <option disabled selected value="">Pilih Ranap</option>
          <option value="Instalasi Rawat Inap Penyakit Dalam">Instalasi Rawat Inap Penyakit Dalam</option>
          <option value="Kebidanan dan Anak">Kebidanan dan Anak</option>
          <option value="Bedah">Bedah</option>
          <option value="Penyakit Jantung Terpadu">Penyakit Jantung Terpadu</option>
          <option value="Non Bedah">Non Bedah</option>
          <option value="Ambun Pagi">Ambun Pagi</option>
        </select>
      </div>
    </div>

    <div class="notif-actions">
      <button type="button" class="notif-btn notif-btn-secondary" onclick="closeTujuanRanap()">Batal</button>
      <button type="submit" class="notif-btn">Simpan</button>
    </div>
  </form>
</dialog>