<?php
    include '../dbconnect.php';
    include 'cek.php';
    include 'fungsi.php';
    // Periksa apakah ada parameter id_laporan yang dikirimkan melalui URL
    if(isset($_GET['id_laporan'])) {
        // Ambil nilai id_laporan dari URL
        $id_laporan = $_GET['id_laporan'];
        //get data laporan
        $sql_lp = " SELECT  `l`.`kode_laporan`,
                            `l`.`judul_laporan`,
                            CONCAT(SUBSTRING(bulan, 6, 2), '-', SUBSTRING(bulan, 1, 4)) AS formatted_bulan,
                            `l`.`keterangan`, 
                            DATE_FORMAT(`l`.`tanggal`,'%d-%m-%Y'), 
                            `u`.`nama`,
                            `u`.`email`
                    FROM `tb_laporan` `l`
                    INNER JOIN `user` `u` ON `l`.`id_user`=`u`.`id_user`
                    WHERE `l`.`id_laporan`='$id_laporan'";
        $query_lp = mysqli_query($conn,$sql_lp);
        while($data_lp = mysqli_fetch_row($query_lp)){
            $kode = $data_lp[0];
            $judul = $data_lp[1];
            $bulan = $data_lp[2];
            $keterangan = $data_lp[3];
            $tanggal = $data_lp[4];
            $nm_user = $data_lp[5];
            $email_user = $data_lp[6];
        }    
    } else {
        echo "Sistem tidak menerima data!";
    }
?>
<!DOCTYPE html>
<html lang="en">

    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- Primary Meta Tags -->
        <title>Perpustakaan - Admin</title>
        <meta name="viewport">
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

        <style>
            /* Aturan CSS untuk pencetakan */
            @media print {
                body {
                    display: block;
                    font-size: 12px;
                }

                #report {
                    margin: 0;
                    width: 100%;
                    overflow: visible;
                }

                .badge {
                    -webkit-print-color-adjust: exact;
                    color-adjust: exact;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                th, td {
                    padding: 4px;
                    border: 1px solid #ddd;   
                }

                .table-wrapper {
                    width: 100%;
                    overflow: visible;
                }

                .no-border th,
                .no-border td {
                    border: none;
                    padding: 2px;
                }
            }
        </style>

    </head>
    <body>
        <main>
            <section  id="report">
                <div class="row justify-content-center mt-2 mb-2">
                    <div class="col-12 col-xl-8">
                        <div class="card shadow border-0 p-4 p-md-5 position-relative">
                            <div class="d-flex justify-content-between pb-4 pb-md-5 mb-4 mb-md-5 border-bottom border-light">
                                <img class="image-fluid" src="https://i0.wp.com/sdgambiranomjogja.sch.id/wp-content/uploads/2017/06/sd-negeri-gambiranom-jogja-logo.png?fit=300%2C307&ssl=1" height="150" width="150" alt="Rocket Logo">
                                <div>
                                    <h4>SDN Kauman 1 Malang</h4>
                                    <ul class="list-group simple-list">
                                        <li class="list-group-item fw-normal">Jalan Kauman No.1, Kauman, Kec. Klojen, </li>
                                        <li class="list-group-item fw-normal">Malang, Jawa Timur</li>
                                        <li class="list-group-item fw-normal">
                                            <a class="fw-bold text-primary" href="#">https://sdnkauman1-malang.sch.id/</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="mb-4 d-flex align-items-center justify-content-center">
                                <h3 class="h3 mb-0">Laporan Manajemen Perpustakaan</h3>
                                <span class="badge badge-lg bg-success ms-4"># <?= BulanIndo($bulan); ?></span>
                            </div>
                            <div class="row justify-content-between mb-2 mb-md-2">
                                <div class="col-sm col-lg-4">
                                    <dl class="row text-sm-right">
                                        <dt class="col-4"><strong>Kode Surat </strong></dt>
                                        <dd class="col-8">: <b>LPRN//355/01/</b><?= $kode; ;?></dd>
                                        <dt class="col-4"><strong>Tanggal Terbit</strong></dt>
                                        <dd class="col-8">: <?= TanggalIndo($tanggal); ?></dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-wrapper">
                                        <table class="">
                                            <thead class="bg-light border-top">
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
                                                                        DATE_FORMAT(tanggal_transaksi_asli, '%Y-%m') IN (SELECT bulan FROM tb_laporan WHERE id_laporan = '$id_laporan')
                                                                    ORDER BY 
                                                                        tanggal_transaksi_asli ASC");
                                                    $result_bk = mysqli_query($conn, $query_bk);
                                                    $no = 1;
                                                    // Inisialisasi variabel untuk menghitung total
                                                    $banyak_buku = 0;
                                                    $jumlah_masuk = 0;
                                                    $jumlah_keluar = 0;

                                                    // Loop melalui hasil query untuk menghitung total
                                                    while ($bk = mysqli_fetch_assoc($result_bk)) {
                                                        $banyak_buku++;
                                                        if ($bk['kategori'] == 'Buku Masuk') {
                                                            $jumlah_masuk += $bk['jumlah'];
                                                        } else {
                                                            $jumlah_keluar += $bk['jumlah'];
                                                        }
                                                        
                                                ?>
                                                <tr>
                                                    <td><span class="fw-normal"><?= $no++ ?></span></td>
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
                                    <div class="d-flex justify-content-end text-right mb-2 py-2">
                                        <div class="mt-2">
                                            <table class="table table-clear no-border">
                                                <tbody>
                                                    <tr>
                                                        <td class="left">
                                                            <strong>Banyak Buku</strong>
                                                        </td>
                                                        <td class="right"><?= $banyak_buku; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="left">
                                                            <strong>Transaksi Masuk</strong>
                                                        </td>
                                                        <td class="right"><?= $jumlah_masuk; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="left">
                                                            <strong>Transaksi Keluar</strong>
                                                        </td>
                                                        <td class="right"><?= $jumlah_keluar; ?></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="left">
                                                            <strong>Total Transaksi</strong>
                                                        </td>
                                                        <td class="right">
                                                            <strong><?= $jumlah_masuk + $jumlah_keluar; ?></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <h5>Dikeluarkan oleh:</h5>
                                    <span><?= $email_user; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-2 mb-2">
                            <div class="col-12 col-xl-9">
                                <div class="card shadow border-0 p-4 p-md-5 position-relative">
                                    <button class="btn btn-lg btn-primary" type="button" onclick="printReport()">Cetak Laporan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
        </main>

        <!-- Script -->

        <script>
            function printReport() {
            print();
        }
        </script>

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