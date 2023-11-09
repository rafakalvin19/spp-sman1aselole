<?php
if (empty($_SESSION['user']['level'])) {
?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.body.innerHTML = '';
        Swal.fire({
            icon: "error",
            title: "403 Forbidden.",
            text: "Akses Dilarang !",
        }).then(function() {
            window.history.back();
        })
    </script>
<?php
}
?>
<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-body table-responsive">
                <?php
                if (!empty($_SESSION['user']['level'] == 'admin')) {
                ?>
                    <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah-siswa">+ Tambah Siswa</button>
                <?php
                }
                ?>
                <table class="table table-bordered table-striped table-hover cell-border" id="siswa">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>No Telp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM siswa INNER JOIN kelas ON kelas.id_kelas=siswa.id_kelas");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $data['nisn'] ?></td>
                                <td><?php echo $data['nis'] ?></td>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo $data['nama_kelas'] ?></td>
                                <td><?php echo $data['kompetensi_keahlian'] ?></td>
                                <td><?php echo $data['jenis_kelamin'] ?></td>
                                <td><?php echo $data['alamat'] ?></td>
                                <td><?php echo $data['no_telp'] ?></td>
                                <td>
                                    <?php
                                    if (!empty($_SESSION['user']['level'] == 'admin')) {
                                    ?>
                                        <button class="btn btn-info btn-xs" data-bs-toggle="modal" data-bs-target="#edit-siswa<?php echo $data['nisn'] ?>"><i class="fa fa-edit" style="font-size: 12px;"></i></button>
                                        <a href="?page=history-pembayaran&id=<?php echo $data['nisn'] ?>" class="btn btn-secondary btn-xs"><i class="fa fa-archive" style="font-size: 12px;"></i></a>
                                        <button class="btn btn-danger btn-xs" id="hapussiswa<?php echo $data['nisn'] ?>"><i class="fa fa-trash" style="font-size: 12px;"></i></button>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="?page=history-pembayaran&id=<?php echo $data['nisn'] ?>" class="btn btn-secondary sm"><i class="fa fa-archive" style="font-size: 12px;"></i></a>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <!-- Modal Edit-->
                            <div class="modal fade" id="edit-siswa<?php echo $data['nisn'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Siswa</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" action="aksi-crud.php">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="mb-3">
                                                        <input type="hidden" name="nisnold" value="<?= $data['nisn'] ?>">
                                                        <label class="form-label">NISN</label>
                                                        <input type="number" name="nisn" class="form-control" value="<?= $data['nisn'] ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">NIS</label>
                                                        <input type="number" name="nis" class="form-control" value="<?= $data['nis'] ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama</label>
                                                        <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Kelas</label>
                                                        <select name="id_kelas" class="form-select">
                                                            <?php
                                                            $query1 = mysqli_query($koneksi, "SELECT * FROM kelas");
                                                            while ($kelas = mysqli_fetch_array($query1)) {
                                                            ?>
                                                                <option value="<?php echo $kelas['id_kelas'] ?>" <?php echo ($data['id_kelas'] == $kelas['id_kelas'] ? 'selected' : '') ?>>
                                                                    <?php echo $kelas['nama_kelas'] ?> - <?php echo $kelas['kompetensi_keahlian'] ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class=" mb-3">
                                                        <label class="form-label">Jenis Kelamin</label>
                                                        <select name="jenis_kelamin" class="form-select">
                                                            <option value="Laki-laki" <?php if ($data['jenis_kelamin'] == 'Laki-laki') {
                                                                                            echo 'selected';
                                                                                        } ?>>Laki-laki</option>
                                                            <option value="Perempuan" <?php if ($data['jenis_kelamin'] == 'Perempuan') {
                                                                                            echo 'selected';
                                                                                        } ?>>Perempuan</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Alamat</label>
                                                        <input type="text" name="alamat" class="form-control" value="<?= $data['alamat'] ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">No Telp</label>
                                                        <input type="number" name="no_telp" class="form-control" value="<?= $data['no_telp'] ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Password</label>
                                                        <input type="password" id="password-edit<?= $data['nisn'] ?>" name="password" class="form-control" value="<?= $data['password'] ?>">
                                                        <span id="edit-toggle<?= $data['nisn'] ?>"><i class="fa fa-eye"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-12">
                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-success" name="edit-siswa">Simpan</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Akhir Modal Edit-->

                            <script>
                                // Tambahkan event listener untuk tombol "Hapus Data"
                                document.getElementById('hapussiswa<?php echo $data['nisn'] ?>').addEventListener('click', function() {
                                    Swal.fire({
                                        title: 'Konfirmasi',
                                        text: 'Anda yakin ingin menghapus data ini?',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Ya, Hapus!',
                                        cancelButtonText: 'Batal'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "aksi-crud.php?submit=hapussiswa&nisn=<?php echo $data['nisn'] ?>"
                                        }
                                    });
                                });
                            </script>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal tambah -->
<div class="modal fade" id="tambah-siswa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12">
                    <div class="text-center">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">+ Tambah Siswa</h1>
                    </div>
                </div>
            </div>
            <form method="post" action="aksi-crud.php">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">NISN</label>
                            <input type="number" name="nisn" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIS</label>
                            <input type="number" name="nis" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select name="id_kelas" class="form-select">
                                <?php
                                $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                                while ($data = mysqli_fetch_array($query)) {
                                ?>
                                    <option value="<?php echo $data['id_kelas'] ?>"><?php echo $data['nama_kelas'] ?> - <?php echo $data['kompetensi_keahlian'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No Telp</label>
                            <input type="number" name="no_telp" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" id="password-tambah" name="password" class="form-control" required>
                            <span id="password-toggle"><i class="fa fa-eye"></i></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12">
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" name="tambah-siswa">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Akhir Modal Tambah-->

<script>
    let table = new DataTable('#siswa');
</script>

<script>
    const passwordTambah = document.getElementById('password-tambah');
    const tambahToggle = document.getElementById('password-toggle');

    tambahToggle.addEventListener('click', () => {
        if (passwordTambah.type === 'password') {
            passwordTambah.type = 'text';
            tambahToggle.innerHTML = '<i class="fa fa-eye-slash"></i>';
        } else {
            passwordTambah.type = 'password';
            tambahToggle.innerHTML = '<i class="fa fa-eye"></i>';
        }
    });
</script>
<style>
    #password-toggle {
        position: absolute;
        right: 26px;
        top: 93%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: medium;
    }
</style>

<?php
$i = 1;
$query = mysqli_query($koneksi, "SELECT * FROM siswa INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas");
while ($data = mysqli_fetch_array($query)) {
?>
    <script>
        const passwordEdit<?= $data['nisn'] ?> = document.getElementById('password-edit<?= $data['nisn'] ?>');
        const editToggle<?= $data['nisn'] ?> = document.getElementById('edit-toggle<?= $data['nisn'] ?>');

        editToggle<?= $data['nisn'] ?>.addEventListener('click', () => {
            if (passwordEdit<?= $data['nisn'] ?>.type === 'password') {
                passwordEdit<?= $data['nisn'] ?>.type = 'text';
                editToggle<?= $data['nisn'] ?>.innerHTML = '<i class="fa fa-eye-slash"></i>';
            } else {
                passwordEdit<?= $data['nisn'] ?>.type = 'password';
                editToggle<?= $data['nisn'] ?>.innerHTML = '<i class="fa fa-eye"></i>';
            }
        });
    </script>
    <style>
        #edit-toggle<?= $data['nisn'] ?> {
            position: absolute;
            right: 26px;
            margin-left: 100px;
            top: 93%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: medium;
        }
    </style>

<?php
}
?>