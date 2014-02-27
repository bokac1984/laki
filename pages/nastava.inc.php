<?php
session_start();

include "incl/data.inc.php";
$datum = $datum2 = $columns = $javascript = $title = "";
$displayChart = false;
//ako je izvrsena dodjela predmeta odredjenoj nastavi prvo izvsi update nastave pa onda citaj kompletnu nastavu 
if (isset($_POST["predmet_id"])) {
  $sqlUpdate = "UPDATE nastava SET predmet_id = '$_POST[predmet_id]' WHERE id= '$_POST[nastava_id]'";
  //echo "<br>".$sqlUpdate;
  @mysql_query($sqlUpdate, $db) or die(mysql_error());
}

if ($_REQUEST['tip']) {
  if ($_REQUEST['tip'][0] == 'prisustvo') {
    if (isset($_REQUEST["datum2"]) && ($_REQUEST['datum2']) != "") {
      $datum2 = $_POST['datum2'];
      if (isset($_REQUEST["datum"]) && ($_REQUEST['datum']) != "") {
        $sqlQuery .= " WHERE datum BETWEEN ('$_POST[datum]') AND ('$_POST[datum2]')";
        $datum = $_POST['datum'];
      }
    } else if (isset($_REQUEST["datum"]) && ($_REQUEST['datum']) != "") {
      $sqlQuery .= " WHERE datum LIKE ('$_POST[datum]%')";
      $datum = $_POST['datum'];
    }
    $sqlQueryLimit = "SELECT  DATE(datum) as Date, COUNT(DISTINCT student_id) as totalCOunt
    FROM `prisustvo`
    " . $sqlQuery . "
    GROUP   BY  DATE(datum)";
    
    $query_comp = mysql_query($sqlQueryLimit);

    $javascript = '';
    $columns = "['Datum', 'Broj studenata']";
    
    while ($red = @mysql_fetch_assoc($query_comp)) {
      $javascript .= '["' . $red['Date'] . '", ' . $red['totalCOunt'] . '],';
    }
    if ($javascript != '') {
      $title = 'Izvještaja o prisustvu studenata na nastavi';
      $displayChart = true;
    }
  } else if ($_REQUEST['tip'][0] == 'cas') {
    $datum = $_REQUEST['datum'];
    $datum2 = $_REQUEST['datum2'];
    $graphReport->getClassesCountByTeacher($_REQUEST['profesori'], $_REQUEST['resurs'], $datum, $datum2);
    if ($graphReport->processRest()) {
      $graphReport->getNumberOfStudentsPerClass();
      $columns = "['Datum', 'Broj studenata', 'Broj časova']";
      $javascript = $graphReport->printChartData();
      $title = 'Izvještaja o održanoj nastavi';
      $displayChart = true;
    } else {
      echo '<h2 style="color: red;">Nema rezultata</h2>';
    }
  }
}
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
      <td>
        <fieldset>
          <legend>Period izvještaja</legend>
          <label for="datum">OD</label>
          <input readonly="1" type="text" name="datum" id="datum" value="<?php echo $datum; ?>">
          <img src="images/calendar.gif" id="trigger1" style="cursor: pointer;" title="Datum"/>
          <script type="text/javascript">
            Calendar.setup({
              inputField: "datum",
              ifFormat: "%Y-%m-%d",
              button: "trigger1",
              align: "Bl",
              singleClick: true
            });
          </script>
          <button id="clear1" onclick="document.getElementById('datum').value = '';
              return false;">X</button>
          <br />
          <label for="datum2">DO</label>
          <input readonly="1" type="text" name="datum2" id="datum2" value="<?php echo $datum2; ?>">
          <img src="images/calendar.gif" id="trigger2" style="cursor: pointer;" title="Datum"/>
          <script type="text/javascript">
            Calendar.setup({
              inputField: "datum2",
              ifFormat: "%Y-%m-%d",
              button: "trigger2",
              align: "Bl",
              singleClick: true
            });
          </script>
          <button id="clear2" onclick="document.getElementById('datum2').value = '';
              return false;">X</button>
        </fieldset>
        <br />
        <select name="profesori">
          <option value="">Profesor</option>
          <?php echo $dbManip->ListOptionsProfesor("nastavnik", $_REQUEST['profesori']); ?>
        </select><br />
        <select name="predmet">
          <option value="">Predmet</option>
          <?php echo $dbManip->ListOptionsPredmet("predmet", $_REQUEST['predmet']); ?>
        </select><br />
        <select name="resurs">
          <option value="">Resurs</option>
          <?php echo $dbManip->ListOptionsResusrsi("resursi", $_REQUEST['predmet']); ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        <fieldset>
          <legend>Tip izvještaja</legend>
          <input type="radio" id="cas" name="tip[]" class="a" value="cas" checked="checked">
          <label for="cas">Održani časovi nastavnika</label><br />
          <input type="radio" id="prisustvo" name="tip[]" class="a" value="prisustvo">
          <label for="prisustvo">Prisustvo studenata</label>
        </fieldset>
        <br />
      </td>
    </tr>
    <tr>
      <td colspan="3">
        <input type="submit" name="filter" value="Traži"> 
        <input type="button" name="osvjezi" value="Osvježi" onclick="window.location = '?page=nastava'">
      </td>
    </tr>
    <tr>
      <td colspan="3"><hr></td>
    </tr>
    <!-- table -->
  </table>
</form>
<form action="pdf.php" name="pdf" method="post">
  <?php
  echo isset($_SESSION['pdf-error']) ? $_SESSION['pdf-error'] : '';
  unset($_SESSION['pdf-error']);
  ?>
  <table border="0">
    <tr>
      <td>
        <select name="year">
          <option value="">--Godina--</option>
          <?php echo $izvjestaj->getActiveYears(); ?>
        </select>
        <select name="month">
          <option value="">--Mjesec--</option>
          <?php echo $izvjestaj->showMonths(); ?>
        </select>
        <input type="submit" name="pdf" value="Generisanje PDF"> 
      </td>
    </tr>
    <tr>
      <td colspan="3"><hr></td>
    </tr>
  </table>
</form>

<!--<table border="0">
  <tr bgcolor="#666666" style="color:white">
    <td>Datum</td>
    <td>Vrijeme</td>
    <td>Profesor</td>
    <td>Predmet</td>
    <td colspan="3"></td>
  </tr>
</table>-->
<input type="hidden" name="nastava_id" value="">
<input type="hidden" name="predmet_id" value="">
<!--<table>
  <tr><td></td></tr>
  <tr><td colspan="9"><?php $dbManip->doPages(20, '?page=nastava', '', $totalresult); ?></td></tr> 
</table>-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
          google.load("visualization", "1", {packages: ["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
//          var data = google.visualization.arrayToDataTable([
//    ['Year', 'Austria', 'Belgium', 'Czech Republic', 'Finland', 'France', 'Germany'],
//    ['2003-15-5',  1336060,   3817614,       974066,       1104797,   6651824,  15727003],
//    ['2004',  1538156,   3968305,       928875,       1151983,   5940129,  17356071],
//    ['2005',  1576579,   4063225,       1063414,      1156441,   5714009,  16716049],
//    ['2006',  1600652,   4604684,       940478,       1167979,   6190532,  18542843],
//    ['2007',  1968113,   4013653,       1037079,      1207029,   6420270,  19564053],
//    ['2008',  1901067,   6792087,       1037327,      1284795,   6240921,  19830493]
//  ]);
            var data = google.visualization.arrayToDataTable(
              [
                <?php echo $columns; ?>,
                <?php echo $javascript; ?>
              ]
            );
            var options = {
              title: "<?php echo $title; ?>",
              hAxis: {
                title: 'Datum',
                slantedText: true,
                slantedTextAngle: 90,
                titleTextStyle: {
                  color: 'red'
                }
              }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            <?php if ($displayChart): ?>
            chart.draw(data, options);
            <?php endif; ?>
          }
</script>
<div id="chart_div" style="width: 610px; height: 500px;"></div>