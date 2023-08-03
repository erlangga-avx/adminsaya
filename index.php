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
    <title>Dashboard - GRAND Inventory</title>
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

        a {
            text-decoration: none;
            color: black;
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
                    <h1 class="mt-4">Stok Barang</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Barang Baru
                            </button>
                            <a href="export.php" class="btn btn-success">Export Data</a>
                        </div>
                        <div class="card-body">

                            <?php
                            $ambildatastok = mysqli_query($conn, "select * from stok where stok < 5");

                            while ($fetch = mysqli_fetch_array($ambildatastok)) {
                                $barang = $fetch['namabarang'];

                            ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    <strong>Peringatan!</strong> Stok <?= $barang; ?> Telah Habis
                                </div>
                            <?php
                            }
                            ?>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Nama Barang</th>
                                            <th>Detail</th>
                                            <th>Kategori</th>
                                            <th>Stok</th>
                                            <th>Satuan</th>
                                            <th>Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ambilsemuadatastok = mysqli_query($conn, "select * from stok");
                                        $i = 1;
                                        while ($data = mysqli_fetch_array($ambilsemuadatastok)) {
                                            $namabarang = $data['namabarang'];
                                            $kategori = $data['kategori'];
                                            $satuan = $data['satuan'];
                                            $stok = $data['stok'];
                                            $idb = $data['idbarang'];

                                            //cek apakah ada gambar
                                            $gambar = $data['image']; //mengambil gambar
                                            if ($gambar == null) {
                                                //jika tidak ada gambar
                                                $img = "Tidak Ada Gambar";
                                            } else {
                                                //jika ada gambar
                                                $img = '<img src="images/' . $gambar . '" class="zoomable">';
                                            }
                                        ?>

                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $img; ?></td>
                                                <td><?= $namabarang; ?></td>
                                                <td><button type="button" class="btn btn-primary"><a href="detail.php?id=<?= $idb; ?>"><i class="fas fa-info" style="color: #ffffff;"></i></a></button></td>
                                                <td><?= $kategori; ?></td>
                                                <td><?= $stok; ?></td>
                                                <td><?= $satuan; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $idb; ?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $idb; ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?= $idb; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Barang</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <form method="post" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <input type="text" name="namabarang" value="<?= $namabarang; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="kategori" value="<?= $kategori; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="satuan" value="<?= $satuan; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="file" name="file" class="form-control">
                                                                <br>
                                                                <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                                <button type="submit" class="btn btn-primary" name="updatebarang">Submit</button>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                            </div>

                            <!-- Hapus Modal -->
                            <div class="modal fade" id="delete<?= $idb; ?>">
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
                                                <br>
                                                <br>
                                                <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
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
                    <select name="satuan" class="form-control" required>
                        <option value="pcs">pcs</option>
                        <option value="rim">rim</option>
                        <option value="ply">ply</option>
                        <option value="pack">pack</option>
                    </select>
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