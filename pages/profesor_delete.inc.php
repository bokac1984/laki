<?php
	include "incl/data.inc.php";
	if(isset($_POST["MM_delete"]))
	{
		$sqlDelete = "DELETE FROM nastavnik WHERE id = '$_POST[id]'";
		//echo "</br>".$sqlDelete;
		@mysql_query($sqlDelete,$db) or die(mysql_error());
	}
	$idProfesora = $_GET['id'];
	$sqlQuery = "SELECT * FROM nastavnik WHERE id = $idProfesora";
	$row_comp = mysql_query($sqlQuery);
	$red = mysql_fetch_assoc($row_comp);
?>
<form method="post" action="" name="myform">
<table>
    <tr>
    <td align="left" colspan="2">Obriši profesora</td>
</tr>
<tr>
    <td colspan="2"><hr></td>
</tr>
<tr>
    <td align="right">id:</td>
    <td><input readonly="1" type="text" value="<? echo $idProfesora ?>" name="id"></td>
</tr>
<tr>
    <td align="right" >prezime:</td>
    <td><input type="text" size="30" name="prezime" value="<? echo $red['prezime']; ?>"></td>
</tr>
<tr>
    <td align="right" >ime:</td>
    <td><input type="text" size="30" name="ime"value="<? echo $red['ime']; ?>"></td>
</tr>
<tr>
    <td align="right" >kor. ime:</td>
    <td><input type="text" size="30" name="username" value="<? echo $red['username']; ?>"></td>
</tr>
<tr>
    <td align="right" >šifra:</td>
    <td><input type="password" size="30" name="password" value="<? echo $red['password']; ?>"></td>
</tr>
<tr>
    <td align="right" >imejl:</td>
    <td><input type="text" size="30" name="email" value="<? echo $red['email']; ?>"></td>
</tr>
<tr>
    <td align="right" >pol:</td>
    <td><select name="pol">
	<? if($red['pol'] == "musko"){
	?>
	<option value="musko">muško</option> 
	<option value="zensko">žensko</option></td>
	<? }
	else
	{?>
	<option value="zensko">žensko</option>
	<option value="musko">muško</option></td>
	<? }?>
	</select>
</tr>
<tr>
	<td></td>
	<td><input type="button" name="brisi" onClick="javascript:ChkDelete()" value="Obriši"></td>
</tr>
</table>
<input type="hidden" name="MM_delete" value="delete">
</form>

