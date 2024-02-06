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
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover cell-border" id="laporan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Petugas</th>
                            <th>Nama Siswa</th>
                            <th>Tanggal Bayar</th>
                            <th>SPP</th>
                            <th>Jumlah Bayar</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $data['nama_petugas'] ?></td>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo date('d-m-Y', strtotime($data['tgl_bayar'])) ?></td>
                                <td>Rp. <?php echo number_format($data['nominal'], 2, ',', '.') ?></td>
                                <td>Rp. <?php echo number_format($data['jumlah_bayar'], 2, ',', '.') ?></td>
                                <td>
                                    <?php
                                    if ($data['nominal'] > $data['jumlah_bayar']) {
                                        echo 'Kurang';
                                    } else {
                                        echo 'Lunas';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($data['nominal'] == $data['jumlah_bayar']) {
                                    ?>
                                        <button class="btn btn-success btn-sm"><i class="fa fa-check" style="font-size: 12px;"></i></button>
                                    <?php
                                    } else {
                                    ?>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#lunasi<?php echo $data['id_pembayaran'] ?>"><i class="fa fa-edit" style="font-size: 12px;"></i></button>
                                    <?php
                                    }
                                    ?>

                                </td>
                            </tr>

                              <!-- Modal Edit -->
                              <div class="modal fade" id="lunasi<?php echo $data['id_pembayaran'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Lunasi</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" action="aksi-crud.php">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="mb-4">
                                                        <input type="hidden" name="id_pembayaran" value="<?= $data['id_pembayaran'] ?>">
                                                        <label class="form-label">Nama Siswa</label>
                                                        <select name="nisn" class="form-select" value="<?= $data['nisn'] ?>" disabled>
                                                            <?php
                                                            $query1 = mysqli_query($koneksi, "SELECT * FROM siswa");
                                                            while ($siswa = mysqli_fetch_array($query1)) {
                                                            ?>
                                                                <option value="<?php echo $siswa['nisn'] ?>" <?php if ($data['nisn'] == $siswa['nisn']) {
                                                                                                                    echo 'selected';
                                                                                                                } ?>><?php echo $siswa['nama'] ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="tanggal_bayar" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                                    <div class="mb-4">
                                                        <label class="form-label">SPP</label>
                                                        <select name="id_spp" class="form-select" value="<?= $data['id_spp'] ?>" disabled>
                                                            <?php
                                                            $query2 = mysqli_query($koneksi, "SELECT * FROM spp");
                                                            while ($spp = mysqli_fetch_array($query2)) {
                                                            ?>
                                                                <option value="<?php echo $spp['id_spp'] ?>" <?php if ($data['id_spp'] == $spp['id_spp']) {
                                                                                                                    echo 'selected';
                                                                                                                } ?>><?php echo $spp['tahun'] ?> - <?php echo $spp['nominal'] ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label">Kekurangan</label>
                                                        <input type="text" name="kekurangan" class="form-control" value="<?php echo $data['nominal'] - $data['jumlah_bayar'] ?>" readonly>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label">Jumlah Bayar</label>
                                                        <input type="text" name="jumlah_bayar" class="form-control" required>
                                                        <input type="hidden" name="oldjumlah_bayar" class="form-control" value="<?php echo $data['jumlah_bayar'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-12">
                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-success" name="lunasi">Simpan</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--Akhir Modal Edit-->

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        <?php if ($_SESSION['user']['level'] == 'admin') { ?>
            var buttons = [{
                extend: 'print',
                text: '<i class="fa fa-print"></i>',
                className: 'custom-print-button',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            }];
        <?php } else { ?>
            var buttons = [];
        <?php } ?>

        var dataTable = $('#laporan').DataTable({
            dom: 'Bfrtip',
            buttons: buttons
        });
    });
</script>