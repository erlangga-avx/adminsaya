<?php
require 'function.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Grafik Barang Terlaris</title>
    <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
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
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Grafik Barang Terlaris</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Barang Terlaris</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="topBarChart" width="100%" height="40"></canvas>
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