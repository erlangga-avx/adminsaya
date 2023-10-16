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
    <title>Mahasiswa</title>
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
                    <h1 class="mt-4">Data Mahasiswa</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Data
                            </button>
                            <a href="exportmhs.php" class="btn btn-success">Export Data</a>
                            <br>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIM</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Program Studi</th>
                                            <th>Tempat Lahir</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Alamat</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tahun Angkatan</th>
                                            <th>Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ambilsemuadata = mysqli_query($conn, "select * from mahasiswa");
                                        $i = 1;
                                        while ($data = mysqli_fetch_array($ambilsemuadata)) {
                                            $idm = $data['idmahasiswa'];
                                            $nim = $data['nim'];
                                            $namamahasiswa = $data['namamahasiswa'];
                                            $programstudi = $data['programstudi'];
                                            $tempatlahir = $data['tempatlahir'];
                                            $tgllahir = $data['tgllahir'];
                                            $alamat = $data['alamat'];
                                            $jeniskelamin = $data['jeniskelamin'];
                                            $angkatan = $data['angkatan'];
                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $nim; ?></td>
                                                <td><?= $namamahasiswa; ?></td>
                                                <td><?= $programstudi; ?></td>
                                                <td><?= $tempatlahir; ?></td>
                                                <td><?= $tgllahir; ?></td>
                                                <td><?= $alamat; ?></td>
                                                <td><?= $jeniskelamin; ?></td>
                                                <td><?= $angkatan; ?></td>
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
                                                            <h4 class="modal-title">Edit Data</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <input type="text" name="nim" value="<?= $nim; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="namamahasiswa" value="<?= $namamahasiswa; ?>" class="form-control" required>
                                                                <br>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" id="check1" name="programstudi" value="Teknik Informatika">
                                                                    <label class="form-check-label">Teknik Informatika</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" id="check1" name="programstudi" value="Sistem Informasi">
                                                                    <label class="form-check-label">Sistem Informasi</label>
                                                                </div>
                                                                <input type="text" name="tempatlahir" value="<?= $tempatlahir; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="date" name="tgllahir" value="<?= $tgllahir; ?>" class="form-control" required>
                                                                <br>
                                                                <textarea class="form-control" rows="5" name="alamat" value="<?= $alamat; ?>" placeholder="Alamat"></textarea>
                                                                <br>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input" id="radio1" name="jeniskelamin" value="Laki-laki" checked>Laki-laki
                                                                    <label class="form-check-label" for="radio1"></label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input" id="radio2" name="jeniskelamin" value="Perempuan">Perempuan
                                                                    <label class="form-check-label" for="radio2"></label>
                                                                </div>
                                                                <br>
                                                                <input type="text" name="angkatan" value="<?= $angkatan; ?>" class="form-control" required>
                                                                <br>
                                                                <input type="hidden" name="idmahasiswa" value="<?= $idm; ?>">
                                                                <button type="submit" class="btn btn-primary" name="updatemahasiswa">Simpan</button>
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
                                            <h4 class="modal-title">Hapus Data?</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Modal body -->
                                        <form method="post">
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus data milik <?= $namamahasiswa; ?>?
                                                <input type="hidden" name="idmahasiswa" value="<?= $idm; ?>">
                                                <br>
                                                <br>
                                                <button type="submit" class="btn btn-danger" name="hapusmahasiswa">Hapus</button>
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
                    <input type="text" name="nim" placeholder="NIM" class="form-control" required>
                    <br>
                    <input type="text" name="namamahasiswa" placeholder="Nama Mahasiswa" class="form-control" required>
                    <br>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check1" name="programstudi" value="Teknik Informatika">
                        <label class="form-check-label">Teknik Informatika</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check1" name="programstudi" value="Sistem Informasi">
                        <label class="form-check-label">Sistem Informasi</label>
                    </div>
                    <br>
                    <input type="text" name="tempatlahir" placeholder="Tempat Lahir" class="form-control" required>
                    <br>
                    <input type="date" name="tgllahir" class="form-control" required>
                    <br>
                    <textarea class="form-control" rows="5" name="alamat" placeholder="Alamat"></textarea>
                    <br>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="radio1" name="jeniskelamin" value="Laki-laki" checked>Laki-laki
                        <label class="form-check-label" for="radio1"></label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="radio2" name="jeniskelamin" value="Perempuan">Perempuan
                        <label class="form-check-label" for="radio2"></label>
                    </div>
                    <br>
                    <input type="text" name="angkatan" placeholder="Angkatan" class="form-control" required>
                    <br>
                    <button type="submit" class="btn btn-primary" name="addmahasiswa">Tambah</button>
            </form>
        </div>

    </div>
</div>
</div>

</html>