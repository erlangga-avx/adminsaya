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
        <title>Pemesanan - GRAND Inventory</title>
        <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
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
                        <h1 class="mt-4">Pemesanan</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Pesanan
                            </button>
                            <a href="exportpesanan.php" class="btn btn-success">Export Data</a>
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
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Nama Barang</th>
                                                <th>Kategori</th>
                                                <th>Jumlah Pesanan</th>
                                                <th>Pilihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        if(isset($_POST['filter_tgl'])){
                                            $mulai = $_POST['tgl_mulai'];
                                            $selesai = $_POST['tgl_selesai'];

                                            if($mulai!=null || $selesai!=null){
                                                $ambilsemuadatapesanan = mysqli_query($conn, "select * from pesanan and tanggal BETWEEN '$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY)");
                                            } else {
                                                $ambilsemuadatapesanan = mysqli_query($conn, "select * from pesanan");
                                            }
                                        } else {
                                            $ambilsemuadatapesanan = mysqli_query($conn, "select * from pesanan");
                                        }
                                            $ambilsemuadatapesanan = mysqli_query($conn, "select * from pesanan");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($ambilsemuadatapesanan)){
                                                $idp = $data['idpesanan'];
                                                $tanggal = $data['tanggal'];
                                                $namabarang = $data['namabarang'];
                                                $kategori = $data['kategori'];
                                                $qty = $data['qty'];
                                            ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$kategori;?></td>
                                                <td><?=$qty;?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$idp;?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idp;?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>

                                                <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?=$idp;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Pesanan</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <form method="post">
                                                <div class="modal-body">
                                                <input type="text" name="namabarang" value="<?=$namabarang;?>" class="form-control" required>
                                                <br>
                                                <input type="text" name="kategori" value="<?=$kategori;?>" class="form-control" required>
                                                <br>
                                                <input type="number" name="qty" value="<?=$qty;?>" class="form-control" required>
                                                <br>
                                                <input type="hidden" name="idp" value="<?=$idp;?>">
                                                <button type="submit" class="btn btn-primary" name="updatepesanan">Simpan</button>
                                                </form>
                                                </div>

                                                </div>
                                            </div>
                                            </div>

                                            <!-- Hapus Modal -->
                                            <div class="modal fade" id="delete<?=$idp;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Pesanan?</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <form method="post">
                                                <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus <?=$namabarang;?>?
                                                <input type="hidden" name="idp" value="<?=$idp;?>">
                                                <br>
                                                <br>
                                                <button type="submit" class="btn btn-danger" name="hapuspesanan">Hapus</button>
                                                </form>
                                                </div>

                                                </div>
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
            $(document).ready(function () {
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

            <!-- The Modal -->
            <div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Tambah Pesanan</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <form method="post">
        <div class="modal-body">
        <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control" required>
        <br>
        <input type="text" name="kategori" placeholder="Kategori Produk" class="form-control" required>
        <br>
        <input type="number" name="qty" placeholder="Jumlah Pesanan" class="form-control" required>
        <br>
        <button type="submit" class="btn btn-primary" name="addpesanan">Tambah</button>
        </form>
        </div>

        </div>
    </div>
    </div>
</html>
