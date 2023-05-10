<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$id_punishment = $_GET['id_punishment'];

	$id_punishment = mysqli_query($koneksi, "DELETE FROM punishment WHERE id_punishment = '$id_punishment'");

	if ($id_punishment) {
		echo "
			<script>
				alert('Punishment berhasil dihapus!')
				window.location.href='punishment.php'
			</script>
		";
		exit;
	} else {
		echo "
			<script>
				alert('Punishment gagal dihapus!')
				window.history.back()
			</script>
		";
		exit;
	}
?>