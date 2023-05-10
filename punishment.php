<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$punishment = mysqli_query($koneksi, "SELECT * FROM punishment INNER JOIN karyawan ON punishment.id_karyawan = karyawan.id_karyawan ORDER BY tanggal_punishment DESC");

	if (isset($_POST['btnCari'])) {
		$cari = $_POST['cari'];
		$punishment = mysqli_query($koneksi, "SELECT * FROM punishment 
			INNER JOIN karyawan ON punishment.id_karyawan = karyawan.id_karyawan
			WHERE 
			punishment LIKE '%$cari%' 
	        OR keterangan LIKE '%$cari%'
	        OR tanggal_punishment LIKE '%$cari%'
	        OR nama_karyawan LIKE '%$cari%'
			ORDER BY tanggal_punishment DESC");
	}
?>

<html>
<head>
	<?php include_once 'head.php'; ?>
	<title>Punishment</title>
</head>
<body>
	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<h1 class="float-left">Punishment</h1>
		<a href="tambah_punishment.php" class="float-right button">Tambah Punishment</a>
        <div class="clear"></div>
	</div>

	<div class="container bg-table">
		<h2 class="float-left">Data Punishment</h2>
		<form method="post" class="form-cari float-right">
	  		<input class="input" type="text" id="cari" name="cari" placeholder="Cari" required value="<?= (isset($_POST['cari'])) ? $_POST['cari'] : ''; ?>">
	  		<button type="submit" class="button align-right" name="btnCari">Cari</button>
    	</form>
    	<?php if (isset($_POST['cari'])): ?>
        	<div class="clear">
        		<h2>Cari: <?= $_POST['cari']; ?></h2>
        		<h2>Ditemukan: <?= mysqli_num_rows($punishment); ?></h2>
	        	<a href="punishment.php" class="button">Reset</a>
        	</div>
    	<?php endif ?>
        <div class="table-responsive clear">
			<table border="1" cellpadding="10" cellspacing="0">
				<tr>
					<th>No.</th>
					<th>Punishment</th>
					<th>Keterangan</th>
					<th>Tanggal Punishment</th>
					<th>Nama Karyawan</th>
					<th>Aksi</th>
				</tr>
				<?php $i = 1; ?>
				<?php foreach ($punishment as $dp): ?>
					<tr>
						<td><?= $i++; ?></td>
						<td><?= $dp['punishment']; ?></td>
						<td><?= $dp['keterangan']; ?></td>
						<td><?= date("d-m-Y, H:i", strtotime($dp['tanggal_punishment'])); ?></td>
						<td><a href="detail_karyawan.php?id_karyawan=<?= $dp['id_karyawan']; ?>"><?= $dp['nama_karyawan']; ?></a></td>
						<td>
							<a href="ubah_punishment.php?id_punishment=<?= $dp['id_punishment']; ?>" class="button">Ubah</a>
							<a href="hapus_punishment.php?id_punishment=<?= $dp['id_punishment']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus Data Punishment <?= $dp['punishment']; ?>?')" class="button">Hapus</a>
						</td>
					</tr>
				<?php endforeach ?>
			</table>
        </div>
	</div>

	<script src="script.js"></script>
</body>
</html>