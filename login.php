<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
        $_SESSION['role'] = $data['role'];

        if ($data['role'] == 'admin') {
            header("Location: list_menu.php");
        } else {
            header("Location: user_menu.php");
        }
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login</title>
<style>
body { font-family: Arial; background: #fff8f0; }
.container { width: 350px; margin: 80px auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px #ffb347; }
button { background: #ff5e00; color: white; border: none; padding: 10px; width: 100%; border-radius: 6px; margin-top: 10px; cursor: pointer; }
</style>
</head>
<body>
<div class="container">
<h2>Login Seblak Prasmanan</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="login">Login</button>
    <p>Belum punya akun? <a href="register.php">Daftar</a></p>
</form>
</div>
</body>
</html>
