<?php
include 'koneksi.php';

// Ambil semua transaksi beserta nama user dan total harga
$query = "
    SELECT t.transaksi_id, u.nama_lengkap, t.tanggal, t.total_harga, t.status
    FROM transaksi t
    JOIN users u ON t.user_id = u.user_id
    ORDER BY t.tanggal DESC
";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Seblak Prasmanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff8f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 900px;
            margin: 40px auto;
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
        .btn {
            display: inline-block;
            padding: 8px 15px;
            text-decoration: none;
            background: #00c853;
            color: white;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Laporan Keuangan Seblak Prasmanan</h2>

    <a href="export_excel.php" class="btn">📊 Export ke Excel</a>

    <table>
        <tr>
            <th>ID Transaksi</th>
            <th>Nama Pelanggan</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Total Harga</th>
        </tr>

        <?php
        $grand_total = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $grand_total += $row['total_harga'];
        ?>
        <tr>
            <td><?= $row['transaksi_id']; ?></td>
            <td><?= $row['nama_lengkap']; ?></td>
            <td><?= date('d-m-Y H:i', strtotime($row['tanggal'])); ?></td>
            <td><?= ucfirst($row['status']); ?></td>
            <td>Rp<?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
        </tr>
        <?php } ?>
        <tr style="font-weight:bold; background:#ffe0b2;">
            <td colspan="4">TOTAL KESELURUHAN</td>
            <td>Rp<?= number_format($grand_total, 0, ',', '.'); ?></td>
        </tr>
    </table>
</div>

</body>
</html>
