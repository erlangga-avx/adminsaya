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
    <title>Transaksi Barang Keluar - GRAND Inventory</title>
    <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <?php include "components/nav.php" ?>
    <div id="layoutSidenav">
        <?php include "components/sidebar.php" ?>
        <div id="layoutSidenav_content">

            <main>
                <!-- kodenya disini -->
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Transaksi Barang Keluar</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Transaksi Keluar</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="insert_transaksi_keluar.php" method="post">
                                <div class="mb-3">
                                    <label for="kodetransaksi" class="form-label">Kode Transaksi</label>
                                    <input type="text" name="kodetransaksi" id="kodetransaksi" class="form-control" value="<?php echo $kodeauto; ?>" disabled>
                                </div>
                                <input type="hidden" id="tanggal" value="<?php echo $tanggal; ?>" required>
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah Produk</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="1" readonly>
                                </div>
                                <hr>
                                <h5>Barang Keluar</h5>
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Quantity</th>
                                            <th>Satuan</th>
                                            <th>keterangan</th>
                                            <th>Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $rowNumber = 0;
                                        $rowNumber++;
                                        ?>
                                        <tr>
                                            <td>
                                                <select name="barangnya[]" class="form-control" required>
                                                    <?php
                                                    $ambilsemuadata = mysqli_query($conn, "select *  from stok");
                                                    while ($fetcharray = mysqli_fetch_array($ambilsemuadata)) {
                                                        $namabarangnya = $fetcharray['namabarang'];
                                                        $idbarangnya = $fetcharray['idbarang'];
                                                    ?>

                                                        <option value="<?= $idbarangnya; ?>"><?= $namabarangnya; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="qty[]" required>
                                            </td>
                                            <td>
                                                <select name="satuan[]" class="form-control" required>
                                                    <option value="pcs">pcs</option>
                                                    <option value="rim">rim</option>
                                                    <option value="ply">ply</option>
                                                    <option value="pack">pack</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="keterangan[]" required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-delete" data-row="<?= $rowNumber ?>" disabled>Hapus Baris</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success" id="btn-add-row">Tambah Baris</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
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
    <script>
        $(document).ready(function() {
            // Hapus baris saat tombol "Hapus Baris" diklik
            $(document).on("click", ".btn-delete", function() {
                $(this).closest("tr").remove();
                // Perbarui nilai "Jumlah Produk" setelah menghapus baris
                updateJumlahProduk();
            });

            // Function untuk memperbarui nilai "Jumlah Produk"
            function updateJumlahProduk() {
                var rowCount = $("#dataTable tbody tr").length;
                $("#jumlah").val(rowCount);
            }

            // Panggil fungsi updateJumlahProduk saat halaman dimuat
            updateJumlahProduk();

            // Counter untuk memberi nomor pada setiap baris baru
            var rowNumber = 1;


            $("#btn-add-row").on("click", function() {
                var newRow = '<tr>' +
                    '<td>' +
                    '<select name="barangnya[]" class="form-control" required>' +
                    '<?php
                        $ambilsemuadata = mysqli_query($conn, "select *  from stok");
                        while ($fetcharray = mysqli_fetch_array($ambilsemuadata)) {
                            $namabarangnya = $fetcharray['namabarang'];
                            $idbarangnya = $fetcharray['idbarang'];
                            echo "<option value=\"$idbarangnya\">$namabarangnya</option>";
                        }
                        ?>' +
                    '</select>' +
                    '</td>' +
                    '<td><input type="number" class="form-control" name="qty[]" required></td>' +
                    '<td>' +
                    '<select name="satuan[]" class="form-control" required>' +
                    '<option value="pcs">pcs</option>' +
                    '<option value="rim">rim</option>' +
                    '<option value="ply">ply</option>' +
                    '<option value="pack">pack</option>' +
                    '</select>' +
                    '</td>' +
                    '<td><input type="text" class="form-control" name="keterangan[]" required></td>' +
                    '<td>' +
                    '<button type="button" class="btn btn-danger btn-delete" data-row="<?= $rowNumber ?>">Hapus Baris</button>' +
                    '</td>' +
                    '</tr>';

                $("#dataTable tbody").append(newRow);

                updateJumlahProduk();
            });
        });
    </script>
</body>

</html>