<?php
@session_start();
use setasign\Fpdi\Fpdi;

require_once '../autoload.php';

if (isset($_GET['BookingID'])) {
  $rooms     = [];
  $bookingID = $system->formatBookingID($_GET['BookingID'], true);
  $result    = $db->query("SELECT DISTINCT(RoomType),COUNT(RoomType) AS NumberOfRoomType,FirstName,LastName,AccountType,booking.BookingID,DateCreated,account.EmailAddress,CheckInDate,CheckOutDate,TotalAmount FROM account JOIN booking ON account.EmailAddress=booking.EmailAddress JOIN booking_room ON booking.BookingID=booking_room.BookingID JOIN room ON booking_room.RoomID=room.RoomID JOIN room_type ON room.RoomTypeID=room_type.RoomTypeID JOIN booking_transaction ON booking.BookingID=booking_transaction.BookingID WHERE booking.BookingID=$bookingID GROUP BY RoomType");
  $row       = $result->fetch_assoc();
  if (!$account->isLogged()) {
    echo 'Login first to view this file.';
  } else if ($account->isLogged() && $system->decrypt($_SESSION['account']) != $row['EmailAddress'] && !$account->checkUserLevel(1)) {
    echo 'You are not allowed to view this file.';
  } else {
    if ($result->num_rows > 0) {
      do {
        $rooms[] = str_replace('_', ' ', $row['RoomType']) . "({$row['NumberOfRoomType']})";
      } while ($row = $result->fetch_assoc());
      $result->data_seek(0);
      $row = $result->fetch_assoc();
      $pdf = new Fpdi();
      $pdf->AddPage();
      $pdf->setSourceFile('../../assets/reservation.pdf');
      $pdf->useTemplate($pdf->importPage(1), 5, 10, 200);
      $pdf->SetTitle('Northwood Reservation Confirmation');
      $pdf->SetFont('Arial');
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFontSize('10');

      // DEAR
      $pdf->SetFont('Arial', 'B', '9');
      $pdf->SetXY(25, 59.5);
      $pdf->Write(0, "{$row['FirstName']} {$row['LastName']}");

      // TABLE
      $pdf->SetFontSize('10');
      $pdf->SetFont('Arial');

      // ARRIVAL
      $pdf->SetXY(48, 86.1);
      $pdf->Write(0, date('F d, Y', strtotime($row['CheckInDate'])));

      // DEPARTURE
      $pdf->SetXY(48, 90.7);
      $pdf->Write(0, date('F d, Y', strtotime($row['CheckOutDate'])));

      // GUEST
      $pdf->SetXY(48, 95.6);
      $pdf->SetFont('Arial', 'B');
      $pdf->Write(0, strlen("{$row['FirstName']} {$row['LastName']}") > 23 ? substr("{$row['FirstName']} {$row['LastName']}", 0, 23) . '...' : "{$row['FirstName']} {$row['LastName']}");
      $pdf->SetFont('Arial');

      // ROOM TYPE
      $pdf->SetXY(48, 100.2);
      $pdf->Write(0, join(', ', array_slice($rooms, 0, 4)));
      $pdf->SetXY(48, 104.2);
      $pdf->Write(0, join(', ', array_slice($rooms, 4)));

      // BOOKING REF
      $pdf->SetXY(48, 108.7);
      $pdf->Write(0, $_GET['BookingID']);

      // ETA
      $pdf->SetXY(135, 86);
      $pdf->Write(0, '2:00pm');

      // ETD
      $pdf->SetXY(135, 90.7);
      $pdf->Write(0, '12:00nn');

      // GUEST TYPE
      $pdf->SetXY(135, 95.6);
      $pdf->Write(0, $row['AccountType']);

      // TOTAL
      $pdf->SetXY(135, 108.7);
      $pdf->Write(0, 'P' . number_format($row['TotalAmount']));

      $pdf->Output("{$row['FirstName']}{$row['LastName']}ReservationConfirmation.pdf", 'I');
    }
  }
} else {
  header('location: ../../');
}

?>
