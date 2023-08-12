<?php
require 'function.php';
require 'cek.php';

//mendapatkan id barang yang dioper dari halaman sebelumnya
$idtransaksi = $_GET['id']; //get id transaksi
//mengambil informasi barang berdasarkan database
$get = mysqli_query($conn, "select * from transaksikeluar where idtransaksi='$idtransaksi'");
$fetch = mysqli_fetch_assoc($get);
//set variabel
$tanggal = $fetch['tanggal'];
$kodetransaksi = $fetch['kodetransaksi'];
$jumlah = $fetch['jumlah'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Detail Transaksi Keluar - GRAND Inventory</title>
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
                    <h1 class="mt-4">Detail Transaksi Keluar</h1>
                    <a href="exportdetailtransaksikeluar.php?id=<?= $idtransaksi; ?>" class="btn btn-success">Export Data</a>
                    <div class="card mb-4 mt-4">
                        <div class="card-header">
                            <h2>Kode Transaksi <?= $kodetransaksi; ?></h2>
                        </div>
                        <div class="card-body">
                            <input type="text" name="tanggal" value="Tanggal Keluar : <?php echo $tanggal; ?>" class="form-control" disabled>

                            <br></br>

                            <h3>Data Barang Keluar</h3>
                            <div class="card mb-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Satuan</th>
                                                <th>Keterangan</th>
                                                <th>Struk</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $query = "select * from keluar k join stok s on s.idbarang = k.idbarang where k.idtransaksi='$idtransaksi'";

                                            $ambildatakeluar = mysqli_query($conn, $query);
                                            $i = 1;

                                            $datagrup = array();

                                            while ($data = mysqli_fetch_array($ambildatakeluar)) {
                                                $idb = $data['idbarang'];
                                                $idk = $data['idkeluar'];
                                                $idt = $data['idtransaksi'];
                                                $tanggal = $data['tanggal'];
                                                $satuan = $data['satuan'];
                                                $harga = $data['harga'];
                                                $namabarang = $data['namabarang'];
                                                $qty = $data['qty'];
                                                $keterangan = $data['keterangan'];
                                                $format_harga = number_format($harga, 0, ',', '.');

                                                $harga_total1 = $harga * $qty;
                                                $format_harga2 = number_format($harga_total1, 0, ',', '.');
                                                $harga_total2;

                                                $groupedData[$keterangan][] = array(
                                                    'idt' => $idt,
                                                    'idk' => $idk,
                                                    'namabarang' => $namabarang,
                                                    'qty' => $qty,
                                                    'satuan' => $satuan,
                                                    'keterangan' => $keterangan,
                                                );
                                            ?>

                                                <tr>
                                                    <td><?= $namabarang; ?></td>
                                                    <td><?= $qty; ?></td>
                                                    <td><?= $satuan; ?></td>
                                                    <td><?= $keterangan; ?></td>
                                                    <td>
                                                        <!--<a href="tandaterimamasuk.php?id=<?= $ids; ?>">
                                                                    <i class="fa-solid fa-pen-nib"></i>
                                                                </a>-->
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#strukmodal<?= $idt . '_' . $keterangan; ?>">
                                                            <i class="fas fa-pen-nib"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-primary" onclick="printModalContent('strukmodal<?= $idt . '_' . $keterangan; ?>')">Print</button>
                                                    </td>
                                                </tr>
                                </div>
                            </div>
                            <!-- Modal Struk -->
                            <div class="modal fade" id="strukmodal<?= $idt . '_' . $keterangan; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="terimaModalLabel">
                                                GRAND Fotocopy Gambut
                                            </h4>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <h5>
                                                <p style="text-align:center">
                                                    <strong>Struk Pengeluaran Barang</strong>
                                                </p>
                                            </h5>
                                            <p>Kode Transaksi : <?= $kodetransaksi; ?>
                                                <input type="hidden" name="kodetransaksi" value="<? $kodetransaksi; ?>">
                                            </p>
                                            <p>Tanggal : <?= $tanggal; ?>
                                                <br>
                                                <?php
                                                $sql = "SELECT * from keluar k join stok s on s.idbarang = k.idbarang WHERE k.idtransaksi='$idtransaksi' ORDER BY k.keterangan";

                                                $subtotal = 0;

                                                // Execute query
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    // Output data of each row
                                                    while ($row = $result->fetch_assoc()) {
                                                        foreach ($groupedData[$keterangan] as $item) {
                                                            if ($keterangan === 'terjual') {
                                                                echo '<p><strong>Nama Barang : </strong>' . $row["namabarang"] . '</p>';
                                                                echo '<p><strong>Jumlah : </strong>' . $row["qty"] . ' ' . $row["satuan"] . '</p>';
                                                                $harga_barang = $conn->query("SELECT harga FROM stok WHERE idbarang = " . $row["idbarang"])->fetch_assoc()["harga"];
                                                                echo '<p><strong>Harga Satuan : </strong> Rp.' . number_format($harga_barang, 0, ',', '.') . '</p>';
                                                                $total_harga = $harga_barang * $row["qty"];
                                                                $subtotal += $total_harga;
                                                                echo '<p><strong>Total Harga : </strong> Rp.' . number_format($total_harga, 0, ',', '.') . '</p>';
                                                            } elseif ($keterangan === 'rusak' || $keterangan === 'hilang') {
                                                                echo '<p>Barang-barang berikut keluar dari toko dalam kondisi ' . $keterangan . ':</p>';
                                                                echo '<p><strong>Nama Barang : </strong>' . $row["namabarang"] . '</p>';
                                                                echo '<p><strong>Jumlah : </strong>' . $row["qty"] . ' ' . $row["satuan"] . '</p>';
                                                            } elseif ($keterangan === 'lain-lain') {
                                                                echo '<p>Barang-barang berikut keluar dari toko dalam kondisi.......................:</p>';
                                                                echo '<p><strong>Nama Barang : </strong>' . $row["namabarang"] . '</p>';
                                                                echo '<p><strong>Jumlah : </strong>' . $row["qty"] . ' ' . $row["satuan"] . '</p>';
                                                            }
                                                            echo "<hr>";
                                                        }
                                                    }
                                                } else {
                                                    echo "0 results";
                                                }
                                                if ($keterangan === 'terjual') {
                                                    echo '<p style="text-align: right"><strong>Subtotal:  Rp.' . number_format($subtotal, 0, ',', '.') . '</strong></p>';
                                                }
                                                ?>
                                                <br>
                                            <p>Atas Perhatiannya Kami Ucapkan Terima Kasih</p>
                                            <br>
                                            <p style="text-align: right;">
                                                Hormat Kami,
                                            </p>
                                            <br>
                                            <br>
                                            <p style="text-align: right;">
                                                GRAND Fotocopy Gambut
                                            </p>
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                        </div>

                                    </div>
                                </div>
                            </div>

                        <?php
                                            };

                        ?>

                        </tbody>
                        </table>
                        <br>
                        <div class="card-footer">
                            <br>
                            <form method="post" class="mt-3">
                            </form>
                        </div>
                        </div>

                        <br></br>

                    </div>
                </div>
        </div>
        </main>
    </div>
    </div>
    <script>
        function printModalContent(modalId) {
            var printContents = document.getElementById(modalId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
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
    <style>
        .table-header {
            display: flex;
            justify-content: space-between;
        }

        .table-row .left {
            flex: 1;
            text-align: left;
        }

        .table-row .center {
            flex: 1;
            text-align: center;
        }

        .table-row .right {
            flex: 1;
            text-align: right;
        }
    </style>

    </style>
</body>
</div>

</html>