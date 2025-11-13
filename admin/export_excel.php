<?php
include 'koneksi.php';

// Set header agar browser tahu ini file Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_keuangan_seblak.xls");

echo "<h2>Laporan Keuangan Seblak Prasmanan</h2>";

echo "
<table border='1' cellpadding='8'>
    <tr style='background:#ff5e00; color:white;'>
        <th>ID Transaksi</th>
        <th>Nama Pelanggan</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th>Total Harga (Rp)</th>
    </tr>
";

$query = "
    SELECT t.transaksi_id, u.nama_lengkap, t.tanggal, t.total_harga, t.status
    FROM transaksi t
    JOIN users u ON t.user_id = u.user_id
    ORDER BY t.tanggal DESC
";
$result = mysqli_query($koneksi, $query);

$total = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $total += $row['total_harga'];
    echo "
    <tr>
        <td>{$row['transaksi_id']}</td>
        <td>{$row['nama_lengkap']}</td>
        <td>{$row['tanggal']}</td>
        <td>{$row['status']}</td>
        <td>{$row['total_harga']}</td>
    </tr>
    ";
}

echo "
<tr style='font-weight:bold; background:#ffe0b2;'>
    <td colspan='4'>TOTAL KESELURUHAN</td>
    <td>{$total}</td>
</tr>
</table>
";
?>
