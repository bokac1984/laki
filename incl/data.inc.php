<?php

$host = "localhost";
$user = "root";
$pass = "";
$database = "etf_rfid";

if (!$db = @mysql_connect($host, $user, $pass)) {
  die("<b>Spajanje na mysql server je bilo neuspje�no</b>");
}
if (!mysql_select_db($database, $db)) {
  die("<b>Gre�ka pri odabiru baze</b>");
} else {
  mysql_query("set names utf8", $db);
}

class DataManipulation {

  function GetID($table_name) {
    $query = "SELECT MAX(id) as maxID FROM $table_name";
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    $id = $row['maxID'] + 1;
    return $id;
  }

  function check_integer($which) { 
    if (isset($_REQUEST[$which])) {
      if (intval($_REQUEST[$which]) > 0) {
        //check the paging variable was set or not,  
        //if yes then return its number:  
        //for example: ?page=5, then it will return 5 (integer)  
        return intval($_REQUEST[$which]);
      } else {
        return false;
      }
    }
    return false;
  }

//end of check_integer()  

  function get_current_page() {
    if (($var = $this->check_integer('p'))) {
      //return value of 'page', in support to above method  
      return $var;
    } else {
      //return 1, if it wasnt set before, page=1  
      return 1;
    }
  }

//end of method get_current_page()  

  function doPages($page_size, $thepage, $query_string, $total = 0) {
    //per page count  
    $index_limit = 10;

    //set the query string to blank, then later attach it with $query_string  
    $query = '';

    if (strlen($query_string) > 0) {
      $query = "&" . $query_string;
    }

    //get the current page number example: 3, 4 etc: see above method description  
    $current = $this->get_current_page();

    $total_pages = ceil($total / $page_size);
    $start = max($current - intval($index_limit / 2), 1);
    $end = $start + $index_limit - 1;

    echo ' 
	<div class="paging">';

    if ($current == 1) {
      echo '<span class="prn">< Previous</span> ';
    } else {
      $i = $current - 1;
      echo '<a class="prn" title="go to page ' . $i . '" rel="nofollow" href="' . $thepage . '&p=' . $i . $query . '">< Previous</a> ';
      echo '<span class="prn">...</span> ';
    }

    if ($start > 1) {
      $i = 1;
      echo '<a title="go to page ' . $i . '" href="' . $thepage . '&p=' . $i . $query . '">' . $i . '</a> ';
    }

    for ($i = $start; $i <= $end && $i <= $total_pages; $i++) {
      if ($i == $current) {
        echo '<span>' . $i . '</span> ';
      } else {
        echo '<a title="go to page ' . $i . '" href="' . $thepage . '&p=' . $i . $query . '">' . $i . '</a> ';
      }
    }

    if ($total_pages > $end) {
      $i = $total_pages;
      echo '<a title="go to page ' . $i . '" href="' . $thepage . '&p=' . $i . $query . '">' . $i . '</a> ';
    }

    if ($current < $total_pages) {
      $i = $current + 1;
      echo '<span class="prn">...</span> ';
      echo '<a class="prn" title="go to page ' . $i . '" rel="nofollow" href="' . $thepage . '&p=' . $i . $query . '">Next ></a> ';
    } else {
      echo '<span class="prn">Next ></span> ';
    }

    //if nothing passed to method or zero, then dont print result, else print the total count below:  
    if ($total != 0) {
      //prints the total result count just below the paging  
      echo '(total ' . $total . ' results)</div> ';
    }
  }

//end of method doPages()  

  function doPageslist($page_size, $thepage, $query_string, $total = 0) {
    //per page count  
    $index_limit = 10;

    //set the query string to blank, then later attach it with $query_string  
    $query = '';

    if (strlen($query_string) > 0) {
      $query = "&" . $query_string;
    }

    //get the current page number example: 3, 4 etc: see above method description  
    $current = $this->get_current_page();

    $total_pages = ceil($total / $page_size);
    $start = max($current - intval($index_limit / 2), 1);
    $end = $start + $index_limit - 1;

    echo ' 
	<div class="paging">';

    if ($current == 1) {
      echo '<span class="prn">< Previous</span> ';
    } else {
      $i = $current - 1;
      echo '<a class="prn" title="go to page ' . $i . '" rel="nofollow" href="' . $thepage . '?p=' . $i . $query . '">< Previous</a> ';
      echo '<span class="prn">...</span> ';
    }

    if ($start > 1) {
      $i = 1;
      echo '<a title="go to page ' . $i . '" href="' . $thepage . '?p=' . $i . $query . '">' . $i . '</a> ';
    }

    for ($i = $start; $i <= $end && $i <= $total_pages; $i++) {
      if ($i == $current) {
        echo '<span>' . $i . '</span> ';
      } else {
        echo '<a title="go to page ' . $i . '" href="' . $thepage . '?p=' . $i . $query . '">' . $i . '</a> ';
      }
    }

    if ($total_pages > $end) {
      $i = $total_pages;
      echo '<a title="go to page ' . $i . '" href="' . $thepage . '?p=' . $i . $query . '">' . $i . '</a> ';
    }

    if ($current < $total_pages) {
      $i = $current + 1;
      echo '<span class="prn">...</span> ';
      echo '<a class="prn" title="go to page ' . $i . '" rel="nofollow" href="' . $thepage . '?p=' . $i . $query . '">Next ></a> ';
    } else {
      echo '<span class="prn">Next ></span> ';
    }

    //if nothing passed to method or zero, then dont print result, else print the total count below:  
    if ($total != 0) {
      //prints the total result count just below the paging  
      echo '(total ' . $total . ' results)</div> ';
    }
  }

//end of method doPages()  

  function ListReursi() {
    $sqlQuery = "SELECT * FROM resursi";
    $result = mysql_query($sqlQuery);
    while ($red = mysql_fetch_assoc($result)) {
      $options .= "\n<option value='" . $red['id'] . "'>" . $red['naziv'] . "</option>";
      //echo $options;
    }
    return $options;
  }

  function ListOptionsResusrsi($table, $id = 0) {
    $sql = "select * from $table";
    $rst = mysql_query($sql);
    while ($row = mysql_fetch_assoc($rst)) {
      $selected = ($row['id'] == $id) ? "selected" : "";
      $options.="\n<option $selected value='" . $row['id'] . "'>" . $row['naziv'] . "</option>";
    }
    return $options;
  }

  function ListOptionsProfesor($table, $id = 0) {
    $sql = "select * from $table";
    $rst = mysql_query($sql);
    while ($row = mysql_fetch_assoc($rst)) {
      $selected = ($row['id'] == $id) ? "selected" : "";
      $options.="\n<option $selected value='" . $row['id'] . "'>" . $row['prezime'] . " " . $row['ime'] . "</option>";
    }
    return $options;
  }

  function ListOptionsPredmet($table, $id) {
    $sql = "select * from $table where id != 1";
    $rst = mysql_query($sql);
    while ($row = mysql_fetch_assoc($rst)) {
      $selected = ($row['id'] == $id) ? "selected" : "";
      $options.="\n<option $selected value='" . $row['id'] . "'>" . $row['naziv_predmeta'] . "</option>";
    }
    return $options;
  }

  function ListOptionsProfesorPredmet($table, $idProf, $id = 0) {
    $sql = "SELECT predmet.id, predmet.naziv_predmeta, predmet.sifra_predmeta, predmet.broj_predavanja, predmet.broj_vjezbi
				FROM predmet, posjeduje_predmet, nastavnik
				WHERE predmet.id = posjeduje_predmet.predmet_id
				AND nastavnik.id = posjeduje_predmet.nastavnik_id
				AND nastavnik.id =$idProf";
    $rst = mysql_query($sql);
    while ($row = mysql_fetch_assoc($rst)) {
      $selected = ($row['id'] == $id) ? "selected" : "";
      $options.="\n<option $selected value='" . $row['id'] . "'>" . $row['naziv_predmeta'] . "</option>";
    }
    return $options;
  }

  function SplitStringToHalf($inputString) {
    $str = $inputString;
    $middle = " ";
    $half = (int) ( (strlen($str) / 2) ); // cast to int incase str length is odd
    $left = substr($str, 0, $half);
    $right = substr($str, $half);
    return $left . $middle . $right;
  }

}

/**
 * Class for data manipulation for Izvjestaji
 */
class Izvjestaj extends DataManipulation {

  public function getActiveYears() {
    $sql = "SELECT DISTINCT YEAR(datum) AS godina FROM `nastava` ORDER BY datum DESC";
    $rst = mysql_query($sql);
    while ($row = mysql_fetch_assoc($rst)) {
      $options.="\n<option value='" . $row['godina'] . "'>" . $row['godina'] . "</option>";
    }
    return $options;
  }

  public function showMonths() {
    $return = '';
    $months = array(
        '1' => 'Januar',
        '2' => 'Februar',
        '3' => 'Mart',
        '4' => 'April',
        '5' => 'Maj',
        '6' => 'Jun',
        '7' => 'Jul',
        '8' => 'Avgust',
        '9' => 'Septembar',
        '10' => 'Oktobar',
        '11' => 'Novembar',
        '12' => 'Decembar',
    );

    foreach ($months as $k => $month) {
      $return .= "\n<option value='" . $k . "'>" . $month . "</option>";
    }
    return $return;
  }

  public function getBrCasovaPerNastavnik($month, $year) {
    $month = $month < 10 ? "0" . $month : $month;
    $sql = "SELECT DISTINCT naziv_predmeta AS predmet, datum, COUNT(*) AS brCasova, nastavnik.ime, nastavnik.prezime, nastavnik.id   
            FROM nastava
            LEFT JOIN nastavnik ON (nastavnik.id = nastava.nastavnik_id)
            LEFT JOIN predmet ON (predmet.id = nastava.predmet_id)
            WHERE  `datum` LIKE  '$year-$month-%'
            GROUP BY nastavnik_id, datum";
    $rst = mysql_query($sql);
    $results = array();
    $tempId = "";
    while ($row = mysql_fetch_assoc($rst)) {
      //echo $row['id']."<br>";
      $results[] = $row;
    }
    mysql_free_result($rst);
    //$this->debug($results);
    return $this->prepareData($results);
  }

  private function prepareData($data) {
    $temp = array();
    if (is_array($data)) {
      foreach ($data as $k => $v) {
        if (isset($temp[$v['id']])) {
          $temp[$v['id']][] = $v;
        } else {
          $temp[$v['id']][] = $v;
        }
      }
    }
    return $temp;
  }

  public function debug($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
  }

}

class GraphicReport extends DataManipulation {

  public $numberOfClasses = array();
  public $numberOfAttendants = array();
  public $result = array();
  public $nastavaIds = array();
  
  public $chartData = '';

  public function getClassesCountByTeacher($nastavnik_id, $resurs, $start_date, $end_date) {
    if ($resurs != '') {
      $resurs = " AND resursi_id = $resurs ";
    }
    $sql = "SELECT id, count(datum) AS classesCount FROM `nastava` "
    . "WHERE nastavnik_id = '$nastavnik_id' AND DATE(datum) BETWEEN ('$start_date') AND ('$end_date') "
    . $resurs . "GROUP BY datum " .
    "ORDER BY `nastava`.`id` ASC";
    $rst = mysql_query($sql);
    $results = array();
    while ($row = mysql_fetch_assoc($rst)) {
      $this->nastavaIds[] = $row['id'];
      $this->numberOfClasses[$row['id']] = $row;
    }
    mysql_free_result($rst);
  }
  
  public function processRest() {
    if (count($this->nastavaIds) > 0) {
      return true;
    } 
    return false;
  }

  public function getNumberOfStudentsPerClass() {
    $inClause = implode(",", $this->nastavaIds);
    $sql = "SELECT nastava_id, DATE(datum) as datum, count(nastava_id) AS studentsCount FROM `prisustvo` WHERE `nastava_id` IN ($inClause) GROUP BY nastava_id ORDER BY datum ASC";
    $rst = mysql_query($sql);
    $results = array();
    while ($row = mysql_fetch_assoc($rst)) {
      $this->numberOfAttendants[$row['nastava_id']] = $row;
    }
    mysql_free_result($rst);
    
    return true;
  }

  public function my_array_merge($arr, $ins) {
    if (is_array($arr)) {
      if (is_array($ins))
        foreach ($ins as $k => $v) {
          if (isset($arr[$k]) && is_array($v) && is_array($arr[$k])) {
            $arr[$k] = $this->my_array_merge($arr[$k], $v);
          } else {
            // This is the new loop :)
            while (isset($arr[$k]))
              $k++;
            $arr[$k] = $v;
          }
        }
    } elseif (!is_array($arr) && (strlen($arr) == 0 || $arr == 0)) {
      $arr = $ins;
    }
    return($arr);
  }

  public function getResults() {
    $this->result = $this->my_array_merge($this->numberOfClasses, $this->numberOfAttendants);
  }

  public function displayIds() {
    $this->debug(implode(",", $this->nastavaIds));
  }

  public function debug($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
  }
  
  public function printChartData() {
    $this->getResults();
    $this->prepareDataForChart();
    
    return $this->chartData;
  }

  private function prepareDataForChart() {
    $temp = array();
    if (is_array($this->result)) {
      foreach ($this->result as $k => $v) {
        if (is_array($v)) {
          $temp[] = '["' . $v['datum'] . '", ' . $v['studentsCount'] . ', '. $v['classesCount'] . ']';
        }
      }
    }
    $this->chartData = implode(",", $temp);
  }
}

$dbManip = new DataManipulation();
$izvjestaj = new Izvjestaj();

$graphReport = new GraphicReport();
?>