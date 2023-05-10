<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$id_karyawan = $_GET['id_karyawan'];

	$id_karyawan = mysqli_query($koneksi, "DELETE FROM karyawan WHERE id_karyawan = '$id_karyawan'");

	if ($id_karyawan) {
		echo "
			<script>
				alert('Karyawan berhasil dihapus!')
				window.location.href='karyawan.php'
			</script>
		";
		exit;
	} else {
		echo "
			<script>
				alert('Karyawan gagal dihapus!')
				window.history.back()
			</script>
		";
		exit;
	}
?>