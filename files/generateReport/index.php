<?php
@session_start();
use setasign\Fpdi\Fpdi;
setlocale(LC_CTYPE, 'en_US');
require_once '../autoload.php';

if (isset($_GET['daterange']) && $account->checkUserLevel(2)) {
  $daterange = explode("-", $_GET['daterange']);
  $from      = $daterange[0];
  $to        = $daterange[1];

  $column = ["Booking ID", "Name", "Check In Date", "Check Out Date", "Total Amount"];
  $width  = [38, 38, 38, 38, 38];
  $pdf    = new Fpdi();
  $pdf->AddPage();
  $pdf->SetTitle('Northwood Hotel Summary Report');
  $pdf->SetFont('Arial');
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFontSize('10');
  $pdf->Image('../../images/logo-white.jpg', 15, 10, 50);
  $pdf->Cell(60, 22, "", 0, 0, 'L');
  $pdf->SetFontSize('16', 'B');
  $pdf->Cell(130, 22, "Summary Report from " . date("m/d/Y", strtotime($from)) . " to " . date("m/d/Y", strtotime($to)), 0, 1);
// COLUMNS
  $pdf->SetFontSize('10');
  $pdf->SetFillColor(16, 44, 88);
  $pdf->SetTextColor(255, 255, 255);
  for ($i = 0; $i < count($column); $i++) {
    $pdf->Cell($width[$i], 10, $column[$i], 1, 0, 'C', true);
  }
  $pdf->Ln();
  $pdf->SetTextColor(0, 0, 0);

  $dates           = $system->getDatesFromRange($from, $to);
  $numberOfBooking = $totalAmount = 0;
  $result          = $db->query("SELECT * FROM account JOIN booking ON account.EmailAddress=booking.EmailAddress JOIN booking_check ON booking.BookingID=booking_check.BookingID ORDER BY booking.BookingID ASC");
  while ($row = $result->fetch_assoc()) {
    if (in_array($row['CheckInDate'], $dates) && in_array($row['CheckOutDate'], $dates)) {
      $pdf->Cell($width[0], 10, $system->formatBookingID($row['BookingID']), 1, 0, 'C');
      $pdf->Cell($width[1], 10, $row['FirstName'] . " " . $row['LastName'], 1, 0, 'C');
      $pdf->Cell($width[2], 10, $system->formatDate($row['CheckInDate'], "F d, Y"), 1, 0, 'C');
      $pdf->Cell($width[3], 10, $system->formatDate($row['CheckOutDate'], "F d, Y"), 1, 0, 'C');
      $pdf->Cell($width[4], 10, "P " . number_format($system->computeTotalAmount($row['BookingID'])), 1, 0, 'C');
      $pdf->Ln();
      $totalAmount += $system->computeTotalAmount($row['BookingID']);
      $numberOfBooking++;
    }
  }

  $pdf->SetFontSize('16');
  $pdf->Cell(0, 15, "Number of Booking: $numberOfBooking", 0, 1, "R");
  $pdf->Cell(0, 5, "Total: P " . number_format($totalAmount), 0, 1, "R");
  $pdf->Output("{$_GET['daterange']}-Report.pdf", "I");
} else {
  header("location: ../../");
}
?>