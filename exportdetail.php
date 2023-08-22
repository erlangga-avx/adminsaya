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
    $img = '<img src="images/' . $gambar . '" class="zoomable">';
}

//membuat QR
$urlview = 'http://localhost/adminsaya/view.php?id=' . $idbarang;
$qrcode = 'https://chart.googleapis.com/chart?chs=350x350&cht=qr&chl=' . $urlview . '&choe=UTF-8';

?>
<html>

<head>
    <title>
        GRAND Fotocopy Gambut
        <h1 class="mt-4">Detail Barang</h1>
        <div class="card mb-4 mt-4">
            <div class="card-header">
                <h2><?= $namabarang; ?></h2>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <h4>Kategori</h4>
                    </div>
                    <div class="col-md-9">
                        <h4>: <?= $kategori; ?></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h4>Stok</h4>
                    </div>
                    <div class="col-md-9">
                        <h4>: <?= $stok; ?></h4>
                    </div>
                </div>

                <br></br>
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
    <div class="container">
        <h2>GRAND Fotocopy Gambut</h2>
        <h1 class="mt-4">Detail Barang</h1>
        <div class="card mb-4 mt-4">
            <div class="card-header">
                <h2><?= $namabarang; ?></h2>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <h4>Kategori</h4>
                    </div>
                    <div class="col-md-9">
                        <h4>: <?= $kategori; ?></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h4>Stok</h4>
                    </div>
                    <div class="col-md-9">
                        <h4>: <?= $stok; ?> <?= $satuan; ?></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h4>Harga</h4>
                    </div>
                    <div class="col-md-9">
                        <h4>: Rp.<?= $format_harga; ?></h4>
                    </div>
                </div>

                <br></br>
                <div class="data-tables datatable-dark">
                    <h3>Barang Masuk</h3>

                    <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
                    <table class="table table-bordered" id="mauexport1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kode Transaksi</th>
                                <th>Pengirim</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Penerima</th>
                                <!--
                                            <th>Pilihan</th>
                                            -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $query = "select * from masuk m join stok s on s.idbarang = m.idbarang join supplier su on su.idsupplier = m.idsupplier join transaksimasuk tm on tm.idtransaksi = m.idtransaksi where s.idbarang='$idbarang'";

                            $ambildatamasuk = mysqli_query($conn, $query);
                            $i = 1;

                            while ($data = mysqli_fetch_array($ambildatamasuk)) {
                                $idb = $data['idbarang'];
                                $idm = $data['idmasuk'];
                                $idt = $data['idtransaksi'];
                                $kodetransaksi = $data['kodetransaksi'];
                                $tanggal = $data['tanggal'];
                                $satuan = $data['satuan'];
                                $namabarang = $data['namabarang'];
                                $qty = $data['qty'];
                                $penerima = $data['penerima'];
                                $ids = $data['idsupplier'];
                                $namasupplier = $data['namasupplier'];

                            ?>

                                <tr>
                                    <td><?= $tanggal; ?></td>
                                    <td><?= $kodetransaksi; ?></td>
                                    <td><?= $namasupplier; ?></td>
                                    <td><?= $qty; ?></td>
                                    <td><?= $satuan; ?></td>
                                    <td><?= $penerima; ?></td>
                                </tr>

                            <?php
                            };

                            ?>

                        </tbody>
                    </table>
                </div>

                <br></br>

                <h3>Barang Keluar</h3>
                <div class="table-responsive">
                    <table class="table table-bordered" id="mauexport2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kode Transaksi</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $ambildatakeluar = mysqli_query($conn, "select * from keluar where idbarang='$idbarang'");
                            $i = 1;

                            while ($fetch = mysqli_fetch_array($ambildatakeluar)) {
                                $tanggal = $fetch['tanggal'];
                                $keterangan = $fetch['keterangan'];
                                $quantity = $fetch['qty'];
                            ?>

                                <tr>
                                    <td><?= $tanggal; ?></td>
                                    <td><?= $kodeauto; ?></td>
                                    <td><?= $quantity; ?></td>
                                    <td><?= $satuan; ?></td>
                                    <td><?= $keterangan; ?></td>
                                </tr>

                            <?php
                            };

                            ?>

                        </tbody>
                    </table>

                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $('#mauexport1').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'excel', 'pdf', 'print'
                        ]
                    });
                });
                $(document).ready(function() {
                    $('#mauexport2').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'excel', 'pdf', 'print'
                        ]
                    });
                });
            </script>

            <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
            <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.flash.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>



</body>

</html>