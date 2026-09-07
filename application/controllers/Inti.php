<?php
// Inti Controller : Handle Keluhan in Single Data
defined('BASEPATH') or exit('No direct script access allowed');

class Inti extends MainController {
  // Inti Controller Builder
  public function __construct(){
    // Parent Builder
    parent::__construct();
    // Model
    $this->load->model('inti_model', 'intidel');
  }

  public function index(){
    // Tampilan Tabel Pasien Terlantar
    if (!permissible('rsup', 'readable')) {
      blokir();
    }
    // File
    $this->data['title'] = "Tabel Pasien Terlantar";
    $this->data['sub_page'] = 'inti/index';
    $this->data['main_menu'] = 'inti';
    $this->load->view('layout/layout', $this->data);
  }

  public function historia(){
    // Hasil Data Model u Tabel Data Pasien Terlantar
    if (!permissible('rsup', 'readable')) {
      blokir();
    }
    // Hasil Tabel
    $result = $this->intidel->getAllPasienTerlantar();
    // Hasil
    echo json_encode($result);
  }

  public function insert(){
    // Tampilan Tabel Pasien Terlantar
    if (!permissible('rsup', 'readable')) {
      blokir();
    }
    // File
    $this->data['title'] = "Input Pasien Terlantar";
    $this->data['sub_page'] = 'inti/insert';
    $this->data['main_menu'] = 'inti';
    $this->load->view('layout/layout', $this->data);
  }

  public function publish(){
    // Publish Seluruh Data Input ke Multi Tabel : Patient, Sosial, Keluarga, Pengantar
    if (!permissible('rsup', 'creatable') || !permissible('rsup', 'editable')) {
      blokir();
    }
    // Variable Utama
    $inputs = $this->input->post();
    // Multi Variable
    $patient = $inputs['patient'];
    $pengantar = $inputs['pengantar'];
    $sosial = $inputs['sosial'];
    $keluarga = $inputs['keluarga'];
    // Model Chain Builder I
    $this->db->trans_start();
    $kode = $this->intidel->publishDataPasien($patient);
    $sosial['patientKey'] = $kode;
    $pengantar['patientKey'] = $kode;
    $keluarga['patientKey'] = $kode;
    // Model Chain Builder II
    $this->intidel->publishDataSosial($sosial);
    $this->intidel->publishDataPengantar($pengantar);
    $this->intidel->publishDataKeluarga($keluarga);
    $this->db->trans_complete();
    // Variable Hasil
    $status = $this->db->trans_status();
    // Hasil Kondisional Fail
    if ($status === false) {
      $errFail = 'Input Data Pasien Tidak Berhasil !';
      alerta('error', $errFail);
      return redirect(base_url('inti/insert'));
    }
    // Hasil Kondisional Berhasil !
    $berhasil = 'Input Data Pasien Berhasil !';
    alerta('success', $berhasil);
    return redirect(base_url('inti'));
  }

  public function detail($kode){
    // Tampilan Detail Satu Pasien Terlantar
    if (!permissible('rsup', 'readable')) {
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
    $this->data['title'] = 'Panel Detail Pasien Terlantar';
    $this->data['sub_page'] = 'inti/detail';
    $this->data['main_menu'] = 'inti';
    $this->load->view('layout/layout', $this->data);
  }

  public function repatient(){
    // Publish Perubahan Data Input Tabel Pasien
    if (!permissible('rsup', 'creatable') || !permissible('rsup', 'editable')) {
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
    return redirect(base_url('inti/detail/' . $inputs['patient']['kode']));
  }

  public function resocial(){
    // Publish Perubahan Data Input Tabel Sosial
    if (!permissible('rsup', 'creatable') || !permissible('rsup', 'editable')) {
      blokir();
    }
    // Variable Input
    $inputs = $this->input->post();
    // Model
    $result = $this->intidel->publishDataSosial($inputs['sosial']);
    // Hasil
    if ($result === false) {
      // Fail
      alerta('error', 'Perubahan Data Sosial Tidak Berhasil Disimpan !');
    } else {
      // Berhasil !
      alerta('success', 'Perubahan Data Sosial Berhasil Disimpan !');
    }
    // Kembali
    return redirect(base_url('inti/detail/' . $inputs['sosial']['patientKey']));
  }

  public function refamilia(){
    // Publish Perubahan Data Input Tabel Sosial
    if (!permissible('rsup', 'creatable') || !permissible('rsup', 'editable')) {
      blokir();
    }
    // Variable Input
    $inputs = $this->input->post();
    // Model
    $result = $this->intidel->publishDataKeluarga($inputs['keluarga']);
    // Hasil
    if ($result === false) {
      // Fail
      alerta('error', 'Perubahan Data Keluarga Tidak Berhasil Disimpan !');
    } else {
      // Berhasil
      alerta('success', 'Perubahan Data Keluarga Berhasil Disimpan !');
    }
    // Kembali
    return redirect(base_url('inti/detail/' . $inputs['keluarga']['patientKey']));
  }

  public function redeliver(){
    // Publish Perubahan Data Input Tabel Sosial
    if (!permissible('rsup', 'creatable') || !permissible('rsup', 'editable')) {
      blokir();
    }
    // Variable Input
    $inputs = $this->input->post();
    // Trial
    trialTest(["Del", $inputs]);
    // Model
    $result = $this->intidel->publishDataPengantar($inputs['pengantar']);
    // Hasil
    if ($result === false) {
      // Fail
      alerta('error', 'Perubahan Data Pengantar Tidak Berhasil Disimpan !');
    } else {
      // Berhasil
      alerta('success', 'Perubahan Data Pengantar Berhasil Disimpan !');
    }
    // Kembali
    return redirect(base_url('inti/detail/' . $inputs['pengantar']['patientKey']));
  }

  public function lokasi(){
    // Tampilan Lokasi Rawat Pasien Terlantar
    if (!permissible('rsup', 'readable')) {
      blokir();
    }
    // Variable
    $inputs = $this->input->post();
    // Model Tukar Lokasi
    $result = $this->intidel->publishDataPasien($inputs);
    // Hasil
    if ($result === false) {
      // Kalau Tidak Berhasil, Maka Tampilkan Pesan Error
      alerta('error', 'Data Lokasi Ranap Pasien Tidak Berhasil Diubah !');
    } else {
      // Kalau Berhasil, Maka Tampilkan Pesan Sukses
      alerta('success', 'Data Lokasi Ranap Pasien Berhasil Diubah !');
    }
    // Kembali
    return redirect(base_url('inti'));
  }

  public function disable($kode){
    // Disable Data Pasien Terlantar
    if (!permissible('rsup', 'deletable')) {
      blokir();
    }
    // Model Delete
    $result = $this->intidel->disableDataPasien($kode);
    // Hasil
    if ($result === false) {
      // Kalau Tidak Berhasil, Maka Tampilkan Pesan Error
      alerta('error', 'Data Pasien Terlantar Tidak Berhasil Dinonaktifkan !');
    } else {
      // Kalau Berhasil, Maka Tampilkan Pesan Sukses
      alerta('success', 'Data Pasien Terlantar Berhasil Dinonaktifkan !');
    }
    // Kembali
    return redirect(base_url('inti'));
  }
}

?>