<?php
include "data.inc.php";    
if(isset($_GET["indeks"]))
{
	$sql = "select * from student where br_indeks='$_GET[indeks]'";  	
	$rst = mysql_query($sql);
	if (mysql_num_rows($rst) > 0 ) {
		$row = mysql_fetch_assoc($rst);
	}
	else {
		$row['ime'] = " podataka";
		$row['prezime'] = "Nema";
		$row['id'] = "";
	}
	$output = json_encode($row);
	header("Content-type: application/json");
	echo $output;
}
?>