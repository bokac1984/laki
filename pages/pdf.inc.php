<?php
//require('incl'.DIRECTORY_SEPARATOR.'fpdf.php');
//
//$pdf = new FPDF();
//$pdf->AddPage();
//$pdf->SetFont('Arial','B',16);
//$pdf->Cell(40,10,'Hello World!');
//$pdf->Output('bokac', 'I');
//$pdf->Close();
include "incl/data.inc.php"; 
$izvjestaj->debug($izvjestaj->getBrCasovaPerNastavnik(12, 2012));
?>
