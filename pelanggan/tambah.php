<?php
include '../koneksi.php';

if(isset($_POST['submit'])) {
    $nama = $_POST['nama_pelanggan'];

    // Upload Foto
    $nama_file = $_FILES['foto']['name'];
    $source = $_FILES['foto']['tmp_name'];
    $folder = './foto/';

    
    if ($nama_file != '') {
        $file_ext = pathinfo($nama_file, PATHINFO_EXTENSION);
        $nama_baru = time() . '.' . $file_ext;
        move_uploaded_file($source, $folder . $nama_baru);
        $query = mysqli_query($koneksi, "INSERT INTO pelanggan (nama_pelanggan, gambar) VALUES ('$nama', '$nama_baru')");
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO pelanggan (nama_pelanggan, gambar) VALUES ('$nama_pelanggan', '')");
    }

    if ($query) {
        header("location: index.php");
        exit;
    } else {
        echo "<script>alert('Gagal menambah data!');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pelanggan</title>
</head>
<body>
<div>
    <h2>Tambah Pelanggan</h2>
    <form method="POST" enctype="multipart/form-data">
        <div>
            <label>Nama Pelanggan</label><br>
            <input type="text" name="nama_pelanggan" required>
        </div>
        <br>
        <div>
            <label>Foto</label><br>
            <input type="file" name="foto">
        </div>
        <br>
        <button type="submit" name="submit">Simpan</button>
        <a href="index.php">Kembali</a>
    </form>
</div>
</body>
</html>
