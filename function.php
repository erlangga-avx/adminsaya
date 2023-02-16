<?php
session_start();
//koneksi ke database
$conn = mysqli_connect("localhost","root","","inventaris");

//menambah barang baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];

    $addtotable = mysqli_query($conn,"insert into stok (namabarang, deskripsi, stok) values('$namabarang', '$deskripsi', '$stok')");
    if($addtotable){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

//menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstoksekarang = mysqli_query($conn, "select * from stok where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstoksekarang);
    
    $stoksekarang = $ambildatanya['stok'];
    $tambahkanstoksekarangdenganqty = $stoksekarang+$qty;

    $addtomasuk = mysqli_query($conn, "insert into masuk (idbarang, penerima, qty) values('$barangnya', '$penerima', '$qty')");
    $updatestokmasuk = mysqli_query($conn, "update stok set stok='$tambahkanstoksekarangdenganqty' where idbarang='$barangnya'");
    if($addtomasuk&&$updatestokmasuk){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}

//menambahbarangkeluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $cekstoksekarang = mysqli_query($conn, "select * from stok where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstoksekarang);
    
    $stoksekarang = $ambildatanya['stok'];
    $kurangkanstoksekarangdenganqty = $stoksekarang-$qty;

    $addtokeluar = mysqli_query($conn, "insert into keluar (idbarang, keterangan, qty) values('$barangnya', '$keterangan', '$qty')");
    $updatestokkeluar = mysqli_query($conn, "update stok set stok='$kurangkanstoksekarangdenganqty' where idbarang='$barangnya'");
    if($addtokeluar&&$updatestokkeluar){
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}
?>