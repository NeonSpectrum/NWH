<?php
@session_start();
use setasign\Fpdi\Fpdi;

require_once '../autoload.php';

if (isset($_GET['BookingID'])) {
  $rooms  = [];
  $result = $db->query("SELECT DISTINCT(RoomType),COUNT(RoomType) AS NumberOfRoomType,FirstName,LastName,AccountType,booking.BookingID,DateCreated,account.EmailAddress,CheckInDate,CheckOutDate,TotalAmount FROM account JOIN booking ON account.EmailAddress=booking.EmailAddress JOIN booking_room ON booking.BookingID=booking_room.BookingID JOIN room ON booking_room.RoomID=room.RoomID JOIN room_type ON room.RoomTypeID=room_type.RoomTypeID WHERE booking.BookingID={$_GET['BookingID']} GROUP BY RoomType");
  $row    = $result->fetch_assoc();
  if (!$system->isLogged()) {
    echo "Login first to view this file.";
  } else if ($system->isLogged() && $_SESSION['email'] != $row['EmailAddress'] && !$system->checkUserLevel(1)) {
    echo "You are not allowed to view this file.";
  } else {
    if ($result->num_rows > 0) {
      do {
        $rooms[] = str_replace("_", " ", $row['RoomType']) . "({$row['NumberOfRoomType']})";
      } while ($row = $result->fetch_assoc());
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
      $pdf->SetXY(48, 110);
      $pdf->Write(0, "nwh" . str_replace("-", "", date("m-d-y", strtotime($row['DateCreated']))) . "-" . sprintf("% '04d\n", $row['BookingID']));
      $pdf->SetXY(135, 87.5);
      $pdf->Write(0, "2:00pm");
      $pdf->SetXY(135, 92);
      $pdf->Write(0, "12:00nn");
      $pdf->SetXY(135, 97);
      $pdf->Write(0, $row['AccountType']);
      $pdf->SetXY(135, 110);
      $pdf->Write(0, "P" . number_format($row['TotalAmount']));
      $pdf->SetXY(48, 101.5);
      $pdf->Write(0, join(", ", array_slice($rooms, 0, 4)));
      $pdf->SetXY(48, 105.5);
      $pdf->Write(0, join(", ", array_slice($rooms, 4)));

      $pdf->Output("{$row['FirstName']}{$row['LastName']}ReservationConfirmation.pdf", "I");
    }
  }
}

?>