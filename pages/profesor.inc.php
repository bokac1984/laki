<?php
include "incl/data.inc.php";  
$sqlQuery = "SELECT * FROM nastavnik WHERE 1";
$prezime = "";
$ime = "";
$pol = "";
if(isset($_REQUEST["filter"]))
{
	if(isset($_REQUEST["pProfesora"]) && ($_REQUEST["pProfesora"])!="")
	{
		$sqlQuery .= " AND nastavnik.prezime LIKE ('$_POST[pProfesora]%')";
		$prezime = $_POST['pProfesora'];
	}
	if(isset($_REQUEST["iProfesora"]) && ($_REQUEST["iProfesora"])!="")
	{
		$sqlQuery .= " AND nastavnik.ime LIKE ('$_POST[iProfesora]%')";
		$ime = $_POST["iProfesora"];
	}
	if(isset($_REQUEST["pol"]) && ($_REQUEST["pol"])!="")
	{
		$sqlQuery .= " AND nastavnik.pol LIKE ('$_POST[pol]')";
		$pol = $_POST['pol'];
	}
}

$totalresult = mysql_num_rows(mysql_query($sqlQuery));
//$red = mysql_fetch_assoc($row_comp);

//stranicenje
$currentPage = $_SERVER["PHP_SELF"]; 
$maxRows_comp = 20;
$pageNum_comp = 0;
if (isset($_GET['p'])) {
	$pageNum_comp = $_GET['p'] - 1;
}
$startRow_comp = $pageNum_comp * $maxRows_comp;
$sqlQueryLimit = sprintf("%s LIMIT %d, %d", $sqlQuery, $startRow_comp, $maxRows_comp);
//echo "<br>".$sqlQueryLimit;
$row_comp = mysql_query($sqlQueryLimit);  
   
?>

<form action="" method="post" name="myform">    
<table>
<tr>
    <td>Pregled profesora::</td>
    <td><a href="?page=profesor_new"><strong>Novi profesor</strong></a></td>
</tr>
<tr>
    <td colspan="4"><hr></td>
</tr>
<tr>
    <td>Prezime</td>
    <td>Ime</td>
    <td>Pol</td>
</tr>
<tr>
    <td><input type="text" name="pProfesora" value="<? echo $prezime ?>" size="20"></td>
    <td><input type="text" name="iProfesora" value="<? echo $ime ?>" size="20"></td>
    <td><select name="pol">
    <option value="">Pol</option>
    <option value="musko" <? echo ($pol == "musko")?"selected":"" ?> >Muški</option>
    <option value="zensko" <? echo ($pol == "zensko")?"selected":"" ?>>Ženski</option>        
    </select></td>
    <td align="left"><input type="submit" name="filter" value="Traži"> <input type="submit" name="osvjezi" value="Osvježi"></td>
</tr>
<tr>
    <td colspan="4"><hr></td>
</tr>
</table>
<table border="0" id="students">
<tr id="header">
    <td width="100">Prezime</td>
    <td width="100">Ime</td>
    <td width="100">Korisnik</td>
    <td width="60">Email</td>
	<td width="60">Pol</td>
    <td colspan="3">Akcije</td>
    
</tr>
<? while($red = mysql_fetch_assoc($row_comp)) { ?>
<tr>
    <td><? echo $red['prezime'] ?></td>
    <td><? echo $red['ime'] ?></td>
    <td><? echo $red['username'] ?></td>
    <td><? echo $red['email'] ?></td>
	<td><? echo $red['pol'] ?></td>
    <td><a href="?page=profesor_edit&id=<? echo $red['id'] ?>"><img src="images/edit-icon.png" title="Izmjena"></a></td>
    <td><a href="?page=profesor_delete&id=<? echo $red['id'] ?>"><img src="images/Delete2.gif" title="Brisanje"></a></td>
    <td><a href="?page=profesor_nastava&id=<? echo $red['id'] ?>"><img src="images/professor-icon.gif" title="Nastava"></a></td>
</tr>
<? } ?>
<tr><td colspan="8"><? $dbManip->doPages(20,'?page=profesor','',$totalresult); ?></td></tr>
</table>
</form>