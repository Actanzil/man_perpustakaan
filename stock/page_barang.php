<?php
    include '../dbconnect.php';
    include 'cek.php';

    $notification = "";

    if(isset($_POST['update'])){
        $id_barang = $_POST['id_barang'];
        $nama = $_POST['nama'];
        $jenis = $_POST['jenis'];
        $merk = $_POST['merk'];
        $ukuran = $_POST['ukuran'];
        $satuan = $_POST['satuan'];
        $lokasi = $_POST['lokasi'];

        $updatedata = mysqli_query($conn,"UPDATE tb_barang SET nama='$nama', jenis='$jenis', merk='$merk', ukuran='$ukuran', satuan='$satuan', lokasi='$lokasi' WHERE id_barang='$id_barang'");
        
        switch ($updatedata) {
            case true:
                $caption = "Selamat !!!";
                $notification = "Data berhasil diperbarui!";
                $alertType = "success";
                break;
            default:
                $caption = "Mohon maaf !!!";
                $notification = "Gagal memperbarui data!";
                $alertType = "danger";
        }
    };

    if(isset($_POST['hapus'])){
        $id_barang = $_POST['id_barang'];

        $delete = mysqli_query($conn,"DELETE FROM tb_barang where id_barang='$id_barang'");
        //hapus juga semua data barang ini di tabel keluar-masuk
        $deltabelkeluar = mysqli_query($conn,"DELETE FROM tb_barang_keluar WHERE id_barang = '$id_barang'");
        $deltabelmasuk = mysqli_query($conn,"DELETE FROM tb_barang_masuk WHERE id_barang = '$id_barang'");
        
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
        <title>Pupuk - Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="title" content="Pupuk - Administrasi">

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
                            <img src="../assets/img/team/profile-picture-3.jpg" class="card-img-top rounded-circle border-white" alt="Bonnie Green">
                        </div>
                        <div class="d-block">
                        <h2 class="h5 mb-3">Hi, <?=$_SESSION['user'];?></h2>
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
                            <span class="mt-1 ms-1 sidebar-text">Pupuk Admin</span>
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
                        <a href="page_barang.php" class="nav-link">
                            <span class="sidebar-icon">
                                <i class="bi bi-basket-fill"></i>
                            </span>
                            <span class="sidebar-text">Persediaan Barang</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="data_masuk.php" class="nav-link">
                            <span class="sidebar-icon">
                                <i class="bi bi-cart-plus-fill"></i>
                            </span>
                            <span class="sidebar-text">Data Masuk</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="data_keluar.php" class="nav-link">
                            <span class="sidebar-icon">
                                <i class="bi bi-cart-dash-fill"></i>
                            </span>
                            <span class="sidebar-text">Data Keluar</span>
                        </a>
                    </li>
                    <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
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
                                        <img class="avatar rounded-circle" alt="Image placeholder" src="../assets/img/team/profile-picture-3.jpg">
                                        <div class="media-body ms-2 text-dark align-items-center d-none d-lg-block">
                                            <span class="mb-0 font-small fw-bold text-gray-900"><?=$_SESSION['user'];?></span>
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
                            <li class="breadcrumb-item active" aria-current="page">Persediaan Barang</li>
                        </ol>
                    </nav>
                    <h2 class="h4">Persediaan Barang</h2>
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
                                <h2 class="h6 modal-title">Formulir Tambah Data Barang</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="konfirmasi_tambah_barang.php" method="POST">
                                <div class="modal-body">
                                    <div class="mb-3 row">
                                        <label for="nama" class="col-sm-2 col-form-label">Nama Barang</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nama" name="nama" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="merk" class="col-sm-2 col-form-label">Merk Barang</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="merk" name="merk" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="jenis" class="col-sm-2 col-form-label">Jenis Barang</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" name="jenis" required>
                                                <option selected>Pilih Jenis</option>
                                                <option value="Organik">Organik</option>
                                                <option value="Anorganik">Anorganik</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="ukuran" class="col-sm-2 col-form-label">Ukuran</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="ukuran" name="ukuran" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" name="satuan" required>
                                                <option selected>Pilih Satuan</option>
                                                <option value="Kilogram">Kilogram</option>
                                                <option value="Kwintal">Kwintal</option>
                                                <option value="Ton">Ton</option>
                                                <option value="Mililiter">Mililiter</option>
                                                <option value="Liter">Liter</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" name="lokasi" required>
                                                <option selected>Pilih Lokasi</option>
                                                <option value="Gudang 1">Gudang 1</option>
                                                <option value="Gudang 2">Gudang 2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="stock" class="col-sm-2 col-form-label">Stock</label>
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
                            <form action="page_barang.php" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Masukkan kata kunci..." aria-label="Search" aria-describedby="basic-addon2" id="kata_kunci" name="katakunci" required>
                                    <button class="btn btn-primary" type="submit">Cari</button>
                                    <a href="page_barang.php" class="btn btn-secondary">
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
                                <meta http-equiv='refresh' content='2; url= page_barang.php'/> ";
                            }
                        ?>
                    </div>
                </div>
            </div>
            <!-- End Kolom Pencarian -->
            
            <div class="card card-body border-0 shadow table-wrapper table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0 rounded-start">#</th>
                            <th class="border-0">Nama Barang</th>
                            <th class="border-0">Merk</th>
                            <th class="border-0">Jenis</th>
                            <th class="border-0">Satuan</th>
                            <th class="border-0">Lokasi</th>
                            <th class="border-0">Stock</th>
                            <th class="border-0 rounded-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Item -->
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
                            
                            // Query untuk menampilkan semua data pada tabel tb_barang
                            $sql = "SELECT * FROM tb_barang";
                            
                            // Logika untuk pencarian
                            if (!empty($katakunci)) {
                                $sql .= " WHERE nama LIKE '%" . mysqli_real_escape_string($conn, $katakunci) . "%'";
                            }
                            
                            // Mengurutkan data berdasarkan nama dan membatasi data sesuai batasan yang telah ditentukan
                            $sql .= " ORDER BY nama ASC LIMIT $posisi, $batas";

                            $brgs = mysqli_query($conn, $sql);
                            $no = 1;
                            while($p=mysqli_fetch_array($brgs)){
                                $idb = $p['id_barang'];
                                ?>
                        <tr>
                            <td><a href="#" class="text-primary fw-bold"><?= $no++ ?></a> </td>
                            <td><?= $p['nama'] ?></td>
                            <td><?= $p['merk'] ?></td>
                            <td><?= $p['jenis'] ?></td>
                            <td><?= $p['satuan'] ?></td>
                            <td><?= $p['lokasi'] ?></td>
                            <td><?= $p['stock'] ?></td>
                            <td>
                                <div class="dropdown ms-3">
                                    <button type="button" class="btn btn-sm fs-6 px-1 py-0 dropdown-toggle" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg></button>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit<?= $idb; ?>"><svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg> Edit Data</a>
                                        <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete<?= $idb; ?>"><svg class="dropdown-icon text-danger me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> Hapus Data</a>
                                    </div>
                                </div>
                            </td>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="edit<?= $idb; ?>" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" >
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="h6 modal-title">Formulir Edit Data Barang</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="POST">
                                            <div class="modal-body">
                                                <div class="mb-3 row">
                                                    <label for="nama" class="col-sm-2 col-form-label">Nama Barang</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $p['nama'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="merk" class="col-sm-2 col-form-label">Merk Barang</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="merk" name="merk" value="<?php echo $p['merk'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="jenis" class="col-sm-2 col-form-label">Jenis Barang</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-select" aria-label="Default select example" name="jenis" required>
                                                            <option value="Organik" <?php if ($p['jenis']=="Organik") { ?> selected <?php } ?>>Organik</option>
                                                            <option value="Anorganik" <?php if ($p['jenis']=="Anorganik") { ?> selected <?php } ?>>Anorganik</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="ukuran" class="col-sm-2 col-form-label">Ukuran</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="ukuran" name="ukuran" value="<?php echo $p['ukuran'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-select" aria-label="Default select example" name="satuan" required>
                                                            <option value="Kilogram" <?php if ($p['satuan']=="Kilogram") { ?> selected <?php } ?>>Kilogram</option>
                                                            <option value="Kwintal" <?php if ($p['satuan']=="Kwintal") { ?> selected <?php } ?>>Kwintal</option>
                                                            <option value="Ton" <?php if ($p['satuan']=="Ton") { ?> selected <?php } ?>>Ton</option>
                                                            <option value="Mililiter" <?php if ($p['satuan']=="Mililiter") { ?> selected <?php } ?>>Mililiter</option>
                                                            <option value="Liter" <?php if ($p['satuan']=="Liter") { ?> selected <?php } ?>>Liter</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-select" aria-label="Default select example" name="lokasi" required>
                                                            <option value="Gudang 1" <?php if ($p['lokasi']=="Gudang 1") { ?> selected <?php } ?>>Gudang 1</option>
                                                            <option value="Gudang 2" <?php if ($p['lokasi']=="Gudang 2") { ?> selected <?php } ?>>Gudang 2</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="stock" class="col-sm-2 col-form-label">Stock</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" class="form-control" id="stock" value="<?php echo $p['stock'] ?>" disabled>
                                                        <input type="hidden" name="id_barang" value="<?= $idb; ?>">
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
                                            <h2 class="h6 modal-title">Formulir Hapus Data Barang</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="POST">
                                            <div class="modal-body">
                                                <p>Nama Barang : <?php echo $p['nama']?> - <?php echo $p['jenis']?></p>
                                                <p>Apakah Anda yakin ingin menghapus barang ini dari daftar persediaan barang?</p>
                                                <input type="hidden" name="id_barang" value="<?=$idb;?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-link text-gray-600" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-secondary" name="hapus">Hapus Data</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination mb-0">
                            <?php
                                //hitung jumlah semua data
                                $sql_jum = "SELECT * FROM tb_barang";
                                if (!empty($katakunci)){
                                    $sql_jum .= " WHERE nama LIKE '%" . mysqli_real_escape_string($conn, $katakunci) . "%'";
                                }
                                $sql_jum .= " ORDER BY nama ASC";
                                $query_jum = mysqli_query($conn,$sql_jum);
                                $jum_data = mysqli_num_rows($query_jum);
                                $jum_halaman = ceil($jum_data/$batas);
                                
                                if($jum_halaman==0){
                                    //tidak ada halaman
                                } else if($jum_halaman==1){
                                    echo "<li class='page-item active'><a class='page-link'>1</a></li>";
                                } else {
                                    $sebelum = $halaman-1;
                                    $setelah = $halaman+1;
                                    if($halaman!=1){
                                        echo "<li class='page-item'><a class='page-link' href='page_barang.php?halaman=$sebelum'><i class='bi bi-chevron-left'></i></a></li>";
                                    }
                                    for($i=1; $i<=$jum_halaman; $i++){
                                        if ($i > $halaman - 5 and $i < $halaman + 5 ) {
                                            if($i!=$halaman){
                                                echo "<li class='page-item'><a class='page-link' href='page_barang.php?halaman=$i'>$i</a></li>";
                                            } else {
                                                echo "<li class='page-item active'><a class='page-link'>$i</a></li>";
                                        }
                                        }
                                    }
                                    if($halaman!=$jum_halaman){
                                        echo "<li class='page-item'><a class='page-link' href='page_barang.php?halaman=$setelah'><i class='bi bi-chevron-right'></i></a></li>";
                                    }
                                }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </main>

        <!-- Script -->
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
