<?php
use setasign\Fpdi\Fpdi;

require '../../assets/fpdf/fpdf.php';
require '../../assets/fpdi/autoload.php';
require_once '../db.php';

if (isset($_GET['BookingID'])) {
  $result = $db->query("SELECT FirstName,LastName,BookingID,account.EmailAddress,RoomType,CheckInDate,CheckOutDate,PeakRate,LeanRate,DiscountedRate FROM account JOIN booking ON account.EmailAddress=booking.EmailAddress JOIN room ON booking.RoomID=room.RoomID JOIN room_type ON room.RoomTypeID=room_type.RoomTypeID WHERE BookingID={$_GET['BookingID']}");
  while ($row = $result->fetch_assoc()) {
    if (mktime(0, 0, 0, 10, 1, date('Y')) < mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y')) && mktime(11, 59, 59, 5, 31, date('Y') + 1) > mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y'))) {
      $price = $row['PeakRate'];
    } else if (mktime(0, 0, 0, 7, 1, date('Y')) < mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y')) && mktime(11, 59, 59, 8, 31, date('Y') + 1) > mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y'))) {
      $price = $row['LeanRate'];
    } else {
      $price = $row['DiscountedRate'];
    }
    $pdf = new Fpdi();
    $pdf->AddPage();
    $pdf->setSourceFile('../../assets/reservation.pdf');
    $tpl = $pdf->importPage(1);
    $pdf->useTemplate($tpl, 5, 10, 200);
    $pdf->SetTitle('Northwood Reservation Confirmation');
    $pdf->SetFont('Arial');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFontSize('10');

    $pdf->SetFont('Arial', 'B', '9');
    $pdf->SetXY(25, 60.7);
    $pdf->Write(0, "{$row['FirstName']} {$row['LastName']}");
    $pdf->SetFontSize('10');
    $pdf->SetFont('Arial');
    $pdf->SetXY(48, 87.5);
    $pdf->Write(0, date("d F Y", strtotime($row['CheckInDate'])));
    $pdf->SetXY(48, 92);
    $pdf->Write(0, date("d F Y", strtotime($row['CheckOutDate'])));
    $pdf->SetXY(48, 97);
    $pdf->SetFont('Arial', 'B');
    $pdf->Write(0, "{$row['FirstName']} {$row['LastName']}");
    $pdf->SetFont('Arial');
    $pdf->SetXY(48, 101.5);
    $pdf->Write(0, sprintf("%'06d\n", $row['BookingID']));
    $pdf->SetXY(135, 87.5);
    $pdf->Write(0, "2:00pm");
    $pdf->SetXY(135, 92);
    $pdf->Write(0, "12:00nn");
    $pdf->SetXY(135, 97);
    $pdf->Write(0, str_replace("_", " ", $row['RoomType']));
    $pdf->SetXY(135, 101.5);
    $pdf->Write(0, "P" . number_format($price));

    $pdf->Output("{$row['FirstName']}{$row['LastName']}ReservationConfirmation.pdf", "I");
  }
}
?>