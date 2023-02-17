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
        <title>Supplier - GRAND Inventory</title>
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
                        <h1 class="mt-4">Supplier</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Supplier
                            </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Supplier</th>
                                            <th>No. Telepon Supplier</th>
                                            <th>Alamat Supplier</th>
                                            <th>Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $ambilsemuadatasupplier = mysqli_query($conn, "select * from supplier");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadatasupplier)){
                                            $ids = $data['idsupplier'];
                                            $namasupplier = $data['namasupplier'];
                                            $nomorsupplier = $data['nomorsupplier'];
                                            $alamat = $data['alamat'];
                                        ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$namasupplier;?></td>
                                            <td><?=$nomorsupplier;?></td>
                                            <td><?=$alamat;?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$ids;?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$ids;?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                            <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?=$ids;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Supplier</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <!-- Modal body -->
                                            <form method="post">
                                            <div class="modal-body">
                                            <input type="text" name="namasupplier" value="<?=$namasupplier;?>" class="form-control" required>
                                            <br>
                                            <input type="text" name="nomorsupplier" value="<?=$nomorsupplier;?>" class="form-control" required>
                                            <br>
                                            <input type="text" name="alamat" value="<?=$alamat;?>" class="form-control" required>
                                            <br>
                                            <input type="hidden" name="ids" value="<?=$ids;?>">
                                            <button type="submit" class="btn btn-primary" name="updatesupplier">Submit</button>
                                            </form>
                                            </div>

                                            </div>
                                        </div>
                                        </div>

                                        <!-- Hapus Modal -->
                                        <div class="modal fade" id="delete<?=$ids;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Supplier?</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <!-- Modal body -->
                                            <form method="post">
                                            <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus <?=$namasupplier;?>?
                                            <input type="hidden" name="ids" value="<?=$ids;?>">
                                            <br>
                                            <br>
                                            <button type="submit" class="btn btn-danger" name="hapussupplier">Hapus</button>
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
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
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
            <h4 class="modal-title">Tambah Supplier</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <form method="post">
        <div class="modal-body">
        <input type="text" name="namasupplier" placeholder="Nama Supplier" class="form-control" required>
        <br>
        <input type="text" name="nomorsupplier" placeholder="No. Telepon Supplier" class="form-control" required>
        <br>
        <input type="text" name="alamat" placeholder="Alamat Supplier" class="form-control" required>
        <br>
        <button type="submit" class="btn btn-primary" name="addsupplier">Submit</button>
        </form>
        </div>

        </div>
    </div>
    </div>
</html>
