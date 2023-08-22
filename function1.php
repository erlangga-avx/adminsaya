<?php
session_start();
//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_presensi");

//menambah absensi
if (isset($_POST['addabsen'])) {
    $nip = $_POST['nip'];
    $namapegawai = $_POST['namapegawai'];
    $jammasuk = $_POST['jammasuk'];
    $jampulang = $_POST['jampulang'];
    $keterangan = $_POST['keterangan'];

    $addtotable = mysqli_query($conn, "insert into absen (nip, namapegawai, jammasuk, jampulang, keterangan) values('$nip', '$namapegawai', '$jammasuk', '$jampulang', '$keterangan')");
    if ($addtotable) {
        header('location:absen.php');
    } else {
        echo 'Gagal';
        header('location:absen.php');
    }
}

//update info pegawai
if (isset($_POST['updateabsen'])) {
    $idp = $_POST['id'];
    $nip = $_POST['nip'];
    $namapegawai = $_POST['namapegawai'];
    $jammasuk = $_POST['jammasuk'];
    $jampulang = $_POST['jampulang'];
    $keterangan = $_POST['keterangan'];

    $update = mysqli_query($conn, "update absen set nip='$nip', namapegawai='$namapegawai' , jammasuk='$jammasuk', jampulang='$jampulang', keterangan='$keterangan' where id='$idp'");
    if ($update) {
        header('location:absen.php');
    } else {
        echo 'Gagal';
        header('location:absen.php');
    }
}

//menghapus data
if (isset($_POST['hapusabsen'])) {
    $idp = $_POST['id'];

    $hapus = mysqli_query($conn, "delete from absen where id='$idp'");
    if ($hapus) {
        header('location:absen.php');
    } else {
        echo 'Gagal';
        header('location:absen.php');
    }
}