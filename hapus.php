<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}
include "koneksi.php";

$id = $_GET['id'];

$hapus = mysqli_query($koneksi, "DELETE FROM servis WHERE id = '$id'");

if ($hapus) {
    header("Location: index.php?pesan=Data berhasil dihapus");
    exit;
} else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
}
?>