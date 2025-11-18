<?php
$host = "localhost";     
$user = "root";         
$pass = "";              
$db   = "seblak"; 

$koneksi = mysqli_connect($host, $user, $pass, $db);


if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
} else {
    // echo "Koneksi berhasil!"; // aktifkan buat debugging
}
?>
