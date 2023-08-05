<?php
require 'function.php';
require 'cek.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Barang Keluar - GRAND Inventory</title>
    <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <style>
        .zoomable {
            width: 100px;
        }

        .zoomable:hover {
            transform: scale(2.5);
            transition: 0.3s ease;
        }
    </style>
</head>

<body class="sb-nav-fixed">

    <body class="sb-nav-fixed">
        <?php include "components/nav.php" ?>
        <div id="layoutSidenav">
            <?php include "components/sidebar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Barang Keluar</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <a href="exportkeluar.php" class="btn btn-success">Export Data</a>
                                <br>
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
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Gambar</th>
                                                <th>Kode Transaksi</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Satuan</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if (isset($_POST['filter_tgl'])) {
                                                $mulai = $_POST['tgl_mulai'];
                                                $selesai = $_POST['tgl_selesai'];

                                                if ($mulai != null || $selesai != null) {
                                                    $ambilsemuadatastok = mysqli_query($conn, "select * from keluar k join stok s on s.idbarang = k.idbarang join transaksikeluar tk on tk.idtransaksi = k.idtransaksi and tanggal BETWEEN '$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY)");
                                                } else {
                                                    $ambilsemuadatastok = mysqli_query($conn, "select * from keluar k join stok s on s.idbarang = k.idbarang join transaksikeluar tk on tk.idtransaksi = k.idtransaksi");
                                                }
                                            } else {
                                                $ambilsemuadatastok = mysqli_query($conn, "select * from keluar k join stok s on s.idbarang = k.idbarang join transaksikeluar tk on tk.idtransaksi = k.idtransaksi");
                                            }

                                            while ($data = mysqli_fetch_array($ambilsemuadatastok)) {
                                                $idb = $data['idbarang'];
                                                $idk = $data['idkeluar'];
                                                $idt = $data['idtransaksi'];
                                                $tanggal = $data['tanggal'];
                                                $namabarang = $data['namabarang'];
                                                $qty = $data['qty'];
                                                $keterangan = $data['keterangan'];
                                                $kodeauto = $data['kodetransaksi'];
                                                $satuan = $data['satuan'];

                                                //cek apakah ada gambar
                                                $gambar = $data['image']; //mengambil gambar
                                                if ($gambar == null) {
                                                    //jika tidak ada gambar
                                                    $img = 'Tidak Ada Gambar';
                                                } else {
                                                    //jika ada gambar
                                                    $img = '<img src="images/' . $gambar . '" class="zoomable">';
                                                }
                                            ?>
                                                <tr>
                                                    <td><?= $tanggal; ?></td>
                                                    <td><?= $img; ?></td>
                                                    <td><?= $kodeauto; ?></td>
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
            </div>
        </div>
        </main>
        </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
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
    </div>

</html>