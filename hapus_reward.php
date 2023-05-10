<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$id_reward = $_GET['id_reward'];

	$id_reward = mysqli_query($koneksi, "DELETE FROM reward WHERE id_reward = '$id_reward'");

	if ($id_reward) {
		echo "
			<script>
				alert('Reward berhasil dihapus!')
				window.location.href='reward.php'
			</script>
		";
		exit;
	} else {
		echo "
			<script>
				alert('Reward gagal dihapus!')
				window.history.back()
			</script>
		";
		exit;
	}
?>