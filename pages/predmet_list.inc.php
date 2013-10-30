<?php
    include "incl/data.inc.php";
    if(isset($_GET["prof_id"]))
    {
        $profId = $_GET['prof_id'];
    }
    //uzimanje imena i prezimena profesora
    $sqlProfesor = "SELECT * FROM nastavnik WHERE nastavnik.id=$profId";
    $res_set = mysql_query($sqlProfesor);
    $redImePrezime = mysql_fetch_assoc($res_set);
    //uzimanje predemta koje predaje nastavnik sa profId
    $sqlQuery = "SELECT predmet.id, predmet.naziv_predmeta, predmet.sifra_predmeta, predmet.broj_predavanja, predmet.broj_vjezbi
FROM predmet, posjeduje_predmet, nastavnik
WHERE predmet.id = posjeduje_predmet.predmet_id
AND nastavnik.id = posjeduje_predmet.nastavnik_id
AND nastavnik.id =$profId";
    $totalresult = mysql_num_rows(mysql_query($sqlQuery));
       
    //stranicenje
    $currentPage = $_SERVER["PHP_SELF"]; 
    //echo "<br>trnutna strana:".$currentPage;
    $maxRows_comp = 20;
    $pageNum_comp = 0;
    if (isset($_GET['p'])) 
    {
        $pageNum_comp = $_GET['p'] - 1;
    }
    $startRow_comp = $pageNum_comp * $maxRows_comp;
    $sqlQueryLimit = sprintf("%s LIMIT %d, %d", $sqlQuery, $startRow_comp, $maxRows_comp);
    //echo "<br>".$sqlQueryLimit;
    
    $row_comp = mysql_query($sqlQueryLimit);
    
    //uzimanje informacije o kojem id-ju nastave se radi
    if(isset($_GET['nastava_id']))
    {
        $nastavaID = $_GET['nastava_id'];
    }
    
           
?>
<html>
<head>
<link rel="stylesheet" href="css/styles.css" type="text/css"> 
<script language="javascript" type="text/javascript" src="incl/javascript.js"></script> 
</head>
<body>
<form action="<? echo $currentPage ?>" method="post" name="myform">
<table>
    <tr>
        <td colspan="5">Predmeti koje predaje profesor <? echo $redImePrezime['ime']." ".$redImePrezime['prezime'] ?>:</td>
    </tr>
</table>
<table id="students">
    
    <tr id="header">
        <td>Id</td>
        <td>Naziv predmeta</td>
        <td>Sifra predemta</td>
        <td>Sedmicno opterecenje predavanja</td>
        <td>Sedmicno opterecenje vjezbi</td>
    </tr>
    
    <? while($red = mysql_fetch_assoc($row_comp)) 
    {?>
    <tr style="cursor:default" onMouseOut="this.bgColor='#FFFFFF'" onMouseOver="this.bgColor='#999999'" onclick="window.opener.document.myform.nastava_id.value='<? echo $nastavaID ?>';window.opener.document.myform.predmet_id.value='<? echo $red['id']; ?>';window.opener.document.myform.submit();window.close();">
        <td align="center"><? echo $red['id'] ?></td>
        <td align="center"><? echo $red['naziv_predmeta'] ?></td>
        <td align="center"><? echo $red['sifra_predmeta'] ?></td>
        <td align="center"><? echo $red['broj_predavanja'] ?></td>
        <td align="center"><? echo $red['broj_vjezbi'] ?></td>
    </tr>
    <? } ?>
    <tr><td></td></tr>
    <tr><td colspan="5"><? $dbManip->doPageslist(20,'/napokon/predemt_list.inc.php','',$totalresult); ?></td></tr>
</table>

</form>
</body>
</html>
