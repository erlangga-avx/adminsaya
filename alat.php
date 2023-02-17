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
        <title>Laporan Alat - GRAND Inventory</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <?php include "components/nav.php" ?>
        <div id="layoutSidenav">
        <?php include "components/sidebar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Laporan Alat</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Alat
                            </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Alat</th>
                                            <th>Deskripsi Kerusakan Alat</th>
                                            <th>Status Perbaikan</th>
                                            <th>Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $ambilsemuadataalat = mysqli_query($conn, "select * from alat");
                                        while($data=mysqli_fetch_array($ambilsemuadataalat)){
                                            $tanggal = $data['tanggal'];
                                            $namaalat = $data['namaalat'];
                                            $deskalat = $data['deskalat'];
                                            $status = $data['status'];
                                            $ida = $data['idalat'];
                                        ?>
                                        <tr>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$namaalat;?></td>
                                            <td><?=$deskalat;?></td>
                                            <td><?=$status;?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$ida;?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$ida;?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                            <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?=$ida;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Laporan Alat</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <!-- Modal body -->
                                            <form method="post">
                                            <div class="modal-body">
                                            <input type="text" name="namaalat" value="<?=$namaalat;?>" class="form-control" required>
                                            <br>
                                            <input type="text" name="deskalat" value="<?=$deskalat;?>" class="form-control" required>
                                            <br>
                                            <input type="radio" name="status" value="Rusak" class="form-check-input" checked>
                                            <label for="radio01" class="form-check-label">Rusak</label>
                                            <br>
                                            <br>
                                            <input type="radio" name="status" value="Diperbaiki" class="form-check-input">
                                            <label for="radio02" class="form-check-label">Diperbaiki</label>
                                            <br>
                                            <br>
                                            <input type="radio" name="status" value="Harus Diganti" class="form-check-input">
                                            <label for="radio03" class="form-check-label">Harus Diganti</label>
                                            <br>
                                            <br>
                                            <input type="hidden" name="ida" value="<?=$ida;?>">
                                            <button type="submit" class="btn btn-primary" name="updatealat">Submit</button>
                                            </form>
                                            </div>

                                            </div>
                                        </div>
                                        </div>

                                        <!-- Hapus Modal -->
                                        <div class="modal fade" id="delete<?=$ida;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Alat?</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <!-- Modal body -->
                                            <form method="post">
                                            <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus <?=$namaalat;?>?
                                            <input type="hidden" name="ida" value="<?=$ida;?>">
                                            <br>
                                            <br>
                                            <button type="submit" class="btn btn-danger" name="hapusalat">Hapus</button>
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
            <h4 class="modal-title">Tambah Alat</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <form method="post">
        <div class="modal-body">
        <input type="text" name="namaalat" placeholder="Nama Alat" class="form-control" required>
        <br>
        <input type="text" name="deskalat" placeholder="Deskripsi Kerusakan" class="form-control" required>
        <br>
        <h5><small>Status Perbaikan</small></h5>
        <input type="radio" name="status" value="Rusak" class="form-check-input" checked>
        <label for="radio01" class="form-check-label">Rusak</label>
        <br>
        <!--
        <input type="radio" name="status" value="Diperbaiki" class="form-check-input">
        <label for="radio02" class="form-check-label">Diperbaiki</label>
        <br>
        <input type="radio" name="status" value="Harus Diganti" class="form-check-input">
        <label for="radio03" class="form-check-label">Harus Diganti</label>
        -->
        <br>
        <button type="submit" class="btn btn-primary" name="addalat">Submit</button>
        </form>
        </div>

        </div>
    </div>
    </div>
</html>
