<?php
// Sipil Controller : Handle Tabel Pasien Terlantar Dinas Kependudukan dan Pencatatan Sipil
defined('BASEPATH') or exit('No direct script access allowed');

class Sipil extends MainController {
  // Sipil Controller Builder
  public function __construct(){
    // Parent Builder
    parent::__construct();
    // Model
    $this->load->model('inti_model', 'intidel');
  }

  public function index(){
    // Tampilan Tabel Pasien Terlantar
    if (!permissible('sipil', 'readable')) {
      blokir();
    }
    // File
    $this->data['title'] = "Dinas Kependudukan dan Pencatatan Sipil - Tabel Pasien Terlantar";
    $this->data['sub_page'] = 'sipil/index';
    $this->data['main_menu'] = 'sipil';
    $this->load->view('layout/layout', $this->data);
  }

  public function historia(){
    // Hasil Data Model u Tabel Data Pasien Terlantar - Dinas Kependudukan dan Pencatatan Sipil
    if (!permissible('sipil', 'readable')) {
      blokir();
    }
    // Model
    $result = $this->intidel->getPasienSipil();
    // Hasil
    echo json_encode($result);
  }

  public function detail($kode){
    // Tampilan Detail Pasien Terlantar
    if (!permissible('sipil', 'readable')) {
      blokir();
    }
    // Hasil Data Pasien
    $this->data['patient'] = $this->intidel->getPasienByKode($kode);
    // Hasil Data Sosial
    $this->data['sosial'] = $this->intidel->getSosialByPatientKey($kode);
    // Hasil Data Keluarga
    $this->data['keluarga'] = $this->intidel->getKeluargaByPatientKey($kode);
    // Hasil Data Pengantar
    $this->data['pengantar'] = $this->intidel->getPengantarByPatientKey($kode);
    // Hasil Data Dokumen
    $this->data['dokumen'] = $this->intidel->getDokumenByPatientKey($kode);
    // File
    $this->data['title'] = "Dinas Kependudukan dan Pencatatan Sipil - Detail Pasien Terlantar";
    $this->data['sub_page'] = 'sipil/detail';
    $this->data['main_menu'] = 'sipil';
    $this->load->view('layout/layout', $this->data);
  }

  public function repatient(){
    // Publish Perubahan Data Input Tabel Pasien
    if (!permissible('sipil', 'creatable') || !permissible('sipil', 'editable')) {
      blokir();
    }
    // Variable Input
    $inputs = $this->input->post();
    // Model
    $result = $this->intidel->publishDataPasien($inputs['patient']);
    // Hasil
    if ($result === false) {
      // Fail !
      alerta('error', 'Perubahan Data Pasien Tidak Berhasil Disimpan !');
    } else {
      // Berhasil !
      alerta('success', 'Perubahan Data Pasien Berhasil Disimpan !');
    }
    // Kembali
    return redirect(base_url('sipil/detail/' . $inputs['patient']['kode']));
  }
}
?>