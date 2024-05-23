<?php
    include '../dbconnect.php';
    include 'cek.php';

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

    $notification = "";

    if(isset($_POST['update'])){
        include '../dbconnect.php';
    
        $id_buku = $_POST['id_buku'];
        $kd_buku = $_POST['kd_buku'];
        $judul = $_POST['judul'];
        $penulis = $_POST['penulis'];
        $penerbit = $_POST['penerbit'];
        $tahun = $_POST['tahun'];
        $tags = $_POST['tags']; // Ambil array dari tag yang dipilih
        
        // Handle file upload
        $gambar = $_FILES['gambar']['name'];
        $lokasi_file = $_FILES['gambar']['tmp_name'];
        $direktori = 'assets/gambar-buku/'.$gambar;
    
        // Default query
        $query = "UPDATE tb_buku SET kode_buku='$kd_buku', judul_buku='$judul', penulis_buku='$penulis', penerbit_buku='$penerbit', tahun_terbit='$tahun'";
        
        // Jika file gambar diunggah, hapus gambar lama dan tambahkan gambar baru ke direktori
        if (!empty($gambar)) {
            // Ambil nama gambar lama
            $query_gambar_lama = mysqli_query($conn, "SELECT gambar FROM tb_buku WHERE id_buku='$id_buku'");
            $data_gambar_lama = mysqli_fetch_assoc($query_gambar_lama);
            $nama_gambar_lama = $data_gambar_lama['gambar'];
    
            // Hapus gambar lama dari direktori jika ada
            if (!empty($nama_gambar_lama) && file_exists('assets/gambar-buku/'.$nama_gambar_lama)) {
                unlink('assets/gambar-buku/'.$nama_gambar_lama);
            }
    
            // Pindahkan gambar baru ke direktori
            if (move_uploaded_file($lokasi_file, $direktori)) {
                $query .= ", gambar='$gambar'";
            } else {
                $caption = "Mohon maaf !!!";
                $notification = "Gagal mengunggah gambar!";
                $alertType = "danger";
                $notification = [
                    'type' => $alertType,
                    'caption' => $caption,
                    'message' => $notification
                ];
                $encodedNotification = urlencode(json_encode($notification));
                header("Location: page_buku.php?notification=$encodedNotification");
                exit();
            }
        }
        
        // Lengkapi query dengan klausa WHERE
        $query .= " WHERE id_buku='$id_buku'";
        
        // Jalankan query
        $updatedata = mysqli_query($conn, $query);
    
        // Hapus semua tag buku lama
        $delete_old_tags = mysqli_query($conn, "DELETE FROM tb_tag_buku WHERE id_buku='$id_buku'");
    
        // Tambahkan tag baru
        foreach ($tags as $tag_id) {
            $add_tag = mysqli_query($conn, "INSERT INTO tb_tag_buku (id_buku, id_tag) VALUES ('$id_buku', '$tag_id')");
        }
    
        // Cek hasil query
        if ($updatedata && $delete_old_tags && $add_tag) {
            $caption = "Selamat !!!";
            $notification = "Data berhasil diperbarui!";
            $alertType = "success";
        } else {
            $caption = "Mohon maaf !!!";
            $notification = "Gagal memperbarui data!";
            $alertType = "danger";
        }
    };

    if(isset($_POST['hapus'])){
        $id_buku = $_POST['id_buku'];

        // Ambil nama gambar buku dari basis data
        $query_gambar = mysqli_query($conn, "SELECT gambar FROM tb_buku WHERE id_buku='$id_buku'");
        $data_gambar = mysqli_fetch_assoc($query_gambar);
        $nama_gambar = $data_gambar['gambar'];

        // Hapus gambar dari direktori jika gambar ada
        if(!empty($nama_gambar)) {
            $path_to_file = 'assets/gambar-buku/' . $nama_gambar;
            if(file_exists($path_to_file)) {
                unlink($path_to_file);
            }
        }

        $delete = mysqli_query($conn,"DELETE FROM tb_buku where id_buku='$id_buku'");
        //hapus juga semua data buku ini di tabel keluar-masuk
        $deltabelkeluar = mysqli_query($conn,"DELETE FROM tb_buku_keluar WHERE id_buku = '$id_buku'");
        $deltabelmasuk = mysqli_query($conn,"DELETE FROM tb_buku_masuk WHERE id_buku = '$id_buku'");
        
        //cek apakah berhasil
        switch ($delete && $deltabelkeluar && $deltabelmasuk) {
            case true:
                $caption = "Peringatan !!!";
                $notification = "Data berhasil dihapus!";
                $alertType = "warning";
                break;
            default:
                $caption = "Mohon maaf !!!";
                $notification = "Gagal menghapus data!";
                $alertType = "danger";
        }
    };
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
        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/css/multi-select-tag.css">
        <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/js/multi-select-tag.js"></script>

        <!-- Volt CSS -->
        <link type="text/css" href="../css/volt.css" rel="stylesheet">

        
    </head>

    <body>
        <nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
            <a class="navbar-brand me-lg-5" href="index.html">
                <img class="navbar-brand-dark" src="../assets/img/brand/light.svg" alt="Volt logo" /> <img class="navbar-brand-light" src="../assets/img/brand/dark.svg" alt="Volt logo" />
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
                            <img src="assets/foto-user/<?= $foto; ?>" class="card-img-top rounded-circle border-white" alt="Bonnie Green">
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
                    
                    <li class="nav-item active ">
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
                        <li class="nav-item ">
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
                        <li class="nav-item ">
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
                            <li class="breadcrumb-item active" aria-current="page">Daftar Buku</li>
                        </ol>
                    </nav>
                    <h2 class="h4">Daftar Buku</h2>
                    <p class="mb-0">Your web analytics dashboard template.</p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="#" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-default">
                        <i class="bi bi-plus-lg me-2"></i>
                        Tambah Data
                    </a>
                </div>
                <div class="modal fade" id="modal-default" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" >
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="h6 modal-title">Formulir Tambah Data Buku</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="konfirmasi_tambah_buku.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="mb-3 row">
                                        <label for="gambar" class="col-sm-2 col-form-label">Gambar Buku</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="file" id="formFile" name="gambar" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="kd_buku" class="col-sm-2 col-form-label">Kode Buku</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="kd_buku" name="kd_buku" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="judul" class="col-sm-2 col-form-label">Judul Buku</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="judul" name="judul" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="penulis" class="col-sm-2 col-form-label">Penulis Buku</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="penulis" name="penulis" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="penerbit" class="col-sm-2 col-form-label">Penerbit Buku</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" name="penerbit" required>
                                                <option selected>Pilih Penerbit</option>
                                                <option value="Gramedia">Gramedia</option>
                                                <option value="Togamas">Togamas</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="ukuran" class="col-sm-2 col-form-label">Tahun Terbit</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="tahun" name="tahun" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="tag" class="col-sm-2 col-form-label">Tag Buku</label>
                                        <div class="col-sm-10">
                                            <select name="tags[]" id="tags" multiple>
                                                <?php
                                                    $sql_tg = " SELECT `id_tag`, `nama_tag` 
                                                                FROM `tb_tag` 
                                                                ORDER BY `nama_tag`";
                                                    $query_tg = mysqli_query($conn, $sql_tg);
                                                    while($data_tg = mysqli_fetch_row($query_tg)){
                                                        $id_tag = $data_tg[0];
                                                        $nama = $data_tg[1];
                                                ?>
                                                <option value="<?= $id_tag; ?>"><?= $nama; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="ukuran" class="col-sm-2 col-form-label">Jumlah Persediaan</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="stock" name="stock" required>
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
                            <form action="page_buku.php" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Masukkan kata kunci..." aria-label="Search" aria-describedby="basic-addon2" id="kata_kunci" name="katakunci" required>
                                    <button class="btn btn-primary" type="submit">Cari</button>
                                    <a href="page_buku.php" class="btn btn-secondary">
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
                                <meta http-equiv='refresh' content='2; url= page_buku.php'/> ";
                            }
                        ?>
                    </div>
                </div>
            </div>
            <!-- End Kolom Pencarian -->
            
            <div class="task-wrapper border bg-white shadow border-0 rounded">
                <!-- Item -->
                <?php
                    // Limit untuk membatasi jumlah data pada satu halaman
                    $batas = 3;
                    if(!isset($_GET['halaman'])){
                        $posisi = 0;
                        $halaman = 1;
                    }else{
                        $halaman = $_GET['halaman'];
                        $posisi = ($halaman-1) * $batas;
                    }

                    // Inisialisasi katakunci pencarian
                    $katakunci = isset($_GET['katakunci']) ? $_GET['katakunci'] : '';

                    // Query untuk menghitung jumlah total data
                    $sql_jum = "SELECT COUNT(*) AS total FROM tb_buku";
                    if (!empty($katakunci)) {
                        $sql_jum .= " WHERE judul_buku LIKE '%" . mysqli_real_escape_string($conn, $katakunci) . "%'";
                    }
                    $query_jum = mysqli_query($conn, $sql_jum);
                    $data_jum = mysqli_fetch_assoc($query_jum);
                    $jum_data = $data_jum['total'];
                    $jum_halaman = ceil($jum_data / $batas);
                    
                    // Query untuk menampilkan semua data pada tabel tb_buku
                    $sql = "SELECT b.*, GROUP_CONCAT(t.nama_tag SEPARATOR ', ') AS tags,
                                    YEAR(b.tahun_terbit) AS tahun 
                            FROM tb_buku b 
                            LEFT JOIN tb_tag_buku tb ON b.id_buku = tb.id_buku 
                            LEFT JOIN tb_tag t ON tb.id_tag = t.id_tag
                            ";
                    
                    // Logika untuk pencarian
                    if (!empty($katakunci)) {
                        $sql .= " WHERE b.judul_buku LIKE '%" . mysqli_real_escape_string($conn, $katakunci) . "%'";
                    }
                    
                    $sql .= " GROUP BY b.id_buku";
                    
                    // Mengurutkan data berdasarkan nama dan membatasi data sesuai batasan yang telah ditentukan
                    $sql .= " ORDER BY b.judul_buku ASC LIMIT $posisi, $batas";

                    $brgs = mysqli_query($conn, $sql);
                    // Hitung jumlah data yang ditampilkan di halaman saat ini
                    $showing_data = mysqli_num_rows($brgs);

                    while($p=mysqli_fetch_array($brgs)){
                        $idb = $p['id_buku'];
                    ?>
                    <div class="card hover-state border-bottom rounded-0 rounded-top py-3">
                        <div class="card-body d-sm-flex align-items-center flex-wrap flex-lg-nowrap py-0">
                            <div class="col-1 text-left text-sm-center mb-2 mb-sm-0">
                                <div class="image-book me-sm-4">
                                    <img src="assets/gambar-buku/<?= $p['gambar'] ?>" alt="">
                                </div>    
                            </div> 
                            <div class="col-11 col-lg-8 px-0 mb-4 mb-md-0">
                                <div class="mb-2">
                                    <h3 class="h5"><?= $p['kode_buku'] ?> - <?= $p['judul_buku'] ?></h3>
                                    <div class="d-block d-sm-flex">
                                        <div>
                                            <h4 class="h6 fw-normal text-gray mb-3 mb-sm-0"><i class="bi bi-person-lines-fill text-gray-500 me-1"></i> <?= $p['penulis_buku'] ?> - <?= $p['tahun'] ?></h4>
                                        </div>
                                        <div class="ms-sm-3">
                                            <h4 class="h6 fw-normal text-danger mb-3 mb-sm-0"><i class="bi bi-bookmark-heart-fill text-danger-500 me-1"></i> <b><?= $p['stock'] ?></b></h4>
                                        </div>
                                        <div class="ms-sm-3">
                                            <?php
                                                $penerbitClass = '';
                                                if ($p['penerbit_buku'] == 'Gramedia') {
                                                    $penerbitClass = 'bg-success'; // Warna untuk Gramedia
                                                } elseif ($p['penerbit_buku'] == 'Togamas') {
                                                    $penerbitClass = 'bg-warning'; // Warna untuk Togamas
                                                } else {
                                                    $penerbitClass = 'bg-secondary'; // Warna default jika penerbit tidak dikenali
                                                }
                                            ?>
                                            <span class="badge super-badge <?= $penerbitClass ?>"><?= $p['penerbit_buku'] ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span class="fw-normal text-gray"><?= $p['tags'] ?></span>
                                </div>
                            </div>
                            <div class="col-10 col-sm-2 col-lg-2 col-xl-2 d-none d-lg-block d-xl-inline-flex align-items-center ms-lg-auto text-right justify-content-end px-md-0">
                                <div class="dropdown">
                                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg class="icon icon-xs" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg><span class="visually-hidden">Toggle Dropdown</span></button>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit<?= $idb; ?>">
                                            <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg> 
                                            Edit Data
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete<?= $idb; ?>">
                                            <svg class="dropdown-icon text-danger me-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> 
                                            Hapus Data
                                        </a>
                                    </div>
                                </div>
                                <!-- Modal Edit -->
                                <div class="modal fade" id="edit<?= $idb; ?>" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" >
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="h6 modal-title">Formulir Edit Data Buku</h2>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="mb-3 row">
                                                        <label for="gambar" class="col-sm-2 col-form-label">Gambar Buku</label>
                                                        <div class="col-sm-10 d-flex align-items-center">
                                                            <div class="me-3">
                                                                <img class="rounded avatar-xl" src="assets/gambar-buku/<?= $p['gambar'] ?>" alt="Gambar Buku <?php echo $p['judul_buku'] ?>">
                                                            </div>
                                                            <div class="">
                                                                <div class="d-flex justify-content-xl-center ms-xl-3">
                                                                    <div class="d-flex">
                                                                        <input class="form-control" type="file" id="formFile" name="gambar"><br>
                                                                        <span class="text-danger" style="font-weight:lighter;font-size:12px">*Jangan diisi jika tidak ingin mengubah gambar</span>
                                                                    </div>
                                                                </div>
                                                            </div>     
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="kd_buku" class="col-sm-2 col-form-label">Kode Buku</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="kd_buku" name="kd_buku" value="<?php echo $p['kode_buku'] ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="judul" class="col-sm-2 col-form-label">Judul Buku</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $p['judul_buku'] ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="penulis" class="col-sm-2 col-form-label">Penulis Buku</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="penulis" name="penulis" value="<?php echo $p['penulis_buku'] ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="penerbit" class="col-sm-2 col-form-label">Penerbit Buku</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-select" aria-label="Default select example" name="penerbit" required>
                                                                <option value="Gramedia" <?php if ($p['penerbit_buku']=="Gramedia") { ?> selected <?php } ?>>Gramedia</option>
                                                                <option value="Togamas" <?php if ($p['penerbit_buku']=="Togamas") { ?> selected <?php } ?>>Togamas</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="tahun" class="col-sm-2 col-form-label">Tahun Terbit</label>
                                                        <div class="col-sm-10">
                                                            <input type="date" class="form-control" id="tahun" name="tahun" value="<?php echo $p['tahun_terbit'] ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="tag" class="col-sm-2 col-form-label">Tag Buku</label>
                                                        <div class="col-sm-10">
                                                            <select name="tags[]" multiple>
                                                                <?php
                                                                    // Query untuk mendapatkan detail buku
                                                                    $sql_buku = "SELECT * FROM tb_buku WHERE id_buku = '$idb'";
                                                                    $query_buku = mysqli_query($conn, $sql_buku);
                                                                    $p = mysqli_fetch_assoc($query_buku);
                    
                                                                    // Query untuk mendapatkan tag yang terkait dengan buku ini
                                                                    $sql_tags_selected = "SELECT id_tag FROM tb_tag_buku WHERE id_buku = '$idb'";
                                                                    $query_tags_selected = mysqli_query($conn, $sql_tags_selected);
                                                                    $selected_tags = [];
                                                                    while ($row = mysqli_fetch_assoc($query_tags_selected)) {
                                                                        $selected_tags[] = $row['id_tag'];
                                                                    }
                                                                    $sql_tg = "SELECT `id_tag`, `nama_tag` FROM `tb_tag` ORDER BY `nama_tag`";
                                                                    $query_tg = mysqli_query($conn, $sql_tg);
                                                                    while($data_tg = mysqli_fetch_row($query_tg)){
                                                                        $id_tag = $data_tg[0];
                                                                        $nama = $data_tg[1];
                                                                        $selected = in_array($id_tag, $selected_tags) ? 'selected' : ''; // Memeriksa apakah tag ini sudah dipilih sebelumnya
                                                                ?>
                                                                <option value="<?= $id_tag; ?>" <?= $selected; ?>><?= $nama; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 row">
                                                        <label for="stock" class="col-sm-2 col-form-label">Stock</label>
                                                        <div class="col-sm-10">
                                                            <input type="number" class="form-control" id="stock" value="<?php echo $p['stock'] ?>" disabled>
                                                            <input type="hidden" name="id_buku" value="<?= $idb; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-link text-gray-600" data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-secondary" name="update">Ubah Data</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="delete<?= $idb; ?>" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="h6 modal-title">Formulir Hapus Data Buku</h2>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="" method="POST">
                                                <div class="modal-body">
                                                    <p>Judul Buku : <?php echo $p['judul_buku']?></p>
                                                    <p>Apakah Anda yakin ingin menghapus buku ini dari daftar buku?</p>
                                                    <input type="hidden" name="id_buku" value="<?=$idb;?>">
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
                        </div>
                    </div>
                <?php } ?>
                <div class="row p-4">
                    <!-- Pagination -->
                    <div class="col-7 mt-1">Showing <b><?php echo $showing_data; ?></b> out of <b><?php echo $jum_data; ?></b> entries</div> <!-- Bagian Ini -->
                    <div class="col-5">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination mb-0 float-end">
                                <?php
                                if ($jum_halaman == 0) {
                                    // tidak ada halaman
                                } else if ($jum_halaman == 1) {
                                    echo "<li class='page-item active'><a class='page-link'>1</a></li>";
                                } else {
                                    $sebelum = $halaman - 1;
                                    $setelah = $halaman + 1;
                                    if ($halaman != 1) {
                                        echo "<li class='page-item'><a class='page-link' href='page_buku.php?halaman=$sebelum'><i class='bi bi-chevron-left'></i></a></li>";
                                    }
                                    for ($i = 1; $i <= $jum_halaman; $i++) {
                                        if ($i > $halaman - 5 and $i < $halaman + 5) {
                                            if ($i != $halaman) {
                                                echo "<li class='page-item'><a class='page-link' href='page_buku.php?halaman=$i'>$i</a></li>";
                                            } else {
                                                echo "<li class='page-item active'><a class='page-link'>$i</a></li>";
                                            }
                                        }
                                    }
                                    if ($halaman != $jum_halaman) {
                                        echo "<li class='page-item'><a class='page-link' href='page_buku.php?halaman=$setelah'><i class='bi bi-chevron-right'></i></a></li>";
                                    }
                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </main>

        <!-- Script -->
        <!-- Main -->
        
        <script>
            new MultiSelectTag('tags', {
                rounded: true,
                shadow: true,
                placeholder: 'Search',
                tagColor: {
                    textColor: '#ffffff',
                    borderColor: '#92e681',
                    bgColor: '#eaffe6',
                },
                onChange: function(values) {
                    console.log(values)
                }
            })  
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
    // Ambil semua elemen <select> di dalam modal
    var selectElements = document.querySelectorAll('.modal select');
    
    // Iterasi melalui setiap elemen <select> dan cek apakah memiliki atribut 'multiple'
    selectElements.forEach(function(element) {
        if (element.multiple) {
            // Jika memiliki atribut 'multiple', inisialisasi perilaku multi-select
            new MultiSelectTag(element, {
                rounded: true,
                shadow: true,
                placeholder: 'Search',
                tagColor: {
                    textColor: '#ffffff',
                    borderColor: '#92e681',
                    bgColor: '#eaffe6',
                },
                onChange: function(values) {
                    console.log(values)
                }
            });
        }
    });
});


        </script>

        <!-- Core -->
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
