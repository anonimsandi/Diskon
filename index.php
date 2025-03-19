<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Toko Retail</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background: url('bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
    </style>
</head>
<body>
<div class="container mt-5 text-center">
        <h1 class="text-primary text-dark">Selamat Datang di Aplikasi Kasir</h1>
        <p class="lead">Ini adalah halaman utama aplikasi kasir toko retail.</p>
        
        <nav class="mt-4">
            <div class="d-flex justify-content-center gap-3">
                <a class="btn btn-light text-dark" href="pages/hitung_diskon.php">Hitung Diskon</a>
                <a class="btn btn-light text-dark" href="pages/menu_barang.php">Menu Barang</a>
                <a class="btn btn-light text-dark" href="pages/transaksi.php">Transaksi</a>
            </div>
        </nav>
    </div>

    <?php include 'includes/footer.php'; ?>
