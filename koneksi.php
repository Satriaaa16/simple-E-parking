<?php
$host = "localhost"; // atau sesuaikan dengan host Anda
$username = "root"; // atau sesuai dengan username database
$password = ""; // atau sesuai dengan password database Anda
$dbname = "e_parking"; // sesuaikan dengan nama database Anda

// Membuat koneksi ke database
$conn = mysqli_connect($host, $username, $password, $dbname);

// Memeriksa koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
