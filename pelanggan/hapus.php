<?php
include '../koneksi.php';
$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan='$id'");
$d = mysqli_fetch_array($data);
$foto = $d['gambar'];

if($foto != '' && file_exists('./foto/'.$foto)) {
    unlink('./foto/'.$foto);
}

$query = mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan='$id'");

if($query) {
    header("location: index.php");
} else {
    echo "<script>alert('Gagal menghapus data!'); window.location='index.php';</script>";
}
?>
