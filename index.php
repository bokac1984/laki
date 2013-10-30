<?php
error_reporting(E_ALL & ~E_NOTICE);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>RFID Evidencija nastave - ETF</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/styles.css" >
    <!--<script language="javascript" type="text/javascript" src="incl/javascript_calendar.js"></script>-->
    <script language="javascript" type="text/javascript" src="incl/javascript.js"></script>
    <script language="javascript" type="text/javascript" src="incl/jquery-1.7.1.min.js"></script>
  </head>
  <body bgcolor="#999999" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table width="800" cellspacing="0" cellpadding="0" border="0" align="center">
      <tr>
        <td bgcolor="#CCCCCC" align="right" width="20%"><a href="index.php"><img src="images/rfid_logo1.jpg" alt=""></a></td>
        <td style="padding-left:10px" bgcolor="#CCCCCC" class="logo" height="75" align="left"> 
          RFID evidencija nastave</td>
      </tr>
      <tr> 
        <td height="22" colspan="2" bgcolor="#999999"> 
          <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr> 
              <td height="30" bgcolor="#FF9900" class="menu" align="center"> 
                <a href="?page=student">Studenti</a> | 
                <a href="?page=profesor">Profesori</a> | 
                <a href="?page=kartice">Kartice</a> | 
                <a href="?page=resursi">Resursi</a> | 
                <a href="?page=nastava">Izvještaji</a> |
                <a href="?page=pdf">PDF</a>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <table width="800" cellspacing="0" cellpadding="0" border="0" align="center">
      <tr> 
        <td bgcolor="#CCCCCC" height="250" valign="top" width="160"> 
          <table width="160" cellspacing="0" cellpadding="8" border="0">
            <tr> 
              <td class="text">&nbsp;

              </td>
            </tr>
          </table>

        </td>
        <td bgcolor="#eeeeee" height="250" valign="top"> 
          <table width="610" align="center" border="0">
            <tr> 
              <td>
                <?php
                if (isset($_GET['page']) && file_exists("pages" . DIRECTORY_SEPARATOR . $_GET['page'] . ".inc.php")) {
                  include ("pages" . DIRECTORY_SEPARATOR . $_GET['page'] . ".inc.php");
                } else {
                  echo "<h2>ETF RFID evidencija nastave</h2>";
                }
                ?>   
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <table width="800" cellspacing="0" cellpadding="0" height="40" border="0" align="center">
      <tr> 
        <td bgcolor="#FF9900" height="24" class="text" align="center"> &copy; 2012. ETF</td>
      </tr>
    </table>
  </body>
</html>