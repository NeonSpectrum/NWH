<?php
@session_start();
use setasign\Fpdi\Fpdi;

require_once '../autoload.php';

$pdf = new Fpdi();
$pdf->AddPage();
$pdf->SetTitle('Northwood Reservation Confirmation');
$pdf->SetFont('Arial');
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFontSize('10');

$pdf->Image('../../images/logo-rendered.png', 10, 10, -300);
// DEAR
$pdf->SetFont('Arial', 'B', '9');
$pdf->SetXY(25, 60.7);
$pdf->Write(0, "<img");

$pdf->Output("ReservationConfirmation.pdf", "I");

?>