<?php
require 'function.php';
require 'cek.php';

// Fungsi untuk menghitung laba rugi
function hitungLabaRugi($tanggal_mulai, $tanggal_selesai)
{
    $mysqli = new mysqli("localhost", "root", "", "inventaris");

    if ($mysqli->connect_error) {
        die("Koneksi database gagal: " . $mysqli->connect_error);
    }

    // Query untuk menghitung total pemasukan
    $query_pemasukan = "SELECT SUM(harga) AS total_pemasukan FROM pemasukan WHERE tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
    $result_pemasukan = $mysqli->query($query_pemasukan);
    $row_pemasukan = $result_pemasukan->fetch_assoc();
    $total_pemasukan = $row_pemasukan["total_pemasukan"];

    // Query untuk menghitung total pengeluaran
    $query_pengeluaran = "SELECT SUM(harga) AS total_pengeluaran FROM pengeluaran WHERE tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
    $result_pengeluaran = $mysqli->query($query_pengeluaran);
    $row_pengeluaran = $result_pengeluaran->fetch_assoc();
    $total_pengeluaran = $row_pengeluaran["total_pengeluaran"];

    $labarugi = $total_pemasukan - $total_pengeluaran;

    $mysqli->close();

    return array($total_pemasukan, $total_pengeluaran, $labarugi);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['filter_tgl'])) {
        $tanggal_mulai = $_POST["tgl_mulai"];
        $tanggal_selesai = $_POST["tgl_selesai"];
    } else {
        $tanggal_mulai = null;
        $tanggal_selesai = null;
    }
    list($total_pemasukan, $total_pengeluaran, $labarugi) = hitungLabaRugi($tanggal_mulai, $tanggal_selesai);
}

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
        <h4>Laporan Laba Rugi</h4>
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
            <h3 class="mt-4">Periode <?php echo $tanggal_mulai . " sampai " . $tanggal_selesai; ?></h3>

            <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
            <table class="table table-striped" id="mauexport" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Deskripsi</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (isset($_POST['filter_tgl'])) {
                            echo "<tr><th>Total Pemasukan</th><td>Rp " . number_format($total_pemasukan) . "</td></tr>";
                            echo "<tr><th>Total Pengeluaran</th><td>Rp " . number_format($total_pengeluaran) . "</td></tr>";
                            echo "<tr><th>Laba Rugi</th><td>Rp " . number_format($labarugi) . "</td></tr>";
                        }
                    }
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