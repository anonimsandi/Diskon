<?php
require '../includes/functions.php';
include '../includes/header.php';

// Tambah barang
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];

    if (tambahBarang($nama, $harga)) {
        $pesan = tampilkanAlert("Barang berhasil ditambahkan!", "success");
    } else {
        $pesan = tampilkanAlert("Gagal menambahkan barang.", "danger");
    }
}

// Ambil data barang
$dataBarang = getDataBarang();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Barang</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background: url('../bg.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Menu Barang</h1>
        <?= $pesan ?? '' ?>
        <form method="post">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Barang</button>
        </form>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataBarang as $barang): ?>
                <tr>
                    <td><?= $barang['id'] ?></td>
                    <td><?= $barang['nama'] ?></td>
                    <td><?= formatRupiah($barang['harga']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>