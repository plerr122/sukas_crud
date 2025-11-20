<?php
include 'koneksi.php';
$query = "SELECT * FROM menu_items ORDER BY item_id ASC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Menu Seblak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff8f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 800px;
            margin: 50px auto;
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ffb347;
        }
        h2 {
            text-align: center;
            color: #ff5e00;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background: #ff5e00;
            color: white;
        }
        a.btn {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
        }
        .btn-add { background: #00c853; }
        .btn-edit { background: #ffb300; }
        .btn-del { background: #e53935; }
    </style>
</head>
<body>

<div class="container">
    <h2>Daftar Menu Seblak Prasmanan</h2>

    <a href="create.php" class="btn btn-add">+ Tambah Menu</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama Item</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['item_id']; ?></td>
            <td><?= $row['nama_item']; ?></td>
            <td><?= $row['kategori']; ?></td>
            <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
            <td><?= $row['stok']; ?></td>
            <td>
                <a href="update.php?id=<?= $row['item_id']; ?>" class="btn btn-edit">Edit</a>
                <a href="delete.php?id=<?= $row['item_id']; ?>" 
                   class="btn btn-del"
                   onclick="return confirm('Yakin mau hapus <?= $row['nama_item']; ?> ?')">
                   Hapus
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="logout.php">Log Out</a>
</div>

</body>
</html>
