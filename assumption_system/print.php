<?php
require('config.php');
require('fpdf/fpdf.php');
require('fpdf/makefont/makefont.php');

/* ==============================
   FETCH DATA FROM DATABASE
============================== */

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM assumption_records WHERE id = $id");

if($result->num_rows == 0){
    die("Record not found.");
}

$row = $result->fetch_assoc();

$fullname             = $row['fullname'];
$position             = $row['position'];
$office               = $row['office'];
$effective_date       = date("F d, Y", strtotime($row['effective_date']));
$appointment_name     = $row['appointment_name'];
$appointment_position = $row['appointment_position'];
$day_signed           = $row['day_signed'];
$month_signed         = $row['month_signed'];
$year_signed          = $row['year_signed'];
$sig_name             = $row['sig_name'];
$sig_rank             = $row['sig_rank'];
$sig_place            = $row['sig_place'];
$hrmo_name            = $row['hrmo_name'];
$hrmo_rank            = $row['hrmo_rank'];
$generated_date       = date("F d, Y");

/* ==============================
   FONT GENERATION
============================== */

$fontFolder = 'C:/xampp/htdocs/coatd/fpdf/font/';

// Tex Gyre Bonum fonts
$regularTTF = 'C:/xampp/htdocs/coatd/fonts/tex-gyre-bonum-font/TexgyrebonumRegular-87LB.ttf';
$boldTTF    = 'C:/xampp/htdocs/coatd/fonts/tex-gyre-bonum-font/TexgyrebonumBold-1oE4.ttf';
$italicTTF  = 'C:/xampp/htdocs/coatd/fonts/tex-gyre-bonum-font/TexgyrebonumItalic-B75l.ttf';

$regularPHP = $fontFolder . 'TexgyrebonumRegular-87LB.php';
$boldPHP    = $fontFolder . 'TexgyrebonumBold-1oE4.php';
$italicPHP  = $fontFolder . 'TexgyrebonumItalic-B75l.php';

if (!file_exists($regularPHP)) { MakeFont($regularTTF, 'cp1252', true, $fontFolder); }
if (!file_exists($boldPHP))    { MakeFont($boldTTF, 'cp1252', true, $fontFolder); }
if (!file_exists($italicPHP))  { MakeFont($italicTTF, 'cp1252', true, $fontFolder); }

// Calibri fonts
$calibriRegularTTF = 'C:/xampp/htdocs/coatd/fonts/calibri.ttf';
$calibriBoldTTF    = 'C:/xampp/htdocs/coatd/fonts/calibri_bold.ttf';
$calibriRegularPHP = $fontFolder . 'calibri.php';
$calibriBoldPHP    = $fontFolder . 'calibri_bold.php';

if (!file_exists($calibriRegularPHP)) { MakeFont($calibriRegularTTF, 'cp1252', true, $fontFolder); }
if (!file_exists($calibriBoldPHP))    { MakeFont($calibriBoldTTF, 'cp1252', true, $fontFolder); }

// Opti Engravers
$optiTTF = 'C:/xampp/htdocs/coatd/fonts/OPTIEngraversOldEnglish.ttf';
$optiPHP = $fontFolder . 'OPTIEngraversOldEnglish.php';
if (!file_exists($optiPHP)) { MakeFont($optiTTF, 'cp1252', true, $fontFolder); }

/* ==============================
   PDF CLASS
============================== */

class PDF extends FPDF {

    function Header() {
        // Add fonts
        $this->AddFont('TexGyreBonum','', 'TexgyrebonumRegular-87LB.php');
        $this->AddFont('TexGyreBonum','B','TexgyrebonumBold-1oE4.php');
        $this->AddFont('TexGyreBonum','I','TexgyrebonumItalic-B75l.php');

        $this->AddFont('Calibri','', 'calibri.php');
        $this->AddFont('Calibri','B','calibri_bold.php');

        $this->AddFont('OPTIEngraversOldEnglish','','OPTIEngraversOldEnglish.php');

        // CS Form info
        $this->SetFont('TexGyreBonum','B',10);
        $this->Cell(0,5,'CS Form No. 4',0,1,'L');
        $this->SetFont('TexGyreBonum','I',10);
        $this->Cell(0,5,'Revised 2025',0,1,'L');

        $this->Ln(5);

// Logo
$logoPath = 'Dep.png';
$logoWidth = 50;
$logoHeight = 30;
$centerX = ($this->GetPageWidth() - $logoWidth) / 2;

if(file_exists($logoPath)){
    $this->SetY($this->GetY() - 10); 
    $this->Image($logoPath, $centerX, $this->GetY(), $logoWidth, $logoHeight);
}

$this->Ln($logoHeight - 3); 

        // Titles
        $this->SetFont('OPTIEngraversOldEnglish','',13);
        $this->Cell(0,6,'Republic of the Philippines',0,1,'C');
        $this->SetFont('OPTIEngraversOldEnglish','',18);
        $this->Cell(0,6,'Department of Education',0,1,'C');

        $this->SetFont('Calibri','B',12);
        $this->Cell(0,6,'REGION VIII - EASTERN VISAYAS',0,1,'C');
        $this->Cell(0,6,'SCHOOLS DIVISION OF SOUTHERN LEYTE',0,1,'C');

        $this->SetLineWidth(0.6);
        $this->Line(25, $this->GetY()+2, 190, $this->GetY()+2);
        $this->Ln(15);

        $this->SetFont('TexGyreBonum','B',14);
        $this->Cell(0,10,'CERTIFICATION OF ASSUMPTION TO DUTY',0,1,'C');
        $this->Ln(10);

        $this->SetLineWidth(0.2);
    }

    function Footer() {
        $this->SetY(-35);

        // Thick line above footer
        $this->SetLineWidth(0.6);
        $this->Line(25, $this->GetY(), 190, $this->GetY());
        $this->Ln(3);

        // Footer logos - bigger and closer
        $logoHeight = 17;
        $logoSpacing = 3;
        $x = 25;
        $y = $this->GetY();

        $logos = ['DepEd.png', 'bagongph.png', 'division.jpg'];
        foreach($logos as $logo){
            if(file_exists($logo)){
                $this->Image($logo, $x, $y, 0, $logoHeight);
                $x += $logoHeight + $logoSpacing;
            }
        }

        // Contact info
        $contactX = $x;
        $contactY = $y;
        $this->SetXY($contactX, $contactY);

        $lineHeight = 5;
        $this->SetFont('Calibri','B',10);
        $this->Cell(19,$lineHeight,'Address:',0,0);
        $this->SetFont('Calibri','',10);
        $this->Cell(0,$lineHeight,'R. Kangleon St., Mantahan, Maasin City, Southern Leyte',0,1);

        $this->SetX($contactX);
        $this->SetFont('Calibri','B',10);
        $this->Cell(23,$lineHeight,'Landline No.:',0,0);
        $this->SetFont('Calibri','',10);
        $this->Cell(0,$lineHeight,'(053) 570-2916',0,1);

        $this->SetX($contactX);
        $this->SetFont('Calibri','B',10);
        $this->Cell(25,$lineHeight,'Email Address:',0,0);
        $this->SetFont('Calibri','',10);
        $this->Cell(0,$lineHeight,'southernleyte.division@deped.gov.ph',0,1);
    }
}

/* ==============================
   CREATE PDF
============================== */

$pdf = new PDF('P','mm','Legal');
$pdf->SetMargins(25,20,25);
$pdf->AddPage();
$pdf->SetFont('TexGyreBonum','',12);

/* ==============================
   INLINE BLANK FUNCTION
============================== */
function InlineBlank($pdf, $text, $padding = 6, $height = 8) {
    $textWidth = $pdf->GetStringWidth($text);
    $cellWidth = $textWidth + $padding;
    $pdf->Cell($cellWidth, $height, $text, 'B', 0, 'C');
}

$indent = 10;

/* ==============================
   MAIN CONTENT
============================== */
$pdf->SetX($pdf->GetX() + $indent);
$pdf->Write(8,"This is to certify that Mr./Ms. ");
InlineBlank($pdf, $fullname);
$pdf->Write(8," has assumed the duties and responsibilities as ");
InlineBlank($pdf, $position);
$pdf->Write(8," of ");
InlineBlank($pdf, $office);
$pdf->Write(8," effective ");
InlineBlank($pdf, $effective_date);
$pdf->Write(8,".");
$pdf->Ln(15);

$pdf->SetX($pdf->GetX() + $indent);
$pdf->Write(8,"This certification is issued in connection with the issuance of the appointment of Mr./Ms. ");
InlineBlank($pdf, $appointment_name);
$pdf->Write(8," as ");
InlineBlank($pdf, $appointment_position);
$pdf->Write(8,".");
$pdf->Ln(15);

$pdf->SetX($pdf->GetX() + $indent);
$pdf->Write(8,"Done this ");
InlineBlank($pdf, $day_signed);
$pdf->Write(8," day of ");
InlineBlank($pdf, $month_signed);
$pdf->Write(8,", ");
InlineBlank($pdf, $year_signed);
$pdf->Write(8," in the Department of Education - Division of Southern Leyte.");
$pdf->Ln(25);

/* ==============================
   SIGNATURES
============================== */

$blockWidth = 80; 
$rightMargin = 25;
$xPos = $pdf->GetPageWidth() - $blockWidth - $rightMargin; 

// Name – Bold
$pdf->SetX($xPos);
$pdf->SetFont('TexGyreBonum','B',12);
$pdf->Cell($blockWidth, 5, $sig_name, 0, 1, 'C');

// Rank – Normal
$pdf->SetX($xPos); 
$pdf->SetFont('TexGyreBonum','',12);
$pdf->Cell($blockWidth, 5, $sig_rank, 0, 1, 'C');

$pdf->SetX($xPos); 
$pdf->Cell($blockWidth, 5, $sig_place, 0, 1, 'C');

$pdf->Ln(10);

// Date
$pdf->Cell(15, 8, 'Date:', 0, 0);
$pdf->Cell($pdf->GetStringWidth($generated_date)+6, 8, $generated_date, 'B', 1, 'C');
$pdf->Ln(5);
$pdf->Cell(0,5,'Attested by:',0,1);
$pdf->Ln(25);

// HRMO signature block – Bold Name
$pdf->SetFont('TexGyreBonum','B',12);
$pdf->Cell(80, 4, $hrmo_name, 0, 1, 'C');  
$pdf->SetFont('TexGyreBonum','',12);
$pdf->Cell(80, 4, $hrmo_rank, 0, 1, 'C');  
$pdf->Cell(80, 4, 'HRMO', 0, 1, 'C');  

/* ==============================
   BOTTOM BOXES
============================== */
$pdf->SetFont('TexGyreBonum','I',12);

$footerHeight = 35; 
$pageHeight = $pdf->GetPageHeight();
$boxesY = $pageHeight - $footerHeight - 25;

// Left Box
$leftBoxWidth = 20;
$leftBoxHeight = 23;
$leftX = 25;
$leftY = $boxesY;

$pdf->SetXY($leftX, $leftY);
$pdf->Cell($leftBoxWidth, $leftBoxHeight, '', 1);

// Start text inside the box
$pdf->SetXY($leftX, $leftY + 2); // 2mm padding from top
$pdf->SetFont('TexGyreBonum','I',11); // smaller font to fit box
$pdf->Cell($leftBoxWidth, 4, '201 File', 0, 1, 'C'); // 4mm height per line
$pdf->Cell($leftBoxWidth, 4, 'Admin', 0, 1, 'C');
$pdf->Cell($leftBoxWidth, 4, 'COA', 0, 1, 'C');
$pdf->Cell($leftBoxWidth, 4, 'CSC', 0, 1, 'C');

// Right Box
$rightBoxWidth = 55;
$rightBoxHeight = 23;
$rightX = $pdf->GetPageWidth() - $rightBoxWidth - 25;
$pdf->SetXY($rightX, $boxesY);
$pdf->Cell($rightBoxWidth, $rightBoxHeight,'',1);

// Centered MultiCell text
$rightText = "For submission to CSC FO\nwithin 30 days from the\ndate of assumption of the\nappointee";
$pdf->SetXY($rightX, $boxesY + 2);
$pdf->MultiCell($rightBoxWidth, 5, $rightText, 0, 'C');
/* ==============================
   OUTPUT
============================== */
$pdf->Output('I','Certification_of_Assumption_to_Duty.pdf');
?>