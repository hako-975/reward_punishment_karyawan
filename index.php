<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));


	if (isset($_POST['btnCari'])) {
		$cari = $_POST['cari'];
		$acara = mysqli_query($koneksi, "SELECT * FROM acara INNER JOIN user ON acara.id_user = user.id_user WHERE acara.id_user = '$id_user' 
	        AND user.id_user = '$id_user' 
	        AND (nama_acara LIKE '%$cari%' 
	        OR tanggal_acara LIKE '%$cari%'
	        OR tempat_acara LIKE '%$cari%')
			ORDER BY tanggal_acara ASC");
	}
?>

<html>
<head>
	<?php include_once 'head.php'; ?>
	<title>Dashboard</title>
</head>
<body>
	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<h1 class="float-left">Dashboard</h1>
	</div>

	<script src="script.js"></script>
</body>
</html>