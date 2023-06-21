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
    <title>Kategori - GRAND Inventory</title>
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
                    <h1 class="mt-4">Kategori</h1>
                    <div class="card mb-4">
                        <a href="exportkategori.php" class="btn btn-success" width="20%">Export Data</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Tabel Kategori -->
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Jumlah Produk</th>
                                        <th>Jumlah Stok</th>
                                        <th>Pilihan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Query untuk mengambil data produk berdasarkan kategori
                                    $query = "SELECT kategori, SUM(stok) as total_stok, COUNT(*) as jumlah_produk FROM stok GROUP BY kategori";
                                    $result = mysqli_query($conn, $query);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $kategori = $row['kategori'];
                                        $modalId = str_replace([' ', '/', '\\'], '_', $kategori); // Mengubah Nilai kategori agar ID modal valid
                                    ?>
                                        <tr>
                                            <td><?= $kategori; ?></td>
                                            <td><?= $row['jumlah_produk']; ?></td>
                                            <td><?= $row['total_stok']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kategoriModal<?= $modalId; ?>">
                                                    Rincian
                                                </button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Modal untuk merincikan produk dalam satu kategori -->
                        <?php
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $kategori = $row['kategori'];
                            $modalId = str_replace([' ', '/', '\\'], '_', $kategori); // Mengubah id kategori agar id modal bisa valid
                        ?>
                            <div class="modal fade" id="kategoriModal<?= $modalId; ?>" tabindex="-1" aria-labelledby="kategoriModalLabel<?= $modalId; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="kategoriModalLabel<?= $modalId; ?>">Rincian Produk - <?= $kategori; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="list-group">
                                                <?php
                                                // Query untuk mengambil daftar produk dalam kategori
                                                $query_produk = "SELECT namabarang FROM stok WHERE kategori = '$kategori'";
                                                $result_produk = mysqli_query($conn, $query_produk);

                                                while ($row_produk = mysqli_fetch_assoc($result_produk)) {
                                                ?>
                                                    <li class="list-group-item"><?= $row_produk['namabarang']; ?></li>
                                                <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
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
