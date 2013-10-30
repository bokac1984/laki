<?php
   include "incl/data.inc.php";
   
   if(isset($_GET["id"]))
   {
       $nastavaID = $_GET['id'];
   } 
   //inforamcije o nastavi
   $sqlNastava = "SELECT nastava.id, resursi.naziv AS prostorija_naziv, resursi.oznaka AS prostorija_oznaka, nastavnik.id AS prof_id, nastavnik.prezime AS prezime, nastavnik.ime AS ime, nastava.broj_casova, nastava.datum, nastava.vrijeme, predmet.naziv_predmeta
FROM nastava, resursi, nastavnik, predmet
WHERE nastava.nastavnik_id = nastavnik.id
AND nastava.resursi_id = resursi.id
AND nastava.predmet_id = predmet.id
AND nastava.id = $nastavaID";   
    //echo "<br>".$sqlNastava;
    $resultSet = mysql_query($sqlNastava);
    $row_nastava = mysql_fetch_assoc($resultSet);

   $sqlQuery = "SELECT student.id,student.ime,student.prezime,student.br_indeks, student.email
FROM student,prisustvo
WHERE prisustvo.nastava_id = $nastavaID
AND student.id = prisustvo.student_id";
    //echo "<br>".$sqlQuery;
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
<table>
<tr>
    <td><h3><a href="?page=nastava">Nastava</a></h3></td>
</tr>


<tr>
    <td>Podaci o nastavi</td>
</tr>
<tr><td colspan="2"><hr></td></tr>
<tr>
    <td>Odražana nastava na dan:</td>
    <td><? echo $row_nastava['datum'] ?></td>
</tr>
<tr>
    <td>Predmet:</td>
    <td><? echo $row_nastava['naziv_predmeta'] ?></td>
</tr>
<tr>
    <td>Predavač:</td>
    <td><? echo $row_nastava['prezime']." ".$row_nastava['ime'] ?></td>
</tr>
<tr><td colspan="2"><hr></td></tr>
<tr>
    <td colspan="2"><b>Studenti koji su prisustvovali nastavi</b></td>
</tr>
<tr></tr>
</table>
<form method="post" action="">
<table border="0" id="students">
<tr id="header">
    <td width="50">id</td>
    <td width="150">prezime</td>
    <td width="150">ime</td>
    <td width="150">broj indeksa</td>
    <td width="150">email</td>
</tr>
<?
    while($red = mysql_fetch_assoc($query_comp))
    {
?>
<tr>
    <td><? echo $red['id'] ?></td>
    <td><? echo $red['prezime'] ?></td> 
    <td><? echo $red['ime'] ?></td>
    <td><? echo $red['br_indeks'] ?></td>
    <td><? echo $red['email'] ?></td>
 </tr>
<? } ?>
<tr><td></td></tr>
<tr><td colspan="5"><? $dbManip->doPages(20,'?page=nastava_studenti&id=1','',$totalresult); ?></td></tr>
</table>
</form>
