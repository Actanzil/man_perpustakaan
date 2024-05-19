<?php
	session_start();
	include 'dbconnect.php';

	$notification = '';

    if (isset($_SESSION['level'])) {
        header("location: stock");
    }

    if (isset($_GET['pesan'])) {
        switch ($_GET['pesan']) {
            case "gagal":
                $notification = "Username atau Password salah!";
                break;
            case "logout":
                $notification = "Anda berhasil keluar dari sistem";
                break;
            case "belum_login":
                $notification = "Anda harus Login";
                break;
            case "noaccess":
                $notification = "Akses Ditutup";
                break;
        }
    }


	if (isset($_POST['btn-login'])) {
		$uname = mysqli_real_escape_string($conn, $_POST['username']);
		$upass = mysqli_real_escape_string($conn, md5($_POST['password']));
		$login = mysqli_query($conn, "SELECT * FROM user WHERE username='$uname' and password='$upass';");
		$cek = mysqli_num_rows($login);

		if ($cek > 0) {

			$data = mysqli_fetch_assoc($login);

			if ($data['level'] == "admin") {
				// buat session login dan username
				$_SESSION['user'] = $data['username'];
				$_SESSION['user_login'] = $data['username'];
				$_SESSION['id'] = $data['id_user'];
				$_SESSION['level'] = "admin";
				header("location:stock");
			} else {
				$notification = "Username atau Password salah!";
			}
		} else {
            $notification = "Username atau Password salah!";
        }
	}


?>
<!DOCTYPE html>
<html lang="en">

    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- Primary Meta Tags -->
        <title>Pupuk - Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="title" content="Volt - Free Bootstrap 5 Dashboard">
        <meta name="author" content="Themesberg">

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon/favicon-16x16.png">
        <link rel="manifest" href="assets/img/favicon/site.webmanifest">
        <link rel="mask-icon" href="assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="theme-color" content="#ffffff">

        <!-- Sweet Alert -->
        <link type="text/css" href="vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

        <!-- Bootstrap Icon -->
        <link type="text/css" href="vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

        <!-- Notyf -->
        <link type="text/css" href="vendor/notyf/notyf.min.css" rel="stylesheet">

        <!-- Volt CSS -->
        <link type="text/css" href="css/volt.css" rel="stylesheet">
        

    </head>

    <body>
        <main>
        
            <!-- Section -->
        <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center form-bg-image" data-background-lg="assets/img/illustrations/signin.svg">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                            <div class="text-center text-md-center mb-4 mt-md-0">
                                <h1 class="mb-0 h3">Sign in to our platform</h1>
                            </div>
                            <form action="" method="POST" class="mt-4">
                                <!-- Form -->
                                <div class="form-group mb-4">
                                    <label for="email">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                                        </span>
                                        <input type="text" class="form-control" placeholder="example@company.com" id="email" name="username" required>
                                    </div>  
                                </div>
                                <!-- End of Form -->
                                <div class="form-group">
                                    <!-- Form -->
                                    <div class="form-group mb-4">
                                        <label for="password">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon2">
                                                <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                            </span>
                                            <input type="password" placeholder="Password" class="form-control" id="password" name="password" required>
                                        </div>  
                                    </div>
                                    <!-- End of Form -->
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-gray-800" name="btn-login" >Sign in</button>
                                </div>
                            </form>
                            <div class="mt-3 mb-4 text-center">
                                <?php if (!empty($notification)) { ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Mohon Maaf !!!</strong> <?= $notification; ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                            
                                        </button>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        </main>

        <!-- Core -->
        <script src="vendor/@popperjs/core/dist/umd/popper.min.js"></script>
        <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Vendor JS -->
        <script src="vendor/onscreen/dist/on-screen.umd.min.js"></script>

        <!-- Slider -->
        <script src="vendor/nouislider/distribute/nouislider.min.js"></script>

        <!-- Smooth scroll -->
        <script src="vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

        <!-- Charts -->
        <script src="vendor/chartist/dist/chartist.min.js"></script>
        <script src="vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>

        <!-- Datepicker -->
        <script src="vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script>

        <!-- Sweet Alerts 2 -->
        <script src="vendor/sweetalert2/dist/sweetalert2.all.min.js"></script>

        <!-- Moment JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>

        <!-- Vanilla JS Datepicker -->
        <script src="vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script>

        <!-- Notyf -->
        <script src="vendor/notyf/notyf.min.js"></script>

        <!-- Simplebar -->
        <script src="vendor/simplebar/dist/simplebar.min.js"></script>

        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>

        <!-- Volt JS -->
        <script src="assets/js/volt.js"></script>

        
    </body>

</html>
