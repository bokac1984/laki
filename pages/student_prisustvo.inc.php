<?php
    include "incl/data.inc.php";    
    $datum = "";
    if(isset($_GET["id"]))
    {
        $idStudenta = $_GET['id'];
    }
    $sqlStudentQuery = "SELECT * FROM student WHERE id =$idStudenta";
    $row_comp = mysql_query($sqlStudentQuery);
    $red = mysql_fetch_assoc($row_comp);
    
    $sqlQuery = "SELECT prisustvo.nastava_id, prisustvo.student_id, nastava.broj_casova, nastava.datum, nastava.vrijeme, predmet.naziv_predmeta, nastavnik.prezime, nastavnik.ime
FROM student, prisustvo, nastava, predmet, nastavnik
WHERE prisustvo.student_id =$idStudenta
AND prisustvo.nastava_id = nastava.id
AND nastava.predmet_id = predmet.id
AND nastava.nastavnik_id = nastavnik.id";

    $sqlGroupBy = " GROUP BY nastava.id";
    $sqlOrderBy = " ORDER BY nastava.id DESC";
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
    $sqlQuery .= $sqlGroupBy. $sqlOrderBy;
    //$result_set = mysql_query($sqlStudentPrisustvo);
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
<table>
    <tr>
        <td colspan="2"><b>Podaci o studentu</b></td>        
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
        <td>Broj indeksa:</td>
        <td><? echo $red['br_indeks'] ?></td>
     </tr>
     <tr>
        <td>Imejl:</td>
        <td><? echo $red['email'] ?></td>
     </tr>
     <tr>
        <td colspan="2"><hr></td>
     </tr>
</table>
<table>
<tr>
        <td colspan="5" align="left">Podaci o prisustvu na nastavi</td>
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
            <? echo $dbManip->ListOptionsPredmet("predmet",$_REQUEST['predmet']); ?>
            </select></td>
            <td><select name="profesori">
            <option value="">Profesor</option>
            <? echo $dbManip->ListOptionsProfesor("nastavnik",$_REQUEST['profesori']); ?>
            </select></td>
           
    </tr>
    <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><input type="submit" name="filter" value="Traži">&nbsp<input type="button" name="osvjezi" value="Osvježi" onclick="window.location='?page=student_prisustvo&id=<? echo $idStudenta ?>'"></td>
    </tr>
    <tr>
        <td colspan="6"><hr></td>
    </tr>
</table>

<table border="0" id="students">
    <? if($totalresult!=0){
    echo '<tr bgcolor="#666666">
       <td width="100"><font color="#FFFFFF">Datum</font></td>
       <td width="100"><font color="#FFFFFF">Vrijeme</font> </td>
       <td width="150"><font color="#FFFFFF">Naziv predmeta</font> </td>
       <td width="150"><font color="#FFFFFF">Profesor</font></td>
       <td width="100"><font color="#FFFFFF">Broj časova</font></td>
    </tr>';
    
     while($red_prisustvo = mysql_fetch_assoc($query_comp))
    { ?>
    <tr>
        <td><? echo $red_prisustvo['datum'] ?></td>
        <td><? echo $red_prisustvo['vrijeme'] ?></td>
        <td><? echo $red_prisustvo['naziv_predmeta'] ?></td>
        <td><? echo $red_prisustvo['prezime']." ".$red_prisustvo['ime'] ?></td>
        <td><? echo $red_prisustvo['broj_casova'] ?></td>
    </tr>
    <?}
    }
    else
    {?>
      <tr>
        <td><font color="#FF0000">Student nije prisustvovao nastavi</font></td>
      </tr>
    <? }?>
<tr><td></td></tr>
<tr><td colspan="10"><? $dbManip->doPages(20,'?page=student_prisustvo','',$totalresult); ?></td></tr>
</table>

</form>
