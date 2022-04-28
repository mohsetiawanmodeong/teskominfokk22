<?php

$appsetup = [
  'tahun' => 2022,
  'bulan' => 4,
  'start' => DateTime::createFromFormat('Y-m-d H:i:s', '2022-04-17 14:00:00')->format('U'),
  'limit' => 5
];

$dbsetup = [
  'host' => 'localhost',
  'user' => 'root',
  'pass' => '',
  'name' => 'senggol'
];

$output = [
  'error' => 1,
  'message' => 'Ada kesalahan.'
];
