<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit;
}

include '../koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data pelanggan tidak ditemukan!");
}

if (isset($_POST['update'])) {

    $nama_pelanggan = $_POST['nama_pelanggan'];

    $gambar_lama = $data['gambar'];
    $gambar_baru = $gambar_lama;

    if (!empty($_FILES['gambar']['name'])) {

        $nama_file = $_FILES['gambar']['name'];
        $source = $_FILES['gambar']['tmp_name'];

        $file_ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $format = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($file_ext, $format)) {
            die("Format gambar tidak valid!");
        }

        $nama_baru = uniqid() . '.' . $file_ext;

        if (!move_uploaded_file($source, __DIR__ . '/foto/' . $nama_baru)) {
            die("Gagal mengupload gambar!");
        }

        $gambar_baru = $nama_baru;
    }

    $stmt = mysqli_prepare(
        $koneksi,
        "UPDATE pelanggan SET nama_pelanggan = ?, gambar = ? WHERE id_pelanggan = ?"
    );

    mysqli_stmt_bind_param($stmt, "ssi", $nama_pelanggan, $gambar_baru, $id);

    if (mysqli_stmt_execute($stmt)) {

        if ($gambar_baru != $gambar_lama) {
            $file_lama = __DIR__ . '/foto/' . basename($gambar_lama);

            if (is_file($file_lama)) {
                unlink($file_lama);
            }
        }

        header("Location: index.php");
        exit;

    } else {
        echo "Gagal mengupdate data!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pelanggan</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<h2>Edit Pelanggan</h2>

<form method="POST" enctype="multipart/form-data">

    <label>Nama Pelanggan</label><br>
    <input type="text" name="nama_pelanggan"
           value="<?= htmlspecialchars($data['nama_pelanggan']); ?>"
           required>

    <br><br>

    <label>Gambar Saat Ini:</label><br>

    <?php if (!empty($data['gambar'])) { ?>
        <img src="foto/<?= htmlspecialchars($data['gambar']); ?>"
             width="100">
    <?php } else { ?>
        Tidak ada gambar
    <?php } ?>

    <br><br>

    <label>Ganti Gambar (Opsional)</label><br>
    <input type="file" name="gambar" accept="image/*">

    <br><br>

    <button type="submit" name="update">Update</button>

    <a href="index.php">Kembali</a>

</form>
</body>
</html>