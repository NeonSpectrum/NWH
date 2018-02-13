<?php
@session_start();
use setasign\Fpdi\Fpdi;

require_once '../autoload.php';

if (isset($_GET['BookingID'])) {
  $rooms     = [];
  $bookingID = $system->formatBookingID($_GET['BookingID'], true);
  $result    = $db->query("SELECT * FROM account JOIN booking ON account.EmailAddress=booking.EmailAddress JOIN booking_check ON booking.BookingID=booking_check.BookingID WHERE booking.BookingID=$bookingID");
  $row       = $result->fetch_assoc();
  if (!$account->isLogged()) {
    echo "Login first to view this file.";
    return;
  } else if ($account->isLogged() && $system->decrypt($_SESSION['account']) != $row['EmailAddress'] && !$account->checkUserLevel(1)) {
    echo "You are not allowed to view this file.";
    return;
  } else if ($result->num_rows > 0) {
    $result = $db->query("SELECT * FROM booking_room WHERE BookingID=$bookingID");
    while ($roomRow = $result->fetch_assoc()) {
      $rooms[] = $roomRow['RoomID'];
    }
    sort($rooms);
    $numberOfDays = count($system->getDatesFromRange($row['CheckInDate'], $row['CheckOutDate'])) - 1;

    $pdf = new Fpdi();
    $pdf->AddPage();
    $pdf->setSourceFile('../../assets/receipt.pdf');
    $pdf->useTemplate($pdf->importPage(1), 5, 10, 200);
    $pdf->SetTitle('Northwood Hotel Receipt');
    $pdf->SetFont('Arial');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFontSize('10');

    $pdf->SetXY(160, 44);
    $pdf->Write(0, date("M d, Y", strtotime($row['CheckOut'])));

    $pdf->SetXY(159, 50);
    $pdf->Write(0, $_GET['BookingID']);

    $pdf->SetXY(38, 95.2);
    $pdf->Write(0, date("M d, Y", strtotime($row['CheckIn'])));

    $pdf->SetXY(43, 102.6);
    $pdf->Write(0, date("M d, Y", strtotime($row['CheckOut'])));

    $pdf->SetXY(53, 109.8);
    $pdf->Write(0, $numberOfDays);

    $pdf->SetXY(39, 117.2);
    $pdf->Write(0, $row['Adults']);

    $pdf->SetXY(42, 124.6);
    $pdf->Write(0, $row['Children']);

    $pdf->SetXY(95, 95.2);
    $pdf->Write(0, count($rooms));

    for ($i = 0, $j = 0, $y = 108.2; $i < count($rooms) / 5; $i++) {
      $roomList = array_slice($rooms, $j, 5);
      $pdf->SetXY(75, $y);
      $pdf->Write(0, join($roomList, ", "));
      $y += 5;
      $j += 5;
    }

    $pdf->SetXY(140, 95.2);
    $pdf->Write(0, "{$row['FirstName']} {$row['LastName']}");

    $pdf->SetXY(133, 108.2);
    $pdf->Write(0, $row['ContactNumber']);

    $roomList = $room->getRoomTypeList();
    $quantity = array_fill(0, count($roomList), 0);
    $result   = $db->query("SELECT * FROM booking JOIN booking_room ON booking.BookingID=booking_room.BookingID WHERE booking.BookingID=$bookingID");
    while ($row = $result->fetch_assoc()) {
      if (in_array($room->getRoomType($row['RoomID']), $roomList)) {
        $index = array_search($room->getRoomType($row['RoomID']), $roomList);
        $quantity[$index]++;
      }
    }
    $totalAmount = 0;
    for ($i = 0, $j = 1, $y = 153; $i < count($roomList); $i++) {
      if ($quantity[$i] > 0) {
        $pdf->SetXY(20, $y);
        $pdf->Write(0, $j);
        $pdf->SetXY(28, $y);
        $pdf->Write(0, str_replace("_", " ", $roomList[$i]));
        $pdf->SetXY(105.5, $y);
        $pdf->Write(0, "P " . number_format($room->getRoomPrice($roomList[$i]), 2, ".", ","));
        $pdf->SetXY(137, $y);
        $pdf->Write(0, $quantity[$i]);
        $pdf->SetXY(150, $y);
        $pdf->Write(0, "P " . number_format($room->getRoomPrice($roomList[$i]) * $quantity[$i], 2, ".", ","));
        $totalAmount += $room->getRoomPrice($roomList[$i]) * $quantity[$i];
        $j += 1;
        $y += 5;
      }
    }
    $expensesResult = $db->query("SELECT Name, Quantity, expenses.Amount as Amount, booking_expenses.Amount as oAmount FROM expenses LEFT JOIN booking_expenses ON expenses.ExpensesID=booking_expenses.ExpensesID WHERE BookingID=$bookingID");
    for ($i = $j; $expensesRow = $expensesResult->fetch_assoc(); $i++) {
      $amount = $expensesRow['Name'] == "Others" ? "oAmount" : "Amount";
      $pdf->SetXY(20, $y);
      $pdf->Write(0, $i);
      $pdf->SetXY(28, $y);
      $pdf->Write(0, $expensesRow['Name']);
      $pdf->SetXY(105.5, $y);
      $pdf->Write(0, "P " . number_format($expensesRow[$amount], 2, ".", ","));
      $pdf->SetXY(137, $y);
      $pdf->Write(0, $expensesRow['Quantity']);
      $pdf->SetXY(150, $y);
      $pdf->Write(0, "P " . number_format($expensesRow[$amount] * $expensesRow['Quantity'], 2, ".", ","));
      $totalAmount += $expensesRow[$amount] * $expensesRow['Quantity'];
      $y += 5;
    }
    $totalAmount *= $numberOfDays;
    $pdf->SetXY(150, 206);
    $pdf->Write(0, "P " . number_format($totalAmount - $totalAmount / 1.12 * .12, 2, ".", ","));
    $pdf->SetXY(150, 211.7);
    $pdf->Write(0, "P " . number_format($totalAmount / 1.12 * .12, 2, ".", ","));
    $pdf->SetXY(150, 217.4);
    $discountResult = $db->query("SELECT Name, discount.Amount as Amount, booking_discount.Amount as oAmount FROM discount JOIN booking_discount ON discount.DiscountID=booking_discount.DiscountID WHERE BookingID=$bookingID");
    $discountRow    = $discountResult->fetch_assoc();
    $amount         = $discountRow['Name'] == "Others" ? "oAmount" : "Amount";
    $pdf->Write(0, strpos($discountRow[$amount], "%") !== false ? $discountRow[$amount] : "P " . number_format($discountRow[$amount], 2, ".", ","));
    $pdf->SetXY(150, 223.1);
    $totalAmount -= strpos($discountRow[$amount], "%") !== false ? $totalAmount * $system->percentToDecimal($discountRow[$amount]) : $discountRow[$amount];
    $pdf->Write(0, "P " . number_format($totalAmount, 2, ".", ","));

    $pdf->SetXY(51, 251.7);
    $pdf->Write(0, $account->firstName . " " . $account->lastName);
    $pdf->Output("{$bookingID}-Receipt.pdf", "I");
  }
} else {
  header("location: ../../");
}
?>