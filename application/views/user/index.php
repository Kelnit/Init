<!-- Custom Styling -->
<link rel="stylesheet" href="<?= base_url('assets/css/tabel.css'); ?>">

<!-- Title Panel -->
<div class="page-header">
  <h1>Tabel User</h1>
  <p style="margin-top:20px">Data Seluruh User</p>
</div>

<!-- Panel Tabel -->
<div class="content">
  <div class="panel">
    <!-- Panel Toolbar -->
    <div class="panel-toolbar">
      <div class="rows-picker">
        <!-- Input Pasien Baru -->
        <a href="<?= base_url('user/insert') ?>" type="button" class="add-btn" title="Tambah data">
          <i class="bi bi-plus-lg"></i>
        </a>
      </div>
    </div>
    <table class="data-table">
      <thead>
        <tr>
          <th class="text-center">Nomor Induk Kependudukan</th>
          <th class="text-center">Nama Lengkap</th>
          <th class="text-center">Email</th>
          <th class="text-center">Telepon</th>
          <th class="text-center">Instansi</th>
          <th class="text-center">Unit</th>
          <th class="text-center"></th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($results)): ?>
          <?php foreach ($results as $row): ?>
            <tr class="text-center">
              <td><?= htmlspecialchars($row['nik']) ?></td>
              <td><?= htmlspecialchars($row['fullname']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['phone']) ?></td>
              <td><?= htmlspecialchars($row['nama']) ?></td>
              <td><?= htmlspecialchars($row['unit']) ?></td>
              <td class="col-action text-center">
                <a href="<?= base_url('user/detail/' . $row['kode']) ?>" class="row-action" title="Lihat Detail"><i class="bi bi-eye"></i></a>
                <a href="<?= base_url('user/repass/' . $row['kode']) ?>" class="row-action"><i class="bi bi-key"></i></a>
                <a href="#" class="row-action" title="Lihat Detail"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr class="empty-row">
            <td colspan="7" class="empty-state">Belum Ada Data User</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>