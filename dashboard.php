<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title-mb-0">Selamat datang di Aplikasi Pembayaran SPP</h5>
      </div>
      <div class="card-body">
        <table class="table">
          <?php
          if (isset($_SESSION['user']['level'])) {
          ?>
            <tr>
              <td width="150">Nama User</td>
              <td width="1">:</td>
              <td><?php echo $_SESSION['user']['nama_petugas']; ?></td>
            </tr>
            <tr>
              <td width="150">Level User</td>
              <td width="1">:</td>
              <td><?php echo $_SESSION['user']['level']; ?></td>
            </tr>
          <?php
          } else {
          ?>
            <tr>
              <td width="150">Nama Siswa</td>
              <td width="1">:</td>
              <td><?php echo $_SESSION['user']['nama']; ?></td>
            </tr>
          <?php
          }
          ?>

          <tr>
            <td width="150">Waktu Login</td>
            <td width="1">:</td>
            <td>
              <?php
              date_default_timezone_set('Asia/Jakarta');
              setlocale(LC_TIME, 'id_ID');

              $hariInggris = date('l');
              $hariIndonesia = [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
              ];

              $bulanInggris = date('F');
              $bulanIndonesia = [
                'January' => 'Januari',
                'February' => 'Februari',
                'March' => 'Maret',
                'April' => 'April',
                'May' => 'Mei',
                'June' => 'Juni',
                'July' => 'Juli',
                'August' => 'Agustus',
                'September' => 'September',
                'October' => 'Oktober',
                'November' => 'November',
                'December' => 'Desember',
              ];

              $hari = $hariIndonesia[$hariInggris];
              $bulan = $bulanIndonesia[$bulanInggris];
              $waktu_sekarang = $_SESSION['waktu_login'];
              $tanggal = date('d') . ' ' . $bulan . ' ' . date('Y') . ' ' . date('H:i:s', $waktu_sekarang) . ' WIB';
              echo $hari . ', ' . $tanggal;
              ?>
            </td>
          </tr>
        </table>

        <?php
        if (empty($_SESSION['user']['level'])) {
        ?>
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
              </tr>
            </thead>
            <tbody>

              <?php
              $no = 1;
              $nisn = $_SESSION['user']['nisn'];
              $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE pembayaran.nisn='$nisn'");
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
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        <?php
        }
        ?>

        <?php
        ?>