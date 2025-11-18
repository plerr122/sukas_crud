<?php
include 'koneksi.php';

// Proses form jika disubmit
if (isset($_POST['simpan'])) {
    $nama_item = $_POST['nama_item'];
    $kategori  = $_POST['kategori'];
    $harga     = $_POST['harga'];
    $stok      = $_POST['stok'];

    // Query insert
    $query = "INSERT INTO menu_items (nama_item, kategori, harga, stok)
              VALUES ('$nama_item', '$kategori', '$harga', '$stok')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Menu berhasil ditambahkan!'); window.location='list_menu.php';</script>";
    } else {
        echo "Gagal menambah data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Menu Seblak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff8f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 400px;
            margin: 60px auto;
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ffb347;
        }
        h2 {
            text-align: center;
            color: #ff5e00;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ddd;
        }
        button {
            background: #ff5e00;
            color: white;
            border: none;
            padding: 10px 15px;
            width: 100%;
            border-radius: 6px;
            margin-top: 15px;
            cursor: pointer;
        }
        button:hover {
            background: #ff7b3d;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #333;
            text-decoration: none;
        }
    </style>
</head>
<body>

<button>Log Out</button>

<div class="container">
    <h2>Tambah Menu Seblak</h2>
    <form method="POST" action="">
        <label>Nama Item</label>
        <input type="text" name="nama_item" required>

        <label>Kategori</label>
        <select name="kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="bahan utama">Bahan Utama</option>
            <option value="topping">Topping</option>
            <option value="level pedas">Level Pedas</option>
            <option value="tambahan">Tambahan</option>
        </select>

        <label>Harga (Rp)</label>
        <input type="number" name="harga" min="0" required>

        <label>Stok</label>
        <input type="number" name="stok" min="0" required>

        <button type="submit" name="simpan">Simpan</button>
        <a href="list_menu.php">Kembali</a>
    </form>
</div>

</body>
</html>
