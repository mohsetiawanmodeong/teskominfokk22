<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-type: application/json');

require_once './conf.php';
require_once './model.php';

try {
  if ($_SERVER['PATH_INFO'] != '/daftar') {
    http_response_code(404);
    throw new Exception('Laman tidak ditemukan.');
  }
  if (!$_POST) {
    http_response_code(405);
    throw new Exception('Metode tidak diperbolehkan.');
  }

  if (date('U') < $appsetup['start']) throw new Exception('Pendaftaran belum dimulai.');

  $nik = filter_input(INPUT_POST, 'nik', FILTER_SANITIZE_NUMBER_INT);
  $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
  $alamat = filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING);
  $surel = filter_input(INPUT_POST, 'surel', FILTER_VALIDATE_EMAIL);

  if (strlen($nik) != 16) throw new Exception('Jumlah karakter NIK tidak sesuai 16 karakter.');
  if (strlen($nama) < 3 || strlen($alamat) < 3) throw new Exception('Ada isian wajib yang tidak diisi/kosong.');
  if (strlen($_POST['surel'] > 3) && !$surel) throw new Exception('Alamat surel yang diisi tidak valid.');

  $data = [
    'tahun' => $appsetup['tahun'],
    'bulan' => $appsetup['bulan'],
    'nik' => $nik,
    'nama' => $nama,
    'alamat' => $alamat,
    'surel' => $surel
  ];

  $db = new Db($dbsetup);
  $db->db()->beginTransaction();
  if ($db->countRegistration($data)->st()->fetchColumn() < $appsetup['limit']) {
    $db->addRegistration($data);
    $id = $db->db()->lastInsertId();
    if ($db->countRegistration($data)->st()->fetchColumn() > $appsetup['limit']) {
      $db->db()->rollBack();
      throw new Exception('Pendaftaran sudah mencapai batas.');
    } else
      $db->db()->commit();
    if ($id > 0) {
      $output['error'] = 0;
      $output['message'] = 'Pendaftaran berhasil.';
    } else throw new Exception('Pendaftaran gagal.');
  } else {
    $db->db()->rollBack();
    throw new Exception('Pendaftaran sudah mencapai batas.');
  }
} catch (PDOException $e) {
  $output['message'] = $e->getMessage();
} catch (Exception $e) {
  $output['message'] = $e->getMessage();
}

echo json_encode($output);
