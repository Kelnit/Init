<?php
// Wilayah Model : Ambil Data Wilayah (Kabupaten Kota, Kecamatan, Kelurahan)
defined('BASEPATH') or exit('No direct script access allowed');

class Wilayah_model extends CI_Model {
  // Wilayah Model Melakukan Handling Data Wilayah
  public function __construct(){
    // Construct Parent
    parent::__construct();
  }

  public function getKota() {
    // Model u Melakukan Pengambilan Data Wilayah Kabupaten Kota
    $this->db->select('kode, nama');
    $this->db->where('induk_kode', 13);
    $this->db->order_by('nama', 'ASC');
    $query = $this->db->get('wilayah');
    // Hasil
    return $query->result();
  }

  public function getKecamatan($kotaKey) {
    // Model u Melakukan Pengambilan Data Wilayah Kecamatan
    $this->db->select('kode, nama');
    $this->db->where('induk_kode', $kotaKey);
    $this->db->order_by('nama', 'ASC');
    $query = $this->db->get('wilayah');
    // Hasil
    return $query->result();
  }

  public function getKelurahan($kecamatanKey) {
    // Model u Melakukan Pengambilan Data Wilayah Kelurahan
    $this->db->select('kode, nama');
    $this->db->where('induk_kode', $kecamatanKey);
    $this->db->order_by('nama', 'ASC');
    $query = $this->db->get('wilayah');
    // Hasil
    return $query->result();
  }
}

?>