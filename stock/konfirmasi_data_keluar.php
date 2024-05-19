<?php
  include '../dbconnect.php';
  $id_barang = $_POST['id_barang']; //id barang
  $qty = $_POST['jumlah'];
  $tanggal = (new \DateTime())->format('Y-m-d');
  $penerima = $_POST['penerima'];
  $ket = $_POST['keterangan'];

  $dt = mysqli_query($conn, "SELECT * FROM tb_barang WHERE id_barang = '$id_barang'");
  $data = mysqli_fetch_array($dt);
  $sisa = $data['stock'] - $qty;

  $query1 = mysqli_query($conn, "UPDATE tb_barang SET stock='$sisa' WHERE id_barang = '$id_barang'");
  $query2 = mysqli_query($conn, "INSERT INTO tb_barang_keluar(id_barang, tanggal, jumlah, penerima, keterangan) VALUES('$id_barang','$tanggal','$qty','$penerima','$ket')");

  if ($query1 && $query2) {
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

  header("Location: data_keluar.php?notification=$encodedNotification");
  exit();
?>