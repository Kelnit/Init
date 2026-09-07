<?php
// Wilayah Controller : Handle Data Wilayah (Provinsi, Kabupaten, Kecamatan, Desa) Lokal
defined('BASEPATH') or exit('No direct script access allowed');

class Wilayah extends MainController {
  // Wilayah Controller Builder
  public function __construct(){
    // Parent Builder
    parent::__construct();
    // Model
    $this->load->model('wilayah_model', 'model');
  }

  public function kota(){
    // Hasil Data Model u Tabel Data Wilayah Kota
    $results = $this->model->getKota();
    // Hasil
    echo json_encode($results);
  }

  public function kecamatan($kotaKey){
    // Penyesuaian Format Key u Tabel Data Wilayah Kecamatan
    $kotaKey = str_replace('-', '.', $kotaKey);
    // Hasil Data Model u Tabel Data Wilayah Kecamatan
    $results = $this->model->getKecamatan($kotaKey);
    // Hasil
    echo json_encode($results);
  }

  public function kelurahan($kecamatanKey){
    // Penyesuaian Format Key u Tabel Data Wilayah Kelurahan
    $kecamatanKey = str_replace('-', '.', $kecamatanKey);
    // Hasil Data Model u Tabel Data Wilayah Kelurahan
    $results = $this->model->getKelurahan($kecamatanKey);
    // Hasil
    echo json_encode($results);
  }
}

?>