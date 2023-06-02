<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<html>
<head>
	<?php include_once 'head.php'; ?>
	<title>Profile - <?= $data_user['username']; ?></title>
</head>
<body>
	<div class="container anti-navbar">
		<h1>Profile - <?= $data_user['username']; ?></h1>
        <table cellpadding="10" class="table-profile">
        	<tr>
        		<th>Username:</th>
        		<td><?= $data_user['username']; ?></td>
        	</tr>
        	<tr>
        		<th>Nama Lengkap:</th>
        		<td><?= $data_user['nama_lengkap']; ?></td>
        	</tr>
        </table>
        <a href="ubah_profile.php" class="button">Ubah Profile</a>
        <a href="ubah_password.php" class="button">Ubah Password</a>
	</div>
	<?php include_once 'navbar.php'; ?>

	<script src="script.js"></script>
</body>
</html>