<?php
    include "incl/data.inc.php";  
    $message = "";
    //if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1"))
    if(isset($_POST["edit"]))
    {
        $sqlUpdate = "UPDATE student SET prezime='$_POST[prezime]', ime='$_POST[ime]',br_indeks='$_POST[brIndeksa]',email='$_POST[email]' WHERE id = '$_POST[id]'";
        @mysql_query($sqlUpdate,$db) or die(mysql_error());
        if (mysql_affected_rows($db)==1) $message="Промјена сачувана"; 
    }
    $id_student = $_GET['id'];
    $sqlquery = "SELECT * FROM student WHERE id = $id_student";
    $row_comp = mysql_query($sqlquery);
    $red = mysql_fetch_assoc($row_comp); 
?>
<form  enctype="multipart/form-data" action="" method="post" name="forml">
<table id="students">
<tr>
    <td align="left" colspan="2">Ispravite podatke za studenta</td>
</tr>
<tr>
    <td colspan="2"><hr></td>
</tr>
<tr>
    <td id="message" colspan="2"><font color="#FF0000"><?echo $message ?></font> </td>
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
    <td align="right">imejl:</td>
    <td><input type="text" size="30" name="email" value="<? echo $red['email'] ?>"></td>
</tr>
<tr>
    <td></td>
    <td><input type="submit" value="Sačuvaj promjene" name="edit"></td>
</tr>
</table>
 <input type="hidden" name="MM_update" value="form1">        
</form>
