        <?php
        require 'function.php';
        require 'cek.php';

        //mendapatkan id barang yang dioper dari halaman sebelumnya
        $idtransaksi = $_GET['id']; //get id transaksi
        //mengambil informasi barang berdasarkan database
        $get = mysqli_query($conn, "select * from transaksimasuk where idtransaksi='$idtransaksi'");
        $fetch = mysqli_fetch_assoc($get);
        //set variabel
        $tanggal = $fetch['tanggal'];
        $kodetransaksi = $fetch['kodetransaksi'];
        $pengirim = $fetch['pengirim'];
        $penerima = $fetch['penerima'];
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
            <title>Detail Transaksi Masuk - GRAND Inventory</title>
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
                            <h1 class="mt-4">Detail Transaksi Masuk</h1>
                            <a href="exportdetailtransaksimasuk.php?id=<?= $idtransaksi; ?>" class="btn btn-success">Export Data</a>
                            <div class="card mb-4 mt-4">
                                <div class="card-header">
                                    <h2>Kode Transaksi <?= $kodetransaksi; ?></h2>
                                </div>
                                <div class="card-body">
                                    <input type="text" name="tanggal" value="Tanggal Masuk : <?php echo $tanggal; ?>" class="form-control" disabled>
                                    <br>
                                    <input type="text" name="pengirim" value="Pengirim : <?php echo $pengirim; ?>" class="form-control" disabled>
                                    <br>
                                    <input type="text" name="penerima" value="Penerima : <?php echo $penerima; ?>" class="form-control" disabled>

                                    <br></br>

                                    <h3>Data Barang Masuk</h3>
                                    <div class="card mb-4">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Barang</th>
                                                        <th>Jumlah</th>
                                                        <th>Satuan</th>
                                                        <th>Supplier</th>
                                                        <th>Nomor Nota</th>
                                                        <th>Biaya</th>
                                                        <th>Tanda Terima</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $query = "select * from masuk m join stok s on s.idbarang = m.idbarang join supplier su on su.idsupplier = m.idsupplier where m.idtransaksi='$idtransaksi'";

                                                    $ambildatamasuk = mysqli_query($conn, $query);
                                                    $i = 1;

                                                    while ($data = mysqli_fetch_array($ambildatamasuk)) {
                                                        $idb = $data['idbarang'];
                                                        $idm = $data['idmasuk'];
                                                        $idt = $data['idtransaksi'];
                                                        $tanggal = $data['tanggal'];
                                                        $satuan = $data['satuan'];
                                                        $namabarang = $data['namabarang'];
                                                        $qty = $data['qty'];
                                                        $ids = $data['idsupplier'];
                                                        $namasupplier = $data['namasupplier'];
                                                        $nota = $data['nota'];
                                                        $harga = $data['hargamasuk'];
                                                        $format_harga = number_format($harga, 0, ',', '.');

                                                    ?>

                                                        <tr>
                                                            <td><?= $namabarang; ?></td>
                                                            <td><?= $qty; ?></td>
                                                            <td><?= $satuan; ?></td>
                                                            <td><?= $namasupplier; ?></td>
                                                            <td><?= $nota; ?></td>
                                                            <td><?= $format_harga; ?></td>
                                                            <td>
                                                                <!--<a href="tandaterimamasuk.php?id=<?= $ids; ?>">
                                                                    <i class="fa-solid fa-pen-nib"></i>
                                                                </a>-->
                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#terimamodal<?= $ids; ?>">
                                                                    <i class="fas fa-pen-nib"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-primary" onclick="printModalContent('terimamodal<?= $ids; ?>')">Print</button>
                                                            </td>
                                                        </tr>
                                        </div>
                                    </div>
                                    <!-- Modal Rekap -->
                                    <div class="modal fade" id="terimamodal<?= $ids; ?>">
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
                                                            <strong>Tanda Terima Barang</strong>
                                                        </p>
                                                    </h5>
                                                    <p>Kepada : <?= $namasupplier; ?></p>
                                                    <p>Kode Transaksi : <?= $kodetransaksi; ?>
                                                        <input type="hidden" name="kodetransaksi" value="<? $kodetransaksi; ?>">
                                                    </p>
                                                    <br>
                                                    <?php
                                                        // SQL query
                                                        $sql = "SELECT * from masuk m join stok s on s.idbarang = m.idbarang join supplier su on su.idsupplier = m.idsupplier where m.idsupplier='$ids' AND m.idtransaksi='$idtransaksi'";

                                                        // Execute query
                                                        $result = $conn->query($sql);

                                                        // Check if there are any results
                                                        if ($result->num_rows > 0) {
                                                            // Output data of each row
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo "<p>Pada tanggal " . $row["tanggal"] . ", dalam nota No. " . $row["nota"] . ", kami telah menerima barang sebagai berikut :</p>";
                                                                echo "<p><strong>Nama Barang:</strong> " . $row["namabarang"] . "</p>";
                                                                echo "<p><strong>Jumlah:</strong> " . $row["qty"] . " " . $row["satuan"] . "</p>";
                                                                echo "<hr>";
                                                            }
                                                        } else {
                                                            echo "0 results";
                                                        }
                                                    ?>
                                                    <br>
                                                    <p>Demikian surat tanda terima kami buat, atas perhatiannya kami ucapkan terima kasih.</p>
                                                    <br>
                                                    <p style="text-align: right;">
                                                        Penerima Barang,
                                                    </p>
                                                    <br>
                                                    <br>
                                                    <p style="text-align: right;">
                                                        <?= $penerima; ?>
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
        </body>
        </div>

        </html>