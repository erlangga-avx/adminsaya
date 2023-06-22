<?php
session_start();
//koneksi ke database
$conn = mysqli_connect("localhost","root","","inventaris");

//menambah barang baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];

    //untuk gambar..
    $allowed_extension = array('png','jpg');
    $nama = $_FILES['file']['name']; //untuk mengambil nama file gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot)); //untuk mengambil ekstensi nama file gambar
    $ukuran = $_FILES['file']['size']; //untuk mengambil size file gambar
    $file_tmp = $_FILES['file']['tmp_name']; //untuk mengambil lokasi file gambar

    //penamaan file -> enkripsi
    $image = md5(uniqid($nama,true).time()).'.'.$ekstensi; //menggabungkan nama file yang dienkripsi dg ekstensinya

    //proses upload gambar
    if(in_array($ekstensi, $allowed_extension) === true){
        //validasi ukuran file
        if($ukuran < 15000000){
            move_uploaded_file($file_tmp, 'images/'.$image);

            $addtotable = mysqli_query($conn,"insert into stok (namabarang, kategori, stok, image) values('$namabarang', '$kategori', '$stok', '$image')");
            if($addtotable){
                header('location:index.php');
            } else {
                echo 'Gagal';
                header('location:index.php');
            }
        } else {
            //kalau ukuran file melebihi 15mb
            echo '
            <script>
                alert("File Terlalu Besar");
                window.location.href="index.php";
            </script>
            ';
        }
    } else {
        //kalau nama filenya tidak didukung
        echo '
            <script>
                alert("Format File Tidak Didukung");
                window.location.href="index.php";
            </script>
            ';
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

//menambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $cekstoksekarang = mysqli_query($conn, "select * from stok where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstoksekarang);
    
    $stoksekarang = $ambildatanya['stok'];

    if($stoksekarang >= $qty){
        //kalau barang cukup
        $kurangkanstoksekarangdenganqty = $stoksekarang-$qty;

        $addtokeluar = mysqli_query($conn, "insert into keluar (idbarang, keterangan, qty) values('$barangnya', '$keterangan', '$qty')");
        $updatestokkeluar = mysqli_query($conn, "update stok set stok='$kurangkanstoksekarangdenganqty' where idbarang='$barangnya'");
        if($addtokeluar&&$updatestokkeluar){
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    } else {
        //kalau barang tidak cukup
        echo '
        <script>
            alert("stok saat ini tidak mencukupi");
            windows.location.href="keluar.php";
        </script>
        ';
    }
}

//menambah supplier
if(isset($_POST['addsupplier'])){
    $namasupplier = $_POST['namasupplier'];
    $kategorisupplier = $_POST['kategorisupplier'];
    $nomorsupplier = $_POST['nomorsupplier'];
    $alamat = $_POST['alamat'];

    $addtotable = mysqli_query($conn,"insert into supplier (namasupplier, kategorisupplier, nomorsupplier, alamat) values('$namasupplier', '$kategorisupplier', '$nomorsupplier', '$alamat')");
    if($addtotable){
        header('location:supplier.php');
    } else {
        echo 'Gagal';
        header('location:supplier.php');
    }
}

//menambah pesanan
if(isset($_POST['addpesanan'])){
    $namabarang = $_POST['namabarang'];
    $kategori = $_POST['kategori'];
    $qty = $_POST['qty'];

    $addtotable = mysqli_query($conn,"insert into pesanan (namabarang, kategori, qty) values('$namabarang', '$kategori', '$qty')");
    if($addtotable){
        header('location:pesanan.php');
    } else {
        echo 'Gagal';
        header('location:pesanan.php');
    }
}

// Fungsi untuk memeriksa stok barang yang kurang dari 5 dan menambahkannya ke tabel pesanan
function checkAndAddToOrder($conn)
{
    $ambilsemuadatabarang = mysqli_query($conn, "SELECT * FROM stok WHERE stok < 5");
    while ($data = mysqli_fetch_array($ambilsemuadatabarang)) {
        $idbarang = $data['idbarang'];
        $namabarang = $data['namabarang'];
        $kategori = $data['kategori'];

        // Memeriksa apakah barang sudah ada dalam tabel pesanan
        $checkPesanan = mysqli_query($conn, "SELECT * FROM pesanan WHERE namabarang = '$namabarang' AND kategori = '$kategori'");
        $rowCount = mysqli_num_rows($checkPesanan);

        // Jika barang belum ada dalam tabel pesanan, tambahkan data ke tabel pesanan
        if ($rowCount == 0) {
            $insertPesanan = mysqli_query($conn, "INSERT INTO pesanan (namabarang, kategori, qty) VALUES ('$namabarang', '$kategori', 100)");
        }
    }
}

// Panggil fungsi untuk memeriksa stok dan menambahkan barang ke tabel pesanan
checkAndAddToOrder($conn);

//menambah laporan alat
if(isset($_POST['addalat'])){
    $namaalat = $_POST['namaalat'];
    $kategori = $_POST['kategori'];
    $deskalat = $_POST['deskalat'];
    $status = $_POST['status'];

    $addtotable = mysqli_query($conn,"insert into alat (namaalat, kategori, deskalat, status) values('$namaalat', '$kategori', '$deskalat', '$status')");
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
    
    //untuk gambar..
    $allowed_extension = array('png','jpg');
    $nama = $_FILES['file']['name']; //untuk mengambil nama file gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot)); //untuk mengambil ekstensi nama file gambar
    $ukuran = $_FILES['file']['size']; //untuk mengambil size file gambar
    $file_tmp = $_FILES['file']['tmp_name']; //untuk mengambil lokasi file gambar

    //penamaan file -> enkripsi
    $image = md5(uniqid($nama,true).time()).'.'.$ekstensi; //menggabungkan nama file yang dienkripsi dg ekstensinya

    if($ukuran==0){
        //jika tidak mengupload
    } else {
        //jika mengupload
        move_uploaded_file($file_tmp, 'images/'.$image);
            $update = mysqli_query($conn, "update stok set namabarang='$namabarang' , kategori='$kategori' , image='$image' where idbarang='$idb'");
        if($update){
            header('location:index.php');
        } else {
            echo 'Gagal';
            header('location:index.php');
        }
    }
}

//menghapus barang dari stok
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    $gambar = mysqli_query($conn, "select * from stok where idbarang='$idb'");
    $get = mysqli_fetch_array($gambar);
    $img = 'images/'.$get['image'];
    unlink($img);

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
    $qty = $_POST['qty'];//qty baru dari user

    //mengambil stok barang saat ini
    $lihatstok = mysqli_query($conn, "select * from stok where idbarang='$idb'");
    $stoknya = mysqli_fetch_array($lihatstok);
    $stokskrg = $stoknya['stok'];
    
    //qty barang keluar saat ini
    $qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
        $selisih = $qty-$qtyskrg;
        $kurangin = $stokskrg - $selisih;

        if($selisih <= $stokskrg){
            //stok cukup, keluarkan stok
            //update tabel keluar, stok
            $kurangistoknya = mysqli_query($conn, "update stok set stok='$kurangin' where idbarang='$idb'");
            $updatenya = mysqli_query($conn, "update keluar set qty='$qty', keterangan='$keterangan' where idkeluar='$idk'");
            if($kurangistoknya&&$updatenya){
                    header('location:keluar.php');
                } else {
                    echo 'Gagal';
                    header('location:keluar.php');
            }
        } else {
            //stok tidak cukup
            //alert gagal
            echo '
                <script>
                    alert("Stok Tidak Mencukupi");
                    window.location.href="keluar.php";
                </script>
            ';
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

// Menghapus barang keluar
if (isset($_POST['hapusbarangkeluar'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['qty'];
    $idk = $_POST['idk'];

    // Mengambil data stok sebelumnya
    $getdatastok = mysqli_query($conn, "SELECT * FROM stok WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastok);
    $stok = $data['stok'];

    // Mengembalikan jumlah stok
    $stok_baru = $stok + $qty;

    // Memperbarui jumlah stok pada tabel stok
    $update = mysqli_query($conn, "UPDATE stok SET stok='$stok_baru' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar='$idk'");

    if ($update && $hapusdata) {
        header('location:keluar.php');
    } else {
        header('location:keluar.php');
    }
}

//update info supplier
if(isset($_POST['updatesupplier'])){
    $ids = $_POST['ids'];
    $namasupplier = $_POST['namasupplier'];
    $kategorisupplier = $_POST['kategorisupplier'];
    $nomorsupplier = $_POST['nomorsupplier'];
    $alamat = $_POST['alamat'];

    $update = mysqli_query($conn, "update supplier set namasupplier='$namasupplier' , kategorisupplier='$kategorisupplier', nomorsupplier='$nomorsupplier' , alamat='$alamat' where idsupplier='$ids'");
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

//update info pesanan
if(isset($_POST['updatepesanan'])){
    $idp = $_POST['idp'];
    $namabarang = $_POST['namabarang'];
    $kategori = $_POST['kategori'];
    $qty = $_POST['qty'];

    $update = mysqli_query($conn, "update pesanan set namabarang='$namabarang' , kategori='$kategori', qty='$qty' where idpesanan='$idp'");
    if($update){
        header('location:pesanan.php');
    } else {
        echo 'Gagal';
        header('location:pesanan.php');
    }
}

//menghapus pesanan
if(isset($_POST['hapuspesanan'])){
    $idp = $_POST['idp'];

    $hapus = mysqli_query($conn, "delete from pesanan where idpesanan='$idp'");
    if($hapus){
        header('location:pesanan.php');
    } else {
        echo 'Gagal';
        header('location:pesanan.php');
    }
}

//update info kerusakan alat
if(isset($_POST['updatealat'])){
    $ida = $_POST['ida'];
    $namaalat = $_POST['namaalat'];
    $deskalat = $_POST['deskalat'];
    $status = $_POST['status'];

    $update = mysqli_query($conn, "update alat set namaalat='$namaalat' , deskalat='$deskalat' , status='$status' where idalat='$ida'");
    if($update){
        header('location:alat.php');
    } else {
        echo 'Gagal';
        header('location:alat.php');
    }
}

//menghapus laporan alat
if(isset($_POST['hapusalat'])){
    $ida = $_POST['ida'];

    $hapus = mysqli_query($conn, "delete from alat where idalat='$ida'");
    if($hapus){
        header('location:alat.php');
    } else {
        echo 'Gagal';
        header('location:alat.php');
    }
}
?>