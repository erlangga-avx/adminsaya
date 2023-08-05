<?php
require 'function.php';
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
        <h4>Barang Keluar</h4>
        <div class="data-tables datatable-dark">
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
            <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
            <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    if (isset($_POST['filter_tgl'])) {
                        $mulai = $_POST['tgl_mulai'];
                        $selesai = $_POST['tgl_selesai'];

                        if ($mulai != null || $selesai != null) {
                            $ambilsemuadatastok = mysqli_query($conn, "select * from keluar k join stok s on s.idbarang = k.idbarang join transaksikeluar tk on tk.idtransaksi = k.idtransaksi and tanggal BETWEEN '$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY)");
                        } else {
                            $ambilsemuadatastok = mysqli_query($conn, "select * from keluar k join stok s on s.idbarang = k.idbarang join transaksikeluar tk on tk.idtransaksi = k.idtransaksi");
                        }
                    } else {
                        $ambilsemuadatastok = mysqli_query($conn, "select * from keluar k join stok s on s.idbarang = k.idbarang join transaksikeluar tk on tk.idtransaksi = k.idtransaksi");
                    }

                    while ($data = mysqli_fetch_array($ambilsemuadatastok)) {
                        $idb = $data['idbarang'];
                        $idk = $data['idkeluar'];
                        $idt = $data['idtransaksi'];
                        $tanggal = $data['tanggal'];
                        $namabarang = $data['namabarang'];
                        $qty = $data['qty'];
                        $keterangan = $data['keterangan'];
                        $kodeauto = $data['kodetransaksi'];
                        $satuan = $data['satuan'];

                        //cek apakah ada gambar
                        $gambar = $data['image']; //mengambil gambar
                        if ($gambar == null) {
                            //jika tidak ada gambar
                            $img = 'Tidak Ada Gambar';
                        } else {
                            //jika ada gambar
                            $img = '<img src="images/' . $gambar . '" class="zoomable">';
                        }
                    ?>
                        <tr>
                            <td><?= $tanggal; ?></td>
                            <td><?= $kodeauto; ?></td>
                            <td><?= $namabarang; ?></td>
                            <td><?= $qty; ?></td>
                            <td><?= $satuan; ?></td>
                            <td><?= $keterangan; ?></td>
                        </tr>

        </div>

        <!-- Hapus Modal -->
        <div class="modal fade" id="delete<?= $idk; ?>">
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
                            <input type="hidden" name="idk" value="<?= $idk; ?>">
                            <br>
                            <br>
                            <button type="submit" class="btn btn-danger" name="hapusbarangkeluar">Hapus</button>
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