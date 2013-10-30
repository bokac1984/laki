<?php
include "incl/data.inc.php";

$sqlQuery = "SELECT * FROM nastavnik order by prezime,ime";
$totalresult = mysql_num_rows(mysql_query($sqlQuery));

//stranicenje
$currentPage = $_SERVER["PHP_SELF"]; 
//echo "<br>trnutna strana:".$currentPage;
$maxRows_comp = 20;
$pageNum_comp = 0;
if (isset($_GET['p'])) 
{
	$pageNum_comp = $_GET['p'] - 1;
}
$startRow_comp = $pageNum_comp * $maxRows_comp;
$sqlQueryLimit = sprintf("%s LIMIT %d, %d", $sqlQuery, $startRow_comp, $maxRows_comp);
//echo "<br>".$sqlQueryLimit;
$row_comp = mysql_query($sqlQueryLimit);  
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/styles.css" > 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript" type="text/javascript" src="incl/javascript.js"></script> 
</head>
<form action="" method="post" name="myform">
<table id="students">
<tr id="header">
    <td width="50">ID</td>
    <td width="100">Prezime</td>
    <td width="100">Ime</td>
    <td width="100">Username</td>
    <td width="100">Password</td>
    <td width="100">Email</td>
    <td width="100">Pol</td>
    <td colspan="2">&nbsp;</td>
</tr>
<? while ($red = mysql_fetch_assoc($row_comp)) { ?>
<tr style="cursor:default" onMouseOut="this.bgColor='#FFFFFF'" onMouseOver="this.bgColor='#999999'" onClick="window.opener.document.myform.profesor_id.value='<? echo $red['id']; ?>';window.opener.document.myform.opis.value='<? echo $red['prezime'].' '.$red['ime']; ?>';window.close();">
	<td><? echo $red['id'] ?></td>
	<td><? echo $red['prezime'] ?></td>
	<td><? echo $red['ime'] ?></td>
	<td><? echo $red['username'] ?></td>
	<td><? echo $red['password'] ?></td>
	<td><? echo $red['email'] ?></td>
	<td><? echo $red['pol'] ?></td>
</tr>
<? } ?>
<tr><td colspan="5"><? $dbManip->doPageslist(20,'/rfid/profesor_list.inc.php','',$totalresult); ?></td></tr>
</table>
</form>
</html>