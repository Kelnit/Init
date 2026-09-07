<?php
// Inti Model - Inti Controller
defined('BASEPATH') or exit('No direct script access allowed');

class Inti_model extends CI_Model {
  // Model Build Only to Handle Seluruh Controller
  public function __construct(){
    // Model Builder
    parent::__construct();
  }

  private function seluruhTabular($filter = array()){
    // Primary Helper u Data Primary Tabel
    $columns = 'p.kode, p.mrn, p.fullname, p.gender, p.datang, p.kondisi, p.lokasi, s.regisdate, s.identity, s.keluarga';
    $this->db->select($columns);
    $this->db->from('patient p');
    $this->db->join('sosial s', 'p.kode = s.patientKey', 'left');
    $this->db->where('p.isactive', 1);
    if (!empty($filter)) $this->db->where($filter);
    $query = $this->db->get();
    return $query->result_array();
  }

  private function upsertByPatientKey($table, $inputs) {
    // Primary Helper u Insert & Melakukan Perubahan Data
    if (empty($table) || empty($inputs['patientKey'])) {
      return false;
    }
    // Model Query Builder I
    $this->db->where('patientKey', $inputs['patientKey']);
    $query = $this->db->get($table);
    if ($query->num_rows() > 0) {
      // Model Query Builder II - Hapus Query Sebelumnya & Melakukan Update Data
      $this->db->reset_query();
      $this->db->where('patientKey', $inputs['patientKey']);
      return $this->db->update($table, $inputs);
    }
    // Model Query Builder III - Hapus Query Sebelumnya
    $this->db->reset_query();
    // Model Query Builder IV - Melakukan Insert Data
    return $this->db->insert($table, $inputs);
  }

  public function getAllPasienTerlantar() {
    // Tampilkan Data Seluruh Pasien Terlantar
    return $this->seluruhTabular(array());
  }

  public function getPasienSipil() {
    // Tampilkan Data Seluruh Pasien Sipil
    return $this->seluruhTabular(array());
  }

  public function getPasienSosial() {
    // Tampilkan Data Seluruh Pasien Sosial
    $cols = "p.kode, p.fullname, p.kondisi, p.kota, s.identity, s.keluarga, s.selesai, s.tglselesai";
    $this->db->select($cols);
    $this->db->from('patient p');
    $this->db->join('sosial s', 's.patientKey = p.kode');
    $this->db->where('p.isactive', 1);
    $this->db->where('p.deleted', null);
    return $this->db->get()->result_array();
  }

  public function getPasienBaznas() {
    // Tampilkan Data Seluruh Pasien Baznas
    return $this->seluruhTabular(array('p.agama' => 'Islam'));
  }

  public function publishDataPasien($inputs) {
    // Melakukan Data Input & Perubahan Data Pada Tabel Patient
    if (empty($inputs)) return false;
    // Melakukan Input Data Baru Jika Kode Kosong
    if (empty($inputs['kode'])) {
      // Input Data
      $kode = hashslinging();
      $inputs['kode'] = $kode;
      $this->db->insert('patient', $inputs);
      return $inputs['kode'];
    }
    // Melakukan Perubahan Data Jika Kode Tidak Kosong
    $filter = array('kode' => $inputs['kode']);
    $this->db->where($filter);
    unset($inputs['kode']);
    $this->db->update('patient', $inputs);
    return $inputs['kode'];
  }

  public function publishDataSosial($inputs) {
    // Melakukan Data Input & Perubahan Data Pada Tabel Sosial
    return $this->upsertByPatientKey('sosial', $inputs);
  }

  public function publishDataPengantar($inputs) {
    // Melakukan Data Input & Perubahan Data Pada Tabel Pengantar
    return $this->upsertByPatientKey('pengantar', $inputs);
  }

  public function publishDataKeluarga($inputs) {
    // Melakukan Data Input & Perubahan Data Pada Tabel Keluarga
    return $this->upsertByPatientKey('keluarga', $inputs);
  }

  public function getPasienByKode($kode) {
    // Mendapatkan Data Dari Tabel Patient Sesuai Dengan Data Pasien
    $filter = array('kode' => $kode);
    $this->db->where($filter);
    $query = $this->db->get('patient');
    return $query->row_array();
  }

  public function getSosialByPatientKey($kode) {
    // Mendapatkan Data Dari Tabel Sosial Sesuai Dengan Data Pasien
    $filter = array('patientKey' => $kode);
    $this->db->where($filter);
    $query = $this->db->get('sosial');
    return $query->row_array();
  }

  public function getKeluargaByPatientKey($kode) {
    // Mendapatkan Data Dari Tabel Keluarga Sesuai Dengan Data Pasien
    $filter = array('patientKey' => $kode);
    $this->db->where($filter);
    $query = $this->db->get('keluarga');
    return $query->row_array();
  }

  public function getPengantarByPatientKey($kode) {
    // Mendapatkan Data Dari Tabel Pengantar Sesuai Dengan Data Pasien
    $filter = array('patientKey' => $kode);
    $this->db->where($filter);
    $query = $this->db->get('pengantar');
    return $query->row_array();
  }

  public function getDokumenByPatientKey($kode) {
    // Mendapatkan Data Dari Tabel Dokumen Sesuai Dengan Data Pasien
    $filter = array('patientKey' => $kode);
    $this->db->where($filter);
    $query = $this->db->get('dokumen');
    return $query->result_array();
  }

  public function disableDataPasien($kode) {
    // Melakukan Disable Data Pasien Terlantar
    if (empty($kode)) return false;
    $filter = array('kode' => $kode);
    $this->db->where($filter);
    $inputs = array('isactive' => 0);
    return $this->db->update('patient', $inputs);
  }
}