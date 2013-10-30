<?php
   include "incl/data.inc.php";  
    $datum = "";
    if(isset($_GET["id"]))
    {
        $idProfesora = $_GET['id'];
    }
    $sqlProfesorNastava = "SELECT * FROM nastavnik WHERE nastavnik.id = $idProfesora";
    $row_set = mysql_query($sqlProfesorNastava);
    $red = mysql_fetch_assoc($row_set);
    
    $sqlOdrzanaNastava = "SELECT nastava.id, nastava.datum, nastava.vrijeme, predmet.naziv_predmeta, broj_casova, resursi.naziv AS resurs_naziv, resursi.oznaka AS resurs_oznaka
FROM nastava, predmet, resursi
WHERE nastava.nastavnik_id =$idProfesora
AND nastava.resursi_id = resursi.id
AND nastava.predmet_id = predmet.id 
AND nastava.predmet_id !=1";
    if(isset($_REQUEST["filter"]))
    {
        if(isset($_REQUEST["predmet"]) && ($_REQUEST["predmet"])!="")
        {
             $sqlOdrzanaNastava .= " AND predmet.id = '$_POST[predmet]'";
             //echo "<br>".$sqlQuery;
        }
        if(isset($_REQUEST["datum"]) && ($_REQUEST['datum'])!="")
        {
            $sqlOdrzanaNastava .= " AND nastava.datum LIKE ('$_POST[datum]')";
            $datum = $_POST['datum'];
        }
    }
   
  
    $totalresult = mysql_num_rows(mysql_query($sqlOdrzanaNastava));
    //stranicenje
    $currentPage = $_SERVER["PHP_SELF"]; 
    $maxRows_comp = 5;
    $pageNum_comp = 0;
    if (isset($_GET['p'])) {
    $pageNum_comp = $_GET['p'] - 1;
    }
    $startRow_comp = $pageNum_comp * $maxRows_comp;
    $sqlQueryLimit = sprintf("%s LIMIT %d, %d", $sqlOdrzanaNastava, $startRow_comp, $maxRows_comp);
    //echo "<br>".$sqlQueryLimit;
    
    $query_comp = mysql_query($sqlQueryLimit);
?>
<form action="" method="post" name="myform">
<table>
     <tr>
        <td colspan="2"><b>Podaci o profesoru</b></td>        
     </tr>
     <tr>
        <td colspan="2"><hr></td>
     </tr>
     <tr>
        <td>Prezime:</td>
        <td><? echo $red['prezime'] ?></td>
     </tr>
     <tr>
        <td>Ime:</td>
        <td><? echo $red['ime'] ?></td>
     </tr>
     <tr>
        <td>Email:</td>
        <td><? echo $red['email'] ?></td>
     </tr>
     <tr>
        <td colspan="2"><hr></td>
     </tr>
</table>
<table>
    <tr>
        <td colspan="6" align="left">Podaci o evidentiranoj nastavi</td>
    </tr>
    <tr>
        <td colspan="6"><hr></td>
    </tr>
    <tr>
        <td>Filter:</td>
        <td><input readonly="1" type="text" name="datum" id="datum" value="<?php echo $datum; ?>">
          <img src="images/calendar.gif" id="trigger1" style="cursor: pointer;" title="In production from"/>
                <script type="text/javascript">
                Calendar.setup({
                    inputField     :    "datum", 
                    ifFormat       :    "%Y-%m-%d", 
                    button         :    "trigger1", 
                    align          :    "Bl",
                    singleClick    :    true
                });
                </script>
          </td>
          <td><select name="predmet">
            <option value="">Predmet</option>
            <? echo $dbManip->ListOptionsProfesorPredmet("predmet",$idProfesora,$_REQUEST['predmet']); ?>
            </select></td>
            <td><input type="submit" name="filter" value="Traži">&nbsp<input type="button" name="osvjezi" value="Osvježi" onclick="window.location='?page=profesor_nastava&id=<? echo $idProfesora  ?>'"></td>
    </tr>
    <!--tr>
        <td><? echo $dbManip->ListOptionsProfesorPredmet("predmet",$idProfesora); ?></td>
    </tr-->
    <tr>
        <td colspan="6"><hr></td>
    </tr>
</table>
<table>
                       
    <tr bgcolor="#666666">
        <td width="100"><font color="#FFFFFF">Datum</font></td>
        <td width="100"><font color="#FFFFFF">Vrijeme</font></td>
        <td width="120"><font color="#FFFFFF">Naziv predmeta</font></td>
        <td width="40"><font color="#FFFFFF">Broj casova</font></td>
        <td width="100"><font color="#FFFFFF">Prostorija</font></td>
        <td width="20" align="center"><font color="#FFFFFF">Oznaka</font></td>
    </tr>
    
    <? while($redProf = mysql_fetch_assoc($query_comp))
    { ?>
    <tr>
        <td><? echo $redProf['datum'] ?></td>
        <td><? echo $redProf['vrijeme'] ?></td>
        <td><? echo $redProf['naziv_predmeta'] ?></td>
        <td align="center"><? echo $redProf['broj_casova'] ?></td>
        <td><? echo $redProf['resurs_naziv'] ?></td>
        <td align="center"><? echo $redProf['resurs_oznaka'] ?></td>
    </tr>
    
    <? }?>
<tr><td></td></tr>
<tr><td colspan="10"><? $dbManip->doPages(20,'?page=profesor_nastava','',$totalresult); ?></td></tr>    
</table>
</form>

