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


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Laporan Laba Rugi - GRAND Inventory</title>
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
                    <h1 class="mt-4">Laporan Laba Rugi</h1>
                    <div class="card mb-4">
                        <div class="card mb-4">
                            <a href="exportlabarugi.php" class="btn btn-success" style="height: 40px; width: 120px;">Export Data</a>
                        </div>
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
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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

</html>