<?php
  include '../dbconnect.php';
  $id_buku = $_POST['id_buku']; // id buku
  $id_user = $_POST['id_user']; // id user
  $qty = $_POST['jumlah'];
  $tanggal = (new \DateTime())->format('Y-m-d');
  $ket = $_POST['keterangan'];

  $dt = mysqli_query($conn, "SELECT * FROM tb_buku WHERE id_buku = '$id_buku'");
  $data = mysqli_fetch_array($dt);
  $sisa = $data['stock'] + $qty;

  $query1 = mysqli_query($conn, "UPDATE tb_buku SET stock='$sisa' WHERE id_buku = '$id_buku'");
  $query2 = mysqli_query($conn, "INSERT INTO tb_buku_masuk (id_buku, id_user, tanggal, jumlah, keterangan) VALUES('$id_buku','$id_user','$tanggal','$qty','$ket')");

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

  header("Location: data_masuk.php?notification=$encodedNotification");
  exit();

?>