<?php
//  Koneksi database - Perpustakaan Mini (VERSI RENTAN)
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'perpus_rentan';

mysqli_report(MYSQLI_REPORT_OFF);

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$conn) {
    die('Koneksi dtabase gagal "'
        . $DB_NAME . '" udh diimport dari database/schema.sql.');
}
mysqli_set_charset($conn, 'utf8mb4');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
