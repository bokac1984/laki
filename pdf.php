<?php 
session_start();
if (isset($_POST['pdf'])) {
  extract($_POST);
} else {
  header('Location: index.php?page=nastava');
}

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

include "incl/data.inc.php"; 

require('incl'.DIRECTORY_SEPARATOR.'reportPDF.class.php');

// create new PDF document
$pdf = new reportPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 55, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set color for text
$pdf->SetTextColor(0, 0, 0);
// ---------------------------------------------------------

$pdf->SetFont('freeserif', '', 12);
$pdf->startPageGroup();
$reports = $izvjestaj->getBrCasovaPerNastavnik($month, $year);
if (empty($reports)) {
  $_SESSION['pdf-error'] = 'Nema podataka za ovaj mjesec';
  //header('Location: index.php?page=nastava');
}
foreach ($reports as $k => $info) {
    // set font
    $pdf->SetFont('freeserif', '', 12);
    // add a page
    $pdf->AddPage();
    //$pdf->setHeaderss();
    $pdf->loadData($info);
    //$pdf->Cell(0, 10, 'This is the second page of group 1', 0, 1, 'L');
    $pdf->Ln(30);
    $pdf->setPageTitle(strtolower($months[$month]), $year);
    $pdf->setH(array('Naziv predmeta', 'Datum', 'Broj održanih časova'));
    $pdf->fillTableWithData();
    $pdf->printText("Izvještaj je osnova za izračunavanje mjesečnih primanja u skladu sa Pravilnikom o normativima i standardim u finansiranju u visokom obrazovanju.");
    $pdf->printText("Izvještaj predati prodekanu za nastavu, najkasnije do 5.-og u sljedećem mjesecu.");
    $pdf->signature();
}
//Close and output PDF document
$pdf->Output("izvjestaj_nastava_$year-$month.pdf", "I");

//============================================================+
// END OF FILE
//============================================================+