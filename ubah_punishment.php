<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	$id_punishment = $_GET['id_punishment'];
	$data_punishment = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM punishment INNER JOIN karyawan ON punishment.id_karyawan = karyawan.id_karyawan WHERE punishment.id_punishment = '$id_punishment'"));

	if (isset($_POST['btnUbah'])) {
		$punishment = $_POST['punishment'];
		$keterangan = $_POST['keterangan'];
		$tanggal_punishment = $_POST['tanggal_punishment'];
		$id_karyawan = $_POST['id_karyawan'];

		$ubah_punishment = mysqli_query($koneksi, "UPDATE punishment SET punishment = '$punishment', keterangan = '$keterangan', tanggal_punishment = '$tanggal_punishment', id_karyawan = '$id_karyawan' WHERE id_punishment = '$id_punishment'");

		if ($ubah_punishment) {
	        echo "
	            <script>
	                alert('Punishment berhasil diubah!')
	                window.location.href='punishment.php'
	            </script>
	        ";
	        exit;
	    } else {
	        echo "
	            <script>
	                alert('Punishment gagal diubah!')
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
	<title>Ubah Punishment - <?= $data_punishment['nama_karyawan']; ?></title>
</head>
<body>
	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<h1 class="float-left">Ubah Punishment - <?= $data_punishment['nama_karyawan']; ?></h1>
        <div class="clear"></div>
	</div>

	<div class="container">
		<form method="post" class="form form-left">
			<label for="id_karyawan">Nama Karyawan</label>
			<select name="id_karyawan" id="id_karyawan" class="input">
				<option value="<?= $data_punishment['id_karyawan']; ?>"><?= $data_punishment['nama_karyawan']; ?></option>
				<?php foreach ($punishment as $dk): ?>
					<?php if ($dk['id_karyawan'] == $data_karyawan['id_karyawan']): ?>
						<option value="<?= $dk['id_karyawan']; ?>"><?= $dk['nama_punishment']; ?></option>
					<?php endif ?>
				<?php endforeach ?>
			</select>

		  	<label class="label" for="punishment">Punishment</label>
			<select name="punishment" id="punishment" class="input">
				<option value="<?= $data_punishment['punishment']; ?>"><?= $data_punishment['punishment']; ?></option>
				<option disabled>--------------------------</option>
				<option value="TEGURAN LISAN">TEGURAN LISAN</option>
				<option value="TEGURAN TERTULIS">TEGURAN TERTULIS</option>
				<option value="SKORSING">SKORSING</option>
				<option value="PEMBERHENTIAN">PEMBERHENTIAN</option>
			</select>

		  	<label class="label" for="keterangan">Keterangan</label>
		  	<textarea class="input" id="keterangan" name="keterangan" required><?= $data_punishment['keterangan']; ?></textarea>

		  	<label class="label" for="tanggal_punishment">Tanggal Punishment</label>
		  	<input class="input" type="datetime-local" id="tanggal_punishment" name="tanggal_punishment" required value="<?= date('Y-m-d H:i', strtotime($data_punishment['tanggal_punishment'])); ?>">

		  	<button type="submit" class="button align-right" name="btnUbah">Kirim</button>
		</form>
	</div>

	<script src="script.js"></script>
</body>
</html>