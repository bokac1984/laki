<?php
   include "incl/data.inc.php"; 
   /*
   //ako je izvrsena dodjela predmeta odredjenoj nastavi prvo izvsi update nastave pa onda citaj kompletnu nastavu 
    if(isset($_POST["predmet_id"]) && isset($_POST["nastava_id"]))
    {
        $sqlUpdate = "UPDATE nastava SET predmet_id = '$_POST[predmet_id]' WHERE id= '$_GET[id]'";
        echo "<br>".$sqlUpdate;
        @mysql_query($sqlUpdate,$db) or die(mysql_error());
    }
     */
   $message = "";
   if(isset($_GET["id"]))
   {
       $idNastava = $_GET['id'];
   }
   if(isset($_POST["update"]))
   {
       $sqlUpdate = "UPDATE nastava SET resursi_id='$_POST[resurs_id]',nastavnik_id='$_POST[profesor_id]',predmet_id = '$_POST[predmet_id]',broj_casova='$_POST[broj_casova]' WHERE id='$_POST[nastava_id]'";
       //echo "<br>".$sqlUpdate;
       @mysql_query($sqlUpdate,$db) or die(mysql_error());
       if (mysql_affected_rows($db)==1) $message="Промјена сачувана";
   }
   $sqlQuery = "SELECT nastava.id, resursi.id AS resurs_id, resursi.naziv AS prostorija_naziv, resursi.oznaka AS prostorija_oznaka, nastavnik.id AS nastavnik_id, nastavnik.prezime AS prezime, nastavnik.ime AS ime, nastava.broj_casova, nastava.datum, nastava.vrijeme, predmet.id AS predmet_id, predmet.naziv_predmeta
FROM nastava, resursi, nastavnik, predmet
WHERE nastava.nastavnik_id = nastavnik.id
AND nastava.resursi_id = resursi.id
AND nastava.predmet_id = predmet.id
AND nastava.id =$idNastava";
//echo "<br>".$sqlQuery;  

    $row_comp = mysql_query($sqlQuery);
    $red = mysql_fetch_assoc($row_comp);  
    
    //echo "<br>". $red["nastavnik_id"];
?>
<form action="" method="post" name="myform">
<table>
    <tr>
        <td><h3>Edituj podatke o održanoj nastavi</h3></td>
    </tr>
    <tr>
        <td><font color="#FF0000"><? echo $message ?></font></td>
    </tr>
</table>
<table>
     <tr>
        <td align="right">Nastava id:</td>
        <td align="left"><input type="text" name="nastava_id" value="<? echo $red['id'] ?>" size="20" readonly="1"></td>
     </tr>
            <? if($red['naziv_predmeta']== "---") {?>
            <tr>
                <td align="right">Naziv predmeta:</td>
                <td align="left"><input type="text" name="naziv_predmeta" value="" size="20" readonly="1">&nbsp<input type="button" name="promjeni_predmet" value="..." onclick="OpenComponents('predmet_edit_list.inc.php?p=1&prof_id=<? echo $red["nastavnik_id"] ?>');"></td>
            </tr>
            
            <?}
            else
            {?>
            <tr>
                <td align="right">Naziv predmeta:</td>
                <td align="left"><input type="text" name="naziv_predmeta" value="<? echo $red['naziv_predmeta'] ?>" size="20" readonly="1">&nbsp<input type="button" name="promjeni_predmet" value="..." onclick="OpenComponents('predmet_edit_list.inc.php?p=1&prof_id=<? echo $red["nastavnik_id"] ?>');"></td>
            </tr>
            <? }?>
            <tr>
                <td align="right">Naziv prostorije:</td>
                <td align="left"><input type="text" name="prostorija_naziv" value="<? echo $red['prostorija_naziv'] ?>" size="20" readonly="1">&nbsp<input type="button" name="promjeni_predmet" value="..." onclick="OpenComponents('resursi_list.inc.php?p=1');"></td>
            </tr>
            <tr>
                <td align="right">Oznaka prostorije:</td>
                <td><input type="text" name="prostorija_oznaka" value="<? echo $red['prostorija_oznaka'] ?> " size="20" readonly="1"></td>
            </tr>              
            <tr>
                <td align="right">Nastavu održao(la)</td>
                <td align="left"><input type="text" name="opis" value="<? echo $red['prezime'].' '.$red['ime'] ?>" size="20" readonly="1">&nbsp<input type="button" name="promjeni_predmet" value="..." onclick="OpenComponents('profesor_list.inc.php?p=1');"></td>
            </tr>
            <tr>
                <td align="right">Broj održanih časova:</td>
                <td align="left"><input type="text" name="broj_casova" value="<? echo $red['broj_casova'] ?>" size="20"></td>
            </tr>            
            <tr>
                <td align="right">Datum:</td>
                <td align="left"><input type="text" name="datum" value="<? echo $red['datum'] ?>" size="20" readonly="1"></td>
            </tr>
            <tr>
                <td align="right">Vrijeme:</td>
                <td align="left"><input type="text" name="vrijeme" value="<? echo $red['vrijeme'] ?>" size="20" readonly="1"></td>
            </tr>
            <tr>
                <td></td>
                <td align="left"><input type="submit" name="update" value="Sačuvaj promjene"></td>
            </tr>
</table>
<input type="hidden" name="nastava_id" value="<? echo $red['id'] ?>">
<input type="hidden" name="predmet_id" value="<? echo $red['predmet_id'] ?>">
<input type="hidden" name="resurs_id" value="<? echo $red['resurs_id'] ?>">
<input type="hidden" name="profesor_id" value="<? echo $red['nastavnik_id'] ?>"> 
</form>
