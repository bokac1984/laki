<?php
  include "incl/data.inc.php"; 
  $sqlQuery = "SELECT * FROM student WHERE 1";
  $prezime = "";
  $ime = "";
  $br_indeksa = ""; 
  if(isset($_REQUEST["filter"]))
  {
      //echo "cao ovde fuilter";
      if(isset($_REQUEST["pStudenta"]) && ($_REQUEST['pStudenta'])!="")
      {
          $sqlQuery .=" AND student.prezime LIKE ('$_POST[pStudenta]%')";       
          $prezime = $_POST['pStudenta'];
      }
      if(isset($_REQUEST["iStudenta"]) && ($_REQUEST["iStudenta"])!="")
      {
          $sqlQuery .= " AND student.ime LIKE ('$_POST[iStudenta]%')";
          $ime = $_POST['iStudenta'];
      }
      if(isset($_REQUEST["brIndStudenta"]) && ($_REQUEST["brIndStudenta"])!="")
      {
          $sqlQuery .=" AND student.br_indeks LIKE ('$_POST[brIndStudenta]%')";
          $br_indeksa = $_POST['brIndStudenta'];
      }
  }
  
  $totalresult = mysql_num_rows(mysql_query($sqlQuery));    
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
<table border="0">
<tr>
    <td>Pregled studenata::</td>
    <td colspan="3" align="left"><a href="?page=student_new"><strong>Novi student</strong></a></td>
</tr>
<tr>
    <td colspan="4"><hr></td>
</tr>
<tr>
    <td>Prezime</td>
    <td>Ime</td>
    <td>Broj indeksa</td>
</tr>
<tr>
    <td><input type="text" name="pStudenta" value="<? echo $prezime ?>" size="20"></td>
    <td><input type="text" name="iStudenta" value="<? echo $ime ?>" size="20"></td>
    <td><input type="text" name="brIndStudenta" value="<? echo $br_indeksa ?>" size="10"></td>
    <td align="left"><input type="submit" name="filter" value="Traži"> <input type="submit" name="osvjezi" value="Osvježi"></td>
</tr>
<tr>
    <td colspan="4"><hr></td>
</tr>
</table>
<table border="0" id="students">
<tr id="header">
    <td width="150">Prezime</td>
    <td width="150">Ime</td>
    <td width="150">Indeks</td>
    <td width="150">Email</td>
    <td colspan="3">Akcije</td>
    
</tr>
<? while($red = mysql_fetch_assoc($row_comp)) { ?>
<tr>
    <td><? echo $red['prezime'] ?></td> 
    <td><? echo $red['ime'] ?></td>
    <td><? echo $red['br_indeks'] ?></td>
    <td><? echo $red['email'] ?></td>
    <td><a href="?page=student_edit&id=<? echo $red['id'] ?>"><img src="images/edit-icon.png" title="Izmjena"></a></td>
    <td><a href="?page=student_delete&id=<? echo $red['id'] ?>"><img src="images/Delete2.gif" title="Brisanje"></a></td>
    <td><a href="?page=student_prisustvo&id= <? echo $red['id'] ?>"><img src="images/book_prisustvo.gif" title="Prisustvo"></a></td>
	<!--<td><input type="button" name="obrisi" value="Delete" onClick="javascript:ChkDelete()"></td>-->
</tr>
<? } ?>
<tr>
	<td colspan="10"><? $dbManip->doPages(20,'?page=student','',$totalresult); ?></td>
</tr>
</table>
<input type="hidden" name="brisi" value="delete">
</form>