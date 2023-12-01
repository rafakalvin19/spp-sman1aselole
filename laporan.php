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