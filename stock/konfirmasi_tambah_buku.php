<?php

  include '../dbconnect.php';
  $kd_buku = $_POST['kd_buku'];
  $judul = $_POST['judul'];
  $penulis = $_POST['penulis'];
  $penerbit = $_POST['penerbit'];
  $tahun = $_POST['tahun'];
  $stock = $_POST['stock'];
      
  $query = mysqli_query($conn," INSERT INTO tb_buku (kode_buku, judul_buku, penulis_buku, penerbit_buku, tahun_terbit, stock)
                                VALUES('$kd_buku','$judul','$penulis','$penerbit','$tahun','$stock')");
  
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

  header("Location: page_buku.php?notification=$encodedNotification");
  exit();
?>