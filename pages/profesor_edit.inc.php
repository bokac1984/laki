<?php 
	include "incl/data.inc.php";
     $message = "";  
	if(isset($_POST["MM_update"]))
	{
		$sqlUpdate = "UPDATE nastavnik SET prezime = '$_POST[prezime]', ime = '$_POST[ime]', username = '$_POST[username]', password = '$_POST[password]', email = '$_POST[email]', pol = '$_POST[pol]' WHERE id = '$_POST[id]'";
		//echo "</br>".$sqlUpdate;
		@mysql_query($sqlUpdate,$db);
         if (mysql_affected_rows($db)==1) $message="Промјена сачувана";  
	}
	$idProfesora = $_GET['id'];
	$sqlQuery = "SELECT * FROM nastavnik WHERE id = $idProfesora";
	$row_comp = mysql_query($sqlQuery);
	$red = mysql_fetch_assoc($row_comp);
?>

<form method="post" action="">
<table>
<tr>
    <td align="left" colspan="2">Ispravite podatke za profesora</td>
</tr>
<tr>
    <td colspan="2"><hr></td>
</tr>
 <tr>
    <td id="message" colspan="2"><font color="#FF0000"><?echo $message ?></font> </td>
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
	
</tr>

<tr>
    <td></td>
    <td><input type="submit" value="Sačuvaj promjene" name="unos"></td>
</tr>
</table>
<input type="hidden" name="MM_update" value="update">
</form>
