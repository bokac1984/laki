<?php
include "incl/data.inc.php";    
if(isset($_POST["profesor_id"]) && ($_POST["profesor_id"])!= "")
{
	$sqlInsert = "INSERT INTO kartice(nastavnik_id,student_id,broj_kartice,tip_kartice) VALUES ('$_POST[profesor_id]',NULL,'$_POST[broj_kartice]','1')";
	//echo "</br>".$sqlInsert;
	@mysql_query($sqlInsert) or die(mysql_error());
}
$newID = $dbManip ->GetID('kartice');     
?>
<form action="" method="post" name="myform">
<table>
<tr>
    <td><a href="?page=kartice"><b>Pregled kartica::</b></a></td>
    <td><a href="?page=kartice_student_new"><b>Nova studentska kartica::</b></a></td>     
    <td>Nova profesorska kartica</td>  
</tr>
<tr><td colspan="2"><hr></td></tr>   
<tr>
    <td colspan="3" align="left">Upišite podatke za novu profesorsku karticu</td>
</tr>
<tr><td colspan="2"><hr></td></tr>
<tr>
    <td>ID:</td>
    <td><input type="text" readonly="1" value="<? echo $newID ?>" name="id"></td>
</tr>
<tr>
    <td>Vlasnik:</td>
    <td><input type="text" name="opis" value="" readonly="1"> <input type="button" name="newStudent" value="..." onclick="OpenComponents('profesor_list.inc.php?p=1');"></td>
</tr>
<tr>
    <td>Broj kartice:</td>
    <td><input type="text" name="broj_kartice" value=""></td>
</tr>
<tr>
    <td></td>
    <td><input type="submit" value="Upiši" onclick="javascript:UnosKartice('2')"></td>
</tr>
</table>
<input type="hidden" name="profesor_id" value="">
</table>
</form>