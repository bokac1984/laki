<?php
// Include the main TCPDF library (search for installation path).
require_once('tcpdf'.DIRECTORY_SEPARATOR.'tcpdf.php');

class reportPDF extends TCPDF {

  public $data = array();
  public $headers = array();
  
  public $name;
  
  public function resetData() {
    $this->data = array();
  }

  public function loadData($data) {
    
    $this->resetData();
    foreach ($data as $d => $k) {
      $this->data[] = $k;
    }
    $this->getName();
  }
  
  public function getName() {
    $this->name = $this->data[0]['ime']. " ". $this->data[0]['prezime'];
  }

  public function Header() {
    $this->Image('incl' . DIRECTORY_SEPARATOR . 'logoetf.png', 10, 25, 18, '', 'PNG', '', 'T', false, 300, 'R', false, false, 1, false, false, false);
    $this->Image('incl' . DIRECTORY_SEPARATOR . 'uis.png', 10, 25, 18, '', 'PNG', '', 'T', false, 300, 'L', false, false, 1, false, false, false);
    // title
    $this->SetFont('freeserif', 'B', 18);
    $this->Cell(35);
    $this->Cell(190, 10, 'Univerzitet u Istočnom Sarajevu');

    // second title
    $this->SetFont('freeserif', 'I', 18);
    $this->Ln(8);
    $this->Cell(65);
    $this->Cell(10, 10, 'Elektrotehnički fakultet');

    // address
    $this->SetFont('freeserif', 'I', 12);
    $this->Ln(14);
    $this->Cell(55);
    $this->Cell(10, 10, 'Vuka Karadžića, 30, 71123 Istočno Sarajevo');

    // second title
    $this->SetFont('freeserif', 'I', 12);
    $this->Ln(14);
    $this->Cell(48);
    $this->PutLink("mailto:etfss@teol.net", "etfss@teol.net");
    $this->Cell(0, 0, ' +387 57 342 788 www.etf.unssa.rs.ba');

    // Line break
    $this->Ln(50);
  }

  public function setPageTitle($month, $year) {
    $yearLast = substr($year, -2)+ 1;
    // address
    $this->SetFont('freeserif', 'B', 20);
    $this->Cell(10);
    $this->Cell(10, 10, "Izvještaj o održanoj nastavi u školskoj $year/$yearLast. godini");
    $this->Ln();
    $this->Cell(58);
    $this->Cell(10, 10, "za mjesec $month");
    $this->Ln(15);
    $this->SetFont('freeserif', '', 12);
  }

  public function PutLink($URL, $txt) {
    // Put a hyperlink
    $this->SetTextColor(0, 0, 255);
    $this->SetFont('', "U");
    $this->Write(0, $txt, $URL);
    $this->SetTextColor(0, 0, 0);
    $this->SetFont('freeserif', 'I', 12);
  }

  public function setH($h) {
    $this->headers = $h;
  }

  /**
   * Sets headers for table
   * 
   * @param array $headers
   */
  public function setTableHeaders() {
    if (is_array($this->headers) && !empty($this->headers)) {
      foreach ($this->headers as $header) {
        $this->Cell(60, 7, $header, 1, 0, "C");
      }
    }
    $this->Ln();
  }

  public function fillTableWithData() {
    $this->setTableHeaders();
    $i = 0;
    foreach ($this->data as $t) {
      foreach ($t as $v) {
        if ($i == 3) {
          $i = 0;
          break;
        }
        $this->Cell(60, 7, $v, 1, 0, "C");
        $i++;
      }
      $this->Ln();
    }
    $this->Ln(10);
  }

  public function printText($text) {
    // Times 12
    $this->SetFont('freeserif', '', 12);
    // Output justified text
    $this->MultiCell(0, 5, $text, 0, '', 0, 1, '', '', true);
    // Line break
    $this->Ln(0);
  }
  
  public function signature() {
    $w = $this->GetStringWidth($this->name);
    $this->SetFont('freeserif', '', 12);
    $this->Ln(14);
    $this->Cell(170-$w);
    $this->Cell(10, 10, "Nastavnik (asistent)");
    $this->Ln(10);
    $this->Cell(165-$w);
    $this->Cell(10, 10, ".........................................");
    // address
    $this->Ln(5);
    $this->Cell(172-$w);
    $this->Cell(10, 10, $this->name);
  }
}

?>
