<!-- cek apakah sudah login -->
<?php 
	session_start();
	if($_SESSION['level']!="admin"){
		header("location:../index.php?pesan=belum_login");
	}
	
?>