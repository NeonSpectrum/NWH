<?php
use setasign\Fpdi\Fpdi;

require_once '../autoload.php';

if (isset($_GET['BookingID'])) {
  $rooms  = [];
  $result = $db->query("SELECT DISTINCT(RoomType),COUNT(RoomType) AS NumberOfRoomType,FirstName,LastName,booking.BookingID,account.EmailAddress,CheckInDate,CheckOutDate,TotalAmount FROM account JOIN booking ON account.EmailAddress=booking.EmailAddress JOIN booking_room ON booking.BookingID=booking_room.BookingID JOIN room ON booking_room.RoomID=room.RoomID JOIN room_type ON room.RoomTypeID=room_type.RoomTypeID WHERE booking.BookingID={$_GET['BookingID']} GROUP BY RoomType");
  while ($row = $result->fetch_assoc()) {
    $rooms[] = str_replace("_", " ", $row['RoomType']) . "({$row['NumberOfRoomType']})";
  }
  $displayRoom = substr(join(", ", $rooms), 0, 30) . "...";
  $result->data_seek(0);
  $row = $result->fetch_assoc();
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
  $pdf->Write(0, $displayRoom);
  $pdf->SetXY(135, 101.5);
  $pdf->Write(0, "P" . number_format($row['TotalAmount']));

  $pdf->Output("{$row['FirstName']}{$row['LastName']}ReservationConfirmation.pdf", "I");
}

?>