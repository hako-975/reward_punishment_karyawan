<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$karyawan = mysqli_query($koneksi, "SELECT * FROM karyawan ORDER BY nama_karyawan ASC");

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
	<title>Karyawan - <?= $data_user['username']; ?></title>
</head>
<body>
	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<h1 class="float-left">Karyawan</h1>
		<a href="" class="float-right button">Tambah Karyawan</a>
        <div class="clear"></div>
	</div>

	<div class="container bg-table">
		<h2 class="float-left">Data Karyawan</h2>
		<form method="post" class="form-cari float-right">
	  		<input class="input" type="text" id="cari" name="cari" placeholder="Cari" required value="<?= (isset($_POST['cari'])) ? $_POST['cari'] : ''; ?>">
	  		<button type="submit" class="button align-right" name="btnCari">Cari</button>
    	</form>
    	<?php if (isset($_POST['cari'])): ?>
        	<div class="clear">
        		<h2>Cari: <?= $_POST['cari']; ?></h2>
	        	<button type="button" onclick="return window.location.href='index.php'" class="button">Reset</button>
        	</div>
    	<?php endif ?>
        <div class="table-responsive clear">
			<table border="1" cellpadding="10" cellspacing="0">
				<tr>
					<th>No.</th>
					<th>Nama Karyawan</th>
					<th>Jenis Kelamin</th>
					<th>Alamat Karyawan</th>
					<th>WhatsApp Karyawan</th>
					<th>Jumlah Reward</th>
					<th>Jumlah Punishment</th>
					<th>Aksi</th>
				</tr>
				<?php $i = 1; ?>
				<?php foreach ($karyawan as $dk): ?>
					<?php 
						$id_karyawan = $dk['id_karyawan'];
						$punishment = mysqli_query($koneksi, "SELECT * FROM punishment WHERE id_karyawan = '$id_karyawan'");
						$reward = mysqli_query($koneksi, "SELECT * FROM reward WHERE id_karyawan = '$id_karyawan'");
					 ?>
					<tr>
						<td><?= $i++; ?></td>
						<td><?= $dk['nama_karyawan']; ?></td>
						<td><?= $dk['jenis_kelamin']; ?></td>
						<td><?= $dk['alamat_karyawan']; ?></td>
						<?php 
							$phone_number = $dk['whatsapp_karyawan']; 

							// Remove the leading "+62" or "08"
							$phone_number = ltrim($phone_number, "+0");
							$phone_number = ltrim($phone_number, "62");

							// Add the "62" prefix if it is not present
							if (substr($phone_number, 0, 2) !== "62") {
							  $phone_number = "62" . $phone_number;
							}
						 ?>
						<td><a href="https://wa.me/<?= $phone_number; ?>" target="_blank" class="button"><?= $phone_number; ?></a></td>
						<td><?= mysqli_num_rows($reward); ?></td>
						<td><?= mysqli_num_rows($punishment); ?></td>
						<td>
							<a href="" class="button">Ubah</a>
							<a href="" class="button">Hapus</a>
						</td>
					</tr>
				<?php endforeach ?>
			</table>
        </div>
	</div>

	<script src="script.js"></script>
</body>
</html>