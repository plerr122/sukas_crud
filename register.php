<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = $_POST['nama_lengkap'];

    $query = "INSERT INTO users (username, password, nama_lengkap, role) 
              VALUES ('$username', '$password', '$nama', 'pelanggan')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Akun</title>
<style>
body { font-family: Arial; background: #fff8f0; }
.container { width: 350px; margin: 80px auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px #ffb347; }
button { background: #ff5e00; color: white; border: none; padding: 10px; width: 100%; border-radius: 6px; margin-top: 10px; cursor: pointer; }
</style>
</head>
<body>
<div class="container">
<h2>Daftar Akun Pelanggan</h2>
<form method="POST">
    <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required><br><br>
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="register">Daftar</button>
    <p>Sudah punya akun? <a href="login.php">Login</a></p>
</form>
</div>
</body>
</html>
