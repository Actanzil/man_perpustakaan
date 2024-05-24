<?php
  include '../dbconnect.php';

  $id_user = $_POST['id_user'];
  $kode = $_POST['kode'];
  $judul = $_POST['judul'];
  $month = $_POST['bulan'];
  $year = $_POST['tahun'];

  // Format bulan dan tahun menjadi 'yy-mm'
  $bulan = sprintf("%02d-%02d", $year, $month);

  // Buat objek DateTime dan format sesuai 'yyyy-mm-dd'
  $tanggal = (new DateTime())->format('Y-m-d');

  $keterangan = $_POST['keterangan'];

  $query = mysqli_query($conn, "INSERT INTO tb_laporan (tanggal, kode_laporan, judul_laporan, bulan, keterangan, id_user) 
                                  VALUES ('$tanggal', '$kode', '$judul', '$bulan', '$keterangan', '$id_user');");
  if ($query) {
      // notifikasi
      $notificationType = "success";
      $notificationCaption = "Selamat !!!";
      $notificationMessage = "Data berhasil ditambahkan!";
  } else {
      // notifikasi
      $notificationType = "warning";
      $notificationCaption = "Mohon maaf !!!";
      $notificationMessage = "Gagal Menambahkan data!";
  }

  // Set notifikasi dalam format array
  $notification = [
      'type' => $notificationType,
      'caption' => $notificationCaption,
      'message' => $notificationMessage
  ];

  // Convert array ke JSON dan encode untuk ditransfer melalui URL
  $encodedNotification = urlencode(json_encode($notification));

  header("Location: page_laporan.php?notification=$encodedNotification");
  exit();
?>
