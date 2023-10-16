<?php
session_start();
//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_mahasiswa");

//menambah absensi
if (isset($_POST['addmahasiswa'])) {
    $nim = $_POST['nim'];
    $namamahasiswa = $_POST['namamahasiswa'];
    $programstudi = $_POST['programstudi'];
    $tempatlahir = $_POST['tempatlahir'];
    $tgllahir = $_POST['tgllahir'];
    $alamat = $_POST['alamat'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $angkatan = $_POST['angkatan'];

    $addtotable = mysqli_query($conn, "insert into mahasiswa (nim, namamahasiswa, programstudi, tempatlahir, tgllahir, alamat, jeniskelamin, angkatan) values('$nim', '$namamahasiswa', '$programstudi', '$tempatlahir', '$tgllahir', '$alamat', '$jeniskelamin', '$angkatan')");
    if ($addtotable) {
        header('location:mahasiswa.php');
    } else {
        echo 'Gagal';
        header('location:mahasiswa.php');
    }
}

//update info pegawai
if (isset($_POST['updatemahasiswa'])) {
    $idm = $_POST['idmahasiswa'];
    $nim = $_POST['nim'];
    $namamahasiswa = $_POST['namamahasiswa'];
    $programstudi = $_POST['programstudi'];
    $tempatlahir = $_POST['tempatlahir'];
    $tgllahir = $_POST['tgllahir'];
    $alamat = $_POST['alamat'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $angkatan = $_POST['angkatan'];

    $update = mysqli_query($conn, "update mahasiswa set nim='$nim', namamahasiswa='$namamahasiswa' , programstudi='$programstudi', tempatlahir='$tempatlahir', tgllahir='$tgllahir', alamat='$alamat', jeniskelamin='$jeniskelamin', angkatan='$angkatan' where idmahasiswa='$idm'");
    if ($update) {
        header('location:mahasiswa.php');
    } else {
        echo 'Gagal';
        header('location:mahasiswa.php');
    }
}

//menghapus data
if (isset($_POST['hapusmahasiswa'])) {
    $idm = $_POST['idmahasiswa'];

    $hapus = mysqli_query($conn, "delete from mahasiswa where idmahasiswa='$idm'");
    if ($hapus) {
        header('location:mahasiswa.php');
    } else {
        echo 'Gagal';
        header('location:mahasiswa.php');
    }
}