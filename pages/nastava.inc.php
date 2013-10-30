<?php
 include "incl/data.inc.php";  
 //$datum=date("Y-m-d"); 
 $datum = "";
//ako je izvrsena dodjela predmeta odredjenoj nastavi prvo izvsi update nastave pa onda citaj kompletnu nastavu 
if(isset($_POST["predmet_id"]))
{
	$sqlUpdate = "UPDATE nastava SET predmet_id = '$_POST[predmet_id]' WHERE id= '$_POST[nastava_id]'";
	//echo "<br>".$sqlUpdate;
	@mysql_query($sqlUpdate,$db) or die(mysql_error());
}     
	$sqlQuery = "SELECT nastava.id, resursi.naziv AS prostorija_naziv, resursi.oznaka AS prostorija_oznaka, 
		nastavnik.id AS prof_id, nastavnik.prezime AS prezime, nastavnik.ime AS ime, 
		nastava.broj_casova, nastava.datum, nastava.vrijeme, predmet.naziv_predmeta
		FROM nastava, resursi, nastavnik, predmet
		WHERE nastava.nastavnik_id = nastavnik.id
		AND nastava.resursi_id = resursi.id
		AND nastava.predmet_id = predmet.id";
    $sqlOrederBy = " ORDER BY id DESC";
    if(isset($_REQUEST["filter"]))
    {
        if(isset($_REQUEST['date']) && ($_REQUEST["date"])!="")
        {
             $sqlQuery .= " AND nastava.datum LIKE ('$_POST[date]')";
        }
        if(isset($_REQUEST["predmet"]) && ($_REQUEST["predmet"])!="")
        {
             $sqlQuery .= " AND predmet.id = '$_POST[predmet]'";
             //echo "<br>".$sqlQuery;
        }
        if(isset($_REQUEST["profesori"]) && ($_REQUEST["profesori"])!="")
        {
            $sqlQuery .= " AND nastavnik.id = '$_POST[profesori]'";
        }
        if(isset($_REQUEST["datum"]) && ($_REQUEST['datum'])!="")
        {
            $sqlQuery .= " AND nastava.datum LIKE ('$_POST[datum]')";
            $datum = $_POST['datum'];
        }
    }
    $sqlQuery .= $sqlOrederBy;
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
<form action="" method="post" name="myform">
<table id="students" border="0">
<tr>
    <td colspan="3" align="left"><b>Pregled održane nastave</b></td>
</tr>
<tr>
    <td colspan="3"><hr></td>
</tr>
<tr>
    <td><input readonly="1" type="text" name="datum" id="datum" value="<?php echo $datum; ?>">
      <img src="images/calendar.gif" id="trigger1" style="cursor: pointer;" title="Datum"/>
            <script type="text/javascript">
            Calendar.setup({
                inputField     :    "datum", 
                ifFormat       :    "%Y-%m-%d", 
                button         :    "trigger1", 
                align          :    "Bl",
                singleClick    :    true
            });
            </script>
	<br />
    <select name="profesori">
        <option value="">Profesor</option>
        <? echo $dbManip->ListOptionsProfesor("nastavnik",$_REQUEST['profesori']); ?>
    </select><br />
	<select name="predmet">
        <option value="">Predmet</option>
        <? echo $dbManip->ListOptionsPredmet("predmet",$_REQUEST['predmet']); ?>
     </select><br /><br />
    <select name="godina">
        <option value="">--Godina--</option>
        <? echo $izvjestaj->getActiveYears(); ?>
    </select>
    <select name="mjesec">
        <option value="">--Mjesec--</option>
        <? echo $izvjestaj->showMonths(); ?>
    </select>
    </td>
	</tr>
 <tr>
    <td colspan="3"><input type="submit" name="filter" value="Traži"> <input type="button" name="osvjezi" value="Osvježi" onclick="window.location='?page=nastava'"></td>
</tr>
<tr>
    <td colspan="3"><hr></td>
</tr>
</table>

<table border="0">
<tr bgcolor="#666666" style="color:white">
       <td>Datum</td>
       <td>Vrijeme</td>
       <td>Profesor</td>
       <td>Predmet</td>
       <td colspan="3"></td>
</tr>
<? while($red = mysql_fetch_assoc($query_comp)) {?>
<tr>
    <td><?echo $red['datum'] ?></td>
    <td><? echo $red['vrijeme'] ?></td>
    <td><? echo $red['prezime'].' '.$red['ime'] ?></td>
   <? if($red['naziv_predmeta']== "---") {?>
            <td><a href="" onclick="OpenComponents('predmet_list.inc.php?p=1&nastava_id=<? echo $red['id']  ?>&prof_id=<? echo $red['prof_id'] ?>');" title="Izaberi predmet"><font color="#FF0000">Upisi predmet</font></a></td>
            <?}
            else
            {?>
            <td><? echo $red['naziv_predmeta'] ?></td>
   <? }?>
   <td><a href="?page=nastava_edit&id=<? echo $red['id'] ?>"><img src="images/edit-icon.png" title="Izmjena"></a></td>
   <td><a href="?page=nastava_studenti&id=<? echo $red['id'] ?>"><img src="images/student_nastava.png" title="Prisutni studenti"></a></td>
   <td><a href="?page=nastava_detalji&id=<? echo $red['id'] ?>"><img src="images/details.png" title="Detalji"></a></td>
</tr>
<!--p>
    <div style="border: solid; border-width: 2px;">
        <table border="0" width="590">
            <tr><td colspan="2">Настава ид: <? echo $red['id'] ?></td></tr>
            <? if($red['naziv_predmeta']== "---") {?>
            <tr><td colspan="2">Назив предмета: <a href="" onclick="OpenComponents('predmet_list.inc.php?p=1&nastava_id=<? echo $red['id']  ?>&prof_id=<? echo $red['prof_id'] ?>');" title="Izaberi predmet"><font color="#FF0000">Upisi predmet</font></a></td></tr>
            <?}
            else
            {?>
            <tr><td colspan="2">Назив предмета: <? echo $red['naziv_predmeta'] ?></td></tr>
            <? }?>
            <tr><td colspan="2">Назив просторије: <? echo $red['prostorija_naziv'] ?></td></tr>
            <tr><td colspan="2">Ознака просторије:<? echo $red['prostorija_oznaka'] ?> </td></tr>
            
            <tr><td colspan="2">Наставу одржао: <? echo $red['prezime'].' '.$red['ime'] ?></td>
            <td rowspan="2" align="right"><a href="?page=nastava_edit&id=<? echo $red['id'] ?>"><img src="images/edit_nastava.png" alt="Edit" title="Edit"></a></td></tr>
            <tr><td colspan="2">Број одржаних часова: <? echo $red['broj_casova'] ?></td></tr>
            
            <tr><td colspan="2">Датум: <? echo $red['datum'] ?></td>
            <td rowspan="2" align="right"><a href="?page=nastava_studenti&id=<? echo $red['id'] ?>"><img src="images/students.jpg" alt="studenti koji su prisustvovali" title="studenti koji su prisustvovali"></a></td></tr>
            <tr><td colspan="2">Вријеме: <? echo $red['vrijeme'] ?></td></tr>
        </table>
    </div>              
</p-->
<? }?>
</table>
<input type="hidden" name="nastava_id" value="">
<input type="hidden" name="predmet_id" value="">
<table>
    <tr><td></td></tr>
    <tr><td colspan="9"><? $dbManip->doPages(20,'?page=nastava','',$totalresult); ?></td></tr> 
</table>
</form>