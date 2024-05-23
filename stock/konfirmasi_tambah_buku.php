<?php
  include '../dbconnect.php';

  $kd_buku = $_POST['kd_buku'];
  $judul = $_POST['judul'];
  $penulis = $_POST['penulis'];
  $penerbit = $_POST['penerbit'];
  $tahun = $_POST['tahun'];
  $stock = $_POST['stock'];
  $tags = $_POST['tags']; // Array tag yang dipilih

  // Proses unggah gambar
  $nama_file = $_FILES['gambar']['name'];
  $lokasi_file = $_FILES['gambar']['tmp_name'];
  $direktori = 'assets/gambar-buku/'.$nama_file;

  if (move_uploaded_file($lokasi_file, $direktori)) {
      
    $query = mysqli_query($conn, "INSERT INTO tb_buku (`gambar`, `kode_buku`, `judul_buku`, `penulis_buku`, `penerbit_buku`, `tahun_terbit`, `stock`) VALUES ('$nama_file', '$kd_buku', '$judul', '$penulis', '$penerbit', '$tahun', '$stock')");

    if ($query) {
      $id_buku = mysqli_insert_id($conn); // Ambil id_buku yang baru saja ditambahkan

      // Insert tag ke tabel tb_tag_buku
      if (!empty($tags)) {
        foreach ($tags as $id_tag) {
          $tag_query = mysqli_query($conn, "INSERT INTO tb_tag_buku (id_buku, id_tag) VALUES ('$id_buku', '$id_tag')");
          if (!$tag_query) {
            // Jika terjadi kesalahan saat menyimpan tag, tampilkan notifikasi
            $notificationType = "warning";
            $notificationCaption = "Mohon maaf !!!";
            $notificationMessage = "Gagal Menyimpan Tag!";
            $notification = [
                'type' => $notificationType,
                'caption' => $notificationCaption,
                'message' => $notificationMessage
            ];
            $encodedNotification = urlencode(json_encode($notification));
            header("Location: page_buku.php?notification=$encodedNotification");
            exit();
          }
        }
      }

      // notifikasi berhasil
      $notificationType = "success";
      $notificationCaption = "Selamat !!!";
      $notificationMessage = "Data berhasil ditambahkan!";
    } else {
      // notifikasi gagal
      $notificationType = "warning";
      $notificationCaption = "Mohon maaf !!!";
      $notificationMessage = "Gagal Menambahkan data!";
    }
  } else {
    // Jika gagal mengunggah gambar, tampilkan notifikasi
    $notificationType = "warning";
    $notificationCaption = "Mohon maaf !!!";
    $notificationMessage = "Gagal mengunggah gambar!";
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
