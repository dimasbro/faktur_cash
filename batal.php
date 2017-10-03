<?php
include "koneksi.php";
$no_faktur = $_GET['n'];
mysqli_query("update tbl_nofaktur set status='BATAL' where no_faktur='$no_faktur'");
?>
<script type="text/javascript">
	alert("faktur cash berhasil di batalkan");
	window.location.href="indexadm.php";
</script>