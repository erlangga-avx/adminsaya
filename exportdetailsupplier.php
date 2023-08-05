<?php
require 'function.php';
require 'cek.php';
?>
<html>

<head>
    <title>
        GRAND Fotocopy Gambut
        <h1 class="mt-4">Riwayat Pengiriman</h1>
        <div class="card mb-4 mt-4">
            <?php
            // Mengambil id supplier dari URL
            $idsupplier = $_GET['id'];

            // Mengambil informasi supplier dari database berdasarkan id supplier
            $get = mysqli_query($conn, "SELECT * FROM supplier WHERE idsupplier='$idsupplier'");
            $fetch = mysqli_fetch_assoc($get);

            // Menetapkan nilai variabel berdasarkan hasil pengambilan dari database
            $namasupplier = isset($fetch['namasupplier']) ? $fetch['namasupplier'] : '';
            $kategorisupplier = isset($fetch['kategorisupplier']) ? $fetch['kategorisupplier'] : '';
            $nomorsupplier = isset($fetch['nomorsupplier']) ? $fetch['nomorsupplier'] : '';
            $alamat = isset($fetch['alamat']) ? $fetch['alamat'] : '';; ?>
            <div class="card-header">
                <h2><?= $namasupplier; ?></h2>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <h4>Kategori : <?= $kategorisupplier; ?></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h4>Nomor Telepon : <?= $nomorsupplier; ?></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h4>Alamat : <?= $alamat; ?></h4>
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
        <h1 class="mt-4">Riwayat Pengiriman</h1>
        <div class="card mb-4 mt-4">
            <?php
            // Mengambil id supplier dari URL
            $idsupplier = $_GET['id'];

            // Mengambil informasi supplier dari database berdasarkan id supplier
            $get = mysqli_query($conn, "SELECT * FROM supplier WHERE idsupplier='$idsupplier'");
            $fetch = mysqli_fetch_assoc($get);

            // Menetapkan nilai variabel berdasarkan hasil pengambilan dari database
            $namasupplier = isset($fetch['namasupplier']) ? $fetch['namasupplier'] : '';
            $kategorisupplier = isset($fetch['kategorisupplier']) ? $fetch['kategorisupplier'] : '';
            $nomorsupplier = isset($fetch['nomorsupplier']) ? $fetch['nomorsupplier'] : '';
            $alamat = isset($fetch['alamat']) ? $fetch['alamat'] : '';; ?>
            <div class="card-header">
                <h2><?= $namasupplier; ?></h2>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <h4>Kategori</h4>
                    </div>
                    <div class="col-md-9">
                        <h4>: <?= $kategorisupplier; ?></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h4>Nomor Telepon</h4>
                    </div>
                    <div class="col-md-9">
                        <h4>: <?= $nomorsupplier; ?></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h4>Alamat</h4>
                    </div>
                    <div class="col-md-9">
                        <h4>: <?= $alamat; ?></h4>
                    </div>
                </div>

                <br></br>
                <div class="data-tables datatable-dark">
                    <form method="post" class="mt-3">
                        <div class="row">
                            <div class="col">
                                <input type="date" name="tgl_mulai" class="form-control">
                            </div>
                            <div class="col">
                                <input type="date" name="tgl_selesai" class="form-control">
                            </div>
                            <div class="col">
                                <button type="submit" name="filter_tgl" class="btn btn-info">Filter</button>
                            </div>
                        </div>
                    </form>

                    <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
                    <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Nomor Nota</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if (isset($_POST['filter_tgl'])) {
                                $mulai = $_POST['tgl_mulai'];
                                $selesai = $_POST['tgl_selesai'];

                                if ($mulai != null || $selesai != null) {
                                    $ambildatamasuk = mysqli_query($conn, "select * from masuk m join stok s on s.idbarang = m.idbarang join supplier su on su.idsupplier = m.idsupplier join transaksimasuk tm on tm.idtransaksi = m.idtransaksi WHERE m.idsupplier='$idsupplier' and tanggal BETWEEN '$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY)");
                                } else {
                                    $ambildatamasuk = mysqli_query($conn, "select * from masuk m join stok s on s.idbarang = m.idbarang join supplier su on su.idsupplier = m.idsupplier join transaksimasuk tm on tm.idtransaksi = m.idtransaksi WHERE m.idsupplier='$idsupplier'");
                                }
                            } else {
                                $ambildatamasuk = mysqli_query($conn, "select * from masuk m join stok s on s.idbarang = m.idbarang join supplier su on su.idsupplier = m.idsupplier join transaksimasuk tm on tm.idtransaksi = m.idtransaksi WHERE m.idsupplier='$idsupplier'");
                            }
                            $i = 1;

                            while ($data = mysqli_fetch_array($ambildatamasuk)) {
                                $idb = $data['idbarang'];
                                $idm = $data['idmasuk'];
                                $idt = $data['idtransaksi'];
                                $kodeauto = $data['kodetransaksi'];
                                $tanggal = $data['tanggal'];
                                $satuan = $data['satuan'];
                                $namabarang = $data['namabarang'];
                                $qty = $data['qty'];
                                $nota = $data['nota'];
                            ?>

                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $kodeauto; ?></td>
                                    <td><?= $tanggal; ?></td>
                                    <td><?= $namabarang; ?></td>
                                    <td><?= $qty; ?></td>
                                    <td><?= $satuan; ?></td>
                                    <td><?= $nota; ?></td>
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
                    $('#mauexport').DataTable({
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