<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_nofaktur";
$konek = mysqli_connect($host, $user, $pass) or die ('Koneksi Gagal! ');
mysqli_select_db($konek, $db);
?>