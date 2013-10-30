<?php
  include "incl/data.inc.php";
  
  if(isset($_POST['insertStudent']) && ($_POST['insertStudent']== "insert") && isset($_POST['unos']))
  {
     $sqlInsert ="INSERT INTO student(prezime,ime,br_indeks,email) VALUES('$_POST[prezime]','$_POST[ime]','$_POST[brIndeksa]','$_POST[email]')";
     @mysql_query($sqlInsert,$db) or die(mysql_errno());
     if(mysql_affected_rows($db)==1) $message = "Successfully inserted";
  }
  $newID = $dbManip ->GetID("student");  
?>
<form enctype="multipart/form-data" method="post" action="">
<table>
<tr>
    <td><a href="?page=student">Pregled studenata::</a></td>
    <td><b>Novi student</b></td>
</tr>
<tr>
    <td colspan="2"></td>
</tr>
<tr>
    <td align="left" colspan="2">UPIŠITE PODATKE ZA NOVOG STUDENTA</td>
</tr>
<tr><td colspan="2"><hr></td></tr>
<!--tr>
    <td align="right">ид:</td>
    <td><input readonly="1" type="text" value="<? echo $newID ?>"></td>
</tr-->
<tr>
    <td align="right" >prezime:</td>
    <td><input type="text" size="30" name="prezime"></td>
</tr>
<tr>
    <td align="right" >ime:</td>
    <td><input type="text" size="30" name="ime"></td>
</tr>
<tr>
    <td align="right" >broj indeksa:</td>
    <td><input type="text" size="30" name="brIndeksa"></td>
</tr>
<tr>
    <td align="right" >imejl:</td>
    <td><input type="text" size="30" name="email"></td>
</tr>
<tr>
    <td></td>
    <td><input type="submit" value="Upiši" name="unos"></td>
</tr>
</table>
<input type="hidden" name="insertStudent" value="insert">
</form>
