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
    <title>Transaksi Barang Keluar - GRAND Inventory</title>
    <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <?php include "components/nav.php" ?>
    <div id="layoutSidenav">
        <?php include "components/sidebar.php" ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Transaksi Barang Keluar</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <a href="tr_keluar.php" class="btn btn-primary"> Tambah Transaksi</a>
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
                            </div>
                        </form>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kode Transaksi</th>
                                            <th>Tanggal</th>
                                            <th>Jumlah</th>
                                            <th>Detail</th>
                                            <th>Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if (isset($_POST['filter_tgl'])) {
                                            $mulai = $_POST['tgl_mulai'];
                                            $selesai = $_POST['tgl_selesai'];

                                            if ($mulai != null || $selesai != null) {
                                                $ambilsemuadatatransaksi = mysqli_query($conn, "select * from transaksikeluar where tanggal BETWEEN '$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY)");
                                            } else {
                                                $ambilsemuadatatransaksi = mysqli_query($conn, "select * from transaksikeluar");
                                            }
                                        } else {
                                            $ambilsemuadatatransaksi = mysqli_query($conn, "select * from transaksikeluar");
                                        }

                                        while ($data = mysqli_fetch_array($ambilsemuadatatransaksi)) {
                                            $idt = $data['idtransaksi'];
                                            $tanggal = $data['tanggal'];
                                            $kodetransaksi = $data['kodetransaksi'];
                                            $jumlah = $data['jumlah'];

                                            //cek apakah ada jumlah
                                            if ($jumlah == null) {
                                                //jika tidak ada jumlah
                                                $jumlah = '0';
                                            }
                                        ?>
                                            <tr>
                                                <td><?= $kodetransaksi; ?></td>
                                                <td><?= $tanggal; ?></td>
                                                <td><?= $jumlah; ?></td>
                                                <td>
                                                    <a href="detailtransaksikeluar.php?id=<?= $idt; ?>">
                                                        <i class="fa-solid fa-bars"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <i class="fa-solid fa-delete-left" data-bs-toggle="modal" data-bs-target="#delete<?= $idt; ?>"></i>
                                                </td>
                                            </tr>

                                            <!--
                                          Edit Modal
                                         <div class="modal fade" id="edit<?= $idm; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            Modal Header
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Barang Masuk</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            Modal body
                                            <form method="post">
                                            <div class="modal-body">
                                            <select name="suppliernya" class="form-control">
                                                <?php
                                                $ambilsemuadata = mysqli_query($conn, "select *  from supplier");
                                                while ($fetcharray = mysqli_fetch_array($ambilsemuadata)) {
                                                    $namasupplier = $fetcharray['namasupplier'];
                                                    $idsupplier = $fetcharray['idsupplier'];
                                                ?>

                                                <option value="<?= $idsupplier; ?>"><?= $namasupplier; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <br>
                                            <input type="text" name="penerima" value="<?= $penerima; ?>" class="form-control" required>
                                            <br>
                                            <input type="number" name="qty" value="<?= $qty; ?>" class="form-control" required>
                                            <br>
                                            <input type="text" name="satuan" value="<?= $satuan; ?>" class="form-control" required>
                                            <br>
                                            <input type="hidden" name="idb" value="<?= $idb; ?>">
                                            <input type="hidden" name="idm" value="<?= $idm; ?>">
                                            <button type="submit" class="btn btn-primary" name="updatebarangmasuk">Submit</button>
                                            </form>
                                            </div>

                                            </div>
                                        </div>
                                        </div> 
                                        -->

                                            <!-- Hapus Modal -->
                                            <div class="modal fade" id="delete<?= $idt; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Transaksi?</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus <?= $kodeauto; ?>?
                                                                <input type="hidden" name="idt" value="<?= $idt; ?>">
                                                                <input type="hidden" name="kodetransaksi" value="<?= $kodeauto; ?>">
                                                                <input type="hidden" name="jumlah" value="<?= $jumlah; ?>">
                                                                <br>
                                                                <br>
                                                                <button type="submit" class="btn btn-danger" name="hapustransaksikeluar">Hapus</button>
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
<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Transaksi Barang Keluar</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <input type="text" name="kodetransaksi" id="kodetransaksi" class="form-control" value="<?php echo $kodeauto; ?>" disabled>
                    <br>
                    <input type="text" name="pengirim" placeholder="Pengirim" class="form-control" required>
                    <br>
                    <input type="text" name="penerima" placeholder="Penerima" class="form-control" required>
                    <br>
                    <button type="submit" class="btn btn-primary" name="addtransaksimasuk">Submit</button>
            </form>
        </div>
    </div>
</div>
</div>

</html>