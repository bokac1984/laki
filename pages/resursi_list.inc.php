<?php
   include "incl/data.inc.php";
   
   $sqlQuery = "SELECT * FROM resursi";
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
        <td colspan="3">Izaberite resurs:</td>
    </tr>
</table>
<table id="students">
    
    <tr id="header">
         <td>id</td>
         <td>Naziv prostrije</td>
         <td>Oznaka prostorije</td>
         <td>IP adresa</td>
    </tr>
    
    <? while($red = mysql_fetch_assoc($row_comp)) 
    {?>
    <tr style="cursor:default" onMouseOut="this.bgColor='#FFFFFF'" onMouseOver="this.bgColor='#999999'" onclick="window.opener.document.myform.resurs_id.value='<? echo $red['id']; ?>';window.opener.document.myform.prostorija_naziv.value='<? echo  $red['naziv']; ?>';window.opener.document.myform.prostorija_oznaka.value='<? echo $red['oznaka'] ?>';window.close();">
        <td><? echo $red['id'] ?></td>
        <td><? echo $red['naziv'] ?></td>
        <td><? echo $red['oznaka'] ?></td>
        <td><? echo $red['ip_adresa'] ?></td>
    </tr>
    <? } ?>
    <tr><td></td></tr>
    <tr><td colspan="5"><? $dbManip->doPageslist(20,'/napokon/resursi_list.inc.php','',$totalresult); ?></td></tr>
</table>

</form>
</body>
</html>