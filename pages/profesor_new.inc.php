<?php
	include "incl/data.inc.php"; 
	if(isset($_POST["insertProfesor"]) && ($_POST["insertProfesor"]=="insert"))
	{
		$sqlInsert = "INSERT INTO nastavnik(prezime,ime,username,password,email,pol) VALUES ('$_POST[prezime]','$_POST[ime]','$_POST[username]','$_POST[password]', '$_POST[email]','$_POST[pol]')";
		//echo "</br>".$sqlInsert;
		@mysql_query($sqlInsert,$db);
		
	}
	
	$newID = $dbManip -> GetID("nastavnik"); 
?>

<form method="post" action="">
<table>
<tr>
    <td><a href="?page=profesor" <b>Pregled profesora::</b></a></td>
    <td><b>Novi profesor</b></td>
</tr>
<tr>
    <td align="left" colspan="2">Upišite podatke za novog profesora</td>
</tr>
<tr><td colspan="2"><hr></td></tr>
<tr>
    <td align="right">id:</td>
    <td><input readonly="1" type="text" value="<? echo $newID ?>"></td>
</tr>
<tr>
    <td align="right" >prezime:</td>
    <td><input type="text" size="30" name="prezime"></td>
</tr>
<tr>
    <td align="right" >ime:</td>
    <td><input type="text" size="30" name="ime"></td>
</tr>
<tr>
    <td align="right" >kor. ime:</td>
    <td><input type="text" size="30" name="username"></td>
</tr>
<tr>
    <td align="right" >šifra:</td>
    <td><input type="password" size="30" name="password"></td>
</tr>
<tr>
    <td align="right" >imejl:</td>
    <td><input type="text" size="30" name="email"></td>
</tr>
<tr>
    <td align="right" >pol:</td>
    <td><select name="pol"><option value="musko">muško</option> 
	<option value="zensko">žensko</option></td>
</tr>

<tr>
    <td></td>
    <td><input type="submit" value="Upiši" name="unos"></td>
</tr>
</table>
<input type="hidden" name="insertProfesor" value="insert">
</form>
