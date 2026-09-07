<?php
// Auth Controller : Sign In, Sign Up, Sign Out, & Publish Data User
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends OutController {
  // Auth Controller Builder
  public function __construct(){
    // Parent Builder
    parent::__construct();
    // Model
    $this->load->model('auth_model', 'authmodel');
  }

  public function login() {
    // Controller u Melakukan Sign In & Sebagai Main File
    if (loggedin()) return redirect(base_url('hub'));
    // Input Sign In
    if ($this->input->post()){
      // Variable I
      $nik = trim($this->input->post('usernik'));
      // Variable II
      $pwd = trim($this->input->post('password'));
      // Wajib Terisi Keduanya
      if ($nik && $pwd){
        // Kalau Terlalu Banyak Usaha Sign In & Selalu Fail !
        if (isThrottle($nik)) {
          // Fail
          $errFail = "Terlalu Banyak Percobaan Gagal ! Silahkan Coba Lagi";
          alerta('error', $errFail);
          return redirect(base_url());
        }
        // Kalau Sistem Berhasil !
        try {
          $result = $this->authmodel->login($nik, $pwd);
          // Kalau Sign In Berhasil !
          if ($result && $result['isactive'] == 1) {
            resetcounter($nik);
            $this->session->sess_regenerate(TRUE);
            $sessiondata = array(
              'id' => $result['id'],
              'kode' => $result['kode'],
              'usernik' => $result['nik'],
              'name' => $result['fullname'],
              'roleKey' => $result['roleKey'],
              'islogin' => true
            );
            // Hasil !
            $this->session->set_userdata($sessiondata);
            $this->session->set_flashdata('show_notif', true);
            return redirect(base_url('hub'));
          } else {
            // Kalau User Sign In Gagal | User Tidak Aktif | Data Uji Coba Plus Satu
            dataUjiCoba($nik);
            $message = "Login Gagal, Pastikan NIK dan Password Benar !";
            alerta('error', $message);
            return redirect(base_url());
          }
        } catch (exception $err) {
          // Kalau Terjadi Kesalahan Sistem !
          $errFailErr = "Terjadi Kesalahan Sistem ! Coba Lagi !";
          alerta('error', $errFailErr);
          return redirect(base_url());
        }
      } else {
        // Ada Variable Tidak Lengkap !
        $errElse = "Login Gagal ! Pastikan Semua Kolom Terisi !";
        alerta('error', $errElse);
        return redirect(base_url(''));
      }
    }
    // File
    $this->data['title'] = "Login Aplikasi Sipiter";
    $this->data['sub_page'] = 'auth/login';
    $this->data['main_menu'] = 'auth';
    $this->load->view('layout/layout', $this->data);
  }

  public function register(){
    // Panel Pendaftaran User Aplikasi
    $this->data['title'] = 'Panel Pendaftaran Sipiter';
    $this->data['sub_page'] = 'auth/register';
    $this->data['main_menu'] = 'auth';
    $this->load->view('layout/layout', $this->data);
  }

  public function publish(){
    // Main Controller u Melakukan Publish Data User
    $inputs = $this->input->post();
    // Proses Simpan Ke Database
    try {
      $result = $this->authmodel->register($inputs);
      // Cek Hasil Insert
      if ($result) {
        // Berhasil !
        alerta('success', "Pendaftaran Berhasil !");
      } else {
        // Fail !
        alerta('danger', "Pendaftaran Tidak Berhasil !");
      }
    } catch (exception $err) {
      // Kalau Terjadi Kesalahan Sistem !
      alerta('danger', "Terjadi Kesalahan Sistem ! Silahkan Coba Lagi !");
    }
    return redirect(base_url(''));
  }

  public function logout(){
    // Disable User !
    $this->session->sess_destroy();
    // Kembali
    return redirect(base_url());
  }
}

?>