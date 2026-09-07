<?php
// User Controller : Handle Data User Aplikasi Sipiter
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MainController {
  // User Controller Builder
  public function __construct(){
    // Parent Builder
    parent::__construct();
    // Model
    $this->load->model('user_model', 'usedel');
  }

  public function index(){
    // Main Tampilan User
    if (!permissible('user', 'readable')) {
      blokir();
    }
    // Hasil
    $this->data['results'] = $this->usedel->getAllUser();
    // File
    $this->data['title'] = 'Tabel User Aplikasi Sipiter';
    $this->data['sub_page'] = 'user/index';
    $this->data['main_menu'] = 'user';
    $this->load->view('layout/layout', $this->data);
  }

  public function insert(){
    // Tampilan Tambah User
    if (!permissible('user', 'creatable')) {
      blokir();
    }
    // File
    $this->data['title'] = 'Tambah User Aplikasi Sipiter';
    $this->data['sub_page'] = 'user/insert';
    $this->data['main_menu'] = 'user';
    $this->load->view('layout/layout', $this->data);
  }

  public function publish(){
    // Publish Data User
    if (!permissible('user', 'creatable')) {
      blokir();
    }
    // Variable Input
    $inputs = $this->input->post();
    // Model Insert User
    $result = $this->usedel->publishDataUser($inputs);
    // Hasil Insert User
    if ($result) {
      // Alert
      alerta('success', "Data User Berhasil Ditambahkan !");
    } else {
      // Kalau Fail | Alert
      alerta('error', "Data User Tidak Berhasil Ditambahkan !");
    }
    // Kembali Ke Tampilan User
    return redirect(base_url('user'));
  }

  public function detail($id){
    // Tampilan Detail User
    if (!permissible('user', 'readable')) {
      blokir();
    }
    // Hasil
    $this->data['result'] = $this->usedel->getUserByID($id);
    // File
    $this->data['title'] = 'Detail User Aplikasi Sipiter';
    $this->data['sub_page'] = 'user/detail';
    $this->data['main_menu'] = 'user';
    $this->load->view('layout/layout', $this->data);
  }

  public function repass($userKey){
    // Melakukan Reset Kata Sandi User
    if (!permissible('user', 'creatable')) {
      blokir();
    }
    try {
      $result = $this->usedel->reKataSandiUser($userKey);
      // Cek Hasil Model
      if ($result) {
        // Berhasil !
        alerta('success', "Melakukan Perubahan Kata Sandi Berhasil !");
      } else {
        // Fail !
        alerta('danger', "Melakukan Perubahan Kata Sandi Tidak Berhasil !");
      }
    } catch (exception $err) {
      // Kalau Terjadi Kesalahan Sistem !
      alerta('danger', "Terjadi Kesalahan Sistem ! Silahkan Coba Lagi !");
    }
    return redirect(base_url('user'));
  }

  public function delete($id){
    // Hapus Data user
    if (!permissible('user', 'deletable')) {
      blokir();
    }
    // Model Delete user
    $result = $this->usedel->disableUser($id);
    // Hasil Delete user
    if ($result) {
      // Alert
      alerta('success', "Data User Berhasil Dihapus !");
    } else {
      // Kalau Fail | Alert
      alerta('error', "Data User Tidak Berhasil Dihapus !");
    }
    // Kembali Ke Tampilan user
    return redirect(base_url('user'));
  }
}

?>