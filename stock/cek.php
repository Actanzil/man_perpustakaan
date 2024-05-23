<!-- cek apakah sudah login -->
<?php 
	session_start();
	if (!isset($_SESSION['level'])) {
		header("location:../index.php?pesan=belum_login");
		exit();
	}

	if ($_SESSION['level'] != "Admin" && $_SESSION['level'] != "Superadmin") {
		header("location:../index.php?pesan=noaccess");
		exit();
	}
?>
