<?php

  include '../dbconnect.php';
  $nama = $_POST['nama'];
  $jenis = $_POST['jenis'];
  $ukuran = $_POST['ukuran'];
  $merk = $_POST['merk'];
  $satuan = $_POST['satuan'];
  $lokasi = $_POST['lokasi'];
  $stock = $_POST['stock'];
      
  $query = mysqli_query($conn,"INSERT INTO tb_barang (nama, jenis, merk, ukuran, satuan, lokasi, stock)VALUES('$nama','$jenis','$merk','$ukuran','$satuan','$lokasi','$stock')");
  
  if ($query){
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

  header("Location: page_barang.php?notification=$encodedNotification");
  exit();
?>