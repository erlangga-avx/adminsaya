<?php
require 'function.php';
require 'cek.php';

//generator kode transaksi masuk
$sql = mysqli_query($conn, "SELECT max(idtransaksi) as maxID FROM transaksimasuk");
$data = mysqli_fetch_array($sql);

$kode = $data['maxID'];

$kode++;
$ket = "EN";
$tgl = date("ymd");
$kodeauto = $ket . $tgl . sprintf("%03s", $kode);

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert data into the 'transaksimasuk' table\
    $kodetransaksi = $_POST["kodetransaksi"];
    $pengirim = $_POST["pengirim"];
    $penerima = $_POST["penerima"];
    $jumlah = $_POST["jumlah"];
    $barangnya = $_POST["barangnya"];
    $qty = $_POST["qty"];
    $nota = $_POST["nota"];
    $suppliernya = $_POST["suppliernya"];
    $satuan = $_POST["satuan"];

    // Insert data into 'transaksimasuk' table
    $insert_transaksi = mysqli_query($conn, "INSERT INTO transaksimasuk (kodetransaksi, pengirim, penerima, jumlah) VALUES ('$kodeauto', '$pengirim', '$penerima', '$jumlah')");

    if ($insert_transaksi) {
        // Get the last inserted ID to use it as 'idtransaksi' in the 'masuk' table
        $idtransaksi = mysqli_insert_id($conn);

        // Loop through the items and insert data into 'masuk' table
        foreach ($barangnya as $index => $idbarang) {
            $nota_value = mysqli_real_escape_string($conn, $nota[$index]);
            $qty_value = mysqli_real_escape_string($conn, $qty[$index]);
            $satuan_value = mysqli_real_escape_string($conn, $satuan[$index]);
            $supplier_value = mysqli_real_escape_string($conn, $suppliernya[$index]);

            $cekstoksekarang = mysqli_query($conn, "SELECT * FROM stok WHERE idbarang='$idbarang'");
            $ambildatanya = mysqli_fetch_array($cekstoksekarang);

            $ceksupplier = mysqli_query($conn, "SELECT * FROM supplier WHERE idsupplier='$supplier_value'");
            $ambildatasupplier = mysqli_fetch_array($ceksupplier);

            $stoksekarang = $ambildatanya['stok'];
            $tambahkanstoksekarangdenganqty = $stoksekarang + $qty_value;

            // Insert data into 'masuk' table
            $addtomasuk = mysqli_query($conn, "INSERT INTO masuk (idbarang, idtransaksi, nota, idsupplier, qty, satuan) VALUES ('$idbarang', '$idtransaksi', '$nota_value', '$supplier_value', '$qty_value', '$satuan_value')");

            // Update stock in 'stok' table
            $updatestokmasuk = mysqli_query($conn, "UPDATE stok SET stok='$tambahkanstoksekarangdenganqty' WHERE idbarang='$idbarang'");

            if (!$addtomasuk || !$updatestokmasuk) {
                echo 'Gagal';
                exit();
            }
        }

        // Redirect back to the main page after the data is inserted
        header("Location: transaksimasuk.php");
        exit();
    } else {
        echo 'Gagal';
        exit();
    }
}
