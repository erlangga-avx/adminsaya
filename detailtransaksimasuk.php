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
                                <div class="card-header">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                        Tambah Barang
                                    </button>
                                    <br>
                                    <form method="post" class="mt-3">
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Satuan</th>
                                                <th>Supplier</th>
                                                <th>Nomor Nota</th>
                                                <th>Pilihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $query = "select * from masuk m join stok s on s.idbarang = m.idbarang join supplier su on su.idsupplier = m.idsupplier";

                                            $ambildatamasuk = mysqli_query($conn, $query);
                                            $i = 1;

                                            while ($fetch = mysqli_fetch_array($ambildatamasuk)) {
                                                $idb = $data['idbarang'];
                                                $idm = $data['idmasuk'];
                                                $idt = $data['idtransaksi'];
                                                $kodetransaksi = $data['kodetransaksi'];
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
                                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $idm; ?>">
                                                            Edit
                                                        </button>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $idm; ?>">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="edit<?= $idm; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">

                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Barang Masuk</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <!-- Modal body -->
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
                                                                    <input type="text" name="nota" value="<?= $nota; ?>" class="form-control" required>
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

                                <!-- Hapus Modal -->
                                <div class="modal fade" id="delete<?= $idm; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Barang?</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <!-- Modal body -->
                                            <form method="post">
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus <?= $namabarang; ?>?
                                                    <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                    <input type="hidden" name="qty" value="<?= $qty; ?>">
                                                    <input type="hidden" name="idm" value="<?= $idm; ?>">
                                                    <input type="hidden" name="ids" value="<?= $ids; ?>">
                                                    <input type="hidden" name="satuan" value="<?= $satuan; ?>">
                                                    <input type="hidden" name="nota" value="<?= $nota; ?>">
                                                    <br>
                                                    <br>
                                                    <button type="submit" class="btn btn-danger" name="hapusbarangmasuk">Hapus</button>
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
                        <br>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Simpan
                            </button>
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

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Barang Masuk</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">

                    <select name="barangnya" class="form-control">
                        <?php
                        $ambilsemuadata = mysqli_query($conn, "select *  from stok");
                        while ($fetcharray = mysqli_fetch_array($ambilsemuadata)) {
                            $namabarangnya = $fetcharray['namabarang'];
                            $idbarangnya = $fetcharray['idbarang'];
                        ?>

                            <option value="<?= $idbarangnya; ?>"><?= $namabarangnya; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <br>
                    <select name="suppliernya" class="form-control">
                        <?php
                        $ambilsemuadata = mysqli_query($conn, "select *  from supplier");
                        while ($fetcharray = mysqli_fetch_array($ambilsemuadata)) {
                            $namasuppliernya = $fetcharray['namasupplier'];
                            $idsuppliernya = $fetcharray['idsupplier'];
                        ?>

                            <option value="<?= $idsuppliernya; ?>"><?= $namasuppliernya; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <br>
                    <input type="text" name="nota" placeholder="nomor nota" class="form-control" required>
                    <br>
                    <input type="number" name="qty" placeholder="jumlah" class="form-control" required>
                    <br>
                    <select name="satuan" class="form-control" required>
                        <option value="pcs">pcs</option>
                        <option value="rim">rim</option>
                        <option value="ply">ply</option>
                        <option value="pack">pack</option>
                    </select>
                    <!--<input type="text" name="satuan" placeholder="satuan" class="form-control" required>-->
                    <br>
                    <button type="submit" class="btn btn-primary" name="barangmasuk">Submit</button>
            </form>
        </div>

    </div>
</div>
</div>

</html>