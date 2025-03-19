<?php
session_start(); // Mulai session
require '../config/connection.php';
require '../includes/functions.php';
include '../includes/header.php';

// Inisialisasi variabel
$pesan = '';

// Ambil data barang dari database
$dataBarang = getDataBarang();

// Proses tambah transaksi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];

    // Validasi input
    if (validasiAngka($id_barang) && validasiAngka($jumlah)) {
        // Ambil harga barang dari database
        $query = "SELECT harga FROM barang WHERE id = $id_barang";
        $result = $koneksi->query($query);
        $barang = $result->fetch_assoc();
        $harga = $barang['harga'];

        // Ambil diskon dari session (jika ada)
        $diskon = 0;
        if (isset($_SESSION['diskon']) && $_SESSION['diskon']['id_barang'] == $id_barang) {
            $diskon = $_SESSION['diskon']['diskon'];
        }

        // Hitung harga setelah diskon
        $hargaSetelahDiskon = hitungHargaSetelahDiskon($harga, $diskon);

        // Hitung subtotal
        $subtotal = $hargaSetelahDiskon * $jumlah;

        // Simpan transaksi ke database
        $query = "INSERT INTO transaksi (tanggal, total) VALUES (NOW(), $subtotal)";
        if ($koneksi->query($query)) {
            $id_transaksi = $koneksi->insert_id;

            // Simpan detail transaksi ke database (termasuk diskon)
            $query = "INSERT INTO detail_transaksi (id_transaksi, id_barang, jumlah, subtotal, diskon) 
                      VALUES ($id_transaksi, $id_barang, $jumlah, $subtotal, $diskon)";
            if ($koneksi->query($query)) {
                $pesan = tampilkanAlert("Transaksi berhasil disimpan!", "success");
                unset($_SESSION['diskon']); // Hapus session setelah transaksi selesai
            } else {
                $pesan = tampilkanAlert("Gagal menyimpan detail transaksi.", "danger");
            }
        } else {
            $pesan = tampilkanAlert("Gagal menyimpan transaksi.", "danger");
        }
    } else {
        $pesan = tampilkanAlert("Input tidak valid!", "danger");
    }
}

// Ambil data transaksi dari database (ambil diskon dari detail_transaksi)
$query = "SELECT t.id, t.tanggal, t.total, b.nama, dt.jumlah, dt.subtotal, dt.diskon, b.harga 
          FROM transaksi t
          JOIN detail_transaksi dt ON t.id = dt.id_transaksi
          JOIN barang b ON dt.id_barang = b.id
          ORDER BY t.tanggal DESC";
$result = $koneksi->query($query);
$dataTransaksi = [];
while ($row = $result->fetch_assoc()) {
    $dataTransaksi[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Transaksi</h1>
        <?= $pesan ?>

        <!-- Form Tambah Transaksi -->
        <form method="post" class="mt-4">
            <div class="mb-3">
                <label for="id_barang" class="form-label">Pilih Barang</label>
                <select class="form-select" id="id_barang" name="id_barang" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php foreach ($dataBarang as $barang): ?>
                    <option value="<?= $barang['id'] ?>"><?= $barang['nama'] ?> (<?= formatRupiah($barang['harga']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
        </form>

        <!-- Tabel Daftar Transaksi -->
        <h2 class="mt-5">Daftar Transaksi</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Asli</th>
                    <th>Diskon</th>
                    <th>Subtotal</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataTransaksi as $transaksi): ?>
                    <tr>
                    <td><?= $transaksi['id'] ?></td>
                    <td><?= $transaksi['tanggal'] ?></td>
                    <td><?= $transaksi['nama'] ?></td>
                    <td><?= $transaksi['jumlah'] ?></td>
                    <td><?= formatRupiah($transaksi['harga']) ?></td>
                    <td><?= $transaksi['diskon'] ?>%</td> <!-- Diskont dari detail_transaksi -->
                    <td><?= formatRupiah($transaksi['subtotal']) ?></td>
                    <td><?= formatRupiah($transaksi['total']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>