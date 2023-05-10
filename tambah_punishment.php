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
		$punishment = $_POST['punishment'];
		$keterangan = $_POST['keterangan'];
		$tanggal_punishment = $_POST['tanggal_punishment'];
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

		$tambah_punishment = mysqli_query($koneksi, "INSERT INTO punishment VALUES ('', '$punishment', '$keterangan', '$tanggal_punishment', '$id_karyawan')");

		if ($tambah_punishment) {
	        echo "
	            <script>
	                alert('Punishment berhasil ditambahkan!')
	                window.location.href='punishment.php'
	            </script>
	        ";
	        exit;
	    } else {
	        echo "
	            <script>
	                alert('Punishment gagal ditambahkan!')
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
	<title>Tambah Punishment</title>
</head>
<body>
	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<h1 class="float-left">Tambah Punishment</h1>
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

		  	<label class="label" for="punishment">Punishment</label>
			<select name="punishment" id="punishment" class="input">
				<option value="TEGURAN LISAN">TEGURAN LISAN</option>
				<option value="TEGURAN TERTULIS">TEGURAN TERTULIS</option>
				<option value="SKORSING">SKORSING</option>
				<option value="PEMBERHENTIAN">PEMBERHENTIAN</option>
			</select>

		  	<label class="label" for="keterangan">Keterangan</label>
		  	<textarea class="input" id="keterangan" name="keterangan" required></textarea>

		  	<label class="label" for="tanggal_punishment">Tanggal Punishment</label>
		  	<input class="input" type="datetime-local" id="tanggal_punishment" name="tanggal_punishment" required value="<?= date('Y-m-d H:i'); ?>">

		  	<button type="submit" class="button align-right" name="btnTambah">Kirim</button>
		</form>
	</div>

	<script src="script.js"></script>
</body>
</html>