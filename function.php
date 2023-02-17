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

//mengubah data barang masuk
if(isset($_POST['updatebarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstok = mysqli_query($conn, "select * from stok where idbarang='$idb'");
    $stoknya = mysqli_fetch_array($lihatstok);
    $stokskrg = $stoknya['stok'];
    
    $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
        $selisih = $qty-$qtyskrg;
        $kurangin = $stokskrg + $selisih;
        $kurangistoknya = mysqli_query($conn, "update stok set stok='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', penerima='$penerima' where idmasuk='$idm'");
            if($kurangistoknya&&$updatenya){
                    header('location:masuk.php');
                } else {
                    echo 'Gagal';
                    header('location:masuk.php');
            }
    } else {
        $selisih = $qtyskrg-$qty;
        $tambahin = $stokskrg - $selisih;
        $tambahistoknya = mysqli_query($conn, "update stok set stok='$tambahin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', penerima='$penerima' where idmasuk='$idm'");
            if($tambahistoknya&&$updatenya){
                    header('location:masuk.php');
                } else {
                    echo 'Gagal';
                    header('location:masuk.php');
            }
    }
}

//menghapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['qty'];
    $idm = $_POST['idm'];

    $getdatastok = mysqli_query($conn, "select * from stok where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastok);
    $stok = $data['stok'];

    $selisih = $stok-$qty;

    $update = mysqli_query($conn, "update stok set stok='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

    if($update&&$hapusdata){
        header('location:masuk.php');
    } else {
        header('location:masuk.php');
    }
}

//mengubah data barang keluar
if(isset($_POST['updatebarangkeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstok = mysqli_query($conn, "select * from stok where idbarang='$idb'");
    $stoknya = mysqli_fetch_array($lihatstok);
    $stokskrg = $stoknya['stok'];
    
    $qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
        $selisih = $qty-$qtyskrg;
        $kurangin = $stokskrg - $selisih;
        $kurangistoknya = mysqli_query($conn, "update stok set stok='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', keterangan='$keterangan' where idkeluar='$idk'");
            if($kurangistoknya&&$updatenya){
                    header('location:keluar.php');
                } else {
                    echo 'Gagal';
                    header('location:keluar.php');
            }
    } else {
        $selisih = $qtyskrg-$qty;
        $tambahin = $stokskrg + $selisih;
        $tambahistoknya = mysqli_query($conn, "update stok set stok='$tambahin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', keterangan='$keterangan' where idkeluar='$idk'");
            if($tambahistoknya&&$updatenya){
                    header('location:keluar.php');
                } else {
                    echo 'Gagal';
                    header('location:keluar.php');
            }
    }
}

//menghapus barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['qty'];
    $idk = $_POST['idk'];

    $getdatastok = mysqli_query($conn, "select * from stok where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastok);
    $stok = $data['stok'];

    $selisih = $stok-$qty;

    $update = mysqli_query($conn, "update stok set stok='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");

    if($update&&$hapusdata){
        header('location:keluar.php');
    } else {
        header('location:keluar.php');
    }
}

//update info supplier
if(isset($_POST['updatesupplier'])){
    $ids = $_POST['ids'];
    $namasupplier = $_POST['namasupplier'];
    $nomorsupplier = $_POST['nomorsupplier'];
    $alamat = $_POST['alamat'];

    $update = mysqli_query($conn, "update supplier set namasupplier='$namasupplier' , nomorsupplier='$nomorsupplier' , alamat='$alamat' where idsupplier='$ids'");
    if($update){
        header('location:supplier.php');
    } else {
        echo 'Gagal';
        header('location:supplier.php');
    }
}

//menghapus supplier
if(isset($_POST['hapussupplier'])){
    $ids = $_POST['ids'];

    $hapus = mysqli_query($conn, "delete from supplier where idsupplier='$ids'");
    if($hapus){
        header('location:supplier.php');
    } else {
        echo 'Gagal';
        header('location:supplier.php');
    }
}
?>