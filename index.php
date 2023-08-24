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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script>
        $(document).ready(function() {
            // data untuk pie chart
            <?php
            $query = "SELECT kategori, COUNT(idbarang) as total FROM stok GROUP BY kategori";
            $result = mysqli_query($conn, $query);

            $categories = [];
            $categoryCounts = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $categories[] = $row['kategori'];
                $categoryCounts[] = $row['total'];
            }
            ?>

            var pieData = {
                labels: <?php echo json_encode($categories); ?>,
                datasets: [{
                    data: <?php echo json_encode($categoryCounts); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(95, 188, 139, 0.5)',
                        'rgba(152, 193, 80, 0.5)',
                    ],
                }],
            };

            // buat pie chart
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
            var pieChart = new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
            });

            // data untuk bar chart
            <?php
            $query = "SELECT namabarang, stok FROM stok ORDER BY stok DESC LIMIT 5";
            $result = mysqli_query($conn, $query);

            $itemNames = [];
            $itemStocks = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $itemNames[] = $row['namabarang'];
                $itemStocks[] = $row['stok'];
            }
            ?>

            var barData = {
                labels: <?php echo json_encode($itemNames); ?>,
                datasets: [{
                    label: 'Stok Barang',
                    data: <?php echo json_encode($itemStocks); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                }],
            };

            // buat bar chart
            var barChartCanvas = $('#barChart').get(0).getContext('2d');
            var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
            <?php
            $query = "SELECT idbarang, SUM(qty) as total_qty FROM keluar GROUP BY idbarang ORDER BY total_qty DESC LIMIT 5";
            $result = mysqli_query($conn, $query);

            $topItemIds = [];
            $topItemQuantities = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $topItemIds[] = $row['idbarang'];
                $topItemQuantities[] = $row['total_qty'];
            }

            $topItemNames = [];
            $query = "SELECT idbarang, namabarang FROM stok WHERE idbarang IN (" . implode(',', $topItemIds) . ")";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $topItemNames[$row['idbarang']] = $row['namabarang'];
            }
            ?>

            var topBarData = {
                labels: <?php echo json_encode(array_values($topItemNames)); ?>,
                datasets: [{
                    label: 'jumlah terjual',
                    data: <?php echo json_encode($topItemQuantities); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                }],
            };

            // bar chart barang terlaris
            var topBarChartCanvas = $('#topBarChart').get(0).getContext('2d');
            var topBarChart = new Chart(topBarChartCanvas, {
                type: 'bar',
                data: topBarData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        });
    </script>
</head>

<body class="sb-nav-fixed">
    <?php include "components/nav.php" ?>
    <div id="layoutSidenav">
        <?php include "components/sidebar.php" ?>
        <div id="layoutSidenav_content">
            <main>
                <?php

                //mengambil jumlah stok
                $query = "SELECT SUM(stok) as total_stock FROM stok";
                $result = mysqli_query($conn, $query);
                $totalstok = 0;
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $totalstok = $row['total_stock'];
                }

                //mengambil jumlah transaksi keluar
                $query = "SELECT COUNT(idtransaksi) as total_transaksi_keluar FROM transaksikeluar";
                $result = mysqli_query($conn, $query);
                $totaltranskeluar = 0;
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $totaltranskeluar = $row['total_transaksi_keluar'];
                }

                //mengambil jumlah transaksi masuk
                $query = "SELECT COUNT(idtransaksi) as total_transaksi_masuk FROM transaksimasuk";
                $result = mysqli_query($conn, $query);
                $totaltransmasuk = 0;
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $totaltransmasuk = $row['total_transaksi_masuk'];
                }

                //mengambil jumlah alat rusak
                $query = "SELECT COUNT(idalat) as total_alat_rusak FROM alat WHERE status = 'Rusak'";
                $result = mysqli_query($conn, $query);
                $totalrusak = 0;
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $totalrusak = $row['total_alat_rusak'];
                }


                ?>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">INVENTARIS GRAND FOTOCOPY & FOTO STUDIO GAMBUT</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">TOTAL STOK :<h2 class="mt-1"><strong><?= $totalstok; ?></strong></h2>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="stok.php">Lihat</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">TOTAL TRANSAKSI KELUAR :<h2 class="mt-1"><strong><?= $totaltranskeluar; ?></strong></h2>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="transaksikeluar.php">Lihat</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">TOTAL TRANSAKSI MASUK :<h2 class="mt-1"><strong><?= $totaltransmasuk; ?></strong></h2>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="transaksimasuk.php">Lihat</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">ALAT RUSAK :<h2 class="mt-1"><strong><?= $totalrusak; ?></strong></h2>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="alat.php">Lihat</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-md-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Kategori
                                    </div>
                                    <div class="card-body">
                                        <canvas id="pieChart" width="100%" height="40"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Stok Barang
                                    </div>
                                    <div class="card-body">
                                        <canvas id="barChart" width="100%" height="40"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Barang Terlaris
                                    </div>
                                    <div class="card-body">
                                        <canvas id="topBarChart" width="100%" height="40"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Muhammad Erlangga 19630325</div>
                    </div>
                </div>
            </footer>
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