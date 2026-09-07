<?php
// Sosial Controller : Handle Tabel Pasien Terlantar Dinas Sosial
defined('BASEPATH') or exit('No direct script access allowed');

class Sosial extends MainController {
  // Sosial Controller Builder
  public function __construct(){
    // Parent Builder
    parent::__construct();
    // Model
    $this->load->model('inti_model', 'intidel');
  }

  public function index(){
    // Tampilan Tabel Pasien Terlantar
    if (!permissible('sosial', 'readable')) {
      blokir();
    }
    // File
    $this->data['title'] = "Dinas Sosial - Tabel Pasien Terlantar";
    $this->data['sub_page'] = 'sosial/index';
    $this->data['main_menu'] = 'sosial';
    $this->load->view('layout/layout', $this->data);
  }

  public function historia(){
    // Hasil Data Model u Tabel Data Pasien Terlantar
    $result = $this->intidel->getPasienSosial();
    // Hasil
    echo json_encode($result);
  }

  public function detail($kode){
    // Tampilan Detail Pasien Terlantar
    if (!permissible('sosial', 'readable')) {
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
    $this->data['title'] = "Dinas Sosial - Detail Pasien Terlantar";
    $this->data['sub_page'] = 'sosial/detail';
    $this->data['main_menu'] = 'sosial';
    $this->load->view('layout/layout', $this->data);
  }

  public function republish(){
    // Tampilan Publish Pasien Terlantar
    if (!permissible('sosial', 'readable')) {
      blokir();
    }
    // Variable
    $inputs = $this->input->post();
    // ?
    trialTest($inputs);
  }
}