<?php
// koneksi.php
$host = "localhost";
$username = "root";
$password = "";
$database = "spk_moora";
$port = 3308;

$koneksi = mysqli_connect($host, $username, $password, $database, $port);

if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
