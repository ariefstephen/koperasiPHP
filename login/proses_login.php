<?php
session_start();

include "../config/koneksi.php";

// Dikirim dari form
$isLogin=$_POST['isLogin'];
$kode_petugas=$_POST['kode_petugas'];
$level=$_POST['level'];
$tgl_entri=$_POST['tgl_entri'];
$nama=$_POST['nama'];
$kode_user=$kode_petugas.''.$nama;


if ($isLogin=='N'){
$username=$_POST['kode_petugas'];
$password=$_POST['kode_petugas'];
	$q=mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM t_anggota WHERE kode_anggota='$kode_petugas'"));
	if($q<1){
	 ?>
		<script>
			alert("Anda belum menjadi anggota koperasi, Silahkan registrasi terlebih dahulu");
			window.location="login.php";
		</script>
	 <?php
	}
	else{
	  $quser=mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM t_user WHERE kode_petugas='$kode_petugas'"));
	  if ($quser>0){
    	?>
			<script>
				alert("Kode angota telah terdaftar, tidak bisa membuat baru");
				window.location="login.php";
			</script>
		<?php
	  }
	  else {
		$qtambah=mysqli_query($koneksi,"INSERT INTO t_user VALUES('$kode_user','$kode_petugas','$username','$password','$nama','$tgl_entri','tidak ada','$level')");
		if($qtambah){
			?>
			<script>
				alert("Pendataran Berhasil. Silahkan login mengunakan kode anggota untuk username dan password.");
				window.location="login.php";
			</script>
			<?php
		}
		else{
				echo 'gagal';
			}
	  }
	}
}
else {
$username=$_POST['username'];
$password=$_POST['password'];
	$query=mysqli_query($koneksi,"SELECT * FROM t_user WHERE username='$username' AND password='$password'");
	$jumlah=mysqli_num_rows($query);
	$a=mysqli_fetch_array($query);
	if($jumlah > 0){
		if($a['level']=='admin')
		{
		$_SESSION['level']=$a['level'];
		$_SESSION['kodeanggota']=$a['kode_petugas'];
		$_SESSION['kopid']=$a['kode_user'];
		$_SESSION['kopname']=$a['nama'];
		header("location:../index.php?pilih=home");
		}
		else if($a['level']=='anggota')
		{
		$_SESSION['level']=$a['level'];
		$_SESSION['kodeanggota']=$a['kode_petugas'];
		$_SESSION['kopid']=$a['kode_user'];
		$_SESSION['kopname']=$a['nama'];
		header("location:../index.php?pilih=home");
		}
		
	}else{
	?>
		<script>
			alert("Username Atau Password Salah");
			window.location="login.php";
		</script>
	<?php
	}
}
?>

