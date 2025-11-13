<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM menu_items WHERE aktif = 1";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Menu Seblak</title>
<style>
body { font-family: Arial; background: #fff8f0; }
.container { width: 800px; margin: 40px auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px #ffb347; }
h2 { color: #ff5e00; text-align: center; }
table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
th { background: #ff5e00; color: white; }
.btn { background: #00c853; color: white; padding: 6px 12px; border-radius: 5px; text-decoration: none; }
.logout { float: right; background: #e53935; padding: 6px 10px; color: white; border-radius: 5px; text-decoration: none; }
</style>
</head>
<body>

<div class="container">
    <a href="logout.php" class="logout">Logout</a>
    <h2>Selamat Datang, <?= $_SESSION['nama_lengkap']; ?> 👋</h2>
    <h3>Daftar Menu Seblak Prasmanan</h3>

    <form method="POST" action="proses_pesan.php">
        <table>
            <tr>
                <th>Pilih</th>
                <th>Nama Item</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Jumlah</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><input type="checkbox" name="item_id[]" value="<?= $row['item_id']; ?>"></td>
                <td><?= $row['nama_item']; ?></td>
                <td><?= $row['kategori']; ?></td>
                <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
                <td><?= $row['stok']; ?></td>
                <td><input type="number" name="jumlah_<?= $row['item_id']; ?>" min="1" max="<?= $row['stok']; ?>" value="1"></td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <button type="submit" style="padding:10px 20px;background:#ff5e00;color:white;border:none;border-radius:6px;">Pesan Sekarang</button>
    </form>
</div>

</body>
</html>
