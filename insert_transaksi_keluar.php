<?php
require 'function.php';
require 'cek.php';

// generator kode transaksi keluar
$sql = mysqli_query($conn, "SELECT max(idtransaksi) as maxID FROM transaksimasuk");
$data = mysqli_fetch_array($sql);
$kode = $data['maxID'];
$kode++;
$ket = "EX";
$tgl = date("ymd");
$kodeauto = $ket . $tgl . sprintf("%03s", $kode);

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert data into the 'transaksikeluar' table
    $jumlah = $_POST["jumlah"];
    $barangnya = $_POST["barangnya"];
    $qty = $_POST["qty"];
    $keterangan = $_POST["keterangan"];
    $satuan = $_POST["satuan"];

    // Start the transaction
    mysqli_autocommit($conn, false);
    $semuaBarangCukup = true;

    // Insert data into 'transaksimasuk' table
    $insert_transaksi = mysqli_query($conn, "INSERT INTO transaksikeluar (kodetransaksi, jumlah) VALUES ('$kodeauto', '$jumlah')");

    if ($insert_transaksi) {
        // Get the last inserted ID to use it as 'idtransaksi' in the 'keluar' table
        $idtransaksi = mysqli_insert_id($conn);

        // Loop through the items and insert data into 'keluar' table
        foreach ($barangnya as $index => $idbarang) {
            $keterangan_value = mysqli_real_escape_string($conn, $keterangan[$index]);
            $qty_value = mysqli_real_escape_string($conn, $qty[$index]);
            $satuan_value = mysqli_real_escape_string($conn, $satuan[$index]);

            $cekstoksekarang = mysqli_query($conn, "select * from stok where idbarang='$idbarang'");
            $ambildatanya = mysqli_fetch_array($cekstoksekarang);
            $stoksekarang = $ambildatanya['stok'];

            if ($stoksekarang >= $qty_value) {
                // kalau barang cukup
                $kurangkanstoksekarangdenganqty = $stoksekarang - $qty_value;

                $addtokeluar = mysqli_query($conn, "INSERT INTO keluar (idbarang, idtransaksi, keterangan, qty, satuan) VALUES ('$idbarang', '$idtransaksi', '$keterangan_value', '$qty_value', '$satuan_value')");

                $updatestokkeluar = mysqli_query($conn, "UPDATE stok SET stok='$kurangkanstoksekarangdenganqty' WHERE idbarang='$idbarang'");

                if (!$addtokeluar || !$updatestokkeluar) {
                    $semuaBarangCukup = false;
                    break;
                }
            } else {
                // kalau barang tidak cukup
                $semuaBarangCukup = false;
                break;
            }
        }

        // Commit or rollback the transaction based on $semuaBarangCukup
        if ($semuaBarangCukup) {
            mysqli_commit($conn);
            header("Location: transaksikeluar.php");
        } else {
            mysqli_rollback($conn);
            echo '
                <script>
                    alert("Stok saat ini tidak mencukupi");
                    window.location.href="tr_keluar.php";
                </script>
                ';
        }
    } else {
        echo 'Gagal';
    }

    // Set autocommit back to true for subsequent queries
    mysqli_autocommit($conn, true);
}
