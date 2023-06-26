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
        <h4>Laporan Kerusakan Alat</h4>
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
            <table class="table table-striped" id="mauexport" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Alat</th>
                        <th>Deskripsi Kerusakan Alat</th>
                        <th>Status Perbaikan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ambilsemuadataalat = mysqli_query($conn, "select * from alat");
                    if (isset($_POST['filter_tgl'])) {
                        $mulai = $_POST['tgl_mulai'];
                        $selesai = $_POST['tgl_selesai'];

                        if ($mulai != null || $selesai != null) {
                            $ambilsemuadataalat = mysqli_query($conn, "select * from alat where idalat=idalat and tanggal BETWEEN '$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY)");
                        } else {
                            $ambilsemuadataalat = mysqli_query($conn, "select * from alat where idalat=idalat");
                        }
                    } else {
                        $ambilsemuadataalat = mysqli_query($conn, "select * from alat where idalat=idalat");
                    }
                    while ($data = mysqli_fetch_array($ambilsemuadataalat)) {
                        $tanggal = $data['tanggal'];
                        $namaalat = $data['namaalat'];
                        $deskalat = $data['deskalat'];
                        $status = $data['status'];
                        $ida = $data['idalat'];
                    ?>
                        <tr>
                            <td><?= $tanggal; ?></td>
                            <td><?php echo $namaalat; ?></td>
                            <td><?php echo $deskalat; ?></td>
                            <td><?php echo $status; ?></td>
                        </tr>

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