<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
	
	$karyawan = mysqli_query($koneksi, "SELECT * FROM karyawan ORDER BY nama_karyawan ASC");
	$reward = mysqli_query($koneksi, "SELECT * FROM reward INNER JOIN karyawan ON reward.id_karyawan = karyawan.id_karyawan ORDER BY tanggal_reward DESC");
	$punishment = mysqli_query($koneksi, "SELECT * FROM punishment INNER JOIN karyawan ON punishment.id_karyawan = karyawan.id_karyawan ORDER BY tanggal_punishment DESC");

?>

<html>
<head>
	<?php include_once 'head.php'; ?>
	<title>Dashboard</title>
</head>
<body>
	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<h1>Dashboard</h1>
		<div class="card-container">
		  <a href="karyawan.php" class="card">
		  	<h4>Jumlah Karyawan</h4>
		  	<h3><?= mysqli_num_rows($karyawan); ?></h3>
		  </a>
		  <a href="reward.php" class="card">
		  	<h4>Jumlah Reward</h4>
		  	<h3><?= mysqli_num_rows($reward); ?></h3>
		  </a>
		  <a href="punishment.php" class="card">
		  	<h4>Jumlah Punishment</h4>
		  	<h3><?= mysqli_num_rows($punishment); ?></h3>
		  </a>
		</div>

	</div>

	<script src="script.js"></script>
</body>
</html>