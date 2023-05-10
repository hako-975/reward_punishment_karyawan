<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$karyawan = mysqli_query($koneksi, "SELECT * FROM karyawan ORDER BY nama_karyawan ASC");

	if (isset($_POST['btnTambah'])) {
		$reward = $_POST['reward'];
		$keterangan = $_POST['keterangan'];
		$tanggal_reward = $_POST['tanggal_reward'];
		$id_karyawan = $_POST['id_karyawan'];

		if ($id_karyawan == '0') {
			echo "
	            <script>
	                alert('Pilih karyawan terlebih dahulu!')
	                window.history.back()
	            </script>
	        ";
	        exit;
		}

		$tambah_reward = mysqli_query($koneksi, "INSERT INTO reward VALUES ('', '$reward', '$keterangan', '$tanggal_reward', '$id_karyawan')");

		if ($tambah_reward) {
	        echo "
	            <script>
	                alert('Reward berhasil ditambahkan!')
	                window.location.href='reward.php'
	            </script>
	        ";
	        exit;
	    } else {
	        echo "
	            <script>
	                alert('Reward gagal ditambahkan!')
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
	<title>Tambah Reward</title>
</head>
<body>
	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<h1 class="float-left">Tambah Reward</h1>
        <div class="clear"></div>
	</div>

	<div class="container">
		<form method="post" class="form form-left">
			<label for="id_karyawan">Nama Karyawan</label>
			<select name="id_karyawan" id="id_karyawan" class="input">
				<option value="0">--- Pilih Karyawan ---</option>
				<?php foreach ($karyawan as $dk): ?>
					<option value="<?= $dk['id_karyawan']; ?>"><?= $dk['nama_karyawan']; ?></option>
				<?php endforeach ?>
			</select>

		  	<label class="label" for="reward">Reward</label>
		  	<input class="input" type="text" id="reward" name="reward" required>

		  	<label class="label" for="keterangan">Keterangan</label>
		  	<textarea class="input" id="keterangan" name="keterangan" required></textarea>

		  	<label class="label" for="tanggal_reward">Tanggal Reward</label>
		  	<input class="input" type="datetime-local" id="tanggal_reward" name="tanggal_reward" required value="<?= date('Y-m-d H:i'); ?>">

		  	<button type="submit" class="button align-right" name="btnTambah">Kirim</button>
		</form>
	</div>

	<script src="script.js"></script>
</body>
</html>