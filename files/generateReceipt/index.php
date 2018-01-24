<?php
@session_start();
use setasign\Fpdi\Fpdi;

require_once '../autoload.php';

if (isset($_GET['BookingID'])) {
  $rooms     = [];
  $bookingID = (int) substr(strrchr($_GET['BookingID'], "-"), 1);
  $result    = $db->query("SELECT * FROM account JOIN booking ON account.EmailAddress=booking.EmailAddress JOIN booking_check ON booking.BookingID=booking_check.BookingID WHERE booking.BookingID=$bookingID");
  $row       = $result->fetch_assoc();
  if (!$system->isLogged()) {
    echo "Login first to view this file.";
    return;
  } else if ($system->isLogged() && $_SESSION['account']['email'] != $row['EmailAddress'] && !$system->checkUserLevel(1)) {
    echo "You are not allowed to view this file.";
    return;
  } else if ($result->num_rows > 0) {
    $result = $db->query("SELECT * FROM booking_room WHERE BookingID=$bookingID");
    while ($roomRow = $result->fetch_assoc()) {
      $rooms[] = $roomRow['RoomID'];
    }
    sort($rooms);

    $pdf = new Fpdi();
    $pdf->AddPage();
    $pdf->setSourceFile('../../assets/receipt.pdf');
    $pdf->useTemplate($pdf->importPage(1), 5, 10, 200);
    $pdf->SetTitle('Northwood Reservation Confirmation');
    $pdf->SetFont('Arial');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFontSize('10');

    $pdf->SetXY(154, 47.2);
    $pdf->Write(0, date("M d, Y", strtotime($row['CheckOut'])));

    $pdf->SetXY(153, 52);
    $pdf->Write(0, $_GET['BookingID']);

    $pdf->SetXY(50, 95.2);
    $pdf->Write(0, date("M d, Y", strtotime($row['CheckIn'])));

    $pdf->SetXY(55, 102.6);
    $pdf->Write(0, date("M d, Y", strtotime($row['CheckOut'])));

    $pdf->SetXY(65, 109.8);
    $pdf->Write(0, count($system->getDatesFromRange($row['CheckIn'], $row['CheckOut'])));

    $pdf->SetXY(51, 117.2);
    $pdf->Write(0, $row['Adults']);

    $pdf->SetXY(54, 124.6);
    $pdf->Write(0, $row['Children']);

    $pdf->SetXY(107, 95.2);
    $pdf->Write(0, count($rooms));

    for ($i = 0, $j = 0, $y = 108.2; $i < count($rooms) / 5; $i++) {
      $roomList = array_slice($rooms, $j, 5);
      $pdf->SetXY(85, $y);
      $pdf->Write(0, join($roomList, ", "));
      $y += 5;
      $j += 5;
    }

    $pdf->SetXY(142, 95.2);
    $pdf->Write(0, "{$row['FirstName']} {$row['LastName']}");

    $pdf->SetXY(133, 108.2);
    $pdf->Write(0, $row['ContactNumber']);

    $pdf->Output("Receipt.pdf", "I");
  }
} else {
  header("location: ../../");
}
?>