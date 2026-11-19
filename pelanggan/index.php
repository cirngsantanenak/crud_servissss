<?php
include '../koneksi.php';

$data = mysqli_query($koneksi, "SELECT id_pelanggan, nama_pelanggan, gambar FROM pelanggan");

if (!$data) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan</title>
</head>
<body>

<div>
    <h2>Data Pelanggan</h2>

    <a href="tambah.php">Tambah Pelanggan</a>

    <br><br>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Pelanggan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;

            while ($d = mysqli_fetch_assoc($data)) {
            ?>
            <tr>
                <td><?= $no++; ?></td>

                <td>
                    <?php if (!empty($d['gambar'])) { ?>
                        <img src="foto/<?= htmlspecialchars($d['gambar']); ?>"
                             width="50" height="50">
                    <?php } else { ?>
                        Tidak ada gambar
                    <?php } ?>
                </td>

                <td>
                    <?= htmlspecialchars($d['nama_pelanggan']); ?>
                </td>

                <td>
                    <a href="edit.php?id=<?= $d['id_pelanggan']; ?>">Edit</a>

                    |

                    <a href="hapus.php?id=<?= $d['id_pelanggan']; ?>"
                       onclick="return confirm('Yakin ingin menghapus?')">
                        Hapus
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <br>

    <a href="../index.php">Kembali ke Menu Utama</a>

</div>

</body>
</html>
