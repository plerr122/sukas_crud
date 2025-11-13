<?php
include 'koneksi.php';

// Cek apakah ada parameter id yang dikirim lewat URL
if (isset($_GET['id'])) {
    $item_id = $_GET['id'];

    // Hapus data berdasarkan ID
    $query = "DELETE FROM menu_items WHERE item_id = '$item_id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location='list_menu.php';
              </script>";
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    // Kalau gak ada ID di URL
    echo "<script>
            alert('ID menu tidak ditemukan!');
            window.location='list_menu.php';
          </script>";
}
?>
