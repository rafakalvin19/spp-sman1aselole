<?php
include "koneksi.php";

if (isset($_POST['tambah-kelas'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $kompetensi_keahlian = $_POST['kompetensi_keahlian'];
    $query = mysqli_query($koneksi, "INSERT INTO kelas (nama_kelas,kompetensi_keahlian) VALUES('$nama_kelas','$kompetensi_keahlian')");

    if ($query) {
        $_SESSION['icon'] = "success";
        $_SESSION['title'] = "Berhasil";
        $_SESSION['text'] = "Data Berhasil Ditambahkan !";
        header('location:index.php?page=kelas');
    }
}

if (isset($_POST['edit-kelas'])) {
    $id = $_POST['id_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $kompetensi_keahlian = $_POST['kompetensi_keahlian'];
    $query = mysqli_query($koneksi, "UPDATE kelas SET nama_kelas='$nama_kelas',kompetensi_keahlian='$kompetensi_keahlian' WHERE id_kelas='$id'");

    if ($query) {
        $_SESSION['icon'] = "success";
        $_SESSION['title'] = "Berhasil";
        $_SESSION['text'] = "Data Berhasil Diubah !";
        header('location:index.php?page=kelas');
    }
}

if (!empty($_GET['submit'] == 'hapuskelas')) {
    $id = $_GET['id_kelas'];
    $query = mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas='$id'");

    if ($query) {
        $_SESSION['icon'] = "success";
        $_SESSION['title'] = "Berhasil";
        $_SESSION['text'] = "Data Berhasil Dihapus !";
        header('location:index.php?page=kelas');
    }
}

if (isset($_POST['tambah-siswa'])) {
    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $id_kelas = $_POST['id_kelas'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $password = md5($_POST['password']);

    $ceknisn = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn = $nisn");
    $ceknis = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis = $nis");

    if (mysqli_num_rows($ceknisn) > 0 && mysqli_num_rows($ceknis) > 0) {
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Gagal";
        $_SESSION['text'] = "NISN & NIS Sudah Digunakan !";
        header('location:index.php?page=siswa');
    } elseif (mysqli_num_rows($ceknisn) > 0) {
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Gagal";
        $_SESSION['text'] = "NISN Sudah Digunakan !";
        header('location:index.php?page=siswa');
    } elseif (mysqli_num_rows($ceknis) > 0) {
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Gagal";
        $_SESSION['text'] = "NIS Sudah Digunakan !";
        header('location:index.php?page=siswa');
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO siswa (nisn, nis, nama, id_kelas, jenis_kelamin, alamat, no_telp, password) VALUES('$nisn', '$nis', '$nama', '$id_kelas','$jenis_kelamin', '$alamat', '$no_telp', '$password')");

        if ($query) {
            $_SESSION['icon'] = "success";
            $_SESSION['title'] = "Berhasil";
            $_SESSION['text'] = "Data Berhasil Ditambakan !";
            header('location:index.php?page=siswa');
        }
    }
}

if (isset($_POST['edit-siswa'])) {
    $nisnold = $_POST['nisnold'];
    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $password = md5($_POST['password']);

    $ceknisn = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn = $nisn AND nisn!='$nisnold'");
    $ceknis = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis = $nis AND nisn!='$nisnold'");

    if (mysqli_num_rows($ceknisn) > 0 && mysqli_num_rows($ceknis) > 0) {
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Gagal";
        $_SESSION['text'] = "NISN & NIS Sudah Digunakan !";
        header('location:index.php?page=siswa');
    } elseif (mysqli_num_rows($ceknisn) > 0) {
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Gagal";
        $_SESSION['text'] = "NISN Sudah Digunakan !";
        header('location:index.php?page=siswa');
    } elseif (mysqli_num_rows($ceknis) > 0) {
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Gagal";
        $_SESSION['text'] = "NIS Sudah Digunakan !";
        header('location:index.php?page=siswa');
    } else {
        $query = mysqli_query($koneksi, "UPDATE siswa SET nisn='$nisn',nis='$nis',nama='$nama',jenis_kelamin='$jenis_kelamin',alamat='$alamat',no_telp='$no_telp',password='$password' WHERE nisn = '$nisnold'");

        if ($query) {
            $_SESSION['icon'] = "success";
            $_SESSION['title'] = "Berhasil";
            $_SESSION['text'] = "Data Berhasil Diubah !";
            header('location:index.php?page=siswa');
        }
    }
}

if (!empty($_GET['submit'] == 'hapussiswa')) {
    $nisn = $_GET['nisn'];
    $query = mysqli_query($koneksi, "DELETE FROM siswa WHERE nisn='$nisn'");

    if ($query) {
        $_SESSION['icon'] = "success";
        $_SESSION['title'] = "Berhasil";
        $_SESSION['text'] = "Data Berhasil Dihapus !";
        header('location:index.php?page=siswa');
    }
}

if (isset($_POST['tambah-petugas'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $nama_petugas = $_POST['nama_petugas'];
    $level = $_POST['level'];

    $cekusername = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username = '$username'");

    if (mysqli_num_rows($cekusername) > 0) {
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Gagal";
        $_SESSION['text'] = "Username Sudah Digunakan !";
        header('location:index.php?page=petugas');
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO petugas (username,password,nama_petugas,level) VALUES('$username','$password','$nama_petugas','$level')");

        if ($query) {
            $_SESSION['icon'] = "success";
            $_SESSION['title'] = "Berhasil";
            $_SESSION['text'] = "Data Berhasil Ditambakan !";
            header('location:index.php?page=petugas');
        }
    }
}

if (isset($_POST['edit-petugas'])) {
    $id = $_POST['id_petugas'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $nama_petugas = $_POST['nama_petugas'];
    $level = $_POST['level'];

    $cekusername = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username = '$username' AND id_petugas !='$id'");

    if (mysqli_num_rows($cekusername) > 0) {
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Gagal";
        $_SESSION['text'] = "Username Sudah Digunakan !";
        header('location:index.php?page=petugas');
    } else {
        $query = mysqli_query($koneksi, "UPDATE petugas SET username='$username',password='$password',nama_petugas='$nama_petugas',level='$level' WHERE id_petugas='$id'");

        if ($query) {
            $_SESSION['icon'] = "success";
            $_SESSION['title'] = "Berhasil";
            $_SESSION['text'] = "Data Berhasil DiUpdate !";
            header('location:index.php?page=petugas');
        }
    }
}

if (!empty($_GET['submit'] == 'hapuspetugas')) {
    $id = $_GET['id_petugas'];
    $query = mysqli_query($koneksi, "DELETE FROM petugas WHERE id_petugas='$id'");

    if ($query) {
        $_SESSION['icon'] = "success";
        $_SESSION['title'] = "Berhasil";
        $_SESSION['text'] = "Data Berhasil Dihapus !";
        header('location:index.php?page=petugas');
    }
}

if (isset($_POST['tambah-spp'])) {
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];

    $cektahun = mysqli_query($koneksi, "SELECT * FROM spp WHERE tahun = '$tahun'");

    if (mysqli_num_rows($cektahun) > 0) {
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Gagal";
        $_SESSION['text'] = "SPP Tahun Ini Sudah Ada !";
        header('location:index.php?page=spp');
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO spp (tahun,nominal) VALUES('$tahun','$nominal')");

        if ($query) {
            $_SESSION['icon'] = "success";
            $_SESSION['title'] = "Berhasil";
            $_SESSION['text'] = "Data Berhasil Ditambakan !";
            header('location:index.php?page=spp');
        }
    }
}

if (isset($_POST['edit-spp'])) {
    $id = $_POST['id_spp'];
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];

    $cektahun = mysqli_query($koneksi, "SELECT * FROM spp WHERE tahun = '$tahun' AND id_spp!='$id'");

    if (mysqli_num_rows($cektahun) > 0) {
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Gagal";
        $_SESSION['text'] = "SPP Tahun Ini Sudah Ada !";
        header('location:index.php?page=spp');
    } else {
        $query = mysqli_query($koneksi, "UPDATE spp SET tahun='$tahun',nominal='$nominal' WHERE id_spp='$id'");

        if ($query) {
            $_SESSION['icon'] = "success";
            $_SESSION['title'] = "Berhasil";
            $_SESSION['text'] = "Data Berhasil DiUpdate !";
            header('location:index.php?page=spp');
        }
    }
}

if (!empty($_GET['submit'] == 'hapusspp')) {
    $id = $_GET['id_spp'];
    $query = mysqli_query($koneksi, "DELETE FROM spp WHERE id_spp='$id'");

    if ($query) {
        $_SESSION['icon'] = "success";
        $_SESSION['title'] = "Berhasil";
        $_SESSION['text'] = "Data Berhasil Dihapus!";
        header('location:index.php?page=spp');
    }
}

if (isset($_POST['tambah-pembayaran'])) {
    $id_petugas = $_SESSION['user']['id_petugas'];
    $nisn = $_POST['nisn'];
    $tanggal_bayar = $_POST['tanggal_bayar'];
    $id_spp = $_POST['id_spp'];
    $jumlah_bayar = $_POST['jumlah_bayar'];

    $cektransaksi = mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE nisn = '$nisn' AND id_spp='$id_spp'");
    $spp = mysqli_query($koneksi, "SELECT * FROM spp WHERE id_spp='$id_spp'");
    $data = mysqli_fetch_array($spp);

    if (mysqli_num_rows($cektransaksi) > 0) {
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Gagal";
        $_SESSION['text'] = "Siswa Telah Melakukan Transaksi Untuk SPP Ini !";
        header('location:index.php?page=laporan');
    } else {
        if ($jumlah_bayar > $data['nominal']) {
            $_SESSION['icon'] = "error";
            $_SESSION['title'] = "Gagal";
            $_SESSION['text'] = "Jumlah Bayar Melebihi Kekurangan !";
            header('location:index.php?page=laporan');
        } else {
            $query = mysqli_query($koneksi, "INSERT INTO pembayaran (id_petugas, nisn, tgl_bayar, id_spp, jumlah_bayar) VALUES ('$id_petugas', '$nisn', '$tanggal_bayar', '$id_spp', '$jumlah_bayar')");
            if ($query) {
                $_SESSION['icon'] = "success";
                $_SESSION['title'] = "Berhasil";
                $_SESSION['text'] = "SPP Telah DiBayar !";
                header('location:index.php?page=laporan');
            }
        }
    }
}

if (isset($_POST['lunasi'])) {
    $id_pembayaran = $_POST['id_pembayaran'];
    $kekurangan = $_POST['kekurangan'];
    $tanggal_bayar = $_POST['tanggal_bayar'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $oldjumlah_bayar = $_POST['oldjumlah_bayar'];

    $total = $oldjumlah_bayar + $jumlah_bayar;

    if ($jumlah_bayar > $kekurangan) {
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Gagal";
        $_SESSION['text'] = "Jumlah Bayar Melebihi Kekurangan !";
        header('location:index.php?page=laporan');
    } else {
        $query = mysqli_query($koneksi, "UPDATE pembayaran SET tgl_bayar='$tanggal_bayar',jumlah_bayar='$total' WHERE id_pembayaran='$id_pembayaran'");
        if ($query) {
            $_SESSION['icon'] = "success";
            $_SESSION['title'] = "Berhasil";
            $_SESSION['text'] = "SPP Telah DiBayar !";
            header('location:index.php?page=laporan');
        }
    }
}
