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
//cek apakah ada gambar
$gambar = $fetch['image']; //mengambil gambar
if($gambar==null){
    //jika tidak ada gambar
    $img = 'Tidak Ada Gambar';
} else {
    //jika ada gambar
    $img = '<img src="images/'.$gambar.'" class="zoomable">';
}

//membuat QR
$urlview = 'http://localhost/adminsaya/view.php?id='.$idbarang;
$qrcode = 'https://chart.googleapis.com/chart?chs=350x350&cht=qr&chl='.$urlview.'&choe=UTF-8';

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Detail Barang - GRAND Inventory</title>
        <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
        <style>
            .zoomable{
                width: 350px;
            }
            .zoomable:hover{
                transform: scale(1.5);
                transition: 0.3s ease;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <?php include "components/nav.php" ?>
        <div id="layoutSidenav">
        <?php include "components/sidebar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Detail Barang</h1>
                        <div class="card mb-4 mt-4">
                            <div class="card-header">
                                <h2><?=$namabarang;?></h2>
                                <?=$img;?>
                                <img src="<?=$qrcode;?>">                            
                            </div>
                            <div class="card-body">

                            <div class="row">
                                <div class="col-md-3"><h4>Kategori</h4></div>
                                <div class="col-md-9"><h4>: <?=$kategori;?></h4></div>
                            </div>

                            <div class="row">
                                <div class="col-md-3"><h4>Stok</h4></div>
                                <div class="col-md-9"><h4>: <?=$stok;?></h4></div>
                            </div>

                            <br></br>

                                <h3>Barang Masuk</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="barangmasuk" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Penerima</th>
                                                <th>Jumlah</th>
                                                <th>Supplier</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            $query = "select m.*, s.namasupplier from masuk m join supplier s on m.idsupplier = s.idsupplier where m.idbarang='$idbarang'";

                                            $ambildatamasuk= mysqli_query($conn, $query);
                                            $i = 1;

                                            while($fetch=mysqli_fetch_array($ambildatamasuk)){
                                                $tanggal = $fetch['tanggal'];
                                                $penerima = $fetch['penerima'];
                                                $quantity = $fetch['qty'];
                                                $idsupplier = $fetch['idsupplier'];
                                                $namasupplier = $fetch['namasupplier'];
                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$penerima;?></td>
                                                <td><?=$quantity;?></td>
                                                <td><?=$namasupplier;?></td>
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
                                    <table class="table table-bordered" id="barangkeluar" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ambildatakeluar = mysqli_query($conn, "select * from keluar where idbarang='$idbarang'");
                                            $i = 1;

                                            while($fetch=mysqli_fetch_array($ambildatakeluar)){
                                                $tanggal = $fetch['tanggal'];
                                                $keterangan = $fetch['keterangan'];
                                                $quantity = $fetch['qty'];
                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$keterangan;?></td>
                                                <td><?=$quantity;?></td>
                                            </tr>
                                            
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
            <h4 class="modal-title">Tambah Barang</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
        <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control" required>
        <br>
        <input type="text" name="kategori" placeholder="Kategori Barang" class="form-control" required>
        <br>
        <input type="number" name="stok" placeholder="stok" class="form-control" required>
        <br>
        <input type="file" name="file" class="form-control">
        <br>
        <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
        </form>
        </div>

        </div>
    </div>
    </div>

</html>
