<?php
require 'vendor/autoload.php';
require 'koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


$query = "
    SELECT t.transaksi_id, u.nama_lengkap, t.tanggal, t.total_harga, t.status
    FROM transaksi t
    JOIN users u ON t.user_id = u.user_id
    ORDER BY t.tanggal DESC
";
$result = mysqli_query($koneksi, $query);

// Buat Excel
$sheet = new Spreadsheet();
$active = $sheet->getActiveSheet();

$active->setCellValue('A1', 'Laporan Keuangan Seblak Prasmanan');
$active->mergeCells('A1:E1');
$active->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$active->getStyle('A1')->getFont()->setBold(true)->setSize(14);

$header = ['ID Transaksi','Nama Pelanggan','Tanggal','Status','Total Harga'];
$col = 'A';
foreach ($header as $h) {
    $active->setCellValue($col.'3', $h);
    $col++;
}


$active->getStyle('A3:E3')->getFill()->setFillType(Fill::FILL_SOLID)
       ->getStartColor()->setRGB('FF5E00');
$active->getStyle('A3:E3')->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');

// Isi data
$row = 4;
$total = 0;

while ($d = mysqli_fetch_assoc($result)) {
    $active->setCellValue("A$row", $d['transaksi_id']);
    $active->setCellValue("B$row", $d['nama_lengkap']);
    $active->setCellValue("C$row", date('d-m-Y H:i', strtotime($d['tanggal'])));
    $active->setCellValue("D$row", ucfirst($d['status']));
    $active->setCellValue("E$row", $d['total_harga']);

    $total += $d['total_harga'];
    $row++;
}


$active->setCellValue("A$row", "TOTAL KESELURUHAN");
$active->mergeCells("A$row:D$row");
$active->setCellValue("E$row", $total);

$active->getStyle("A$row:E$row")->getFont()->setBold(true);
$active->getStyle("A$row:E$row")->getFill()->setFillType(Fill::FILL_SOLID)
       ->getStartColor()->setRGB('FFE0B2');


foreach (range('A','E') as $c) {
    $active->getColumnDimension($c)->setAutoSize(true);
}

$writer = new Xlsx($sheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="laporan_keuangan.xlsx"');
$writer->save('php://output');
exit;
?>
