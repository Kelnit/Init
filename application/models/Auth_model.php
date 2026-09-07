<?php
// Auth Model - Auth Controller
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model {
  // Model Build
  public function __construct(){
    // Model Builder
    parent::__construct();
  }

  public function login($nik, $pwd){
    // Multi Tabel Sign In : Login Credential, Staff
    $resultset = false;
    // Filter
    $filter = array('nik' => $nik, 'isactive' => 1);
    $this->db->where($filter);
    $reroles = $this->db->get('login_credential')->row_array();
    // Kalau Data Available
    if ($reroles && kataSandi('verify', $pwd, $reroles['password'])) {
      // Data Sign In
      $this->db->where('nik', $nik);
      $lastlogin = array('last_login' => date('Y-m-d H:i:s'));
      $this->db->update('login_credential', $lastlogin);
      // Hasil Model
      $resultset = $this->db->where($filter)->get('staff')->row_array();
    }
    return $resultset;
  }

  public function register($data){
    // Tabel Mulai
    $this->db->trans_start();
    // Variable
    $userKey = hashslinging();
    // Tabel Login Credential
    $incredentials = array('userKey' => $userKey, 'nik' => $data['nik'], 'roleKey' => $data['roleKey']);
    // Kata Sandi
    $incredentials['password'] = kataSandi('hash', $data['password']);
    // Insert
    $this->db->insert('login_credential', $incredentials);
    // Del Kata Sandi
    unset($data['password']);
    // Tabel Patients
    $data['kode'] = $userKey;
    $this->db->insert('staff', $data);
    $this->db->trans_complete();
    return $this->db->trans_status();
  }
}

?>