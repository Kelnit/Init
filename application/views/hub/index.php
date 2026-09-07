<!-- Custom Styling -->
<link rel="stylesheet" href="<?= base_url('assets/css/hub.css'); ?>">

<!-- Modal Notif Total Pasien -->
<?php if ($this->session->flashdata('show_notif')) : ?>
  <?php $this->load->view('modal/notif'); ?>
<?php endif; ?>

<!-- Main File Panel -->
<div class="hub">
  <!-- Panel Title -->
  <div class="hub-header">
    <div>
      <p class="eyebrow">Layanan Pasien Terlantar</p>
      <p class="lead" style="font-weight:300; font-size:30px; color:black">Dashboard</p>
      <p style="margin-top:10px; font-size:18px">Data Keseluruhan Pasien Terlantar</p>
    </div>
  </div>
  <!-- 4 Info Data Key Performance Indicator -->
  <div class="kpis">
    <!-- Total Pasien Keseluruhan -->
    <div class="kpi k-total">
      <span class="kpi-icon">
        <i class="bi bi-people-fill"></i>
      </span>
      <p class="kpi-label">Total Pasien Keseluruhan</p>
      <div class="kpi-value js-counter"><?php echo $total_patient;?></div>
      <div class="kpi-legend" style="margin-top:12px;">
        <span>Sepanjang Periode Tercatat</span>
      </div>
    </div>
    <!-- Kondisi Tiba Pasien -->
    <div class="kpi k-status">
      <span class="kpi-icon">
        <i class="bi bi-heart-pulse-fill"></i>
      </span>
      <p class="kpi-label">Kondisi Tiba Pasien</p>
      <div class="kpi-split">
        <span style="width:<?= $kohid['pct']; ?>%;background:#0E6B63;"></span>
        <span style="width:<?= $komat['pct']; ?>%;background:#A23A3A;"></span>
      </div>
      <div class="kpi-legend">
        <div class="kpi-stat">
          <span class="who">
            <span class="dot" style="background:#0E6B63;"></span>
            Hidup
          </span>
          <span class="figures">
            <span class="pct"><?php echo $kohid['pct'];?> %</span>
            <span class="n"><?php echo $kohid['total'];?></span>
          </span>
        </div>
        <div class="kpi-stat">
          <span class="who">
            <span class="dot" style="background:#A23A3A;"></span>
            Meninggal
          </span>
          <span class="figures">
            <span class="pct"><?php echo $komat['pct'];?> %</span>
            <span class="n"><?php echo $komat['total'];?></span>
          </span>
        </div>
      </div>
    </div>
    <!-- Penjemputan Oleh Dinal Sosial atau Keluarga -->
    <div class="kpi k-jemput">
      <span class="kpi-icon">
        <i class="bi bi-truck"></i>
      </span>
      <p class="kpi-label">Proses Penjemputan</p>
      <div class="kpi-split">
        <span style="width:<?= $dahjemput['pct']; ?>%;background:#B4702A;"></span>
        <span style="width:<?= $lumjemput['pct']; ?>%;background:#3E5A6B;"></span>
      </div>
      <div class="kpi-legend">
        <div class="kpi-stat">
          <span class="who">
            <span class="dot" style="background:#B4702A;"></span>
            Sudah Dijemput
          </span>
          <span class="figures">
            <span class="pct"><?php echo $dahjemput['pct'];?> %</span>
            <span class="n"><?php echo $dahjemput['total'];?></span>
          </span>
        </div>
        <div class="kpi-stat">
          <span class="who">
            <span class="dot" style="background:#3E5A6B;"></span>
            Belum Dijemput
          </span>
          <span class="figures">
            <span class="pct"><?php echo $lumjemput['pct'];?> %</span>
            <span class="n"><?php echo $lumjemput['total'];?></span>
          </span>
        </div>
      </div>
    </div>
    <!-- Punya Identitas -->
    <div class="kpi k-identity">
      <span class="kpi-icon">
        <i class="bi bi-person-vcard-fill"></i>
      </span>
      <p class="kpi-label">Status Identitas</p>
      <div class="kpi-split">
        <span style="width:<?= $identitas['pct']; ?>%;background:#0E6B63;"></span>
        <span style="width:<?= $noidentita['pct']; ?>%;background:#A23A3A;"></span>
      </div>
      <div class="kpi-legend">
        <div class="kpi-stat">
          <span class="who">
            <span class="dot" style="background:#0E6B63;"></span>
            Punya Identitas
          </span>
          <span class="figures">
            <span class="pct"><?php echo $identitas['pct'];?> %</span>
            <span class="n"><?php echo $identitas['total'];?></span>
          </span>
        </div>
        <div class="kpi-stat">
          <span class="who">
            <span class="dot" style="background:#A23A3A;"></span>
            Tanpa Identitas
          </span>
          <span class="figures">
            <span class="pct"><?php echo $noidentita['pct'];?> %</span>
            <span class="n"><?php echo $noidentita['total'];?></span>
          </span>
        </div>
      </div>
    </div>
  </div>
  <!-- 3 Info Data Key Performance Indicator -->
  <div class="kpis kpis-3">
    <!-- Cara Datang -->
    <div class="kpi k-status">
      <span class="kpi-icon">
        <i class="bi bi-signpost-split-fill"></i>
      </span>
      <p class="kpi-label">Cara Datang</p>
      <div class="kpi-split">
        <span style="width:<?= $dantar['pct']; ?>%;background:#0E6B63;"></span>
        <span style="width:<?= $datari['pct']; ?>%;background:#B4702A;"></span>
      </div>
      <div class="kpi-legend">
        <div class="kpi-stat">
          <span class="who">
            <span class="dot" style="background:#0E6B63;"></span>
            Diantar
          </span>
          <span class="figures">
            <span class="pct"><?php echo $dantar['pct'];?> %</span>
            <span class="n"><?php echo $dantar['total'];?></span>
          </span>
        </div>
        <div class="kpi-stat">
          <span class="who">
            <span class="dot" style="background:#B4702A;"></span>
            Sendiri
          </span>
          <span class="figures">
            <span class="pct"><?php echo $datari['pct'];?> %</span>
            <span class="n"><?php echo $datari['total'];?></span>
          </span>
        </div>
      </div>
    </div>
    <!-- Jenis Kelamin -->
    <div class="kpi k-jemput">
      <span class="kpi-icon">
        <i class="bi bi-gender-ambiguous"></i>
      </span>
      <p class="kpi-label">Jenis Kelamin</p>
      <div class="kpi-split">
        <span style="width:<?= $jekelpr['pct']; ?>%;background:#0E6B63;"></span>
        <span style="width:<?= $jekelpw['pct']; ?>%;background:#B4702A;"></span>
      </div>
      <div class="kpi-legend">
        <div class="kpi-stat">
          <span class="who">
            <span class="dot" style="background:#0E6B63;"></span>
            Pria
          </span>
          <span class="figures">
            <span class="pct"><?php echo $jekelpr['pct'];?> %</span>
            <span class="n"><?php echo $jekelpr['total'];?></span>
          </span>
        </div>
        <div class="kpi-stat">
          <span class="who">
            <span class="dot" style="background:#B4702A;"></span>
            Wanita
          </span>
          <span class="figures">
            <span class="pct"><?php echo $jekelpw['pct'];?> %</span>
            <span class="n"><?php echo $jekelpw['total'];?></span>
          </span>
        </div>
      </div>
    </div>
    <!-- Rata Rata Lama Tunggu Jemput -->
    <div class="kpi k-identity">
      <span class="kpi-icon">
        <i class="bi bi-hourglass-split"></i>
      </span>
      <p class="kpi-label">Rata Rata Lama Tunggu Jemput Dalam Satuan Hari</p>
      <div class="kpi-compare">
        <div class="kpi-compare-col">
          <span class="kpi-compare-label" id="lbl-bulan-lalu">Juli</span>
          <span class="kpi-compare-value"><?= $rata_bulan_lalu; ?></span>
        </div>
        <?php if ($rata_bulan_ini > $rata_bulan_lalu) : ?>
          <span class="kpi-trend kpi-trend-up"><i class="bi bi-arrow-up-short"></i></span>
        <?php elseif ($rata_bulan_ini < $rata_bulan_lalu) : ?>
          <span class="kpi-trend kpi-trend-down"><i class="bi bi-arrow-down-short"></i></span>
        <?php else : ?>
          <span class="kpi-trend kpi-trend-flat"><i class="bi bi-dash-lg"></i></span>
        <?php endif; ?>
        <div class="kpi-compare-col">
          <span class="kpi-compare-label" id="lbl-bulan-ini">Agustus</span>
          <span class="kpi-compare-value"><?= $rata_bulan_ini; ?></span>
        </div>
      </div>
    </div>
  </div>
  <!-- Plot Over Time -->
  <div class="chart-row">
    <!-- Pendaftaran Pasien Terlantar Bulanan -->
    <div class="card">
      <div class="card-head">
        <p class="card-title">
          <i class="bi bi-graph-up-arrow"></i>
          Registrasi Baru Tahun <?= date('Y'); ?>
        </p>
      </div>
      <div class="trend-panel active">
        <canvas id="trendRegisChart" data-value="<?= json_encode($regis); ?>"></canvas>
      </div>
    </div>
    <!-- Selisih Masa Tinggal -->
    <div class="card">
      <div class="card-head">
        <p class="card-title">
          <i class="bi bi-graph-up-arrow"></i>
          Masa Tinggal Diluar Ranap Tahun <?= date('Y'); ?>
        </p>
      </div>
      <div class="trend-panel active">
        <canvas id="trendMasaTinggalChart" data-value="<?= json_encode($nmlos); ?>"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Helper Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= base_url('assets/js/number.js'); ?>"></script>
<script src="<?= base_url('assets/js/progress.js'); ?>"></script>
<script src="<?= base_url('assets/js/line.js'); ?>"></script>
<!-- Monthly Script -->
<script>
  const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
  const now = new Date();
  const lastMonthDate = new Date(now.getFullYear(), now.getMonth() - 1, 1);
  document.getElementById('lbl-bulan-ini').textContent = monthNames[now.getMonth()];
  document.getElementById('lbl-bulan-lalu').textContent = monthNames[lastMonthDate.getMonth()];
</script>