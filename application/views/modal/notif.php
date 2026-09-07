<!-- Final -->

<!-- Custom Styling -->
<link rel="stylesheet" href="<?= base_url('assets/css/modal.css'); ?>">
 
<!-- Modal Panel -->
<div class="modal fade" id="notifModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content notif-modal">
      <div class="modal-body text-center">
        <div class="notif-icon" style="background: #F0F9FF; color: #1E6FA8;">
          <i class="bi bi-info-circle-fill"></i>
        </div>
        <!-- Info -->
        <p class="lead notif-title" style="color: #1e6fa8;">
          Info
        </p>
        <!-- Panel Notif -->
        <p class="notif-message">
          Terdapat <?= totalBelumSelesai(); ?> Pasien Terlantar Baru Hari Ini !
        </p>
        <!-- Tombol ! -->
        <button type="button" class="btn notif-btn" data-bs-dismiss="modal">
          Lihat !
        </button>
      </div>
    </div>
  </div>
</div>
 
<script>
document.addEventListener('DOMContentLoaded', function () {
  var notifModal = new bootstrap.Modal(document.getElementById('notifModal'));
  notifModal.show();
});
</script>