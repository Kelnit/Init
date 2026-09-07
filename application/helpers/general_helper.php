<?php
// Helper Function
defined('BASEPATH') or exit('No direct script access allowed');

// Variable Tetap - Total Jumlah Percobaan Sign In Dalam 1 Menit
if (!defined('MAX_LOGIN_ATTEMPTS')) define('MAX_LOGIN_ATTEMPTS', 5);
// Variable Tetap - Berapa Detik Batas Tak Bisa Sign In
if (!defined('THROTTLE_SECONDS')) define('THROTTLE_SECONDS', 60);

function totalBelumSelesai() {
  $ci = &get_instance();
  $ci->db->where('selesai', false);
  $ci->db->from('sosial');
  $ci->db->join('patient', 'patient.kode = sosial.patientKey');
  $ci->db->where('patient.isactive', true);
  $query = $ci->db->get();
  return $query->num_rows();
}

function permissible($permission, $can) {
  // Cek Apakah Role Yang Sedang Login Punya Hak Akses Tertentu
  $ci = &get_instance();
  $roleKey = $ci->session->userdata('roleKey');
  // Belum Login, Nggak Ada roleKey Sama Sekali
  if (!$roleKey) return false;
  // Super Admin Selalu Boleh Akses Apapun
  if ($roleKey == 1) return true;
  // Ambil Semua Privilege Milik Role Ini
  $listofables = permitable($roleKey);
  // Cek Satu Per Satu, Cocokkan Label & Hak Akses Yang Diminta
  foreach ($listofables as $permObject) {
    if ($permObject['permission_label'] == $permission && $permObject[$can] == '1') {
      return true;
    }
  }
  return false;
}
 
function permitable($id) {
  // Ambil Semua Privilege Milik Role Tertentu Dari View roleview
  $ci = &get_instance();
  $ci->db->select('permission_label, readable, creatable, editable, deletable');
  $ci->db->where('role_id', $id);
  $ci->db->where('privilege_status', 1);
  $result = $ci->db->get('roleview')->result_array();
  return $result;
}

function blokir() {
  alerta('error', "Tidak Punya Ijin !");
  redirect(base_url('hub'));
}

function trialTest($data) {
  // Trial Error Controller Helper
  echo "<pre>";
  var_dump($data);
  echo "</pre>";
  exit();
}

function terminalTest($label, $data = null) {
  // Cetak Log ke Terminal, Tidak Menghentikan Eksekusi
  $output = "[LOG] " . $label;
  if ($data !== null) {
    $output .= ": " . print_r($data, true);
  }
  error_log($output);
}

function loggedin(){
  // Sign In ?
  $ci = &get_instance();
  // True or False
  return $ci->session->userdata('islogin') === true;
}

function alerta($type, $message){
  // Panel Helper
  $ci = &get_instance();
  // Flash Data Alert
  $ci->session->set_flashdata('alert-' . $type, $message);
}

function hashslinging($length = 7){
  // Hash Slicing Creator
  $hash = md5(rand() . microtime() . time() . uniqid());
  // ?
  return substr($hash, 0, $length);
}

function userids(){
  // Panel Helper User Key
  $ci = &get_instance();
  // Hasil
  return $ci->session->userdata('kode');
}

function throttleKey($nik) {
  // Buat Identifier Unik Buat Simpan Data Percobaan Sign In
  return 'login_attempts_' . md5($nik);
}

function isThrottle($nik) {
  // User in Limit ?
  $ci = &get_instance();
  $data = $ci->session->userdata(throttleKey($nik));
  if (!$data) return false;
  // Apakah Sudah Kena Batas Maksimal ?
  if ($data['count'] >= MAX_LOGIN_ATTEMPTS) {
    // Hitung Selisih Waktu Dari Percobaan Terakhir
    $elapsed = time() - $data['last_attempt'];
    // Kalau Belum Lewat Waktu Kunci
    if ($elapsed < THROTTLE_SECONDS) {
      // User in Limit !
      return true;
    }
    // Ulang !
    resetcounter($nik);
  }
  return false;
}

function dataUjiCoba($nik) {
  // Catat Percobaan Gagal, Tambah Hitungan 1
  $ci = &get_instance();
  $key = throttleKey($nik);
  $data = $ci->session->userdata($key);
  // Kalau Belum Pernah Gagal, Mulai Dari 1
  $count = $data ? $data['count'] + 1 : 1;
  // Data Baru Buat Di Simpan
  $setdata = array('count' => $count, 'last_attempt' => time());
  // Simpan Balik Ke Session
  $ci->session->set_userdata($key, $setdata);
}

function resetcounter($nik) {
  // Bersihkan Hitungan Percobaan Gagal
  $ci = &get_instance();
  // Hapus Catatan Percobaan Dari Session
  $ci->session->unset_userdata(throttleKey($nik));
}

if (!defined('PASSWORD_PEPPER')) define('PASSWORD_PEPPER', 'doomsday');

function kataSandi($mode, $password, $hash = null) {
  // Gabung Password Dengan Pepper Sebelum Diproses
  $peppered = hash_hmac('sha256', $password, PASSWORD_PEPPER);
  // Bikin Kata Sandi Baru
  if ($mode === 'hash') return password_hash($peppered, PASSWORD_DEFAULT);
  // Mode Match Kata Sandi
  if ($mode === 'verify') {
    // Cocokkan Password Yang Diketik User Dengan Hash Di Database
    if (!$hash) return false;
    // Bandingkan Hasil Peppered Dengan Hash Tersimpan
    return password_verify($peppered, $hash);
  }
  return false;
}

function roletounit($number) {
  $ci = &get_instance();
  $filter = array('id' => $number);
  $ci->db->select('nama');
  $ci->db->where($filter);
  $result = $ci->db->get('roles')->row();
  return $result ? $result->nama : null;
}

function esc($v) { return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); }

?>