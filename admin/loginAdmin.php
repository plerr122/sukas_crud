<?php
session_start();
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $_SESSION['error'] = 'Username dan password wajib diisi.';
        header('Location: loginAdmin.php');
        exit;
    }

    // Gunakan prepared statement untuk mencegah SQL injection
    $stmt = mysqli_prepare($koneksi, 'SELECT user_id, username, password, nama_lengkap, role FROM users WHERE username = ? LIMIT 1');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $data = mysqli_fetch_assoc($result);

            if ($data['role'] !== 'admin') {
                $_SESSION['error'] = 'Anda tidak memiliki akses admin!';
                header('Location: loginAdmin.php');
                exit;
            }

            if (password_verify($password, $data['password'])) {
                // Set session
                $_SESSION['admin_login'] = true;
                $_SESSION['admin_name']  = $data['nama_lengkap'];
                $_SESSION['admin_id']    = $data['user_id'];

                // Redirect ke dashboard admin (relatif ke folder admin/)
                header('Location: ../create.php');
                exit;
            } else {
                $_SESSION['error'] = 'Password salah!';
                header('Location: loginAdmin.php');
                exit;
            }
        } else {
            $_SESSION['error'] = 'Username tidak ditemukan!';
            header('Location: loginAdmin.php');
            exit;
        }
    } else {
        $_SESSION['error'] = 'Gagal mempersiapkan query.';
        header('Location: loginAdmin.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { width: 320px; margin: 80px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #9c0000ff; border-radius: 4px; box-sizing: border-box; }
        #submit { width: 100%; padding: 10px; background-color: #9c0000ff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        #submit:hover { background-color: #b30000ff; }
        .error { color: #b30000; margin-bottom: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login Admin</h1>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form method="post" action="loginAdmin.php">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <button id="submit" type="submit">Submit</button>
        </form>
    </div>
</body>
</html>