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
  $html .= "<th style='text-align:center'>Room Type</th>";
  $html .= "<th style='text-align:center'>Quantity</th>";
  $html .= "<th style='text-align:center'>Price</th>";
  $html .= "</thead>";
  for ($i = 0; $i < count($roomList); $i++) {
    if ($quantity[$i] > 0) {
      $html .= "<tr>";
      $html .= "<td style='width:33%;text-align:center;padding:10px'>" . str_replace("_", " ", $roomList[$i]) . "</td>";
      $html .= "<td style='width:33%;text-align:center;padding:10px'>{$quantity[$i]}</td>";
      $html .= "<td style='width:33%;text-align:center;padding:10px'>₱&nbsp;" . number_format($room->getRoomPrice($roomList[$i]) * $quantity[$i]) . "</td>";
      $html .= "</tr>";
    }
  }
  $html .= "</table>";
  $result        = $db->query("SELECT * FROM booking JOIN booking_check ON booking.BookingID=booking_check.BookingID WHERE booking.BookingID=$bookingID");
  $row           = $result->fetch_assoc();
  $total         = $row['TotalAmount'] + $row['ExtraCharges'] - (strpos($row['Discount'], "%") !== false ? ($row['TotalAmount'] + $row['ExtraCharges']) * $system->percentToDecimal($row['Discount']) : $row['Discount']);
  $paypal        = 0;
  $paymentResult = $db->query("SELECT * FROM booking_paypal WHERE BookingID=$bookingID");
  while ($paymentRow = $paymentResult->fetch_assoc()) {
    $paypal += $paymentRow['PaymentAmount'];
  }
  $amountPaid = $row['AmountPaid'] + $paypal;
  $html .= "<table style='float:right;margin:20px 0'>";
  $html .= "<tr>";
  $html .= "<td style='text-align:right;font-size:18px;font-weight:bold'>Number of Days:</td>";
  $html .= "<td style='text-align:right;font-size:18px;width:20%;padding-left:20px'>" . count($room->getDatesFromRange($row['CheckIn'], $row['CheckOut'])) . "</td>";
  $html .= "</tr>";
  $html .= "<tr>";
  $html .= "<td style='text-align:right;font-size:18px;font-weight:bold'>Extra Charges:</td>";
  $html .= "<td style='text-align:right;font-size:18px;width:20%;padding-left:20px'>₱&nbsp;" . number_format($row['ExtraCharges'], 2, '.', ',') . "</td>";
  $html .= "</tr>";
  $html .= "<tr>";
  $html .= "<tr>";
  $html .= "<td style='text-align:right;font-size:18px;font-weight:bold'>Discount:</td>";
  $html .= "<td style='text-align:right;font-size:18px;width:20%;padding-left:20px'>" . (strpos($row['Discount'], "%") !== false ? $row['Discount'] : "₱&nbsp;" . number_format($total - $total / 1.12 * .12)) . "</td>";
  $html .= "</tr>";
  $html .= "<tr>";
  $html .= "<td style='text-align:right;font-size:18px;font-weight:bold'>Subtotal:</td>";
  $html .= "<td style='text-align:right;font-size:18px;width:20%;padding-left:20px'>₱&nbsp;" . number_format($total - $total / 1.12 * .12, 2, '.', ',') . "</td>";
  $html .= "</tr>";
  $html .= "<tr>";
  $html .= "<td style='text-align:right;font-size:18px;font-weight:bold'>VAT:</td>";
  $html .= "<td style='text-align:right;font-size:18px;width:20%;padding-left:20px'>₱&nbsp;" . number_format($total / 1.12 * .12, 2, '.', ',') . "</td>";
  $html .= "</tr>";
  $html .= "<tr>";
  $html .= "<td style='text-align:right;font-size:18px;font-weight:bold'>Total:</td>";
  $html .= "<td style='text-align:right;font-size:18px;width:20%;padding-left:20px'>₱&nbsp;" . number_format($total, 2, '.', ',') . "</td>";
  $html .= "</tr>";
  $html .= "</table>";

  echo $html;
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>