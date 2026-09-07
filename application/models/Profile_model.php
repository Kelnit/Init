<?php
// Profile Model to Profile Controller
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_model extends CI_Model {
  // Profile Model Melakukan Handling Data In & Data Out Profile User
  public function __construct(){
    // Construct Parent
    parent::__construct();
  }

  public function getProfileByID($key) {
    // Model u Melakukan Pengambilan Data Profile User
    $table = 'staff';
    $filter = array('kode' => $key);
    $this->db->where($filter);
    return $this->db->get($table)->row_array();
  }

  public function publishProfile($data) {
    // Model u Melakukan Update Data Profile
    $table = 'staff';
    $filter = array('kode' => $data['kode']);
    unset($data['kode']);
    $this->db->where($filter);
    return $this->db->update($table, $data);
  }

  public function publishKataSandi($data) {
    // Model u Melakukan Update Kata Sandi
    $filter = array('nik' => $data['nik']);
    $this->db->where($filter);
    $pass = kataSandi('hash', $data['password']);
    $update = array('password' => $pass);
    return $this->db->update('login_credential', $update);
  }
}