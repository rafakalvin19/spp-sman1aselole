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
                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah-kelas">+ Tambah Kelas</button>
                <table class="table table-bordered table-striped table-hover cell-border" id="kelas">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Kompetensi Keahlian</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $data['nama_kelas'] ?></td>
                                <td><?php echo $data['kompetensi_keahlian'] ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit-kelas<?php echo $data['id_kelas'] ?>"><i class="fa fa-edit" style="font-size: 12px;"></i></button>
                                    <button class="btn btn-danger btn-sm" id="hapuskelas<?php echo $data['id_kelas'] ?>"><i class="fa fa-trash" style="font-size: 12px;"></i></button>
                                </td>
                            </tr>
                            <!-- Modal Edit-->
                            <div class="modal fade" id="edit-kelas<?php echo $data['id_kelas'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Kelas</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" action="aksi-crud.php">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="mb-3">
                                                        <input type="hidden" name="id_kelas" value="<?= $data['id_kelas'] ?>">
                                                        <label class="form-label">Nama Kelas</label>
                                                        <input type="text" name="nama_kelas" class="form-control" value="<?= $data['nama_kelas'] ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Kompetensi Keahlian</label>
                                                        <input type="text" name="kompetensi_keahlian" class="form-control" value="<?= $data['kompetensi_keahlian'] ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-12">
                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-success" name="edit-kelas">Simpan</button>
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
                                document.getElementById('hapuskelas<?php echo $data['id_kelas'] ?>').addEventListener('click', function() {
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
                                            window.location.href = "aksi-crud.php?submit=hapuskelas&id_kelas=<?php echo $data['id_kelas'] ?>"
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
<div class="modal fade" id="tambah-kelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12">
                    <div class="text-center">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">+ Tambah Kelas</h1>
                    </div>
                </div>
            </div>
            <form method="post" action="aksi-crud.php">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Nama Kelas</label>
                            <input type="text" name="nama_kelas" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kompetensi Keahlian</label>
                            <input type="text" name="kompetensi_keahlian" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12">
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" name="tambah-kelas">Simpan</button>
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
    let table = new DataTable('#kelas');
</script>