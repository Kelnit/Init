<?php
// Hub Model - Hub Controller
defined('BASEPATH') or exit('No direct script access allowed');

class Hub_model extends CI_Model {
  // Model Build Only to Handle Hub Controller
  public function __construct(){
    // Model Builder
    parent::__construct();
  }

  public function get_all_patient() {
    // Total Keseluruhan Pasien
    return $this->db->count_all('patient');
  }

  public function get_in_number($col, $val, $table) {
    // Total in Digit & Persen
    $subquery = "(SELECT COUNT(*) FROM $table)";
    // Final Query
    $setup = "COUNT(*) AS total, ROUND(IFNULL(COUNT(*) * 100.0 / NULLIF($subquery, 0), 0), 2) AS pct";
    // Model Query Builder
    $this->db->select($setup);
    $this->db->from($table);
    $this->db->where($col, $val);
    $query = $this->db->get();
    return $query->row_array();
  }

  public function get_trend_regis() {
    // Tren Registrasi Baru per Bulan Dalam Tahun Ini
    $startYear = date('Y-01-01');
    $nextYear = date('Y-01-01', strtotime('+1 year'));
    // Model Query Builder
    $this->db->select('MONTH(regisdate) AS bulan, COUNT(*) AS total');
    $this->db->from('sosial');
    $this->db->where('regisdate >=', $startYear);
    $this->db->where('regisdate <', $nextYear);
    $this->db->group_by('MONTH(regisdate)');
    // Hasil
    $rows  = $this->db->get()->result_array();
    $hasil = array_fill(1, 12, 0);
    foreach ($rows as $row) $hasil[(int) $row['bulan']] = (int) $row['total'];
    return array_values($hasil);
  }

  public function get_trend_nmlos() {
    // Tren Rata Rata Masa Tinggal Diluar Ranap per Bulan Dalam Tahun Ini
    $startYear = date('Y-01-01');
    $nextYear = date('Y-01-01', strtotime('+1 year'));
    // Model Query Builder
    $this->db->select('MONTH(tgljemput) AS bulan, AVG(DATEDIFF(tgljemput, tglselesai)) AS rata');
    $this->db->from('sosial');
    $this->db->where('dijemput', true);
    $this->db->where('tgljemput >=', $startYear);
    $this->db->where('tgljemput <', $nextYear);
    $this->db->group_by('MONTH(tgljemput)');
    $rows  = $this->db->get()->result_array();
    // Hasil
    $hasil = array_fill(1, 12, 0);
    foreach ($rows as $row) $hasil[(int) $row['bulan']] = round((float) $row['rata'], 1);
    return array_values($hasil);
  }

  public function get_avg_wait_days_this_month() {
    // Rata Rata Masa Tinggal Diluar Medis Bulan Ini
    $firstDayThisMonth = date('Y-m-01');
    $firstDayNextMonth = date('Y-m-01', strtotime('first day of next month'));
    // Model Query Builder
    $this->db->select_avg('DATEDIFF(tgljemput, tglselesai)', 'rata');
    $this->db->from('sosial');
    $this->db->where('dijemput', true);
    $this->db->where('tgljemput >=', $firstDayThisMonth);
    $this->db->where('tgljemput <', $firstDayNextMonth);
    $result = $this->db->get()->row_array();
    return round((float) ($result['rata'] ?? 0), 1);
  }

  public function get_avg_wait_days_last_month() {
    // Rata Rata Masa Tinggal Diluar Medis Bulan Lalu
    $firstDayLastMonth = date('Y-m-01', strtotime('first day of last month'));
    $firstDayThisMonth = date('Y-m-01');
    // Model Query Builder
    $this->db->select_avg('DATEDIFF(tgljemput, tglselesai)', 'rata');
    $this->db->from('sosial');
    $this->db->where('dijemput', true);
    $this->db->where('tgljemput >=', $firstDayLastMonth);
    $this->db->where('tgljemput <', $firstDayThisMonth);
    $result = $this->db->get()->row_array();
    return round((float) ($result['rata'] ?? 0), 1);
  }
}

?>