<?php

  include '../dbconnect.php';
  $foto = $_POST['foto'];
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $level = $_POST['level'];
  $user = mysqli_real_escape_string($conn, $username );
  $pass = mysqli_real_escape_string($conn, md5($password) );

  $lokasi_file = $_FILES['foto']['tmp_name'];
  $nama_file = $_FILES['foto']['name'];
  $direktori = 'assets/foto-user/'.$nama_file;
      
  if(move_uploaded_file($lokasi_file, $direktori)) {
    $query = mysqli_query($conn, "INSERT INTO user (`foto`, `nama`, `email`, `username`, `password`, `level`)
                                  VALUES('$nama_file','$nama','$email','$user','$pass','$level')");
    
    if ($query) {
        $notificationType = "success";
        $notificationCaption = "Selamat !!!";
        $notificationMessage = "Data berhasil ditambahkan!";
    } else { 
        $notificationType = "warning";
        $notificationCaption = "Mohon maaf !!!";
        $notificationMessage = "Gagal Menambahkan data!";
    }
} else {
    $notificationType = "warning";
    $notificationCaption = "Mohon maaf !!!";
    $notificationMessage = "Gagal mengunggah foto!";
}

$notification = [
    'type' => $notificationType,
    'caption' => $notificationCaption,
    'message' => $notificationMessage
];

  // Convert array ke JSON dan encode untuk ditransfer melalui URL
  $encodedNotification = urlencode(json_encode($notification));

  header("Location: page_user.php?notification=$encodedNotification");
  exit();
?>