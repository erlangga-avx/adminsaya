<?php
require 'function1.php';
require 'cek.php';
?>
<html>

<head>
    <title>GRAND Fotocopy Gambut</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
    <div class="container">
        <h2>GRAND Fotocopy Gambut</h2>
        <h4>Supplier</h4>
        <div class="data-tables datatable-dark">

            <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
            <table class="table table-striped" id="mauexport" width="100%" cellspacing="0">
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
                                                                <label for="alamat">Alamat:</label>
                                                                <textarea class="form-control" rows="5" id="alamat" name="alamat"></textarea>
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
                                                                <input type="hidden" name="id" value="<?= $idm; ?>">
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

<script>
    $(document).ready(function() {
        $('#mauexport').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>



</body>

</html>