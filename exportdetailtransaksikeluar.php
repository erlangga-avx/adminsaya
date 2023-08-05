<?php
require 'function.php';
require 'cek.php';

//mendapatkan id barang yang dioper dari halaman sebelumnya
$idtransaksi = $_GET['id']; //get id transaksi
//mengambil informasi barang berdasarkan database
$get = mysqli_query($conn, "select * from transaksikeluar where idtransaksi='$idtransaksi'");
$fetch = mysqli_fetch_assoc($get);
//set variabel
$tanggal = $fetch['tanggal'];
$kodetransaksi = $fetch['kodetransaksi'];
$jumlah = $fetch['jumlah'];
?>
<html>

<head>
    <title>
        GRAND Fotocopy Gambut
        <h1 class="mt-4">Detail Transaksi Keluar</h1>
        <div class="card mb-4 mt-4">
            <div class="card-header">
                <h2>Kode Transaksi <?= $kodetransaksi; ?></h2>
            </div>
            <div class="card-body">
                <input type="text" name="tanggal" value="Tanggal Keluar : <?php echo $tanggal; ?>" class="form-control" disabled>

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
        <h1 class="mt-4">Detail Transaksi Keluar</h1>
        <div class="card mb-4 mt-4">
            <div class="card-header">
                <h2>Kode Transaksi <?= $kodetransaksi; ?></h2>
            </div>
            <div class="card-body">
                <input type="text" name="tanggal" value="Tanggal Keluar : <?php echo $tanggal; ?>" class="form-control" disabled>

                <br></br>

                <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
                <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $query = "select * from keluar k join stok s on s.idbarang = k.idbarang where k.idtransaksi='$idtransaksi'";

                        $ambildatakeluar = mysqli_query($conn, $query);
                        $i = 1;

                        while ($data = mysqli_fetch_array($ambildatakeluar)) {
                            $idb = $data['idbarang'];
                            $idk = $data['idkeluar'];
                            $idt = $data['idtransaksi'];
                            $tanggal = $data['tanggal'];
                            $satuan = $data['satuan'];
                            $namabarang = $data['namabarang'];
                            $qty = $data['qty'];
                            $keterangan = $data['keterangan'];
                        ?>

                            <tr>
                                <td><?= $namabarang; ?></td>
                                <td><?= $qty; ?></td>
                                <td><?= $satuan; ?></td>
                                <td><?= $keterangan; ?></td>
                            </tr>
            </div>
        </div>

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