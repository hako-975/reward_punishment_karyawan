<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$id_reward = $_GET['id_reward'];
	$data_reward = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM reward INNER JOIN karyawan ON reward.id_karyawan = karyawan.id_karyawan WHERE reward.id_reward = '$id_reward'"));

	if (isset($_POST['btnUbah'])) {
		$reward = $_POST['reward'];
		$keterangan = $_POST['keterangan'];
		$tanggal_reward = $_POST['tanggal_reward'];
		$id_karyawan = $_POST['id_karyawan'];

		$ubah_reward = mysqli_query($koneksi, "UPDATE reward SET reward = '$reward', keterangan = '$keterangan', tanggal_reward = '$tanggal_reward', id_karyawan = '$id_karyawan' WHERE id_reward = '$id_reward'");

		if ($ubah_reward) {
	        echo "
	            <script>
	                alert('Reward berhasil diubah!')
	                window.location.href='reward.php'
	            </script>
	        ";
	        exit;
	    } else {
	        echo "
	            <script>
	                alert('Reward gagal diubah!')
	                window.history.back()
	            </script>
	        ";
	        exit;
	    }
	}
?>

<html>
<head>
	<?php include_once 'head.php'; ?>
	<title>Ubah Reward - <?= $data_reward['nama_karyawan']; ?></title>
</head>
<body>
	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<h1 class="float-left">Ubah Reward - <?= $data_reward['nama_karyawan']; ?></h1>
        <div class="clear"></div>
	</div>

	<div class="container">
		<form method="post" class="form form-left">
			<label for="id_karyawan">Nama Karyawan</label>
			<select name="id_karyawan" id="id_karyawan" class="input">
				<option value="<?= $data_reward['id_karyawan']; ?>"><?= $data_reward['nama_karyawan']; ?></option>
				<?php foreach ($reward as $dk): ?>
					<?php if ($dk['id_karyawan'] == $data_karyawan['id_karyawan']): ?>
						<option value="<?= $dk['id_karyawan']; ?>"><?= $dk['nama_reward']; ?></option>
					<?php endif ?>
				<?php endforeach ?>
			</select>

		  	<label class="label" for="reward">Reward</label>
		  	<input class="input" type="text" id="reward" name="reward" required value="<?= $data_reward['reward']; ?>">

		  	<label class="label" for="keterangan">Keterangan</label>
		  	<textarea class="input" id="keterangan" name="keterangan" required><?= $data_reward['keterangan']; ?></textarea>

		  	<label class="label" for="tanggal_reward">Tanggal Reward</label>
		  	<input class="input" type="datetime-local" id="tanggal_reward" name="tanggal_reward" required value="<?= date('Y-m-d H:i', strtotime($data_reward['tanggal_reward'])); ?>">

		  	<button type="submit" class="button align-right" name="btnUbah">Kirim</button>
		</form>
	</div>

	<script src="script.js"></script>
</body>
</html>