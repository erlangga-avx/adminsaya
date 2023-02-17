<?php
session_start();
//koneksi ke database
$conn = mysqli_connect("localhost","root","","inventaris");

//menambah barang baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];

    $addtotable = mysqli_query($conn,"insert into stok (namabarang, kategori, stok) values('$namabarang', '$kategori    ', '$stok')");
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

//menambah supplier
if(isset($_POST['addsupplier'])){
    $namasupplier = $_POST['namasupplier'];
    $nomorsupplier = $_POST['nomorsupplier'];
    $alamat = $_POST['alamat'];

    $addtotable = mysqli_query($conn,"insert into supplier (namasupplier, nomorsupplier, alamat) values('$namasupplier', '$nomorsupplier', '$alamat')");
    if($addtotable){
        header('location:supplier.php');
    } else {
        echo 'Gagal';
        header('location:supplier.php');
    }
}

//menambah laporan alat
if(isset($_POST['addalat'])){
    $namaalat = $_POST['namaalat'];
    $deskalat = $_POST['deskalat'];
    $status = $_POST['status'];

    $addtotable = mysqli_query($conn,"insert into alat (namaalat, deskalat, status) values('$namaalat', '$deskalat', '$status')");
    if($addtotable){
        header('location:alat.php');
    } else {
        echo 'Gagal';
        header('location:alat.php');
    }
}

//update info barang
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $kategori = $_POST['kategori'];

    $update = mysqli_query($conn, "update stok set namabarang='$namabarang' , kategori='$kategori' where idbarang='$idb'");
    if($update){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

//menghapus barang dari stok
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from stok where idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}
?>