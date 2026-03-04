<?php
require_once('fpdf/fpdf.php');
require_once('fpdi/src/autoload.php');

use setasign\Fpdi\Fpdi;

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $so_number = $_POST['so_number'] ?? '';
    $year      = $_POST['year'] ?? '';
    $name      = $_POST['district'] ?? '';
    $position  = $_POST['position'] ?? '';
    $office    = $_POST['office'] ?? '';
    $date      = $_POST['date'] ?? '';
    $place     = $_POST['zone'] ?? '';
    $conforme  = $_POST['conforme'] ?? '';

    $pdf = new Fpdi();
    $pdf->AddPage();

    // Import template
    $pdf->setSourceFile("template.pdf");
    $template = $pdf->importPage(1);
    $pdf->useTemplate($template, 0, 0, 210, 297); // full A4 page

    $pdf->SetFont('Times','',12);

    /* ===== ADJUST THESE POSITIONS BASED ON YOUR TEMPLATE ===== */

    $pdf->SetFont('Times','',12);
    $pdf->SetXY(149, 75);  // exact measurement from template
    $pdf->Cell(40, 6, date("F d, Y", strtotime($date)), 0, 0, 'L');

    // Special Order No
   $pdf->SetXY(39, 90);  // exact measurement from template
   $pdf->Cell(50, 6, "$so_number, s. $year", 0, 0, 'L');

// Zone ✅ NEW
   $pdf->SetXY(39, 102);
   $pdf->Cell(100,6, $place, 0, 0, 'L');

    // District
    $pdf->SetXY(30, 109);
    $pdf->Cell(100,6, $name, 0, 0, 'L');

    // Position
    $pdf->SetXY(110, 139);
    $pdf->Cell(100,6, $position, 0, 0, 'L');

    // Office
    $pdf->SetXY(62, 152);
    $pdf->Cell(100,6, $office, 0, 0, 'L');

    // Conforme
    $pdf->SetXY(30, 217);
    $pdf->Cell(100,6, $conforme, 0, 0, 'L');

    $pdf->Output();
}
?>