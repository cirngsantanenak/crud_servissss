<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.php");
    exit;
}

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
    <link rel="stylesheet" href="../style.css">
    <style>
        nav.nav-utama {
            width: 100%;
            max-width: 1150px;
            margin: 20px auto;
            padding: 16px 24px;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            box-sizing: border-box;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        nav.nav-utama .garis-pisah {
            color: #5c5b9e;
            font-weight: bold;
        }
        nav.nav-utama a.btn-kotak {
            display: inline-block;
            padding: 8px 18px;
            background-color: #efeffc;
            color: #5c5b9e;
            border: 1.5px solid #dcdbf3;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        nav.nav-utama a.btn-kotak:hover {
            background-color: #e1e0f8;
            border-color: #b8b6e6;
        }
        nav.nav-utama a.btn-keluar {
            background-color: #fdf0f1;
            color: #b85d66;
            border-color: #f3d7da;
            margin-left: auto;
        }
        nav.nav-utama a.btn-keluar:hover {
            background-color: #fae1e3;
            border-color: #e6b8bd;
        }
    </style>
</head>
<body>

<div>
    <h2>Data Pelanggan</h2>

    <nav class="nav-utama">
        <a href="tambah.php" class="btn-kotak">+ Tambah Pelanggan</a>
        <span class="garis-pisah">|</span>
        <a href="../index.php" class="btn-kotak">Data Servis</a>
        <span class="garis-pisah">|</span>
        <a href="../logout.php" class="btn-kotak btn-keluar" onclick="return confirm('Yakin ingin logout?')">Logout</a>
    </nav>

    <br>

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