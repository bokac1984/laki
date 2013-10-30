<?php
include "incl/data.inc.php";    
if(isset($_POST["student_id"]) && ($_POST["student_id"])!= "")
{
	 $sqlInsert = "INSERT INTO kartice(nastavnik_id,student_id,broj_kartice,tip_kartice) VALUES (NULL,'$_POST[student_id]','$_POST[broj_kartice]','2')";
	// echo "</br>".$sqlInsert;
	 @mysql_query($sqlInsert,$db) or die(mysql_error());
}
$newID = $dbManip ->GetID('kartice');
?> 
<form action=""  method="post" name="myform">
<table border="0">
<tr>
    <td><a href="?page=kartice"><b>Pregled kartica::</b></a></td>
    <td>Nova studentska kartica::</td>     
    <td><a href="?page=kartice_profesor_new"><b>Nova profesorska karitca</b></a></td>  
</tr>
<tr><td colspan="2"><hr></td></tr>
<tr>
    <td colspan="3" align="left">Upišite podatke za novu studentsku karticu</td>
</tr>
<tr><td colspan="2"><hr></td></tr>
<tr>
    <td>ID:</td>
    <td><input type="text" readonly="1" value="<? echo $newID ?>" name="id"></td>
</tr>
<tr>
    <td>Indeks:</td>
    <td><input type="text" id="indeks" name="indeks"></td>
</tr>
<tr>
    <td>Vlasnik:</td>
    <td><input type="text" id="opis" name="opis" value="" readonly="1"> <input type="button" name="newStudent" value="..." onclick="OpenComponents('student_list.inc.php?p=1');"></td>
</tr>
<tr>
    <td>Broj kartice:</td>
    <td><input type="text" id="broj_kartice" name="broj_kartice" value="" maxlength="10"></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>
    	<input type="submit" value="Upiši" onclick="javascript:UnosKartice('1')">
        <input type="hidden" id="student_id" name="student_id" value="">    
    </td>
</tr>
</table>
</form>
<script>
$(document).ready(function(){
	$("#indeks").blur(function(){
		var ind = $("#indeks").val();
		$.getJSON("incl/student_podaci.php?indeks=" + ind, null, function(data){
			var info = data;
			$("#opis").val(info.prezime + " " + info.ime);
			$("#student_id").val(info.id);
			$("#broj_kartice").focus();
		});
	});
});
</script>