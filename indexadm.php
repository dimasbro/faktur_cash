<?php
date_default_timezone_set('Asia/Jakarta');
session_start();
if(!isset($_SESSION['username'])) {
header('location:login.php'); }
else { $username = $_SESSION['username']; }
require_once("koneksi.php");
$query = mysqli_query($konek,"SELECT * FROM tbl_user WHERE username = '$username'");
$hasil = mysqli_fetch_array($query);
?>
<html>
<head>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
<title>Halaman Sukses Login</title>
<link rel="stylesheet" href="css/jquery-ui.css"> 
<link rel="stylesheet" href="css/bootstrap.min.css"> 
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>  
<script src="js/jquery-ui.js"></script>
<script type="text/javascript"> 
$(function() { 
      $("#datepicker").datepicker();
});
$(function() { 
      $("#datepicker2").datepicker();
}); 
</script> 
<style type="text/css">
body{
	font-family: arial;
}
table,tr,th,td{
	padding: 5px;
	border-collapse: collapse;
	text-align: center;
}
th{
	background-color: blue;
	color: white;
}
#footer{
	text-align: center;
	padding: 20px;
	background-color: #ccc;
	font-size: 12px;
}
</style>
</head>
<body>
<center>
<?php
echo "<div style=\"color:blue\"><h2>Selamat Datang, $username</h2></div>";
?>

<h1>Faktur Kecil</h1>

<?php
$ex = mysqli_query($konek, "select * from tbl_nofaktur where tgl_faktur=curdate() order by no_faktur desc");
?>

<hr>
<h3>Pencarian Tanggal</h3>
<form action="" method="post">
	<input type="text" name="tanggal" size="7" id="datepicker2" placeholder="tanggal" required/>
	<input type="submit" value="cari" name="pencarian" class="btn btn-success btn-sm">
</form><br>
<?php
if(isset($_POST['pencarian'])){
	$tanggals = $_POST['tanggal'];

	function ubahTanggal($tanggals){
	 $pisah = explode('/',$tanggals);
	 $array = array($pisah[2],$pisah[0],$pisah[1]);
	 $satukan = implode('/',$array);
	 return $satukan;
	}

	$tanggal = ubahTanggal($tanggals);
 

	if(empty($tanggal)){
		?>
		<script type="text/javascript">
		alert('tanggal harus diisi');
		document.location='index.php';
		</script>
		<?php
	}else{
		$ex = mysqli_query($konek,"select * from tbl_nofaktur where tgl_faktur='$tanggal' order by no_faktur desc");
	}
}
?>
<div class="container">
<section class="col-lg-12">
<div class="table-responsive">
<table class="table table-bordered table-striped" align="center">
<tr>
<th>no_faktur</th>
<th>tgl_faktur</th>
<th>customer</th>
<th>issued_by</th>
<th>status</th>
<th>Aksi</th>
</tr>

<?php
while($r = mysqli_fetch_array($ex)){
	echo "<tr>";
	echo "<td>".$r['no_faktur']."</td>";
    echo "<td>".$r['tgl_faktur']."</td>";
    echo "<td>".$r['customer']."</td>";
    echo "<td>".$r['issued_by']."</td>";
    echo "<td>".$r['status']."</td>";
    echo "<td><a href='batal.php?n=".$r['no_faktur']."'><button class='btn btn-danger btn-sm' onclick=\"return confirm('Anda Yakin ingin membatalkan faktur cash ".$r['no_faktur']."')\">Batal Faktur</button></a></td>";
	echo "</tr>"; 
}
?>
</table>
</div>
</section>
</div>

<?php $brss = mysqli_num_rows($ex); ?>
<p>Data : <?php  echo $brss; ?></p>

<br>
<a href="logout.php"><button class="btn btn-danger btn-sm">Logout</button></a>
</center>
<br>
<div id="footer">
	Copyright &copy; 2017-<?php echo date("Y"); ?>. Created by Dimas Prasetio. All Rights Reserved

</div>
</body>
</html>