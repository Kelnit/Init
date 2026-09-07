<?php
// Hub Controller : Main File
defined('BASEPATH') or exit('No direct script access allowed');

class Hub extends MainController {
  // Hub Controller Builder
  public function __construct(){
    // Parent Builder
    parent::__construct();
    // Model
    $this->load->model('hub_model', 'hudel');
  }

  public function index(){
    // Main File u Tampilan Dashboard
    if (!permissible('hub', 'readable')) {
      blokir();
    }
    // Variable - Total
    $this->data['total_patient'] = $this->hudel->get_all_patient();
    // Variable - Jenis Tiba Pasien Datang Sendiri
		$this->data['datari'] = $this->hudel->get_in_number('datang', 'Sendiri', 'patient');
    // Variable - Jenis Tiba Pasien Datang Diantar
    $this->data['dantar'] = $this->hudel->get_in_number('datang', 'Diantar', 'patient');
    // Variable - Jenis Kelamin Pasien Pria
		$this->data['jekelpr'] = $this->hudel->get_in_number('gender', 'Pria', 'patient');
    // Variable - Jenis Kelamin Pasien Wanita
    $this->data['jekelpw'] = $this->hudel->get_in_number('gender', 'Wanita', 'patient');
    // Variable - Kondisi Pasien Ketika Tiba Hidup
		$this->data['kohid'] = $this->hudel->get_in_number('kondisi', 'Hidup', 'patient');
    // Variable - Kondisi Pasien Ketika Tiba Death on Arrival
    $this->data['komat'] = $this->hudel->get_in_number('kondisi', 'Meninggal', 'patient');
    // Variable - Apa Pasien Sudah Dijemput ? Belum
    $this->data['lumjemput'] = $this->hudel->get_in_number('dijemput', false, 'sosial');
    // Variable - Apa Pasien Sudah Dijemput ? Sudah
		$this->data['dahjemput'] = $this->hudel->get_in_number('dijemput', true, 'sosial');
    // Variable - Apa Pasien Punya Identitas ? Yes
		$this->data['identitas'] = $this->hudel->get_in_number('identity', true, 'sosial');
    // Variable - Apa Pasien Punya Identitas ? False
    $this->data['noidentita'] = $this->hudel->get_in_number('identity', false, 'sosial');
		// Data in Yearly - Registrasi
		$this->data['regis'] = $this->hudel->get_trend_regis();
		// Data in Yearly - Masa Tinggal
    $this->data['nmlos'] = $this->hudel->get_trend_nmlos();
		// Sekarang
		$this->data['rata_bulan_ini'] = $this->hudel->get_avg_wait_days_this_month();
    // Sebelum
		$this->data['rata_bulan_lalu'] = $this->hudel->get_avg_wait_days_last_month();
		// File
    $this->data['title'] = "Dashboard";
    $this->data['sub_page'] = 'hub/index';
    $this->data['main_menu'] = 'hub';
    $this->load->view('layout/layout', $this->data);
	}
}

?>