<?php
// Memanggil file koneksi
require '../config/connection.php';

// Memanggil header
include '../includes/header.php';

// Proses perhitungan diskon
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $harga = $_POST['harga'];
    $diskon = $_POST['diskon'];

    // Validasi input
    if (is_numeric($harga) && is_numeric($diskon)) {
        $total_diskon = $harga * ($diskon / 100);
        $total_harga = $harga - $total_diskon;
        $hasil = [
            'total_diskon' => $total_diskon,
            'total_harga' => $total_harga
        ];
    } else {
        $error = "Input tidak valid! Harap masukkan angka.";
    }
}
?>

<div class="container mt-5">
    <h1 class="text-center">Hitung Diskon</h1>
    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="harga" class="form-label">Harga (Rp)</label>
            <input type="text" class="form-control" id="harga" name="harga" required>
        </div>
        <div class="mb-3">
            <label for="diskon" class="form-label">Diskon (%)</label>
            <input type="text" class="form-control" id="diskon" name="diskon" required>
        </div>
        <button type="submit" class="btn btn-primary">Hitung</button>
    </form>

    <?php if (isset($hasil)): ?>
    <div class="mt-4">
        <h3>Hasil Perhitungan</h3>
        <p>Total Diskon: Rp. <?= number_format($hasil['total_diskon'], 2) ?></p>
        <p>Total Harga: Rp. <?= number_format($hasil['total_harga'], 2) ?></p>
    </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
    <div class="alert alert-danger mt-4">
        <?= $error ?>
    </div>
    <?php endif; ?>
</div>

<?php
// Memanggil footer
include '../includes/footer.php';
?>