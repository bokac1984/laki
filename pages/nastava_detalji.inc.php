<?php
     include "incl/data.inc.php";    
     //$datum=date("Y-m-d"); 
     $datum = "";
    //uzmemo inforamcije o kojoj se nastavi radi
    if(isset($_GET['id']))
    {
        $nastavaID = $_GET['id'];
    }
    //ako je izvrsena dodjela predmeta odredjenoj nastavi prvo izvsi update nastave pa onda citaj kompletnu nastavu 
    if(isset($_POST["predmet_id"]))
    {
        $sqlUpdate = "UPDATE nastava SET predmet_id = '$_POST[predmet_id]' WHERE id= '$_POST[nastava_id]'";
        //echo "<br>".$sqlUpdate;
        @mysql_query($sqlUpdate,$db) or die(mysql_error());
    }
   
     
     $sqlQuery = "SELECT nastava.id, resursi.naziv AS prostorija_naziv, resursi.oznaka AS prostorija_oznaka, nastavnik.id AS prof_id, nastavnik.prezime AS prezime, nastavnik.ime AS ime, nastava.broj_casova, nastava.datum, nastava.vrijeme, predmet.naziv_predmeta
FROM nastava, resursi, nastavnik, predmet
WHERE nastava.nastavnik_id = nastavnik.id
AND nastava.resursi_id = resursi.id
AND nastava.predmet_id = predmet.id
AND nastava.id = $nastavaID";
    $sqlOrederBy = " ORDER BY id DESC";
    $sqlQuery .= $sqlOrederBy;
    $totalresult = mysql_num_rows(mysql_query($sqlQuery));
    //stranicenje
    $currentPage = $_SERVER["PHP_SELF"]; 
    $maxRows_comp = 5;
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
    <td colspan="6" align="left"><b>Detalji nastave</b></td>
</tr>
<tr>
    <td width="590"><hr></td>
</tr>
</table>
<?
$red = mysql_fetch_assoc($query_comp) 
?>
<p>
    <div style="border: solid; border-width: 2px;">
       
                <table border="0" width="550"> 
                    <tr><td align="left">Nastava id:</td><td align="left"><? echo $red['id'] ?></td> <td width="200"></td></tr>
                    <? if($red['naziv_predmeta']== "---") {?>
                    <tr><td align="left">Naziv predemta:</td><td align="left"><a href="" onclick="OpenComponents('predmet_list.inc.php?p=1&nastava_id=<? echo $red['id']  ?>&prof_id=<? echo $red['prof_id'] ?>');" title="Izaberi predmet"><font color="#FF0000">Upisi predmet</font></a></td><td></td></tr>
                    <?}
                    else
                    {?>
                    <tr><td align="left">Naziv predemta:</td><td align="left"><? echo $red['naziv_predmeta'] ?></td><td></td></tr>
                    <? }?>
                    <tr><td align="left">Naziv prostorije:</td><td align="left"><? echo $red['prostorija_naziv'] ?></td><td></td></tr>
                    <tr><td align="left">Oznaka prostorije:</td><td align="left"><? echo $red['prostorija_oznaka'] ?> </td><td></td></tr>
                    
                    <tr><td align="left">Nastavu održao:</td><td align="left"><? echo $red['prezime'].' '.$red['ime'] ?></td>
                    <td rowspan="2" align="right"><a href="?page=nastava_edit&id=<? echo $red['id'] ?>"><img src="images/edit_nastava.png" alt="Edit" title="Edit"></a></td></tr>
                    
                    <tr><td align="left">Broj održanih časova:</td><td align="left"><? echo $red['broj_casova'] ?></td></tr>
                    
                    <tr><td align="left">Datum:</td><td align="left"><? echo $red['datum'] ?></td>
                    <td rowspan="2" align="right"><a href="?page=nastava_studenti&id=<? echo $red['id'] ?>"><img src="images/students_manji.jpg" alt="studenti koji su prisustvovali" title="studenti koji su prisustvovali"></a></td></tr>
                    <tr><td align="left">Vrijeme:</td><td align="left"><? echo $red['vrijeme'] ?></td></tr>
                </table>
           
    </div>              
</p>
<input type="hidden" name="nastava_id" value="">
<input type="hidden" name="predmet_id" value="">
</form>
