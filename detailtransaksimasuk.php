<?php
require 'function.php';
require 'cek.php';

//mendapatkan id barang yang dioper dari halaman sebelumnya
$idtransaksi = $_GET['id']; //get id transaksi
//mengambil informasi barang berdasarkan database
$get = mysqli_query($conn, "select * from transaksimasuk where idtransaksi='$idtransaksi'");
$fetch = mysqli_fetch_assoc($get);
//set variabel
$tanggal = $fetch['tanggal'];
$kodetransaksi = $fetch['kodetransaksi'];
$pengirim = $fetch['pengirim'];
$penerima = $fetch['penerima'];
$jumlah = $fetch['jumlah'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Detail Transaksi Masuk - GRAND Inventory</title>
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
                    <h1 class="mt-4">Detail Transaksi Masuk</h1>
                    <a href="exportdetailtransaksimasuk.php?id=<?= $idtransaksi; ?>" class="btn btn-success">Export Data</a>
                    <div class="card mb-4 mt-4">
                        <div class="card-header">
                            <h2>Kode Transaksi <?= $kodetransaksi; ?></h2>
                        </div>
                        <div class="card-body">
                            <input type="text" name="tanggal" value="Tanggal Masuk : <?php echo $tanggal; ?>" class="form-control" disabled>
                            <br>
                            <input type="text" name="pengirim" value="Pengirim : <?php echo $pengirim; ?>" class="form-control" disabled>
                            <br>
                            <input type="text" name="penerima" value="Penerima : <?php echo $penerima; ?>" class="form-control" disabled>

                            <br></br>

                            <h3>Data Barang Masuk</h3>
                            <div class="card mb-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Satuan</th>
                                                <th>Supplier</th>
                                                <th>Nomor Nota</th>
                                                <th>Tanda Terima</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $query = "select * from masuk m join stok s on s.idbarang = m.idbarang join supplier su on su.idsupplier = m.idsupplier where m.idtransaksi='$idtransaksi'";

                                            $ambildatamasuk = mysqli_query($conn, $query);
                                            $i = 1;

                                            while ($data = mysqli_fetch_array($ambildatamasuk)) {
                                                $idb = $data['idbarang'];
                                                $idm = $data['idmasuk'];
                                                $idt = $data['idtransaksi'];
                                                $tanggal = $data['tanggal'];
                                                $satuan = $data['satuan'];
                                                $namabarang = $data['namabarang'];
                                                $qty = $data['qty'];
                                                $ids = $data['idsupplier'];
                                                $namasupplier = $data['namasupplier'];
                                                $nota = $data['nota'];

                                            ?>

                                                <tr>
                                                    <td><?= $namabarang; ?></td>
                                                    <td><?= $qty; ?></td>
                                                    <td><?= $satuan; ?></td>
                                                    <td><?= $namasupplier; ?></td>
                                                    <td><?= $nota; ?></td>
                                                    <td>
                                                        <a href="tandaterimamasuk.php?id=<?= $ids; ?>">
                                                            <i class="fa-solid fa-pen-nib"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                </div>
                            </div>

                        <?php
                                            };

                        ?>

                        </tbody>
                        </table>
                        <br>
                        <div class="card-footer">
                            <br>
                            <form method="post" class="mt-3">
                            </form>
                        </div>
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