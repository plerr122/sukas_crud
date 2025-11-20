<?php
// ...existing code...
session_start();
include '../koneksi.php'; // gunakan koneksi dari root

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $_SESSION['error'] = 'Username dan password wajib diisi.';
        header('Location: registerUsers.php');
        exit;
    }

    // Cek apakah username sudah ada
    $stmt = mysqli_prepare($koneksi, 'SELECT user_id FROM users WHERE username = ? LIMIT 1');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_close($stmt);
            $_SESSION['error'] = 'Username sudah digunakan.';
            header('Location: registerUsers.php');
            exit;
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = 'Gagal mempersiapkan query.';
        header('Location: registerUsers.php');
        exit;
    }

    // Hash password dan simpan user baru
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $nama_lengkap = $username; // bisa diubah menjadi input terpisah jika mau
    $role = 'pelanggan'; // set default role

    $stmt = mysqli_prepare($koneksi, 'INSERT INTO users (username, password, nama_lengkap, role) VALUES (?, ?, ?, ?)');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssss', $username, $hashed, $nama_lengkap, $role);
        $exec = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($exec) {
            $_SESSION['success'] = 'Registrasi berhasil. Silakan login.';
            header('Location: loginUsers.php');
            exit;
        } else {
            $_SESSION['error'] = 'Gagal registrasi: ' . mysqli_error($koneksi);
            header('Location: registerUsers.php');
            exit;
        }
    } else {
        $_SESSION['error'] = 'Gagal mempersiapkan query insert.';
        header('Location: registerUsers.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Users</title>

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

        button {
            width: 95%;
            padding: 10px;
            background-color: #9c0000ff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #b30000ff;
            width: 97%;
        }

        .message { text-align:center; margin-bottom:10px; color:#b30000; }
        .success { color: #008000; }
    </style>
</head>
<body>
    <div class="container">
    <h1>Register User</h1>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="message"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="message success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form method="post" action="registerUsers.php">
        <input type="text" name="username" placeholder="Username" required value="<?php echo htmlspecialchars($_POST['username'] ?? '') ?>" />
        <input type="password" name="password" placeholder="Password" required />
        <button id="submit" type="submit">Submit</button>
    </form>
    <p style="text-align:center;margin-top:8px;"><a href="loginUsers.php">Sudah punya akun? Login</a></p>
    </div>
</body>
</html>
// ...existing code...