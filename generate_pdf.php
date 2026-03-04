<?php
include "config/db.php";

require_once('fpdf/fpdf.php');
require_once('fpdi/src/autoload.php');

use setasign\Fpdi\Fpdi;


function formatDateLong($date)
{
    if (empty($date) || $date == "0000-00-00") {
        return "";
    }
    return date("F d, Y", strtotime($date));
}

/* ===============================
   HANDLE REQUEST
================================ */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // FROM MODAL (INSERT NEW)
    $data = $_POST;

    $stmt = $conn->prepare("INSERT INTO appointments (
    fullname, address, position, sg, status, office,
    salary_words, salary_amount, nature, vice_name, vice_status,
    plantilla, page_no, date_signing, authorized_official,
    csc_date, published_at, published_from, published_to,
    posted_from, posted_to, hrmpsb_start, deliberation_date,
    ack_date, appointee, created_at
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())");

    $stmt->bind_param(
        "sssssssssssssssssssssssss",
        $data['fullname'],
        $data['address'],
        $data['position'],
        $data['sg'],
        $data['status'],
        $data['office'],
        $data['salary_words'],
        $data['salary_amount'],
        $data['nature'],
        $data['vice_name'],
        $data['vice_status'],
        $data['plantilla'],
        $data['page_no'],
        $data['date_signing'],
        $data['authorized_official'],
        $data['csc_date'],
        $data['published_at'],
        $data['published_from'],
        $data['published_to'],
        $data['posted_from'],
        $data['posted_to'],
        $data['hrmpsb_start'],
        $data['deliberation_date'],
        $data['ack_date'],
        $data['appointee']
    );

    $stmt->execute();
    $stmt->close();

} elseif (isset($_GET['id'])) {

    // FROM TABLE (PRINT EXISTING)
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM appointments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if (!$data) {
        die("Record not found");
    }

    $stmt->close();

} else {
    die("Invalid request");
}



$published_from = formatDateLong($data['published_from']);
$published_to = formatDateLong($data['published_to']);
$posted_from = formatDateLong($data['posted_from']);
$posted_to = formatDateLong($data['posted_to']);
$hrmpsb_start = formatDateLong($data['hrmpsb_start']);
$deliberation_date = formatDateLong($data['deliberation_date']);
$ack_date = formatDateLong($data['ack_date']);


class PDF extends Fpdi
{
    function Header()
    {
    }
    function Footer()
    {
    }
}

$pdf = new PDF();
$pdf->SetAutoPageBreak(false);

$pdf->AddFont('Bookman', '', 'BOOKOS.php');
$pdf->setSourceFile("template.pdf");


$pdf->AddPage('P', 'Legal');
$template1 = $pdf->importPage(1);
$pdf->useTemplate($template1, 0, 0, 216, 356);

$pdf->SetFont('Bookman', '', 11);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetXY(46, 82);
$pdf->Cell(110, 6, strtoupper($data['fullname']), 0, 0, 'L');

$pdf->SetXY(45, 89);
$pdf->Cell(80, 6, strtoupper($data['address']), 0, 0, 'L');

$pdf->SetXY(100, 104);
$pdf->Cell(90, 6, $data['position'], 0, 0, 'L');

$pdf->SetXY(29, 112);
$pdf->Cell(20, 6, $data['sg'], 0, 0, 'C');

$pdf->SetXY(98, 112);
$pdf->Cell(60, 6, $data['status'], 0, 0, 'L');

$pdf->SetXY(48, 133);
$pdf->Cell(120, 6, $data['office'], 0, 0, 'L');

$pdf->SetXY(97, 145);
$pdf->Cell(80, 6, $data['salary_words'], 0, 0, 'L');

$pdf->SetXY(173, 146);
$pdf->Cell(30, 6, $data['salary_amount'], 0, 0, 'L');

$pdf->SetXY(139, 163);
$pdf->Cell(95, 6, $data['nature'], 0, 0, 'L');

$pdf->SetXY(50, 175);
$pdf->Cell(85, 6, $data['vice_name'], 0, 0, 'L');

$pdf->SetXY(135, 175);
$pdf->Cell(45, 6, $data['vice_status'], 0, 0, 'L');

$pdf->SetXY(90, 190);
$pdf->Cell(85, 6, $data['plantilla'], 0, 0, 'L');

$pdf->SetXY(161, 190);
$pdf->Cell(20, 6, $data['page_no'], 0, 0, 'L');

/* 🔥 PAGE 1 DATES (UNCHANGED FORMAT) */

$pdf->SetXY(148, 247);
$pdf->Cell(40, 6, $data['date_signing'], 0, 0, 'L');

$pdf->SetXY(40, 305);
$pdf->Cell(90, 6, $data['authorized_official'], 0, 0, 'L');

$pdf->SetXY(39, 319);
$pdf->Cell(60, 6, $data['csc_date'], 0, 0, 'L');



$pdf->AddPage('P', 'Legal');
$template2 = $pdf->importPage(2);
$pdf->useTemplate($template2, 0, 0, 216, 356);

$pdf->SetFont('Bookman', '', 9);

$pdf->SetXY(90, 43);
$pdf->Cell(90, 6, $data['published_at'], 0, 0, 'L');

$pdf->SetXY(174, 43);
$pdf->Cell(30, 6, $published_from, 0, 0, 'L');

$pdf->SetXY(25, 50);
$pdf->Cell(40, 6, $published_to, 0, 0, 'L');

$pdf->SetXY(137, 50);
$pdf->Cell(40, 6, $posted_from, 0, 0, 'L');

$pdf->SetXY(171, 50);
$pdf->Cell(40, 6, $posted_to, 0, 0, 'L');

$pdf->SetXY(70, 65);
$pdf->Cell(40, 6, $hrmpsb_start, 0, 0, 'L');

$pdf->SetXY(110, 119);
$pdf->Cell(40, 6, $deliberation_date, 0, 0, 'L');

$pdf->SetXY(170, 296);
$pdf->Cell(40, 6, $ack_date, 0, 0, 'L');

$pdf->SetXY(135, 321);
$pdf->Cell(100, 6, strtoupper($data['appointee']), 0, 0, 'L');

$pdf->Output("I", "Appointment.pdf");
exit;