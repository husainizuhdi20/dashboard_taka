<?php
require 'assets/pdf/fpdf.php';
require 'function.php';

if(isset($_POST["exportPdf"])) {
    $tahunReport = $_POST["inputReport"];
    
    // Running
    $runAnnual = runningFr($tahunReport);
        foreach($runAnnual as $ra){
    $dra =  $ra['timeRunAn'];
    }

    // Setup
    


    // Workpiece
    $workpieceAnnual = workpieceFr($tahunReport);
        foreach($workpieceAnnual as $wa){
    $dworkpiece =  $wa['timeWorkpieceAn'];
    }
    // Tools
    $toolsAnnual = toolsFr($tahunReport);
        foreach($toolsAnnual as $ta){
    $dtools =  $ta['timeToolsAn'];
    }

    // Break
    // $breakAnnual = breakFr($tahunReport);
    //     foreach($breakAnnual as $ba1){
    // $dbreak =  $ba1['timeBreakAn'];
    // }

    // Idle
    $idleAnnual = idleFr($tahunReport);
        foreach($idleAnnual as $ia){
    $dia =  $ia['timeIdleAn'];
    }

    // Breakdown
    $breakdownAnnual = breakdownFr($tahunReport);
        foreach($breakdownAnnual as $ba2){
    $dbreakdown =  $ba2['timeBreakdownAn'];
    }

    // Product Good
    $goodAnnual = goodFr($tahunReport);
        foreach($goodAnnual as $ga){
    $dgood =  $ga['timeGoodAn'];
    }

    // Product Failed
    $rejectAnnual = rejectFr($tahunReport);
        foreach($rejectAnnual as $ra){
    $dreject =  $ra['timeRejectAn'];
    }

    // Utilisasi
    $utilAnnual = utilisasiFr($tahunReport);
    foreach($utilAnnual as $ua){
        $query1 =  $ua['availAn'];
        $query2 = "7603200";  //waktu sekon dalam 1 tahun 
        $dua = ($query1 / $query2)*100;
    }

    // Energy
    $queryc = currentMonthFr();
    foreach($queryc as $c1){
        $qenergy =  $c1['energyMonthAn'];
    }

    // Average Energy


    // Jumlah pekerjaan
    $pekerjaanAnnual = jumPekerjaanFr($tahunReport);
    foreach($pekerjaanAnnual as $pa){
        $dpekerjaan =  $pa['jumPekerjaanAn'];
    }

    // Maintenance

}

// $tess = timeRun();
// foreach($tess as $t11){
//     $ttt =  $t11['all_running'];
// }

// Extend FPDF class
class PDF extends FPDF
{
    // Page header
    function Header()
    {
        global $tahunReport;
        // Logo image
        $this->Image('assets/images/logo.jpg', 150, 10, 50, 0, '', '');
        
        
        // Arial bold 15
        $this->SetFont('Arial','B',30);
        
        // Header text
        $this->Cell(80,10,'Annual Machine Report',0,0,'L');
        
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(0, 0, 0);
    
        // Image caption
        $this->Cell(170, 40, 'Report tahun  '.$tahunReport, 0, 0, 'C');
       
        // Line break
        $this->Ln(10);
    }
    
    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Create new PDF document
$pdf = new PDF();

// Add new page
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial','',12);

$pdf->Cell(5,10,'Machine ID: Lathe');

// Image
$pdf->Image('assets/images/machine/bubut.png', 10, 25, 30, 0, '', '');

$pdf->Ln();
$pdf->Cell(50);
$pdf->Cell(45,10,'Jumlah Pekerjaan',1);
$pdf->Cell(45,10,$dpekerjaan,1);
$pdf->Ln();
$pdf->Cell(50);
$pdf->Cell(45,10,'Maintenance',1);
$pdf->Cell(45,10,'4/4',1);
$pdf->Ln();
$pdf->Cell(50);
$pdf->Cell(45,10,'Breakdown',1);
$pdf->Cell(45,10,'',1);
$pdf->Ln();

$pdf->Cell(5,30,'Production');
// production
$pdf->Ln(20);
$pdf->SetFont('Arial','B', 12);
$width_cell=array(35,35,35,35);
$pdf->SetFillColor(133,136,133);
// $pdf->Cell($width_cell[0],10,'No',1,0,'C', true);
$pdf->Cell($width_cell[0],10,'Good Product',1,0,'C', true);
$pdf->Cell($width_cell[1],10,'Failed Product',1,0,'C', true);
$pdf->Cell($width_cell[2],10,'Utilization',1,0,'C', true);
$pdf->Cell($width_cell[3],10,'Maintenance',1,1,'C', true);
// header over //

$pdf->SetFont('Arial', '', 10);
// $pdf->Cell($width_cell[0],10,'1',1,0,'C',false);
$pdf->Cell($width_cell[0],10,$dgood,1,0,'C',false);
$pdf->Cell($width_cell[1],10,$dreject,1,0,'C',false);
$pdf->Cell($width_cell[2],10,$dua.'%',1,0,'C',false);
$pdf->Cell($width_cell[3],10,'100'.'%',1,1,'C',false);
$pdf->Ln();
$pdf->Cell(5,30,'Utilization');

// utilisasi
$pdf->Ln(20);
$pdf->SetFont('Arial','B', 12);
$width_cell=array(35,25,25,25,25,35);
$pdf->SetFillColor(133,136,133);

// $pdf->Cell($width_cell[0],10,'No',1,0,'C', true);
$pdf->Cell($width_cell[0],10,'Workpiece Time',1,0,'C', true);
$pdf->Cell($width_cell[1],10,'Tools Time',1,0,'C', true);
$pdf->Cell($width_cell[2],10,'Run Time',1,0,'C', true);
$pdf->Cell($width_cell[3],10,'Break Tme',1,0,'C', true);
$pdf->Cell($width_cell[4],10,'Idle Tme',1,0,'C', true);
$pdf->Cell($width_cell[5],10,'Breakdown Time',1,1,'C', true);
// header over //

$pdf->SetFont('Arial', '', 10);
// $pdf->Cell($width_cell[0],10,'1',1,0,'C',false);
$pdf->Cell($width_cell[0],10,$dworkpiece,1,0,'C',false);
$pdf->Cell($width_cell[1],10,$dtools,1,0,'C',false);
$pdf->Cell($width_cell[2],10,$dra,1,0,'C',false);
$pdf->Cell($width_cell[3],10,$dia,1,0,'C',false);
$pdf->Cell($width_cell[4],10,$dia,1,0,'C',false);
$pdf->Cell($width_cell[5],10,$dbreakdown,1,0,'C',false);
$pdf->Ln();
$pdf->Cell(5,45,'Energy');
// energy
$pdf->Ln(30);
$pdf->SetFont('Arial','B', 12);
$width_cell=array(30,50);
$pdf->SetFillColor(133,136,133);
// $pdf->Cell($width_cell[0],10,'No',1,0,'C', true);
$pdf->Cell($width_cell[0],10,'Total Energy',1,0,'C', true);
$pdf->Cell($width_cell[1],10,'Average Consumption',1,1,'C', true);
// header over //

$pdf->SetFont('Arial', '', 10);
// $pdf->Cell($width_cell[0],10,'1',1,0,'C',false);
$pdf->Cell($width_cell[0],10,$qenergy,1,0,'C',false);
$pdf->Cell($width_cell[1],10,'64.864',1,1,'C',false);

// $pdf->Cell(10);
// $pdf->SetFont('Arial','',20);
// $pdf->Cell(5,20,'Utilisasi');
// $pdf->SetFont('Arial','',);
// $pdf->Cell(5,40,'78 %');
// $pdf->Cell(40);
// $pdf->Cell(5,20,'Part Replacement');
// $pdf->SetFont('Arial','',20);
// $pdf->Cell(15,40,'3');
// $pdf->Cell(60);
// $pdf->Cell(5,20,'Part Repaired');
// $pdf->SetFont('Arial','',20);
// $pdf->Cell(15,40,'2');
// $pdf->Ln();

// $pdf->Cell(40);
// $pdf->SetFont('Arial','',20);
// $pdf->Cell(5,20,'Machine Runtime');
// $pdf->SetFont('Arial','',);
// $pdf->Cell(5,40, '20');
// $pdf->Cell(60);
// $pdf->Cell(5,20,'Total Energy');
// $pdf->SetFont('Arial','',20);
// $pdf->Cell(15,40,'3');
// $pdf->Ln();

// $pdf->Cell(50);

// $pdf->Ln();
// $pdf->Cell(30);
// $pdf->SetFont('Arial','',20);
// $pdf->Cell(5,20,'Setup');
// $pdf->SetFont('Arial','',);
// $pdf->Cell(5,40,'16.966');
// $pdf->Cell(40);
// $pdf->Cell(5,20,'Running');
// $pdf->SetFont('Arial','',20);
// $pdf->Cell(15,40, $dra);
// $pdf->Cell(40);
// $pdf->Cell(5,20,'Break');
// $pdf->SetFont('Arial','',20);
// $pdf->Cell(15,40,'8.933');

// $pdf->Ln();

// $pdf->Cell(50);
// $pdf->SetFont('Arial','',20);
// $pdf->Cell(5,20,'Idle');
// $pdf->SetFont('Arial','',);
// $pdf->Cell(5,40,'15.298');
// $pdf->Cell(60);
// $pdf->Cell(5,20,'Breakdown');
// $pdf->SetFont('Arial','',20);
// $pdf->Cell(15,40,'0');
// $pdf->Ln();
// $pdf->Cell(70);
// $pdf->Cell(5,20,'Total Energy');
// $pdf->SetFont('Arial','',20);
// $pdf->Cell(15,40,'3');

// Output document
$pdf->Output();

?>