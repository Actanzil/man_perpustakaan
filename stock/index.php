<?php
    include '../dbconnect.php';
    include 'cek.php';
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
                            <span class="mt-1 ms-1 sidebar-text">Perpustakaan Admin</span>
                        </a>
                    </li>
                    <li class="nav-item active ">
                        <a href="index.php" class="nav-link">
                            <span class="sidebar-icon">
                                <i class="bi bi-grid-1x2-fill"></i>
                            </span> 
                            <span class="sidebar-text">Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="nav-item ">
                        <a href="page_buku.php" class="nav-link">
                            <span class="sidebar-icon">
                                <i class="bi bi-basket-fill"></i>
                            </span>
                            <span class="sidebar-text">Daftar Buku</span>
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
                            <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                    <h2 class="h4">Dashboard</h2>
                    <p class="mb-0">Your web analytics dashboard template.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-xl-8">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h2 class="fs-5 fw-bold mb-0">Data Transaksi Buku</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                        <tr>
                                            <th class="border-bottom" scope="col">Kode Buku</th>
                                            <th class="border-bottom" scope="col">Judul Buku</th>
                                            <th class="border-bottom" scope="col">Transaksi</th>
                                            <th class="border-bottom" scope="col">Kategori</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $query_brg = (" SELECT id_buku, kode_buku, judul_buku, tanggal_transaksi, kategori 
                                                                FROM (  SELECT b.id_buku, b.kode_buku, b.judul_buku, bm.tanggal as tanggal_transaksi, 'Masuk' as kategori
                                                                        FROM tb_buku b
                                                                        LEFT JOIN tb_buku_masuk bm ON b.id_buku = bm.id_buku
                                                                        WHERE bm.id_buku IS NOT NULL
                                                    
                                                                        UNION
                                                    
                                                                        SELECT b.id_buku, b.kode_buku, b.judul_buku, bk.tanggal as tanggal_transaksi, 'Keluar' as kategori
                                                                        FROM tb_buku b
                                                                        LEFT JOIN tb_buku_keluar bk ON b.id_buku = bk.id_buku
                                                                        WHERE bk.id_buku IS NOT NULL
                                                                    ) AS combined_data
                                                                ORDER BY tanggal_transaksi DESC, id_buku ASC;");
                                                $result_brg = mysqli_query($conn, $query_brg);
                                                while ($b = mysqli_fetch_array($result_brg)) {
                                                    $tanggal_format = date("d F Y", strtotime($b['tanggal_transaksi']));
                                                ?>
                                            <tr>
                                                <th class="text-gray-900" scope="row"><?php echo $b['kode_buku'] ?></th>
                                                <td class="fw-bolder text-gray-500"><?php echo $b['judul_buku'] ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <div class="col-12 px-0 mb-4">
                        <div class="card border-0 shadow">
                            <?php
                                // Menghitung total transaksi dari tabel tb_buku_masuk
                                $query_total_masuk = "SELECT SUM(jumlah) as total_masuk FROM tb_buku_masuk";
                                $result_total_masuk = $conn->query($query_total_masuk);
                                $row_total_masuk = $result_total_masuk->fetch_assoc();
                                $total_masuk = $row_total_masuk['total_masuk'];

                                // Menghitung total transaksi dari tabel tb_buku_keluar
                                $query_total_keluar = "SELECT SUM(jumlah) as total_keluar FROM tb_buku_keluar";
                                $result_total_keluar = $conn->query($query_total_keluar);
                                $row_total_keluar = $result_total_keluar->fetch_assoc();
                                $total_keluar = $row_total_keluar['total_keluar'];

                                // Mengambil data dari tabel tb_buku_masuk
                                $query_masuk = "SELECT MONTH(tanggal) as bulan, SUM(jumlah) as total_masuk FROM tb_buku_masuk GROUP BY MONTH(tanggal)";
                                $result_masuk = $conn->query($query_masuk);

                                // Mengambil data dari tabel tb_buku_keluar
                                $query_keluar = "SELECT MONTH(tanggal) as bulan, SUM(jumlah) as total_keluar FROM tb_buku_keluar GROUP BY MONTH(tanggal)";
                                $result_keluar = $conn->query($query_keluar);

                                // Menyusun data untuk digunakan dalam script ApexCharts
                                $data_masuk = [];
                                $data_keluar = [];
                                $bulan_label = [];

                                while ($row = $result_masuk->fetch_assoc()) {
                                    $data_masuk[] = $row['total_masuk'];
                                }

                                while ($row = $result_keluar->fetch_assoc()) {
                                    $data_keluar[] = $row['total_keluar'];
                                    $bulan_label[] = date("M", mktime(0, 0, 0, $row['bulan'], 1));
                                }

                            ?>
                            <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                                <div class="d-block">
                                    <div class="h6 fw-normal text-gray mb-2">Total Transaksi</div>
                                    <h2 class="h3 fw-extrabold"><?= $total_masuk + $total_keluar; ?></h2>
                                </div>
                                <div class="d-block ms-auto">
                                    <div class="d-flex align-items-center text-end mb-2">
                                        <span class="dot rounded-circle bg-info me-2"></span>
                                        <span class="fw-normal small">Data Masuk</span>
                                    </div>
                                    <div class="d-flex align-items-center text-end">
                                        <span class="dot rounded-circle bg-success me-2"></span>
                                        <span class="fw-normal small">Data Keluar</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <!-- Column Chart -->
                                <div id="columnChart"></div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#columnChart"), {
                                        series: [{
                                            name: 'Data Masuk',
                                            data: <?= json_encode($data_masuk); ?>
                                        }, {
                                            name: 'Data Keluar',
                                            data: <?= json_encode($data_keluar); ?>
                                        }],
                                        chart: {
                                            type: 'bar',
                                            height: 290
                                        },
                                        plotOptions: {
                                            bar: {
                                            horizontal: false,
                                            columnWidth: '55%',
                                            endingShape: 'rounded'
                                            },
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        stroke: {
                                            show: true,
                                            width: 2,
                                            colors: ['transparent']
                                        },
                                        xaxis: {
                                            categories: <?= json_encode($bulan_label); ?>
                                        },
                                        yaxis: {
                                            title: {
                                            text: 'Banyak Transaksi'
                                            }
                                        },
                                        fill: {
                                            opacity: 1
                                        },
                                        tooltip: {
                                            y: {
                                            formatter: function(val) {
                                                return val + " Data"
                                            }
                                            }
                                        }
                                        }).render();
                                    });
                                </script>
                                <!-- End Column Chart -->
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>

        </main>
        
        <!-- Core -->
        <script src="../vendor/apexcharts/apexcharts.min.js"></script>

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
