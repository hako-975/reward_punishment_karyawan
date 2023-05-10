<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
	$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

	if (isset($_POST['btnTambah'])) {
		$nama_karyawan = $_POST['nama_karyawan'];
		$jenis_kelamin = $_POST['jenis_kelamin'];
		$alamat_karyawan = $_POST['alamat_karyawan'];
		$whatsapp_karyawan = $_POST['whatsapp_karyawan'];

		// Remove the leading "+62" or "08"
		$whatsapp_karyawan = ltrim($whatsapp_karyawan, "+0");
		$whatsapp_karyawan = ltrim($whatsapp_karyawan, "+62");
		
		// Add the "62" prefix if it is not present
		if (substr($whatsapp_karyawan, 0, 2) !== "62") {
		  $whatsapp_karyawan = "62" . $whatsapp_karyawan;
		}

		$tambah_karyawan = mysqli_query($koneksi, "INSERT INTO karyawan VALUES ('', '$nama_karyawan', '$jenis_kelamin', '$alamat_karyawan', '$whatsapp_karyawan')");

		if ($tambah_karyawan) {
	        echo "
	            <script>
	                alert('Karyawan berhasil ditambahkan!')
	                window.location.href='karyawan.php'
	            </script>
	        ";
	        exit;
	    } else {
	        echo "
	            <script>
	                alert('Karyawan gagal ditambahkan!')
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
	<title>Tambah Karyawan</title>
</head>
<body>
	<?php include_once 'navbar.php'; ?>

	<div class="container anti-navbar">
		<h1 class="float-left">Tambah Karyawan</h1>
        <div class="clear"></div>
	</div>

	<div class="container">
		<form method="post" class="form form-left">
		  	<label class="label" for="nama_karyawan">Nama Karyawan</label>
		  	<input class="input" type="text" id="nama_karyawan" name="nama_karyawan" required>

		  	<label class="label" for="jenis_kelamin">Jenis Kelamin Karyawan</label>
		  	<select class="input" name="jenis_kelamin" id="jenis_kelamin">
		  		<option value="l">Laki-laki</option>
		  		<option value="p">Perempuan</option>
		  	</select>

		  	<label class="label" for="alamat_karyawan">Alamat Karyawan</label>
		  	<textarea class="input" id="alamat_karyawan" name="alamat_karyawan" required></textarea>

		  	<label class="label" for="whatsapp_karyawan">WhatsApp Karyawan</label>
		  	<input class="input" type="text" id="whatsapp_karyawan" name="whatsapp_karyawan" required>

		  	<button type="submit" class="button align-right" name="btnTambah">Kirim</button>
		</form>
	</div>

	<script src="script.js"></script>
</body>
</html>