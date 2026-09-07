<?php

// Alert Array
$alertMap = array(
  // 1
  'success' => array(
    'title'     => 'Berhasil !',
    'icon'      => 'success',
    'iconColor' => '#48BB78',
    'background'=> '#F0FFF4',
    'color'     => '#276749',
  ),
  // 2
  'error' => array(
    'title'     => 'Gagal !',
    'icon'      => 'error',
    'iconColor' => '#FC8181',
    'background'=> '#FFF1F0',
    'color'     => '#c0392b',
  ),
  // 3
  'danger' => array(
    'title'     => 'Hati Hati !',
    'icon'      => 'warning',
    'iconColor' => '#F6AD55',
    'background'=> '#FFFBEB',
    'color'     => '#92610a',
  ),
  // 4
  'info' => array(
    'title'     => 'Informasi !',
    'icon'      => 'info',
    'iconColor' => '#63B3ED',
    'background'=> '#F0F9FF',
    'color'     => '#1e6fa8',
  ),
);
// Tampilkan Alert
foreach ($alertMap as $key => $config) {
  $message = $this->session->flashdata("alert-{$key}");
  if (!empty($message)) :
    $safeTitle   = addslashes(htmlspecialchars($config['title']));
    $safeMessage = addslashes(htmlspecialchars($message));
?>

<!-- Sweet Alert Content -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
      title: '<?= $safeTitle ?>',
      text: '<?= $safeMessage ?>',
      icon: '<?= $config['icon'] ?>',
      iconColor: '<?= $config['iconColor'] ?>',
      background: '<?= $config['background'] ?>',
      color: '<?= $config['color'] ?>',
      timer: 4000,
      timerProgressBar: true,
      showConfirmButton: false,
      customClass: {
        popup: 'rounded-4 shadow'
      }
    });
  });
</script>

<?php endif; } ?>