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
    <title>Aset - GRAND Inventory</title>
    <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <!--<style>
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
    </style>-->
</head>

<body class="sb-nav-fixed">
    <?php include "components/nav.php" ?>
    <div id="layoutSidenav">
        <?php include "components/sidebar.php" ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Aset Toko</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Aset Baru
                            </button>
                            <a href="exportaset.php" class="btn btn-success">Export Data</a>
                        </div>
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
                        <!-- <div class="card-body">

                            <?php
                            $ambildatastok = mysqli_query($conn, "select * from stok where stok < 5 and stok > 0");

                            while ($fetch = mysqli_fetch_array($ambildatastok)) {
                                $barang = $fetch['namabarang'];
                                $stok = $fetch['stok'];
                                $satuan = $fetch['satuan'];

                            ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    <strong>Peringatan!</strong> Stok <?= $barang; ?> Hampir Habis, stok tersisa <u><?= $stok; ?> <?= $satuan; ?></u>
                                </div>
                            <?php
                            }

                            $ambildatastok = mysqli_query($conn, "select * from stok where stok = 0");

                            while ($fetch = mysqli_fetch_array($ambildatastok)) {
                                $barang = $fetch['namabarang'];
                                $stok = $fetch['stok'];
                                $satuan = $fetch['satuan'];

                            ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    <strong>Peringatan!</strong> Stok <?= $barang; ?> Telah Habis
                                </div>
                            <?php
                            }

                            ?>-->
                            <br>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Aset</th>
                                        <th>Jumlah</th>
                                        <th>Jenis</th>
                                        <th>Kondisi</th>
                                        <th>Tanggal Input</th>
                                        <th>Tanggal Update</th>
                                        <th>Pilihan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_POST['filter_tgl'])) {
                                        $mulai = $_POST['tgl_mulai'];
                                        $selesai = $_POST['tgl_selesai'];

                                        if ($mulai != null || $selesai != null) {
                                            $ambilsemuadataaset = mysqli_query($conn, "select * from aset where idaset=idaset and tglupdate BETWEEN '$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY)");
                                        } else {
                                            $ambilsemuadataaset = mysqli_query($conn, "select * from aset where idaset=idaset");
                                        }
                                    } else {
                                        $ambilsemuadataaset = mysqli_query($conn, "select * from aset where idaset=idaset");
                                    }

                                    $i = 1;
                                    while ($data = mysqli_fetch_array($ambilsemuadataaset)) {
                                        $idaset = $data['idaset'];
                                        $namaaset = $data['namaaset'];
                                        $jumlah = $data['jumlah'];
                                        $jenis = $data['jenis'];
                                        $kondisi = $data['kondisi'];
                                        $tglinput = $data['tglinput'];
                                        $tglupdate = $data['tglupdate'];
                                    ?>

                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $namaaset; ?></td>
                                            <td><?= $jumlah; ?></td>
                                            <td><?= $jenis; ?></td>
                                            <td>
                                                <?php
                                                $kondisi = $data['kondisi'];
                                                $badge_class = '';
                                                switch ($kondisi) {
                                                    case 'Baik Seluruhnya':
                                                        $badge_class = 'badge bg-success';
                                                        break;
                                                    case 'Rusak Sebagian':
                                                        $badge_class = 'badge bg-warning';
                                                        break;
                                                    case 'Rusak Total':
                                                        $badge_class = 'badge bg-danger';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge <?= $badge_class; ?>"><?= $kondisi; ?></span>
                                            </td>
                                            <td><?= $tglinput; ?></td>
                                            <td><?= $tglupdate; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $idaset; ?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $idaset; ?>">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?= $idaset; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Data Aset</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type="text" name="namaaset" value="<?= $namaaset; ?>" class="form-control" required>
                                                            <br>
                                                            <input type="number" name="jumlah" value="<?= $jumlah; ?>" class="form-control" required>
                                                            <br>
                                                            <select name="jenis" class="form-control" required>
                                                                <option value="Bangunan Tetap">Bangunan Tetap</option>
                                                                <option value="Barang Elektronik">Alat Elektronik</option>
                                                                <option value="Barang Non-Elektronik">Barang Non-Elektronik</option>
                                                                <option value="Kendaraan">Kendaraan</option>
                                                            </select>
                                                            <br>
                                                            <h5><small>Kondisi Aset</small></h5>
                                                            <input type="radio" name="kondisi" value="Baik Seluruhnya" class="form-check-input" checked>
                                                            <label for="radio01" class="form-check-label">Baik Seluruhnya</label>
                                                            <br>
                                                            <br>
                                                            <input type="radio" name="kondisi" value="Rusak Sebagian" class="form-check-input">
                                                            <label for="radio01" class="form-check-label">Rusak Sebagian</label>
                                                            <br>
                                                            <br>
                                                            <input type="radio" name="kondisi" value="Rusak Total" class="form-check-input">
                                                            <label for="radio02" class="form-check-label">Rusak Total</label>
                                                            <br>
                                                            <br>
                                                            <h5>Tanggal Input Data</h5><small>*masukkan hanya jika terjadi kesalahan</small>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <input type="date" name="tglinput" class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <input type="hidden" name="idaset" value="<?= $idaset; ?>">
                                                            <button type="submit" class="btn btn-primary" name="updateaset">Simpan</button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                        </div>

                        <!-- Hapus Modal -->
                        <div class="modal fade" id="delete<?= $idaset; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Hapus Data Aset?</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <form method="post">
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus <?= $namaaset; ?>?
                                            <input type="hidden" name="idaset" value="<?= $idaset; ?>">
                                            <br>
                                            <br>
                                            <button type="submit" class="btn btn-danger" name="hapusaset">Hapus</button>
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
                <h4 class="modal-title">Tambah Data Aset</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="text" name="namaaset" placeholder="Nama Aset" class="form-control" required>
                    <br>
                    <input type="number" name="jumlah" placeholder="Jumlah Aset" class="form-control" required>
                    <br>
                    <select name="jenis" class="form-control" required>
                        <option value="Bangunan Tetap">Bangunan Tetap</option>
                        <option value="Barang Elektronik">Alat Elektronik</option>
                        <option value="Barang Non-Elektronik">Barang Non-Elektronik</option>
                        <option value="Kendaraan">Kendaraan</option>
                    </select>
                    <br>
                    <h5><small>Kondisi Aset</small></h5>
                    <input type="radio" name="kondisi" value="Baik Seluruhnya" class="form-check-input" checked>
                    <label for="radio01" class="form-check-label">Baik Seluruhnya</label>
                    <br>
                    <br>
                    <input type="radio" name="kondisi" value="Rusak Sebagian" class="form-check-input">
                    <label for="radio01" class="form-check-label">Rusak Sebagian</label>
                    <br>
                    <br>
                    <input type="radio" name="kondisi" value="Rusak Total" class="form-check-input">
                    <label for="radio02" class="form-check-label">Rusak Total</label>
                    <br>
                    <br>
                    <h5>Tanggal Input Data</h5><small>*tanggal aset masuk pertama kali</small>
                    <div class="row">
                        <div class="col">
                            <input type="date" name="tglinput" class="form-control" required>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" name="addnewaset">Tambah</button>
            </form>
        </div>

    </div>
</div>
</div>

</html>