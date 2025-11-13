<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$item_ids = $_POST['item_id'] ?? [];

if (empty($item_ids)) {
    echo "<script>alert('Pilih minimal 1 item!'); window.location='user_menu.php';</script>";
    exit;
}

$total = 0;

// Insert transaksi
mysqli_query($koneksi, "INSERT INTO transaksi (user_id, total_harga, status) VALUES ('$user_id', 0, 'pending')");
$transaksi_id = mysqli_insert_id($koneksi);

// Loop item yang dipesan
foreach ($item_ids as $id) {
    $jumlah = $_POST['jumlah_' . $id];
    $q = mysqli_query($koneksi, "SELECT harga FROM menu_items WHERE item_id='$id'");
    $d = mysqli_fetch_assoc($q);
    $subtotal = $d['harga'] * $jumlah;
    $total += $subtotal;

    mysqli_query($koneksi, "INSERT INTO detail_transaksi (transaksi_id, item_id, jumlah, subtotal)
                            VALUES ('$transaksi_id', '$id', '$jumlah', '$subtotal')");
}

// Update total transaksi
mysqli_query($koneksi, "UPDATE transaksi SET total_harga='$total', status='selesai' WHERE transaksi_id='$transaksi_id'");

echo "<script>alert('Pesanan berhasil! Total: Rp$total'); window.location='user_menu.php';</script>";
?>
