<?php
      include "incl/data.inc.php";      
      if(isset($_POST["student_id"]) && ($_POST["student_id"])!="")
      {
          $sqlDelete = "DELETE FROM kartice WHERE student_id='$_POST[student_id]' AND kartice.id = '$_POST[id]'";
          //echo "</br>".$sqlDelete;
          @mysql_query($sqlDelete,$db) or die(mysql_error());
      }
      
      $idKartice = $_GET['id'];
      $sqlQuery = "SELECT kartice.id, kartice.broj_kartice, kartice.tip_kartice,student.id as idCard, student.ime AS ime, student.prezime AS prezime
				FROM kartice, student
				WHERE kartice.student_id = student.id
				AND kartice.id = $idKartice";
      $row_comp = mysql_query($sqlQuery);
      $red = mysql_fetch_assoc($row_comp);
?>
<form action=""  method="post" name="myform">
<table>
<tr>
    <td colspan="2" align="left"><a href="?page=kartice"><b>Pregled kartica::</b></a></td>
</tr>
<tr>
    <td colspan="2" align="left">Obriši studentsku karticu</td>
</tr>
<tr><td colspan="2"><hr></td></tr>
<tr>
    <td>ID:</td>
    <td><input type="text" readonly="1" value="<? echo $idKartice ?>" name="id"></td>
</tr>
<tr>
    <td>Vlasnik:</td>
    <td><input type="text" name="opis" value="<? echo $red['ime'].' '.$red['prezime'] ?>" readonly="1"></td>
</tr>
<tr>
    <td>Broj kartice:</td>
    <td><input type="text" name="broj_kartice" value="<? echo $red['broj_kartice'] ?>"></td>
</tr>
<tr>
    <td></td>
    <td><input type="button" value="Obriši" onclick="javascript:ChkDelete()"></td>
</tr>
</table>
<input type="hidden" name="student_id" value="<? echo $red['idCard'] ?>">
</form>