<?php
// Informasi koneksi ke database
$host = "localhost"; // Nama host database (biasanya localhost)
$username = "root"; // Nama pengguna database
$password = ""; // Kata sandi database (kosongkan jika tidak ada)
$database = "sait_db_uts"; // Nama database yang digunakan

// Membuat koneksi
$koneksi = mysqli_connect($host, $username, $password, $database);

// Memeriksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
