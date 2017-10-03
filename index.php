<?php
date_default_timezone_set('Asia/Jakarta');
session_start();
if(!isset($_SESSION['username'])) {
header('location:login.php'); }
else { $username = $_SESSION['username']; }
require_once("koneksi.php");
$query = mysqli_query($konek, "SELECT * FROM tbl_user WHERE username = '$username'");
$hasil = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
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
echo "<font color='blue'><h2>Selamat Datang, $username</h2></font>";
?>
<hr>
<h2>Faktur Kecil</h2>
<form action="" method="post">
<input type="text" name="tglf" size="10" required id="datepicker" placeholder="tanggal"/>
<input type="submit" value="Generate Nomer Faktur" name="klik" class="btn btn-success btn-sm" />
</form>

<?php
if(isset($_POST['klik'])){
	
	$tglf = $_POST['tglf'];
	//$cstt = $_POST['cst'];
	//$cst = strtoupper($cstt);
	$usernamee = strtoupper($username);
	$tgl = date("Y/m/d", strtotime($tglf));
	$fkt = date("ymd", strtotime($tglf))."-".date("His");

	if($tglf==null || $usernamee==null || $tgl==null || $fkt==null){
		?>
		<script type="text/javascript">
		alert("pengambilan nomer faktur gagal, ulangi lagi");
		<?php header('location:index.php') ?>
		</script>
		<?php
	}else{
		/*echo $fkt."<br>";
		echo $tgl."<br>";
		echo $cst."<br>";
		echo $username."<br>";
		echo "ok";*/
		$input = mysqli_query($konek,"insert into tbl_nofaktur values('$fkt', '$tgl','CASH','$usernamee', 'OK')");
		if($input){
			//echo "Faktur Cash <b>$usernamee</b> adalah <div style=\"color:red\"><b>$fkt</b></div>";
			echo "<br>Faktur Cash <b>$usernamee</b> adalah <font color='red'><b>$fkt</b></font>";
		}else{
			echo "<div style=\"color:red\">input gagal</div>";
		}
	}
}

?>
<hr>
<h3>Faktur Hari Ini</h3>
<?php
$ex = mysqli_query($konek,"select * from tbl_nofaktur where tgl_faktur=curdate() order by no_faktur desc");
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
</tr>

<?php
while($r = mysqli_fetch_array($ex)){
	echo "<tr>";
	echo "<td>".$r['no_faktur']."</td>";
    echo "<td>".$r['tgl_faktur']."</td>";
    echo "<td>".$r['customer']."</td>";
    echo "<td>".$r['issued_by']."</td>";
    echo "<td>".$r['status']."</td>";
	echo "</tr>"; 
}
?>
</table>
</div>
</section>
</div>

<?php $brs = mysqli_num_rows($ex) ?>
<p>Data : <?php echo $brs; ?></p>

<hr>
<h3>Pencarian Tanggal</h3>
<form action="" method="post">
	<input type="text" name="tanggal" size="10" id="datepicker2" placeholder="tanggal" required/>
	<input type="submit" value="cari" name="pencarian" class="btn btn-success btn-sm">
</form><br>
<?php
$brss=0;
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
		$ex = mysqli_query($konek, "select * from tbl_nofaktur where tgl_faktur='$tanggal' order by no_faktur desc");
		$brss = mysqli_num_rows($ex);
	}
}
?>
<div class="container">
<section class="col-lg-12">
<div class="table-responsive">
<table class="table table-bordered table-striped" width="50%" align="center">
<tr>
<th>no_faktur</th>
<th>tgl_faktur</th>
<th>customer</th>
<th>issued_by</th>
<th>status</th>
</tr>

<?php
while($r = mysqli_fetch_array($ex)){
	echo "<tr>";
	echo "<td>".$r['no_faktur']."</td>";
    echo "<td>".$r['tgl_faktur']."</td>";
    echo "<td>".$r['customer']."</td>";
    echo "<td>".$r['issued_by']."</td>";
    echo "<td>".$r['status']."</td>";
	echo "</tr>"; 
}

?>
</table>
</div>
</section>
</div>

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