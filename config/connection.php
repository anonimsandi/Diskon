<?php
// koneksi database
$host = "localhost";
$username = "root";
$password = "";
$database = "proyek-ukk";

$koneksi = new mysqli($host,$username,$password,$database);

// cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>