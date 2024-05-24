<?php
    include '../dbconnect.php';
    include 'cek.php';
    include 'fungsi.php';

    // Pastikan hanya Superadmin yang dapat mengakses halaman ini
    if ($_SESSION['level'] != "Superadmin") {
        // Redirect pengguna kembali ke halaman dashboard atau halaman lain yang sesuai
        header("location: index.php?pesan=noaccess");
        exit(); // Penting untuk menghentikan eksekusi skrip setelah melakukan redirect
    }

    $id_user = $_SESSION['id'];
    //get profil
    $sql_us = " SELECT  `foto`, `nama`
                FROM `user`
                WHERE `id_user` = '$id_user' "; 
    $query_us = mysqli_query($conn,$sql_us);
    while($data_us = mysqli_fetch_row($query_us)){
      $foto = $data_us[0];
      $nama = $data_us[1];
    }

    if (isset($_POST['cetak'])) {
        // Ambil nilai input type hidden
        $id_laporan = $_POST['id_laporan'];

        // Redirect ke halaman selanjutnya dengan mengirimkan data menggunakan URL
        header("Location: cetak_laporan.php?id_laporan=$id_laporan");
        exit(); // Pastikan untuk keluar setelah mengirimkan header redirect
    };

    // Periksa apakah formulir hapus telah dikirim
    if (isset($_POST['hapus'])) {
        $id_laporan = $_POST['id_laporan'];
        
        // Query untuk menghapus data laporan berdasarkan id_laporan
        $query = "DELETE FROM tb_laporan WHERE id_laporan = '$id_laporan'";
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            // notifikasi
            $notificationType = "success";
            $notificationCaption = "Selamat !!!";
            $notificationMessage = "Data berhasil dihapus!";
        } else {
            // notifikasi
            $notificationType = "warning";
            $notificationCaption = "Mohon maaf !!!";
            $notificationMessage = "Gagal menghapus data!";
        }

        // Set notifikasi dalam format array
        $notification = [
            'type' => $notificationType,
            'caption' => $notificationCaption,
            'message' => $notificationMessage
        ];

        // Convert array ke JSON dan encode untuk ditransfer melalui URL
        $encodedNotification = urlencode(json_encode($notification));

        // Redirect ke halaman page laporan dengan notifikasi
        header("Location: page_laporan.php?notification=$encodedNotification");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">

    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- Primary Meta Tags -->
        <title>Perpustakaan - Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="title" content="Perpustakaan - Administrasi">

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="120x120" href="../assets/img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon/favicon-16x16.png">
        <link rel="manifest" href="../assets/img/favicon/site.webmanifest">
        <link rel="mask-icon" href="../assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="theme-color" content="#ffffff">

        <!-- Bootstrap Icon -->
        <link type="text/css" href="../vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

        <!-- Volt CSS -->
        <link type="text/css" href="../css/volt.css" rel="stylesheet">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    </head>

    <body>
        <nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
            <a class="navbar-brand me-lg-5" href="index.html">
                <img class="navbar-brand-dark" src="../assets/img/brand/light.svg" alt="Volt logo"/> <img class="navbar-brand-light" src="../assets/img/brand/dark.svg" alt="Volt logo" />
            </a>
            <div class="d-flex align-items-center">
                <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
            <div class="sidebar-inner px-4 pt-3">
                <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar-lg me-4">
                            <img src="assets/foto-user/<? $foto; ?>" class="card-img-top rounded-circle border-white" alt="Bonnie Green">
                        </div>
                        <div class="d-block">
                        <h2 class="h5 mb-3">Hi, <?= $nama; ?></h2>
                        <a href="pages/examples/sign-in.html" class="btn btn-secondary btn-sm d-inline-flex align-items-center">         
                            Keluar
                        </a>
                        </div>
                    </div>
                    <div class="collapse-close d-md-none">
                        <a href="#sidebarMenu" data-bs-toggle="collapse"
                            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true"
                            aria-label="Toggle navigation">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </a>
                    </div>
                </div>
                <ul class="nav flex-column pt-3 pt-md-0">
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center">
                            <span class="sidebar-icon">
                                <img src="../assets/img/brand/light.svg" height="20" width="20" alt="Volt Logo">
                            </span>
                            <span class="mt-1 ms-1 sidebar-text">Perpustakaan Admin</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="index.php" class="nav-link">
                            <span class="sidebar-icon">
                                <i class="bi bi-grid-1x2-fill"></i>
                            </span> 
                            <span class="sidebar-text">Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="page_buku.php" class="nav-link">
                            <span class="sidebar-icon">
                                <i class="bi bi-basket-fill"></i>
                            </span>
                            <span class="sidebar-text">Daftar Buku</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link  collapsed  d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#submenu-app">
                            <span>
                                <span class="sidebar-icon">
                                    <i class="bi bi-bookmarks-fill"></i>
                                </span> 
                                <span class="sidebar-text">Transaksi Data</span>
                            </span>
                            <span class="link-arrow">
                                <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            </span>
                        </span>
                        <div class="multi-level collapse " role="list" id="submenu-app" aria-expanded="false">
                        <ul class="flex-column nav">
                            <li class="nav-item ">
                                <a class="nav-link" href="data_masuk.php">
                                    <span class="sidebar-text">Data Masuk</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="data_keluar.php">
                                    <span class="sidebar-text">Data Keluar</span>
                                </a>
                            </li>
                        </ul>
                        </div>
                    </li>
                    <?php if ($_SESSION['level'] == "Superadmin") { ?>
                        <li class="nav-item">
                            <a href="page_user.php" class="nav-link">
                                <span class="sidebar-icon">
                                    <i class="bi bi-people-fill"></i>
                                </span>
                                <span class="sidebar-text">Data User</span>
                            </a>
                        </li>
                    <?php } ?>
                    <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
                    <?php if ($_SESSION['level'] == "Superadmin") { ?>
                        <li class="nav-item active">
                            <a href="page_laporan.php" class="nav-link">
                                <span class="sidebar-icon">
                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                </span>
                                <span class="sidebar-text">Laporan</span>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="nav-item ">
                        <a href="logout.php" class="nav-link">
                            <span class="sidebar-icon">
                                <i class="bi bi-box-arrow-left"></i>
                            </span>
                            <span class="sidebar-text">Keluar</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        
        <main class="content">
            <nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
                <div class="container-fluid px-0">
                    <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
                        <div class="d-flex align-items-center">
                            <h4>
                                <div class="date">
                                    <script type='text/javascript'>
                                        var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                        var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                                        var date = new Date();
                                        var day = date.getDate();
                                        var month = date.getMonth();
                                        var thisDay = date.getDay(),
                                            thisDay = myDays[thisDay];
                                        var yy = date.getYear();
                                        var year = (yy < 1000) ? yy + 1900 : yy;
                                        document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);		
                                    </script>
                                </div>
                            </h4>
                        </div>
                        <!-- Navbar links -->
                        <ul class="navbar-nav align-items-center">
                            </li>
                            <li class="nav-item ms-lg-3">
                                <a class="nav-link pt-1 px-0" role="button">
                                    <div class="media d-flex align-items-center">
                                        <img class="avatar rounded-circle" alt="Image placeholder" src="assets/foto-user/<?= $foto; ?>">
                                        <div class="media-body ms-2 text-dark align-items-center d-none d-lg-block">
                                            <span class="mb-0 font-small fw-bold text-gray-900"><?=$nama;?></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
                <div class="d-block mb-4 mb-md-0">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                            <li class="breadcrumb-item">
                                <a href="#">
                                    <i class="bi bi-house-door-fill"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                        </ol>
                    </nav>
                    <h2 class="h4">Laporan</h2>
                    <p class="mb-0">Your web analytics dashboard template.</p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="#" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-default">
                        <i class="bi bi-plus-lg me-2"></i>
                        Buat Laporan
                    </a>
                </div>
                <div class="modal fade" id="modal-default" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" >
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="h6 modal-title">Formulir Buat Laporan</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="konfirmasi_buat_laporan.php" method="POST">
                                <input type="hidden" name="id_user" value="<?php echo $_SESSION['id']; ?>">
                                <div class="modal-body">
                                    <div class="mb-3 row">
                                        <label for="kode" class="col-sm-3 col-form-label">Kode Laporan</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon3">LPRN//355/01/</span>
                                                <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4" name="kode">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="judul" class="col-sm-3 col-form-label">Judul Laporan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="judul" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="bulan" class="col-sm-3 col-form-label">Periode Laporan</label>
                                        <div class="col-sm-4">
                                            <input type="number" min="1" max="12" class="form-control" name="bulan" placeholder="Bulan" required>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="number" min="2020" max="2024" class="form-control" name="tahun" placeholder="Tahun" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="keterangan" class="col-sm-3 col-form-label">Keterangan Laporan</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="keterangan" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link text-gray-600" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-secondary" value="simpan">Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Pencarian -->
            <div class="table-settings mb-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col col-md-6 col-lg-3 col-xl-4">
                        <div class="input-group me-2 me-lg-3 fmxw-400">
                            <form action="page_laporan.php" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Masukkan kata kunci..." aria-label="Search" aria-describedby="basic-addon2" id="kata_kunci" name="katakunci" required>
                                    <button class="btn btn-primary" type="submit">Cari</button>
                                    <a href="page_laporan.php" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col col-md-6 col-lg-6 col-xl-6">
                        <?php
                            
                            // Tampilkan notifikasi dari Update dan Delete
                            if (!empty($notification)) {
                                echo "  <div class='alert alert-$alertType alert-dismissible fade show' role='alert'>
                                            <strong>$caption</strong> $notification.
                                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                        </div>
                                    ";
                            }

                            // Ambil notifikasi Tambah dari URL dan decode dari JSON
                            if (isset($_GET['notification'])) {
                                $encodedNotification = $_GET['notification'];
                                $decodedNotification = json_decode(urldecode($encodedNotification), true);

                                // Tampilkan notifikasi
                                $notificationType = $decodedNotification['type'];
                                $notificationCaption = $decodedNotification['caption'];
                                $notificationMessage = $decodedNotification['message'];

                                echo "
                                <div class='alert alert-$notificationType alert-dismissible fade show' role='alert'>
                                    <strong>$notificationCaption</strong> $notificationMessage.
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                                <meta http-equiv='refresh' content='2; url= page_laporan.php'/> ";
                            }
                        ?>
                    </div>
                </div>
            </div>
            <!-- End Kolom Pencarian -->

            <div class="container-fluid py-4 px-0">
                <div class="row">
                    <?php
                        // Limit untuk membatasi jumlah data pada satu halaman
                        $batas = 5;
                        if(!isset($_GET['halaman'])){
                            $posisi = 0;
                            $halaman = 1;
                        }else{
                            $halaman = $_GET['halaman'];
                            $posisi = ($halaman-1) * $batas;
                        }

                        // Inisialisasi katakunci pencarian
                        $katakunci = isset($_GET['katakunci']) ? $_GET['katakunci'] : '';
                        
                        $sql = "SELECT * FROM tb_laporan";
                        
                        // Logika untuk pencarian
                        if (!empty($katakunci)) {
                            $sql .= " WHERE judul_laporan LIKE '%" . mysqli_real_escape_string($conn, $katakunci) . "%'";
                        }
                        
                        // Mengurutkan data berdasarkan judul dan membatasi data sesuai batasan yang telah ditentukan
                        $sql .= " ORDER BY tanggal ASC LIMIT $posisi, $batas";

                        $brgs = mysqli_query($conn, $sql);
                        while($p=mysqli_fetch_array($brgs)){
                            $idb = $p['id_laporan'];
                        
                    ?>
                    <div class="col-md-6 col-lg-3 mt-2 mb-2">
                        <div class="list-group kanban-list">
                            <div class="card border-0 shadow p-4">
                                <div class="card-header d-flex align-items-center justify-content-between border-0 p-0 mb-3">
                                    <h3 class="h5 mb-0"><?= $p['judul_laporan']; ?></h3>
                                    <div>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm fs-6 px-1 py-0 dropdown-toggle" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><svg class="icon icon-xs text-gray-500" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg></button>
                                            <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#detail<?= $idb; ?>">
                                                    <i class="bi bi-arrows-fullscreen text-gray-400 me-2"></i>
                                                    Detail Laporan 
                                                </a>
                                                <div role="separator" class="dropdown-divider my-1"></div>
                                                <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#delete<?= $idb; ?>"><i class="bi bi-trash-fill text-danger me-2"></i> Hapus Laporan</a>
                                            </div>
                                            <div class="dropdown-menu dashboard-dropdown dropdown-menu-start py-0" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item fw-normal rounded-top" href="#" data-bs-toggle="modal" data-bs-target="#editTaskModal"><span class="fas fa-edit"></span>Edit task</a><a class="dropdown-item fw-normal" href="#"><span class="far fa-clone"></span>Copy Task</a><a class="dropdown-item fw-normal" href="#"><span class="far fa-star"></span> Add to favorites</a>
                                                <div role="separator" class="dropdown-divider my-0"></div>
                                                <a class="dropdown-item fw-normal text-danger rounded-bottom" href="#"><span class="fas fa-trash-alt"></span>Hapus Laporan</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <p>
                                        <?= $p['keterangan']; ?>.
                                    </p>
                                    
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal fade" id="detail<?= $idb; ?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                                <div class="modal-content p-lg-3">
                                    <div class="modal-header align-items-start border-bottom">
                                        <div class="d-block">
                                            <h2 class="h5 mb-3"><?= $p['judul_laporan']; ?></h2>
                                            <div class="d-flex">
                                                <div class="d-block me-3 me-sm-4">
                                                    <h5 class="fs-6 fw-bold text-gray-500" id="editTaskModalLabel"><?= $p['kode_laporan']; ?></h5>
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body py-4" id="printableModal">
                                        <div class="row">
                                            <div class="col-12 col-lg-12">
                                                <div class="row mb-4 mb-lg-0">
                                                    <div class="card card-body border-0 shadow table-wrapper table-responsive" >
                                                        <table class="table table-hover" >
                                                            <thead>
                                                                <tr>
                                                                    <th class="border-gray-200" style="text-align: center;">No</th>
                                                                    <th class="border-gray-200" style="text-align: center;">Judul Buku</th>
                                                                    <th class="border-gray-200" style="text-align: center;">Tanggal</th>
                                                                    <th class="border-gray-200" style="text-align: center;">User</th>
                                                                    <th class="border-gray-200" style="text-align: center;">Transaksi</th>
                                                                    <th class="border-gray-200" style="text-align: center;">Keterangan</th>
                                                                    <th class="border-gray-200" style="text-align: center;">Jumlah</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $query_bk = ("  SELECT id_buku, kode_buku, judul_buku, keterangan, tanggal_transaksi, kategori, nama, jumlah 
                                                                                    FROM (
                                                                                        SELECT  b.id_buku, b.kode_buku, b.judul_buku, bm.keterangan,
                                                                                                bm.tanggal AS tanggal_transaksi_asli, 
                                                                                                DATE_FORMAT(bm.tanggal, '%d-%m-%Y') AS tanggal_transaksi, 
                                                                                                'Buku Masuk' AS kategori, 
                                                                                                u.nama, 
                                                                                                bm.jumlah
                                                                                        FROM tb_buku b
                                                                                        LEFT JOIN tb_buku_masuk bm ON b.id_buku = bm.id_buku
                                                                                        LEFT JOIN user u ON bm.id_user = u.id_user
                                                                                        WHERE bm.id_buku IS NOT NULL
                                                                                        
                                                                                        UNION
                                                                                        
                                                                                        SELECT  b.id_buku, b.kode_buku, b.judul_buku, bk.keterangan,
                                                                                                bk.tanggal AS tanggal_transaksi_asli, 
                                                                                                DATE_FORMAT(bk.tanggal, '%d-%m-%Y') AS tanggal_transaksi, 
                                                                                                'Buku Keluar' AS kategori, 
                                                                                                u.nama, 
                                                                                                bk.jumlah
                                                                                        FROM tb_buku b 
                                                                                        LEFT JOIN tb_buku_keluar bk ON b.id_buku = bk.id_buku
                                                                                        LEFT JOIN user u ON bk.id_user = u.id_user
                                                                                        WHERE bk.id_buku IS NOT NULL
                                                                                    ) AS combined_data
                                                                                    WHERE 
                                                                                        DATE_FORMAT(tanggal_transaksi_asli, '%Y-%m') IN (SELECT bulan FROM tb_laporan WHERE id_laporan = '$idb')
                                                                                    ORDER BY 
                                                                                        tanggal_transaksi_asli ASC");
                                                                    $result_bk = mysqli_query($conn, $query_bk);
                                                                    $no = 1;
                                                                    while ($bk = mysqli_fetch_array($result_bk)) {
                                                                        
                                                                ?>
                                                                <tr>
                                                                    <td><?= $no++ ?></td>
                                                                    <td style="text-align: justify;"><span class="fw-normal"><?= $bk['judul_buku']; ?></span></td>
                                                                    <td style="text-align: center;"><span class="fw-normal"><?= TanggalIndo($bk['tanggal_transaksi']); ?></span></td>
                                                                    <td><span class="fw-normal"><?= $bk['nama']; ?></span></td>
                                                                    <td style="text-align: center;"><span class="fw-bold <?= $bk['kategori'] == 'Buku Masuk' ? 'text-success' : 'text-danger'; ?>"><?= $bk['kategori']; ?></span></td>
                                                                    <td><span class="fw-normal"><?= $bk['keterangan']; ?></span></td>
                                                                    <td style="text-align: center;"><span class="fw-normal" style="text-align: left;"><?= $bk['jumlah']; ?></span></td>
                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-start border-top">
                                        <form action="" method="POST">
                                            <input type="hidden" name="id_laporan" value="<?= $p['id_laporan'] ?>">
                                            <button type="submit" class="btn btn-gray-800 d-inline-flex align-items-center me-2" name="cetak">
                                                <i class="bi bi-printer-fill text-gray-300 me-2"></i> Cetak Laporan <i class="bi bi-patch-check-fill text-success ms-2"></i>
                                            </button>
                                            <div class="col-12 d-grid gap-2 d-sm-none">
                                                <button type="submit" class="btn btn-gray-800 me-2 text-start" name="cetak" target="_blank">
                                                    <span class="fas fa-eye me-2"></span>Cetak Laporan<span class="fas fa-check-circle ms-3 text-success"></span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Hapus -->
                        <div class="modal fade" id="delete<?= $idb; ?>" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="h6 modal-title">Formulir Hapus Data Laporan</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="modal-body">
                                            <p>Judul Laporan : <?php echo $p['judul_laporan']?></p>
                                            <p>Apakah Anda yakin ingin menghapus daftar laporan ini?</p>
                                            <input type="hidden" name="id_laporan" value="<?=$idb;?>">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-link text-gray-600" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-secondary" name="hapus">Hapus Data</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php } ?>
                </div>
                
            </div>
        </main>

        <!-- Script -->

        <script src="../vendor/@popperjs/core/dist/umd/popper.min.js"></script>
        <script src="../vendor/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Vendor JS -->
        <script src="../vendor/onscreen/dist/on-screen.umd.min.js"></script>

        <!-- Slider -->
        <script src="../vendor/nouislider/distribute/nouislider.min.js"></script>

        <!-- Smooth scroll -->
        <script src="../vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

        <!-- Charts -->
        <script src="../vendor/chartist/dist/chartist.min.js"></script>
        <script src="../vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>

        <!-- Datepicker -->
        <script src="../vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script>

        <!-- Moment JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>

        <!-- Vanilla JS Datepicker -->
        <script src="../vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script>

        <!-- Simplebar -->
        <script src="../vendor/simplebar/dist/simplebar.min.js"></script>

        <!-- Volt JS -->
        <script src="../assets/js/volt.js"></script>
        
    </body>

</html>