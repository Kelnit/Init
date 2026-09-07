<?php
// User Model - User Controller
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model {
  // Model Build
  public function __construct(){
    // Model Builder
    parent::__construct();
  }

  public function getAllUser(){
    // Get All User
    $this->db->select('s.kode, s.nik, s.fullname, s.email, s.phone, r.nama, s.unit');
    $this->db->from('staff s');
    $this->db->join('roles r', 's.roleKey = r.id', 'left');
    $this->db->where('s.isactive', 1);
    $this->db->order_by('s.id', 'ASC');
    return $this->db->get()->result_array();
  }

  public function updateDataUser($data) {
    $userKey = $data['kode'];
    $this->db->where('kode', $userKey);
    unset($data['kode']);
    return $this->db->update('staff', $data);
  }

  public function publishDataUser($data) {
    // ?
    $isUpdate = !empty($data['kode']);
    // ?
    return $isUpdate ? $this->updateDataUser($data) : $this->insertDataUser($data);
  }

  public function getUserByID($key){
    // Get User By ID
    $this->db->select('*');
    $this->db->from('staff');
    $this->db->where('kode', $key);
    return $this->db->get()->row_array();
  }

  public function disableUser($key){
    // Disable User
    $this->db->trans_start();
    // Disable Staff
    $this->db->where('kode', $key);
    $this->db->update('staff', array('isactive' => false));
    // Disable Login Credential
    $this->db->where('userKey', $key);
    $this->db->update('login_credential', array('isactive' => false));
    $this->db->trans_complete();
    return $this->db->trans_status();
  }

  public function reKataSandiUser($userKey){
    // Melakukan Reset Kata Sandi User
    $this->db->trans_start();
    $this->db->where('userKey', $userKey);
    $password = array('password' => kataSandi('hash', 'password'));
    $this->db->update('login_credential', $password);
    $this->db->trans_complete();
    return $this->db->trans_status();
  }

}

?>