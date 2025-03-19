<?php
// Fungsi untuk menghubungkan ke database
function koneksiDatabase() {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "proyek-ukk";
    
    $koneksi = new mysqli($host,$username,$password,$database);
    
    // cek koneksi
    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    return $koneksi;
}

// Fungsi untuk menampilkan pesan alert Bootstrap
function tampilkanAlert($pesan, $tipe = 'success') {
    return "<div class='alert alert-$tipe'>$pesan</div>";
}

// Fungsi untuk memformat angka ke format mata uang Rupiah
function formatRupiah($angka) {
    return "Rp. " . number_format($angka, 2, ',', '.');
}

// Fungsi untuk validasi input angka
function validasiAngka($input) {
    if (is_numeric($input)) {
        return true;
    }
    return false;
}

//Fungsi menghitung harga setelah diskon
function hitunghargaSetelahDiskon($harga, $diskon) {
    return $harga = $harga - ($harga * ($diskon / 100));
}

// Fungsi untuk mendapatkan data barang dari database
function getDataBarang() {
    $koneksi = koneksiDatabase();
    $query = "SELECT * FROM barang";
    $result = $koneksi->query($query);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $koneksi->close();
    return $data;
}

// Fungsi untuk menambahkan data barang ke database
function tambahBarang($nama, $harga) {
    $koneksi = koneksiDatabase();
    $query = "INSERT INTO barang (nama, harga) VALUES ('$nama', $harga)";
    if ($koneksi->query($query) === TRUE) {
        return true;
    } else {
        return false;
    }
    $koneksi->close();
}

// Fungsi untuk menghapus data barang dari database
function hapusBarang($id) {
    $koneksi = koneksiDatabase();
    $query = "DELETE FROM barang WHERE id = $id";
    if ($koneksi->query($query)) {
        return true;
    } else {
        return false;
    }
    $koneksi->close();
}


?>