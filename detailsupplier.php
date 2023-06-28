<?php
require 'function.php';
require 'cek.php';

//mendapatkan id supplier yang dioper dari halaman sebelumnya
$idsupplier = $_GET['id']; //get id supplier
//mengambil informasi supplier berdasarkan database
$get = mysqli_query($conn, "select * from supplier where idsupplier='$idsupplier'");
$fetch = mysqli_fetch_assoc($get);
//set variabel
$namasupplier = $fetch['namasupplier'];
$namabarang = $fetch['namasupplier'];
$kategorisupplier = $fetch['kategorisupplier'];
$nomorsupplier = $fetch['nomorsupplier'];
$alamat = $fetch['alamat'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Riwayat Pengiriman - GRAND Inventory</title>
    <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <?php include "components/nav.php" ?>
    <div id="layoutSidenav">
        <?php include "components/sidebar.php" ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Riwayat Pengiriman</h1>
                    <div class="card mb-4 mt-4">
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

                            <h3>Pengiriman yang Masuk</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Penerima</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ambildatamasuk = mysqli_query($conn, "SELECT masuk.tanggal, stok.namabarang, masuk.qty, masuk.penerima FROM masuk JOIN stok ON masuk.idbarang = stok.idbarang WHERE masuk.namasupplier='$namasupplier'");
                                        $i = 1;

                                        while ($fetch = mysqli_fetch_array($ambildatamasuk)) {
                                            $tanggal = $fetch['tanggal'];
                                            $namabarang = $fetch['namabarang'];
                                            $penerima = $fetch['penerima'];
                                            $quantity = $fetch['qty'];
                                        ?>

                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $tanggal; ?></td>
                                                <td><?= $namabarang; ?></td>
                                                <td><?= $quantity; ?></td>
                                                <td><?= $penerima; ?></td>
                                            </tr>

                                        <?php
                                        };

                                        ?>

                                    </tbody>
                                </table>
                            </div>

                            <br></br>

                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>