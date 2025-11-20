<?php
session_start();
include '../koneksi.php'; // file koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data user
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika username ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Cek password HASH
        if (password_verify($password, $row['password'])) {

            // Cek role pelanggan
            if ($row['role'] !== "pelanggan") {
                echo "<script>alert('Akun ini bukan pelanggan!'); window.location='userPage.php;</script>";
                exit;
            }

            // Simpan session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            echo "<script>alert('Login Berhasil!'); window.location='userPage.php';</script>";
        } else {
            echo "<script>alert('Password salah!'); window.location='loginUsers.php';</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!'); window.location='loginUsers.php';</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Users</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #9c0000ff;
            border-radius: 4px;
        }

        #submit {
            width: 95%;
            padding: 10px;
            background-color: #9c0000ff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #submit:hover {
            background-color: #b30000ff;
            width: 97%;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Login Users</h1>

    <form action="" method="POST">
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />

        <button id="submit" type="submit">Submit</button>
    </form>

    <p>Belum Punya Akun? <a href="registerUsers.php">Register</a></p>
    </div>
</body>
</html>
