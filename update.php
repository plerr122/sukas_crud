<?php
include 'koneksi.php';

// Ambil data berdasarkan ID dari URL
if (isset($_GET['id'])) {
    $item_id = $_GET['id'];
    $query = "SELECT * FROM menu_items WHERE item_id = '$item_id'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        echo "<script>alert('Data tidak ditemukan!'); window.location='list_menu.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location='list_menu.php';</script>";
    exit;
}

// Proses update data
if (isset($_POST['update'])) {
    $nama_item = $_POST['nama_item'];
    $kategori  = $_POST['kategori'];
    $harga     = $_POST['harga'];
    $stok      = $_POST['stok'];

    $query = "UPDATE menu_items 
              SET nama_item='$nama_item', kategori='$kategori', harga='$harga', stok='$stok' 
              WHERE item_id='$item_id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Data berhasil diupdate!'); window.location='list_menu.php';</script>";
    } else {
        echo "Gagal update data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu Seblak</title>
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

<div class="container">
    <h2>Edit Menu Seblak</h2>
    <form method="POST" action="">
        <label>Nama Item</label>
        <input type="text" name="nama_item" value="<?php echo $data['nama_item']; ?>" required>

        <label>Kategori</label>
        <select name="kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="bahan utama" <?php if ($data['kategori'] == 'bahan utama') echo 'selected'; ?>>Bahan Utama</option>
            <option value="topping" <?php if ($data['kategori'] == 'topping') echo 'selected'; ?>>Topping</option>
            <option value="level pedas" <?php if ($data['kategori'] == 'level pedas') echo 'selected'; ?>>Level Pedas</option>
            <option value="tambahan" <?php if ($data['kategori'] == 'tambahan') echo 'selected'; ?>>Tambahan</option>
        </select>

        <label>Harga (Rp)</label>
        <input type="number" name="harga" min="0" value="<?php echo $data['harga']; ?>" required>

        <label>Stok</label>
        <input type="number" name="stok" min="0" value="<?php echo $data['stok']; ?>" required>

        <button type="submit" name="update">Update</button>
        <a href="list_menu.php">Kembali</a>
    </form>
</div>

</body>
</html>
