<?php
session_start();
//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "inventaris");

//menambah barang baru
if (isset($_POST['addnewbarang'])) {
    $namabarang = $_POST['namabarang'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];
    $harga = $_POST['harga'];

    //untuk gambar..
    $allowed_extension = array('png', 'jpg');
    $nama = $_FILES['file']['name']; //untuk mengambil nama file gambar
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot)); //untuk mengambil ekstensi nama file gambar
    $ukuran = $_FILES['file']['size']; //untuk mengambil size file gambar
    $file_tmp = $_FILES['file']['tmp_name']; //untuk mengambil lokasi file gambar

    //penamaan file -> enkripsi
    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; //menggabungkan nama file yang dienkripsi dg ekstensinya

    //proses upload gambar
    if (in_array($ekstensi, $allowed_extension) === true) {
        //validasi ukuran file
        if ($ukuran < 15000000) {
            move_uploaded_file($file_tmp, 'images/' . $image);

            $addtotable = mysqli_query($conn, "insert into stok (namabarang, kategori, stok, image, satuan, harga) values('$namabarang', '$kategori', '$stok', '$image', '$satuan', '$harga')");
            if ($addtotable) {
                header('location:stok.php');
            } else {
                echo 'Gagal';
                header('location:stok.php');
            }
        } else {
            //kalau ukuran file melebihi 15mb
            echo '
            <script>
                alert("File Terlalu Besar");
                window.location.href="stok.php";
            </script>
            ';
        }
    } else {
        //kalau nama filenya tidak didukung
        echo '
            <script>
                alert("Format File Tidak Didukung");
                window.location.href="stok.php";
            </script>
            ';
    }
}

//generator kode transaksi keluar
$sql = mysqli_query($conn, "SELECT max(idtransaksi) as maxID FROM transaksimasuk");
$data = mysqli_fetch_array($sql);

$kode = $data['maxID'];

$kode++;
$ket = "EX";
$tgl = date("ymd");
$kodeauto = $ket . $tgl . sprintf("%03s", $kode);

//menambah barang masuk
if (isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $nota = $_POST['nota'];
    $qty = $_POST['qty'];
    $satuan = $_POST['satuan'];
    $hargamasuk = $_POST['harga'];
    $suppliernya = $_POST['suppliernya'];

    $cekstoksekarang = mysqli_query($conn, "select * from stok where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstoksekarang);

    $ceksupplier = mysqli_query($conn, "select * from supplier where idsupplier='$suppliernya'");
    $ambildatasupplier = mysqli_fetch_array($ceksupplier);

    $stoksekarang = $ambildatanya['stok'];
    $tambahkanstoksekarangdenganqty = $stoksekarang + $qty;

    $addtomasuk = mysqli_query($conn, "insert into masuk (idbarang, nota, idsupplier, qty, satuan, harga) values('$barangnya', '$nota', '$suppliernya', '$qty', '$satuan', '$hargamasuk')");
    $updatestokmasuk = mysqli_query($conn, "update stok set stok='$tambahkanstoksekarangdenganqty' where idbarang='$barangnya'");
    if ($addtomasuk && $updatestokmasuk) {
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}

//menambah barang keluar
if (isset($_POST['addbarangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $cekstoksekarang = mysqli_query($conn, "select * from stok where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstoksekarang);

    $stoksekarang = $ambildatanya['stok'];

    if ($stoksekarang >= $qty) {
        //kalau barang cukup
        $kurangkanstoksekarangdenganqty = $stoksekarang - $qty;

        $addtokeluar = mysqli_query($conn, "insert into keluar (idbarang, keterangan, qty) values('$barangnya', '$keterangan', '$qty')");
        $updatestokkeluar = mysqli_query($conn, "update stok set stok='$kurangkanstoksekarangdenganqty' where idbarang='$barangnya'");
        if ($addtokeluar && $updatestokkeluar) {
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
if (isset($_POST['addsupplier'])) {
    $namasupplier = $_POST['namasupplier'];
    $kategorisupplier = $_POST['kategorisupplier'];
    $nomorsupplier = $_POST['nomorsupplier'];
    $alamat = $_POST['alamat'];

    $addtotable = mysqli_query($conn, "insert into supplier (namasupplier, kategorisupplier, nomorsupplier, alamat) values('$namasupplier', '$kategorisupplier', '$nomorsupplier', '$alamat')");
    if ($addtotable) {
        header('location:supplier.php');
    } else {
        echo 'Gagal';
        header('location:supplier.php');
    }
}

//generator kode transaksi masuk
$sql = mysqli_query($conn, "SELECT max(idtransaksi) as maxID FROM transaksimasuk");
$data = mysqli_fetch_array($sql);

$kode = $data['maxID'];

$kode++;
$ket = "EN";
$tgl = date("ymd");
$kodeauto = $ket . $tgl . sprintf("%03s", $kode);

//menambah transaksi masuk
if (isset($_POST['addtransaksimasuk'])) {
    $pengirim = $_POST['pengirim'];
    $penerima = $_POST['penerima'];
    $jumlah = $_POST['jumlah'];


    $addtotable = mysqli_query($conn, "INSERT INTO transaksimasuk (kodetransaksi, pengirim, penerima, jumlah) VALUES ('$kodeauto', '$pengirim', '$penerima', '$jumlah')");


    if ($addtotable) {
        header('location: transaksimasuk.php');
    } else {
        echo 'Gagal';
        header('location: transaksimasuk.php');
    }
}

//menghapus transaksi masuk
if (isset($_POST['hapustransaksimasuk'])) {
    $idt = $_POST['idt'];

    // Get items from the transaction
    $getItemsQuery = "SELECT idbarang, qty FROM masuk WHERE idtransaksi = $idt";
    $getItemsResult = mysqli_query($conn, $getItemsQuery);
    while ($itemData = mysqli_fetch_assoc($getItemsResult)) {
        $idbarang = $itemData['idbarang'];
        $qty = $itemData['qty'];

        // Get current stock and update
        $getStokQuery = "SELECT stok FROM stok WHERE idbarang = $idbarang";
        $getStokResult = mysqli_query($conn, $getStokQuery);
        $stokData = mysqli_fetch_assoc($getStokResult);
        $stokSebelumnya = $stokData['stok'];

        $stokBaru = $stokSebelumnya - $qty;

        $updateStokQuery = "UPDATE stok SET stok = $stokBaru WHERE idbarang = $idbarang";
        mysqli_query($conn, $updateStokQuery);
    }

    // Delete related data from 'masuk' table
    $deleteMasukQuery = "DELETE FROM masuk WHERE idtransaksi = $idt";
    mysqli_query($conn, $deleteMasukQuery);

    // Delete transaction from 'transaksimasuk' table
    $deleteTransaksiMasukQuery = "DELETE FROM transaksimasuk WHERE idtransaksi = $idt";
    mysqli_query($conn, $deleteTransaksiMasukQuery);

    // Redirect after successful deletion
    header('location:transaksimasuk.php');
}



//generator kode transaksi keluar
$sql = mysqli_query($conn, "SELECT max(idtransaksi) as maxID FROM transaksikeluar");
$data = mysqli_fetch_array($sql);

$kode = $data['maxID'];

$kode++;
$ket = "EX";
$tgl = date("ymd");
$kodeauto = $ket . $tgl . sprintf("%03s", $kode);

//menambah transaksi keluar
if (isset($_POST['addtransaksikeluar'])) {
    $jumlah = $_POST['jumlah'];


    $addtotable = mysqli_query($conn, "INSERT INTO transaksikeluar (kodetransaksi, jumlah) VALUES ('$kodeauto', '$jumlah')");


    if ($addtotable) {
        header('location: transaksikeluar.php');
    } else {
        echo 'Gagal';
        header('location: transaksikeluar.php');
    }
}

//menghapus transaksi keluar
if (isset($_POST['hapustransaksikeluar'])) {
    $idt = $_POST['idt'];

    // Get items from the transaction
    $getItemsQuery = "SELECT idbarang, qty FROM keluar WHERE idtransaksi = $idt";
    $getItemsResult = mysqli_query($conn, $getItemsQuery);
    while ($itemData = mysqli_fetch_assoc($getItemsResult)) {
        $idbarang = $itemData['idbarang'];
        $qty = $itemData['qty'];

        // Get current stock and update
        $getStokQuery = "SELECT stok FROM stok WHERE idbarang = $idbarang";
        $getStokResult = mysqli_query($conn, $getStokQuery);
        $stokData = mysqli_fetch_assoc($getStokResult);
        $stokSebelumnya = $stokData['stok'];

        $stokBaru = $stokSebelumnya + $qty;

        $updateStokQuery = "UPDATE stok SET stok = $stokBaru WHERE idbarang = $idbarang";
        mysqli_query($conn, $updateStokQuery);
    }

    // Delete related data from 'keluar' table
    $deleteKeluarQuery = "DELETE FROM keluar WHERE idtransaksi = $idt";
    mysqli_query($conn, $deleteKeluarQuery);

    // Delete transaction from 'transaksikeluar' table
    $deleteTransaksiKeluarQuery = "DELETE FROM transaksikeluar WHERE idtransaksi = $idt";
    mysqli_query($conn, $deleteTransaksiKeluarQuery);

    // Redirect after successful deletion
    header('location:transaksikeluar.php');
}


//menambah pesanan
if (isset($_POST['addpesanan'])) {
    $namabarang = $_POST['namabarang'];
    $kategori = $_POST['kategori'];
    $qty = $_POST['qty'];

    $addtotable = mysqli_query($conn, "insert into pesanan (namabarang, kategori, qty) values('$namabarang', '$kategori', '$qty')");
    if ($addtotable) {
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
if (isset($_POST['addalat'])) {
    $namaalat = $_POST['namaalat'];
    $kategori = $_POST['kategori'];
    $deskalat = $_POST['deskalat'];
    $status = $_POST['status'];

    $addtotable = mysqli_query($conn, "insert into alat (namaalat, kategori, deskalat, status) values('$namaalat', '$kategori', '$deskalat', '$status')");
    if ($addtotable) {
        header('location:alat.php');
    } else {
        echo 'Gagal';
        header('location:alat.php');
    }
}

//update info barang
if (isset($_POST['updatebarang'])) {
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $satuan = $_POST['satuan'];

    //untuk gambar..
    $allowed_extension = array('png', 'jpg');
    $nama = $_FILES['file']['name']; //untuk mengambil nama file gambar
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot)); //untuk mengambil ekstensi nama file gambar
    $ukuran = $_FILES['file']['size']; //untuk mengambil size file gambar
    $file_tmp = $_FILES['file']['tmp_name']; //untuk mengambil lokasi file gambar

    //penamaan file -> enkripsi
    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; //menggabungkan nama file yang dienkripsi dg ekstensinya

    if ($ukuran == 0) {
        //jika tidak mengupload
    } else {
        //jika mengupload
        move_uploaded_file($file_tmp, 'images/' . $image);
        $update = mysqli_query($conn, "update stok set namabarang='$namabarang' , kategori='$kategori' , image='$image' , satuan='$satuan' , harga='$harga' where idbarang='$idb'");
        if ($update) {
            header('location:stok.php');
        } else {
            echo 'Gagal';
            header('location:stok.php');
        }
    }
}

//menghapus barang dari stok
if (isset($_POST['hapusbarang'])) {
    $idb = $_POST['idb'];

    $gambar = mysqli_query($conn, "select * from stok where idbarang='$idb'");
    $get = mysqli_fetch_array($gambar);
    $img = 'images/' . $get['image'];
    unlink($img);

    $hapus = mysqli_query($conn, "delete from stok where idbarang='$idb'");
    if ($hapus) {
        header('location:stok.php');
    } else {
        echo 'Gagal';
        header('location:stok.php');
    }
}

//mengubah data barang masuk
if (isset($_POST['updatebarangmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $nota = $_POST['nota'];
    $qty = $_POST['qty'];
    $suppliernya = $_POST['suppliernya'];

    $lihatstok = mysqli_query($conn, "select * from stok where idbarang='$idb'");
    $stoknya = mysqli_fetch_array($lihatstok);
    $stokskrg = $stoknya['stok'];

    $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    $ceksupplier = mysqli_query($conn, "select * from supplier where idsupplier='$suppliernya'");
    $ambildatasupplier = mysqli_fetch_array($ceksupplier);

    if ($qty > $qtyskrg) {
        $selisih = $qty - $qtyskrg;
        $kurangin = $stokskrg + $selisih;
        $kurangistoknya = mysqli_query($conn, "update stok set stok='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', nota='$nota', idsupplier='$suppliernya' where idmasuk='$idm'");
        if ($kurangistoknya && $updatenya) {
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $tambahin = $stokskrg - $selisih;
        $tambahistoknya = mysqli_query($conn, "update stok set stok='$tambahin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', nota='$nota', idsupplier='$suppliernya' where idmasuk='$idm'");
        if ($tambahistoknya && $updatenya) {
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    }
}

//menghapus barang masuk
if (isset($_POST['hapusbarangmasuk'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['qty'];
    $idm = $_POST['idm'];
    $suppliernya = $_POST['suppliernya'];

    $getdatastok = mysqli_query($conn, "select * from stok where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastok);
    $stok = $data['stok'];

    $ceksupplier = mysqli_query($conn, "select * from supplier where idsupplier='$suppliernya'");
    $ambildatasupplier = mysqli_fetch_array($ceksupplier);

    $selisih = $stok - $qty;

    $update = mysqli_query($conn, "update stok set stok='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

    if ($update && $hapusdata) {
        header('location:masuk.php');
    } else {
        header('location:masuk.php');
    }
}

//mengubah data barang keluar
if (isset($_POST['updatebarangkeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty']; //qty baru dari user

    //mengambil stok barang saat ini
    $lihatstok = mysqli_query($conn, "select * from stok where idbarang='$idb'");
    $stoknya = mysqli_fetch_array($lihatstok);
    $stokskrg = $stoknya['stok'];

    //qty barang keluar saat ini
    $qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if ($qty > $qtyskrg) {
        $selisih = $qty - $qtyskrg;
        $kurangin = $stokskrg - $selisih;

        if ($selisih <= $stokskrg) {
            //stok cukup, keluarkan stok
            //update tabel keluar, stok
            $kurangistoknya = mysqli_query($conn, "update stok set stok='$kurangin' where idbarang='$idb'");
            $updatenya = mysqli_query($conn, "update keluar set qty='$qty', keterangan='$keterangan' where idkeluar='$idk'");
            if ($kurangistoknya && $updatenya) {
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
        $selisih = $qtyskrg - $qty;
        $tambahin = $stokskrg + $selisih;
        $tambahistoknya = mysqli_query($conn, "update stok set stok='$tambahin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', keterangan='$keterangan' where idkeluar='$idk'");
        if ($tambahistoknya && $updatenya) {
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
if (isset($_POST['updatesupplier'])) {
    $ids = $_POST['ids'];
    $namasupplier = $_POST['namasupplier'];
    $kategorisupplier = $_POST['kategorisupplier'];
    $nomorsupplier = $_POST['nomorsupplier'];
    $alamat = $_POST['alamat'];

    $update = mysqli_query($conn, "update supplier set namasupplier='$namasupplier' , kategorisupplier='$kategorisupplier', nomorsupplier='$nomorsupplier' , alamat='$alamat' where idsupplier='$ids'");
    if ($update) {
        header('location:supplier.php');
    } else {
        echo 'Gagal';
        header('location:supplier.php');
    }
}

//menghapus supplier
if (isset($_POST['hapussupplier'])) {
    $ids = $_POST['ids'];

    $hapus = mysqli_query($conn, "delete from supplier where idsupplier='$ids'");
    if ($hapus) {
        header('location:supplier.php');
    } else {
        echo 'Gagal';
        header('location:supplier.php');
    }
}

//update info pesanan
if (isset($_POST['updatepesanan'])) {
    $idp = $_POST['idp'];
    $namabarang = $_POST['namabarang'];
    $kategori = $_POST['kategori'];
    $qty = $_POST['qty'];

    $update = mysqli_query($conn, "update pesanan set namabarang='$namabarang' , kategori='$kategori', qty='$qty' where idpesanan='$idp'");
    if ($update) {
        header('location:pesanan.php');
    } else {
        echo 'Gagal';
        header('location:pesanan.php');
    }
}

//menghapus pesanan
if (isset($_POST['hapuspesanan'])) {
    $idp = $_POST['idp'];

    $hapus = mysqli_query($conn, "delete from pesanan where idpesanan='$idp'");
    if ($hapus) {
        header('location:pesanan.php');
    } else {
        echo 'Gagal';
        header('location:pesanan.php');
    }
}

//update info kerusakan alat
if (isset($_POST['updatealat'])) {
    $ida = $_POST['ida'];
    $namaalat = $_POST['namaalat'];
    $deskalat = $_POST['deskalat'];
    $status = $_POST['status'];

    $update = mysqli_query($conn, "update alat set namaalat='$namaalat' , deskalat='$deskalat' , status='$status' where idalat='$ida'");
    if ($update) {
        header('location:alat.php');
    } else {
        echo 'Gagal';
        header('location:alat.php');
    }
}

//menghapus laporan alat
if (isset($_POST['hapusalat'])) {
    $ida = $_POST['ida'];

    $hapus = mysqli_query($conn, "delete from alat where idalat='$ida'");
    if ($hapus) {
        header('location:alat.php');
    } else {
        echo 'Gagal';
        header('location:alat.php');
    }
}

//menambah data aset
if (isset($_POST['addnewaset'])) {
    $namaaset = $_POST['namaaset'];
    $jumlah = $_POST['jumlah'];
    $jenis = $_POST['jenis'];
    $kondisi = $_POST['kondisi'];
    $tglinput = $_POST['tglinput'];
    $tglupdate = $_POST['tglupdate'];

    $addtotable = mysqli_query($conn, "insert into aset (namaaset, jumlah, jenis, kondisi, tglinput) values('$namaaset', '$jumlah', '$jenis', '$kondisi', '$tglinput')");
    if ($addtotable) {
        header('location:aset.php');
    } else {
        echo 'Gagal';
        header('location:aset.php');
    }
}

//update data aset
if (isset($_POST['updateaset'])) {
    $idaset = $_POST['idaset'];
    $namaaset = $_POST['namaaset'];
    $jumlah = $_POST['jumlah'];
    $jenis = $_POST['jenis'];
    $kondisi = $_POST['kondisi'];
    $tglinput = $_POST['tglinput'];
    $tglupdate = $_POST['tglupdate'];

    $update = mysqli_query($conn, "update aset set namaaset='$namaaset' , jumlah='$jumlah' , jenis='$jenis' , kondisi='$kondisi' , tglinput='$tglinput' where idaset='$idaset'");
    if ($update) {
        header('location:aset.php');
    } else {
        echo 'Gagal';
        header('location:aset.php');
    }
}

//menghapus data aset
if (isset($_POST['hapusaset'])) {
    $idaset = $_POST['idaset'];

    $hapus = mysqli_query($conn, "delete from aset where idaset='$idaset'");
    if ($hapus) {
        header('location:aset.php');
    } else {
        echo 'Gagal';
        header('location:aset.php');
    }
}