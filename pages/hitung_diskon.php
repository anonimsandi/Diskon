<?php
session_start(); // Mulai session
require '../config/connection.php';
require '../includes/functions.php';
include '../includes/header.php';

// Proses perhitungan diskon
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_barang = $_POST['id_barang'];
    $diskon = $_POST['diskon'];
    $query = "INSERT INTO transaksi (tanggal, total) VALUES (NOW(), $subtotal)";

    // Validasi input
    if (validasiAngka($id_barang) && validasiAngka($diskon)) {
        // Simpan data diskon ke session
        $_SESSION['diskon'] = [
            'id_barang' => $id_barang,
            'diskon' => $diskon
        ];

        // Redirect ke halaman transaksi
        header("Location: transaksi.php");
        exit();
    } else {
        echo tampilkanAlert("Input tidak valid!", "danger");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitung Diskon</title>
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
        <h1>Hitung Diskon</h1>
        <form method="post" class="mt-4">
            <div class="mb-3">
                <label for="id_barang" class="form-label">Pilih Barang</label>
                <select class="form-select" id="id_barang" name="id_barang" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php
                    $query = "SELECT * FROM barang";
                    $result = $koneksi->query($query);
                    while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['nama'] ?> (<?= formatRupiah($row['harga']) ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="diskon" class="form-label">Diskon (%)</label>
                <input type="number" class="form-control" id="diskon" name="diskon" required>
            </div>
            <button type="submit" class="btn btn-primary">Hitung Diskon</button>
        </form>
    </div>
</body>
</html>