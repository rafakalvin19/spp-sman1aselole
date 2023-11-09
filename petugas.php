<?php
if (empty($_SESSION['user']['level'] == 'admin')) {
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
            <div class="card-body">
                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah-petugas">+ Tambah Petugas</button>
                <table class="table table-bordered table-striped table-hover cell-border" id="petugas">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama Petugas</th>
                            <th>Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM petugas");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $data['username'] ?></td>
                                <td><?php echo $data['nama_petugas'] ?></td>
                                <td><?php echo $data['level'] ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit-petugas<?php echo $data['id_petugas'] ?>"><i class="fa fa-edit" style="font-size: 12px;"></i></button>
                                    <button class="btn btn-danger btn-sm" id="hapuspetugas<?php echo $data['id_petugas'] ?>"><i class="fa fa-trash" style="font-size: 12px;"></i></button>
                                </td>
                            </tr>
                            <!-- Modal Edit-->
                            <div class="modal fade" id="edit-petugas<?php echo $data['id_petugas'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Petugas</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" action="aksi-crud.php">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="mb-3">
                                                        <input type="hidden" name="id_petugas" value="<?= $data['id_petugas'] ?>">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Password</label>
                                                        <input type="password" name="password" class="form-control" value="<?= $data['password'] ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Petugas</label>
                                                        <input type="text" name="nama_petugas" class="form-control" value="<?= $data['nama_petugas'] ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Level</label>
                                                        <select name="level" class="form-select">
                                                            <option value="admin" <?php echo ($data['level'] == 'admin' ? 'selected' : '') ?>>Admin</option>
                                                            <option value="petugas" <?php echo ($data['level'] == 'petugas' ? 'selected' : '') ?>>Petugas</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-12">
                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-success" name="edit-petugas">Simpan</button>
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
                                document.getElementById('hapuspetugas<?php echo $data['id_petugas'] ?>').addEventListener('click', function() {
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
                                            window.location.href = "aksi-crud.php?submit=hapuspetugas&id_petugas=<?php echo $data['id_petugas'] ?>"
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
<div class="modal fade" id="tambah-petugas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12">
                    <div class="text-center">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">+ Tambah Petugas</h1>
                    </div>
                </div>
            </div>
            <form method="post" action="aksi-crud.php">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Petugas</label>
                            <input type="text" name="nama_petugas" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Level</label>
                            <select name="level" class="form-select">
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12">
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" name="tambah-petugas">Simpan</button>
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
    let table = new DataTable('#petugas');
</script>