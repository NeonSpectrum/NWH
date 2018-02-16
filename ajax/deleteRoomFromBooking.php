<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID = $system->filter_input($system->formatBookingID($_POST['txtBookingID'], true));
  $roomID    = $system->filter_input($_POST['roomID']);
  $db->query("DELETE FROM booking_room WHERE BookingID=$bookingID AND RoomID=$roomID");
  if ($db->affected_rows > 0) {
    $result       = $db->query("SELECT * FROM booking WHERE BookingID=$bookingID");
    $row          = $result->fetch_assoc();
    $numberOfDays = count($system->getDatesFromRange($row['CheckInDate'], $row['CheckOutDate'])) - 1;
    $price        = $room->getRoomPrice($room->getRoomType($roomID)) * $numberOfDays;
    $db->query("UPDATE booking_transaction SET TotalAmount = TotalAmount - $price WHERE BookingID=$bookingID");
    $system->log("delete|booking.room|{$system->formatBookingID($bookingID)}|$roomID");
    echo true;
  } else {
    echo $db->error;
  }
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>