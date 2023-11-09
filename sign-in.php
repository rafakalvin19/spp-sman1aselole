<?php
include 'koneksi.php';
if (isset($_POST['username'])) {
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $query = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username ='$username' AND password ='$password'");

  if (mysqli_num_rows($query) > 0) {
    $_SESSION['user'] = mysqli_fetch_array($query);
    $_SESSION['waktu_login'] = time();
    $_SESSION['icon'] = "success";
    $_SESSION['title'] = "Berhasil";
    $_SESSION['text'] = "Anda Berhasil Login !";
    header('location:index.php');
  } else {
    $query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn ='$username' AND password ='$password'");
    if (mysqli_num_rows($query) > 0) {
      $_SESSION['user'] = mysqli_fetch_array($query);
      $_SESSION['waktu_login'] = time();
      $_SESSION['icon'] = "success";
      $_SESSION['title'] = "Berhasil";
      $_SESSION['text'] = "Anda Berhasil Login !";
      header('location:index.php');
    } else {
      echo '<script>
      alert("Username/NISN atau Password salah !");location.href="sign-in.php"
      </script>';
    }
  }
}
if (!empty($_SESSION['user'])) {
  header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <title>
    Sign-in
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
  <style>
    body {
      margin: 0;
      padding: 0;
    }

    .content {
      min-height: 100vh;
      padding-bottom: 50px;
      /* Tinggi footer */
    }

    .footer {
      background-color: #ffffff;
      /* Warna latar belakang footer */
      color: #fff;
      /* Warna teks footer */
      text-align: center;
      position: absolute;
      bottom: 0;
      width: 100%;
      height: 75px;
      /* Tinggi footer */
    }

    #password-toggle {
      position: absolute;
      right: 34px;
      top: 70%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: medium;
    }
  </style>
</head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
          <div class="container-fluid pe-0">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="sign-in.php">
              Pembayaran SPP SMAN 1 Aselole
            </a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Selamat datang</h3>
                  <p class="mb-0">Masukkan Username/NISN & Password untuk Login.</p>
                </div>
                <div class="card-body">
                  <form role="form" method="post">
                    <label>Username/NISN</label>
                    <div class="mb-3">
                      <input type="text" name="username" class="form-control" placeholder="Masukkan Username/NISN anda.">
                    </div>
                    <label>Password</label>
                    <div class="mb-3">
                      <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password anda.">
                      <span id="password-toggle"><i class="fa fa-eye"></i></span>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('assets/img/curved-images/curved6.jpg')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <div class="footer">
    <div class="col-lg-8 mx-auto text-center mb-4 mt-2">
      <a href="https://twitter.com/elonmusk" target="_blank" class="text-secondary me-xl-4 me-4">
        <span class="text-lg fab fa-twitter"></span>
      </a>
      <a href="https://instagram.com/rafakalvn_" target="_blank" class="text-secondary me-xl-4 me-4">
        <span class="text-lg fab fa-instagram"></span>
      </a>
      <a href="https://facebook.com/rafa.k.allan/" target="_blank" class="text-secondary me-xl-4 me-4">
        <span class="text-lg fab fa-facebook"></span>
      </a>
      <a href="https://wa.me/+628976108526" target="_blank" class="text-secondary me-xl-4 me-4">
        <span class="text-lg fab fa-whatsapp"></span>
      </a>
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> by Lanvoster.
          </p>
        </div>
      </div>
    </div>
  </div>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    const passwordInput = document.getElementById('password');
    const passwordToggle = document.getElementById('password-toggle');

    passwordToggle.addEventListener('click', () => {
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordToggle.innerHTML = '<i class="fa fa-eye-slash"></i>';
      } else {
        passwordInput.type = 'password';
        passwordToggle.innerHTML = '<i class="fa fa-eye"></i>';
      }
    });
  </script>
</body>

</html>