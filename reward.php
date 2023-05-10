<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$reward = mysqli_query($koneksi, "SELECT * FROM reward INNER JOIN karyawan ON reward.id_karyawan = karyawan.id_karyawan ORDER BY tanggal_reward DESC");

	if (isset($_POST['btnCari'])) {
		$cari = $_POST['cari'];
		$reward = mysqli_query($koneksi, "SELECT * FROM reward 
			INNER JOIN karyawan ON reward.id_karyawan = karyawan.id_karyawan
			WHERE 
			reward LIKE '%$cari%' 
	        OR keterangan LIKE '%$cari%'
	        OR tanggal_reward LIKE '%$cari%'
	        OR nama_karyawan LIKE '%$cari%'
			ORDER BY tanggal_reward DESC");
	}
?>

<html>
<head>
	<?php include_once 'head.php'; ?>
	<title>Reward</title>
</head>
<body>
	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<h1 class="float-left">Reward</h1>
		<a href="tambah_reward.php" class="float-right button">Tambah Reward</a>
        <div class="clear"></div>
	</div>

	<div class="container bg-table">
		<h2 class="float-left">Data Reward</h2>
		<form method="post" class="form-cari float-right">
	  		<input class="input" type="text" id="cari" name="cari" placeholder="Cari" required value="<?= (isset($_POST['cari'])) ? $_POST['cari'] : ''; ?>">
	  		<button type="submit" class="button align-right" name="btnCari">Cari</button>
    	</form>
    	<?php if (isset($_POST['cari'])): ?>
        	<div class="clear">
        		<h2>Cari: <?= $_POST['cari']; ?></h2>
        		<h2>Ditemukan: <?= mysqli_num_rows($reward); ?></h2>
	        	<a href="reward.php" class="button">Reset</a>
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
						<td><a href="detail_karyawan.php?id_karyawan=<?= $dr['id_karyawan']; ?>"><?= $dr['nama_karyawan']; ?></a></td>
						<td>
							<a href="ubah_reward.php?id_reward=<?= $dr['id_reward']; ?>" class="button">Ubah</a>
							<a href="hapus_reward.php?id_reward=<?= $dr['id_reward']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus Data Reward <?= $dr['reward']; ?>?')" class="button">Hapus</a>
						</td>
					</tr>
				<?php endforeach ?>
			</table>
        </div>
	</div>

	<script src="script.js"></script>
</body>
</html>