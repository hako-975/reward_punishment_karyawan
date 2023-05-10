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
		$karyawan = mysqli_query($koneksi, "SELECT * FROM karyawan 
			WHERE 
			nama_karyawan LIKE '%$cari%' 
	        OR jenis_kelamin LIKE '%$cari%'
	        OR alamat_karyawan LIKE '%$cari%'
	        OR whatsapp_karyawan LIKE '%$cari%'
			ORDER BY nama_karyawan ASC");
	}
?>

<html>
<head>
	<?php include_once 'head.php'; ?>
	<title>Karyawan</title>
</head>
<body>
	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<h1 class="float-left">Karyawan</h1>
		<a href="tambah_karyawan.php" class="float-right button">Tambah Karyawan</a>
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
        		<h2>Ditemukan: <?= mysqli_num_rows($karyawan); ?></h2>
	        	<a href="karyawan.php" class="button">Reset</a>
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
						<td><a href="https://wa.me/<?= $dk['whatsapp_karyawan']; ?>" target="_blank" class="button"><?= $dk['whatsapp_karyawan']; ?></a></td>
						<td><?= mysqli_num_rows($reward); ?></td>
						<td><?= mysqli_num_rows($punishment); ?></td>
						<td>
							<a href="ubah_karyawan.php?id_karyawan=<?= $dk['id_karyawan']; ?>" class="button">Ubah</a>
							<a href="hapus_karyawan.php?id_karyawan=<?= $dk['id_karyawan']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus Data Karyawan <?= $dk['nama_karyawan']; ?>?')" class="button">Hapus</a>
						</td>
					</tr>
				<?php endforeach ?>
			</table>
        </div>
	</div>

	<script src="script.js"></script>
</body>
</html>