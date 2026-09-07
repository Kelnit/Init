<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Aplikasi Pasien Terlantar'; ?></title>
  <link rel="icon" type="image/png" href="<?= base_url('/assets/sipiter-logo.webp'); ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <!-- Variable Kondisional -->
  <?php $isAuth = in_array($this->uri->segment(1), ['', 'auth']); ?>
  <!-- Alert -->
  <?php $this->load->view('layout/alerts'); ?>
  <!-- File -->
  <?php if (!$isAuth) : ?>
    <div class="app-shell" id="appShell">
      <?php $this->load->view('layout/sidebar'); ?>
      <?php $this->load->view('layout/topbar'); ?>
      <main class="app-content">
        <?php $this->load->view($sub_page); ?>
      </main>
    </div>
  <?php else : ?>
    <?php $this->load->view($sub_page); ?>
  <?php endif; ?>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <script src="<?= base_url('assets/js/app.js'); ?>"></script>
</body>
</html>