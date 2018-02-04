<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID = $system->filter_input($_POST['txtBookingID']);
  $roomList  = $room->getRoomTypeList();
  $quantity  = array_fill(0, count($roomList), 0);
  $result    = $db->query("SELECT * FROM booking JOIN booking_room ON booking.BookingID=booking_room.BookingID WHERE booking.BookingID=$bookingID");
  while ($row = $result->fetch_assoc()) {
    if (in_array($room->getRoomType($row['RoomID']), $roomList)) {
      $index = array_search($room->getRoomType($row['RoomID']), $roomList);
      $quantity[$index]++;
    }
  }
  $html = "<table border=1 cellspacing=0 style='width:100%;border:0px solid black'>";
  $html .= "<thead>";
  $html .= "<th style='text-align:center;padding:10px'>Room Type</th>";
  $html .= "<th style='text-align:center;padding:10px'>Quantity</th>";
  $html .= "<th style='text-align:center;padding:10px'>Price</th>";
  $html .= "</thead>";
  for ($i = 0; $i < count($roomList); $i++) {
    if ($quantity[$i] > 0) {
      $html .= "<tr>";
      $html .= "<td style='width:33%;text-align:center;padding:10px'>" . str_replace("_", " ", $roomList[$i]) . "</td>";
      $html .= "<td style='width:33%;text-align:center;padding:10px'>{$quantity[$i]}</td>";
      $html .= "<td style='width:33%;text-align:center;padding:10px'>₱&nbsp;" . number_format($room->getRoomPrice($roomList[$i]) * $quantity[$i], 2, ".", ",") . "</td>";
      $html .= "</tr>";
    }
  }
  $html .= "</table><br/>";
  $result         = $db->query("SELECT * FROM booking JOIN booking_check ON booking.BookingID=booking_check.BookingID WHERE booking.BookingID=$bookingID");
  $row            = $result->fetch_assoc();
  $expenses       = 0;
  $expensesResult = $db->query("SELECT Name, Quantity, expenses.Amount as Amount, booking_expenses.Amount as oAmount FROM expenses JOIN booking_expenses ON expenses.ExpensesID=booking_expenses.ExpensesID WHERE BookingID=$bookingID ORDER BY Name ASC");
  if ($expensesResult->num_rows > 0) {
    $html .= "<table border=1 cellspacing=0 style='width:100%;border:0px solid black'>";
    $html .= "<thead>";
    $html .= "<th style='text-align:center;padding:10px'>Expenses Type</th>";
    $html .= "<th style='text-align:center;padding:10px'>Quantity</th>";
    $html .= "<th style='text-align:center;padding:10px'>Price</th>";
    $html .= "</thead>";
    while ($expensesRow = $expensesResult->fetch_assoc()) {
      if ($expensesRow['Name'] == "Others") {
        $expenses += $expensesRow['oAmount'] * $expensesRow['Quantity'];
        $html .= "<tr>";
        $html .= "<td style='width:33%;text-align:center;padding:10px'>{$expensesRow['Name']}</td>";
        $html .= "<td style='width:33%;text-align:center;padding:10px'>{$expensesRow['Quantity']}</td>";
        $html .= "<td style='width:33%;text-align:center;padding:10px'>₱&nbsp;" . number_format($expensesRow['oAmount'] * $expensesRow['Quantity'], 2, ".", ",") . "</td>";
        $html .= "</tr>";
      } else {
        $expenses += $expensesRow['Amount'] * $expensesRow['Quantity'];
        $html .= "<tr>";
        $html .= "<td style='width:33%;text-align:center;padding:10px'>{$expensesRow['Name']}</td>";
        $html .= "<td style='width:33%;text-align:center;padding:10px'>{$expensesRow['Quantity']}</td>";
        $html .= "<td style='width:33%;text-align:center;padding:10px'>₱&nbsp;" . number_format($expensesRow['Amount'] * $expensesRow['Quantity'], 2, ".", ",") . "</td>";
        $html .= "</tr>";
      }
    }
  }
  $discountResult = $db->query("SELECT Name, discount.Amount as Amount, booking_discount.Amount as oAmount FROM discount JOIN booking_discount ON discount.DiscountID=booking_discount.DiscountID WHERE BookingID=$bookingID");
  $discountRow    = $discountResult->fetch_assoc();
  if ($discountRow['Name'] == "Others") {
    $discount = $discountRow['oAmount'];
  } else {
    $discount = $discountRow['Amount'];
  }
  $paypal        = 0;
  $paymentResult = $db->query("SELECT * FROM booking_paypal WHERE BookingID=$bookingID");
  while ($paymentRow = $paymentResult->fetch_assoc()) {
    $paypal += $paymentRow['PaymentAmount'];
  }
  $amountPaid = $row['AmountPaid'] + $paypal;
  $html .= "<table style='float:right;margin:20px 0'>";
  $html .= "<tr>";
  $html .= "<td style='text-align:right;font-size:16px;font-weight:bold'>Number of Days:</td>";
  $html .= "<td style='text-align:right;font-size:16px;width:20%;padding-left:20px'>" . (count($room->getDatesFromRange($row['CheckIn'], $row['CheckOut'])) - 1) . "</td>";
  $html .= "</tr>";
  $html .= "<tr>";
  $html .= "<td style='text-align:right;font-size:16px;font-weight:bold'>Original Price:</td>";
  $html .= "<td style='text-align:right;font-size:16px;width:20%;padding-left:20px'>₱&nbsp;" . number_format($row['TotalAmount'], 2, '.', ',') . "</td>";
  $html .= "</tr>";
  $html .= "<tr>";
  $html .= "<td style='text-align:right;font-size:16px;font-weight:bold'>Extra Charges:</td>";
  $html .= "<td style='text-align:right;font-size:16px;width:20%;padding-left:20px'>₱&nbsp;" . number_format($expenses, 2, '.', ',') . "</td>";
  $html .= "</tr>";
  if ($discount != null) {
    $html .= "<tr>";
    $html .= "<td style='text-align:right;font-size:16px;font-weight:bold'>Discount ({$discountRow['Name']}):</td>";
    $html .= "<td style='text-align:right;font-size:16px;width:20%;padding-left:20px'>$discount</td>";
    $html .= "</tr>";
  }
  $total = $row['TotalAmount'] + $expenses;
  $total = $total - (strpos($discount, "%") !== false ? $total * $system->percentToDecimal($discount) : $discount);
  $html .= "<td style='text-align:right;font-size:16px;font-weight:bold'>Subtotal:</td>";
  $html .= "<td style='text-align:right;font-size:16px;width:20%;padding-left:20px'>₱&nbsp;" . number_format($total - $total / 1.12 * .12, 2, '.', ',') . "</td>";
  $html .= "</tr>";
  $html .= "<tr>";
  $html .= "<td style='text-align:right;font-size:16px;font-weight:bold'>VAT (12%):</td>";
  $html .= "<td style='text-align:right;font-size:16px;width:20%;padding-left:20px'>₱&nbsp;" . number_format($total / 1.12 * .12, 2, '.', ',') . "</td>";
  $html .= "</tr>";
  $html .= "<tr>";
  $html .= "<td style='text-align:right;font-size:16px;font-weight:bold'>Total:</td>";
  $html .= "<td style='text-align:right;font-size:16px;width:20%;padding-left:20px'>₱&nbsp;" . number_format($total, 2, '.', ',') . "</td>";
  $html .= "</tr>";
  $html .= "<tr>";
  $html .= "<td style='text-align:right;font-size:16px;font-weight:bold'>Amount Paid:</td>";
  $html .= "<td style='text-align:right;font-size:16px;width:20%;padding-left:20px'>₱&nbsp;" . number_format($row['AmountPaid'], 2, '.', ',') . "</td>";
  $html .= "</tr>";
  $html .= "<tr>";
  $html .= "<td style='text-align:right;font-size:16px;font-weight:bold'>Remaining Amount:</td>";
  $html .= "<td style='text-align:right;font-size:16px;width:20%;padding-left:20px'>₱&nbsp;" . number_format($total - $row['AmountPaid'], 2, '.', ',') . "</td>";
  $html .= "</tr>";
  $html .= "</table>";

  echo $html;
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>