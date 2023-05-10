<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$id_karyawan = $_GET['id_karyawan'];
	$data_karyawan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id_karyawan'"));

	$reward = mysqli_query($koneksi, "SELECT * FROM reward INNER JOIN karyawan ON reward.id_karyawan = karyawan.id_karyawan WHERE reward.id_karyawan = '$id_karyawan' ORDER BY tanggal_reward DESC");

	if (isset($_POST['btnCariReward'])) {
		$cari_reward = $_POST['cari_reward'];
		$reward = mysqli_query($koneksi, "SELECT * FROM reward INNER JOIN karyawan ON reward.id_karyawan = karyawan.id_karyawan WHERE reward.id_karyawan = '$id_karyawan' 
			  AND (reward.reward LIKE '%$cari_reward%' 
			       OR reward.keterangan LIKE '%$cari_reward%'
			       OR reward.tanggal_reward LIKE '%$cari_reward%'
			       OR karyawan.nama_karyawan LIKE '%$cari_reward%')
			ORDER BY reward.tanggal_reward DESC");
	}

	$punishment = mysqli_query($koneksi, "SELECT * FROM punishment INNER JOIN karyawan ON punishment.id_karyawan = karyawan.id_karyawan WHERE punishment.id_karyawan = '$id_karyawan' ORDER BY tanggal_punishment DESC");

	if (isset($_POST['btnCariPunishment'])) {
		$cari_punishment = $_POST['cari_punishment'];
		$punishment = mysqli_query($koneksi, "SELECT * FROM punishment INNER JOIN karyawan ON punishment.id_karyawan = karyawan.id_karyawan WHERE punishment.id_karyawan = '$id_karyawan' 
			  AND (punishment.punishment LIKE '%$cari_punishment%' 
			       OR punishment.keterangan LIKE '%$cari_punishment%'
			       OR punishment.tanggal_punishment LIKE '%$cari_punishment%'
			       OR karyawan.nama_karyawan LIKE '%$cari_punishment%')
			ORDER BY punishment.tanggal_punishment DESC");
	}
?>

<html>
<head>
	<?php include_once 'head.php'; ?>
	<title>Detail Karyawan - <?= $data_karyawan['nama_karyawan']; ?></title>
</head>
<body>
	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<h1 class="float-left">Detail Karyawan - <?= $data_karyawan['nama_karyawan']; ?></h1>
        <div class="clear"></div>
	</div>

	<div class="container bg-table">
		<h2 class="float-left">Data Reward</h2>
		<form method="post" class="form-cari float-right">
	  		<input class="input" type="text" id="cari_reward" name="cari_reward" placeholder="Cari" required value="<?= (isset($_POST['cari_reward'])) ? $_POST['cari_reward'] : ''; ?>">
	  		<button type="submit" class="button align-right" name="btnCariReward">Cari</button>
    	</form>
    	<?php if (isset($_POST['cari_reward'])): ?>
        	<div class="clear">
        		<h2>Cari: <?= $_POST['cari_reward']; ?></h2>
        		<h2>Ditemukan: <?= mysqli_num_rows($reward); ?></h2>
	        	<a href="detail_karyawan.php?id_karyawan=<?= $id_karyawan; ?>" class="button">Reset</a>
        	</div>
    	<?php endif ?>
		<div class="table-responsive clear">
			<table border="1" cellpadding="10" cellspacing="0">
				<tr>
					<th>No.</th>
					<th>Reward</th>
					<th>Keterangan</th>
					<th>Tanggal Reward</th>
					<th>Nama Karyawan</th>
					<th>Aksi</th>
				</tr>
				<?php $i = 1; ?>
				<?php foreach ($reward as $dr): ?>
					<tr>
						<td><?= $i++; ?></td>
						<td><?= $dr['reward']; ?></td>
						<td><?= $dr['keterangan']; ?></td>
						<td><?= date("d-m-Y, H:i", strtotime($dr['tanggal_reward'])); ?></td>
						<td><?= $dr['nama_karyawan']; ?></td>
						<td>
							<a href="ubah_reward.php?id_reward=<?= $dr['id_reward']; ?>" class="button">Ubah</a>
							<a href="hapus_reward.php?id_reward=<?= $dr['id_reward']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus Data Reward <?= $dr['reward']; ?>?')" class="button">Hapus</a>
						</td>
					</tr>
				<?php endforeach ?>
			</table>
        </div>
	</div>

	<div class="container bg-table margin-top-25">
		<h2 class="float-left">Data Punishment</h2>
		<form method="post" class="form-cari float-right">
	  		<input class="input" type="text" id="cari_punishment" name="cari_punishment" placeholder="Cari" required value="<?= (isset($_POST['cari_punishment'])) ? $_POST['cari_punishment'] : ''; ?>">
	  		<button type="submit" class="button align-right" name="btnCariPunishment">Cari</button>
    	</form>
    	<?php if (isset($_POST['cari_punishment'])): ?>
        	<div class="clear">
        		<h2>Cari: <?= $_POST['cari_punishment']; ?></h2>
        		<h2>Ditemukan: <?= mysqli_num_rows($punishment); ?></h2>
	        	<a href="detail_karyawan.php?id_karyawan=<?= $id_karyawan; ?>" class="button">Reset</a>
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
						<td><?= $dp['nama_karyawan']; ?></td>
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