<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

if ($cari != '') {
    $keyword = mysqli_real_escape_string($koneksi, $cari);
    $query = mysqli_query($koneksi, "SELECT * FROM servis WHERE nama_pelanggan LIKE '%$keyword%' OR jenis_perangkat LIKE '%$keyword%'");
} else {
    $query = mysqli_query($koneksi, "SELECT * FROM servis");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Servis Komputer</title>
    <link rel="stylesheet" href="style.css">
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
        form.search-form {
            width: 100% !important;
            max-width: 1150px !important;
            box-sizing: border-box !important;
            margin: 20px auto !important;
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

    <h2>Daftar Servis Komputer</h2>

    <nav class="nav-utama">
        <a href="tambah.php" class="btn-kotak">+ Tambah Servis</a>
        <span class="garis-pisah">|</span>
        <a href="pelanggan/index.php" class="btn-kotak">Kelola Pelanggan</a>
        <span class="garis-pisah">|</span>
        <a href="logout.php" class="btn-kotak btn-keluar" onclick="return confirm('Yakin ingin logout?')">Logout</a>
    </nav>

    <form method="GET" action="" class="search-form">
        <input type="text" name="cari" placeholder="Cari nama atau jenis perangkat..."
        value="<?php echo htmlspecialchars($cari); ?>">
        <button type="submit">Cari</button>
        <a href="index.php">Reset</a>
    </form>

    <br>

    <?php if (isset($_GET['pesan'])) { ?>
        <p><b>Status: <?php echo htmlspecialchars($_GET['pesan']); ?></b></p>
    <?php } ?>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>No</th>
            <th>No_Nota</th>
            <th>Nama Pelanggan</th>
            <th>Biaya</th>
            <th>Keluhan</th>
            <th>Status_Servis</th>
            <th>Jenis_Perangkat</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) {
        ?>

        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['no_nota']; ?></td>
            <td><?php echo $data['nama_pelanggan']; ?></td>
            <td><?php echo number_format($data['biaya'], 0, ',', '.'); ?></td>
            <td><?php echo $data['keluhan']; ?></td>
            <td><?php echo $data['status_servis']; ?></td>
            <td><?php echo $data['jenis_perangkat']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $data['id']; ?>">Edit</a> |
                <a href="hapus.php?id=<?php echo $data['id']; ?>" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>
        </tr>

        <?php } ?>

    </table>

</body>
</html>