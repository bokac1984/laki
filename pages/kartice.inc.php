<?php   
include "incl/data.inc.php";
$brojKartice = "";
$tipKartice = "";
$queryNastavnik = "SELECT kartice.id, kartice.broj_kartice, kartice.tip_kartice,nastavnik.id AS idCard, nastavnik.ime AS ime, nastavnik.prezime AS prezime 
					FROM kartice, nastavnik
					WHERE kartice.nastavnik_id = nastavnik.id";
$queryUnion = " UNION ";
$queryStudent = "SELECT kartice.id, kartice.broj_kartice, kartice.tip_kartice,student.id as idCard, student.ime AS ime, student.prezime AS prezime
				FROM kartice, student
				WHERE kartice.student_id = student.id";
$queryOrderBy = " ORDER BY id ASC";
$sqlQuery = $queryNastavnik.$queryUnion.$queryStudent.$queryOrderBy;

if(isset($_REQUEST["filter"]))      
{
	//filter po tipu kartice
	if(isset($_REQUEST["tip_kartice"]) && ($_REQUEST["tip_kartice"])!="" && $_REQUEST["broj_pretraga"]=="")
	{
		$tipKartice = $_POST["tip_kartice"]; 
		if(($_REQUEST["tip_kartice"])=="prof")
		{
			$sqlQuery = $queryNastavnik.$queryOrderBy;			   
		}
		else
		{
			$sqlQuery= $queryStudent.$queryOrderBy;			
		}
	}
	//pretraga po broju kartice
	if(isset($_REQUEST["broj_pretraga"]) && ($_REQUEST["broj_pretraga"])!= "" && $_REQUEST["tip_kartice"]=="")
	{
		$sqlQuery = $queryNastavnik." AND broj_kartice LIKE '$_POST[broj_pretraga]%'".$queryUnion.$queryStudent." AND broj_kartice LIKE '$_POST[broj_pretraga]%'".$queryOrderBy;
		$brojKartice = $_POST['broj_pretraga'];
	}
	//pretraga i filter zajedno
	if(isset($_REQUEST["broj_pretraga"]) && ($_REQUEST["broj_pretraga"])!= "" && ($_REQUEST["tip_kartice"])!="")
	{
		$tipKartice = $_POST["tip_kartice"]; 
		if(($_REQUEST["tip_kartice"])=="prof")
		{
			$sqlQuery = $queryNastavnik." AND broj_kartice LIKE '$_POST[broj_pretraga]%'".$queryOrderBy;
			$brojKartice = $_POST['broj_pretraga'];
		}
		else
		{
			  $sqlQuery= $queryStudent." AND broj_kartice LIKE '$_POST[broj_pretraga]%'".$queryOrderBy;
			  $brojKartice = $_POST['broj_pretraga'];
		}
	}
}
echo "<br>".$sqlQuery;
$totalresult = mysql_num_rows(mysql_query($sqlQuery));
//stranicenje
$currentPage = $_SERVER["PHP_SELF"]; 
$maxRows_comp = 20;
$pageNum_comp = 0;
if (isset($_GET['p'])) {
	$pageNum_comp = $_GET['p'] - 1;
}
$startRow_comp = $pageNum_comp * $maxRows_comp;
$sqlQueryLimit = sprintf("%s LIMIT %d, %d", $sqlQuery, $startRow_comp, $maxRows_comp);
//echo "<br>".$sqlQueryLimit;
$query_comp = mysql_query($sqlQueryLimit);
?>
<form action="?page=kartice" method="post" name="myform" enctype="multipart/form-data">
<table>
<tr>
    <td>Pregled kartica::</td>
    <td><a href="?page=kartice_student_new"><b>Nova studentska kartica::</b></a></td>     
    <td><a href="?page=kartice_profesor_new"><b>Nova profesorska kartica</b></a></td>
</tr>
</table>
<table border="0">
    <tr>
        <td colspan="7"><hr></td>
    </tr>
    <tr>
      <td colspan="7">
        <table border="0">
             <tr>
                <td colspan="3" align="left"><strong>Pretraga i filter</strong></td>
             </tr>
             <tr>
                <td align="right">Broj kartice:</td>
                <td align="left"><input size="20" name="broj_pretraga" value="<? echo $brojKartice;  ?>"></td>                
             </tr>
             <tr>
                <td align="right">Filter:</td>
                <td align="left">
                <select name="tip_kartice">
                    <option value="">Tip kartice</option>
                    <option value="prof" <?php echo ($tipKartice=="prof")?"selected":"";?> >Profesorska</option>
                    <option value="stud" <?php echo ($tipKartice=="stud")?"selected":"";?> >Studentska</option>
                </select>
                </td>               
             </tr>
             <tr></tr>
             <tr>
                <td></td>       
                <td align="right"><input type="submit" value="Pretraga" name="filter"> <input type="submit" value="Osvježi"></td>
             </tr>
        </table>
      </td>
    <tr>
        <td colspan="7"><hr></td>
    </tr>
    <tr>
        <td colspan="3" bgcolor="#cacaca" align="center"><b>Podaci o kartici</b></td>
        <td colspan="4" bgcolor="#cacaca" align="center"><b>Podaci o vlasniku</b></td>
    </tr>
    <tr bgcolor="#666666" style="color:white">
        <td width="100">ID</td>
        <td width="150">Broj kartice</td>
        <td width="100">Tip kartice</td>
        <td width="150">Ime</td>
        <td width="150">Prezime</td>
        <td colspan="2">Akcije</td>
    </tr>
    <? while($red = mysql_fetch_assoc($query_comp))
    { ?>
    <tr>
        <td><? echo $red['id'] ?></td>
        <td><? echo $dbManip -> SplitStringToHalf($red['broj_kartice']) ?></td>
        <? if($red['tip_kartice'] == 1) {?>
        <td>Profesorska</td>
        <? }
        else
        {?>
        <td>Studentska</td>
        <? } ?>
        <td><? echo $red['ime'] ?></td>
        <td><? echo $red['prezime'] ?></td>
        <? if ($red['tip_kartice']==1){?>
        <td><a href="?page=kartice_profesor_edit&id=<? echo $red['id']; ?>"><img src="images/edit-icon.png" alt="Edit"></a></td>
        <td><a href="?page=kartice_profesor_delete&id=<? echo $red['id']; ?>"><img src="images/Delete2.gif" alt="Delete"></a></td>    
        <? } else { ?>        
        <td><a href="?page=kartice_student_edit&id=<? echo $red['id']; ?>"><img src="images/edit-icon.png" alt="Edit"></a></td>
        <td><a href="?page=kartice_student_delete&id=<? echo $red['id']; ?>"><img src="images/Delete2.gif" alt="Delete"></a></td> 
        <? } ?>
        
    </tr>
    <? } ?>
<tr><td></td></tr>
<tr><td colspan="9"><? $dbManip->doPages(20,'?page=kartice','',$totalresult); ?></td></tr>     
</table>
<input type="hidden" name="filter_tip" value="">
</form>