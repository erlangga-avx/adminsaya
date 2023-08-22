<?php
require 'function1.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Absensi Pegawai</title>
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
                    <h1 class="mt-4">Absensi Pegawai</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Data
                            </button>
                            <br>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIP</th>
                                            <th>Nama Pegawai</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Pulang</th>
                                            <th>Keterangan</th>
                                            <th>Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ambilsemuadata = mysqli_query($conn, "select * from absen");
                                        $i = 1;
                                        while ($data = mysqli_fetch_array($ambilsemuadata)) {
                                            $idp = $data['id'];
                                            $nip = $data['nip'];
                                            $namapegawai = $data['namapegawai'];
                                            $jammasuk = $data['jammasuk'];
                                            $jampulang = $data['jampulang'];
                                            $keterangan = $data['keterangan'];
                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $nip; ?></td>
                                                <td><?= $namapegawai; ?></td>
                                                <td><?= $jammasuk; ?></td>
                                                <td><?= $jampulang; ?></td>
                                                <td><?= $keterangan; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $idp; ?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $idp; ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?= $idp; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Data</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <input type="text" name="nip" value="<?= $nip; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="namapegawai" value="<?= $namapegawai; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="time" name="jammasuk" value="<?= $jammasuk; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="time" name="jampulang" value="<?= $jampulang; ?>" class="form-control" required>
                                                                <br>
                                                                <select name="keterangan" class="form-control" required>
                                                                    <option value="tepatwaktu">Tepat Waktu</option>
                                                                    <option value="terlambat">Terlambat</option>
                                                                    <option value="terlambatberizin">Terlambat-Berizin</option>
                                                                </select>
                                                                <br>
                                                                <input type="hidden" name="id" value="<?= $idp; ?>">
                                                                <button type="submit" class="btn btn-primary" name="updateabsen">Simpan</button>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                            </div>

                            <!-- Hapus Modal -->
                            <div class="modal fade" id="delete<?= $idp; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Hapus Data?</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Modal body -->
                                        <form method="post">
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus data milik <?= $namapegawai; ?>?
                                                <input type="hidden" name="id" value="<?= $idp; ?>">
                                                <br>
                                                <br>
                                                <button type="submit" class="btn btn-danger" name="hapusabsen">Hapus</button>
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
                <h4 class="modal-title">Tambah Data</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <input type="text" name="nip" placeholder="NIP" class="form-control" required>
                    <br>
                    <input type="text" name="namapegawai" placeholder="Nama Pegawai" class="form-control" required>
                    <br>
                    Jam Masuk
                    <input type="time" name="jammasuk" class="form-control" required>
                    <br>
                    Jam Pulang
                    <input type="time" name="jampulang" class="form-control" required>
                    <br>
                    <select name="keterangan" class="form-control" required>
                        <option value="tepatwaktu">Tepat Waktu</option>
                        <option value="terlambat">Terlambat</option>
                        <option value="terlambatberizin">Terlambat-Berizin</option>
                    </select>
                    <br>
                    <button type="submit" class="btn btn-primary" name="addabsen">Tambah</button>
            </form>
        </div>

    </div>
</div>
</div>

</html>