<?php
require 'function.php';
require 'cek.php';

//mendapatkan id barang yang dioper dari halaman sebelumnya
$idbarang = $_GET['id']; //get id barang
//mengambil informasi barang berdasarkan database
$get = mysqli_query($conn, "select * from stok where idbarang='$idbarang'");
$fetch = mysqli_fetch_assoc($get);
//set variabel
$namabarang = $fetch['namabarang'];
$kategori = $fetch['kategori'];
$stok = $fetch['stok'];
$harga = $fetch['harga'];
$format_harga = number_format($harga, 0, ',', '.');
$satuan = $fetch['satuan'];
//cek apakah ada gambar
$gambar = $fetch['image']; //mengambil gambar
if ($gambar == null) {
    //jika tidak ada gambar
    $img = 'Tidak Ada Gambar';
} else {
    //jika ada gambar
    $img = '<img class="card-img-top" src="images/' . $gambar . '" alt="Card image" style="width:100%">';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Menampilkan Barang</title>
</head>

<body>

    <div class="container">
        <div class="container mt-3">
            <h3>Detail Barang :</h3>
            <div class="card mt-4" style="width:400px">
                <?= $img; ?>
                <div class="card-body">
                    <h4 class="card-title"><?= $namabarang; ?></h4>
                    <h4 class="card-text"><?= $kategori; ?></h4>
                    <h4 class="card-text">Stok <?= $stok; ?> <?= $satuan; ?></h4>
                    <h4 class="card-text">Harga <?= $format_harga; ?></h4>
                </div>
            </div>
            <br>
        </div>

</body>

</html>