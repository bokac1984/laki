<?php
	include "incl/data.inc.php";
	
	if (isset($_POST["MM_update"]))
	{

		$sqlDelete = "DELETE FROM student WHERE id = '$_POST[id]'";
		//echo "</br>".$sqlDelete;
		@mysql_query($sqlDelete,$db) or die(mysql_error());
	}
	$id_student = $_GET['id'];
	$sqlquery = "SELECT * FROM student WHERE id = $id_student";
    $row_comp = mysql_query($sqlquery);
    $red = mysql_fetch_assoc($row_comp); 
?>
<form method="post" action="" name="myform" enctype="multipart/form-data">
<table id="students">
    <tr>
    <td align="left" colspan="2">Obriši studenta</td>
</tr>
<tr>
    <td colspan="2"><hr></td>
</tr>
<tr>
    <td align="right">id:</td>
    <td><input readonly="1" type="text" name="id" value="<? echo $id_student ?>"></td>
</tr>
<tr>
    <td align="right" >prezime:</td>
    <td><input type="text" size="30" name="prezime" value="<? echo $red['prezime'] ?>"></td>
</tr>
<tr>
    <td align="right" >ime:</td>
    <td><input type="text" size="30" name="ime" value="<? echo $red['ime'] ?>"></td>
</tr>
<tr>
    <td align="right" >broj indeksa:</td>
    <td><input type="text" size="30" name="brIndeksa" value="<? echo $red['br_indeks'] ?>"></td>
</tr>
<tr>
    <td align="right" >imejl:</td>
    <td><input type="text" size="30" name="email" value="<? echo $red['email'] ?>"></td>
</tr>
<tr>
    <td></td>
    <td><input type="button" value="Obriši" name="edit" onClick="javascript:ChkDelete()"></td>
</tr>
</table>
<input type="hidden" name="MM_update" value="form1">        
</form>
