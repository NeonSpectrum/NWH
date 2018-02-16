<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID = $system->filter_input($system->formatBookingID($_POST['txtBookingID'], true));
  $roomID    = $system->filter_input($_POST['txtRoomID']);
  $newRoomID = $system->filter_input($_POST['cmbNewRoomID']);
  if ($_POST['txtType'] == "edit") {
    $db->query("UPDATE booking_room SET RoomID=$newRoomID WHERE BookingID=$bookingID AND RoomID=$roomID");
    if ($db->affected_rows > 0) {
      $result       = $db->query("SELECT * FROM booking WHERE BookingID=$bookingID");
      $row          = $result->fetch_assoc();
      $numberOfDays = count($system->getDatesFromRange($row['CheckInDate'], $row['CheckOutDate'])) - 1;
      $price        = $room->getRoomPrice($room->getRoomType($roomID)) * $numberOfDays;
      $newPrice     = $room->getRoomPrice($room->getRoomType($newRoomID)) * $numberOfDays;
      $db->query("UPDATE booking_transaction SET TotalAmount = TotalAmount - $price + $newPrice WHERE BookingID=$bookingID");
      $system->log("edit|booking.room|{$system->formatBookingID($bookingID)}|$newRoomID|$roomID");
      echo true;
    } else {
      echo $db->error;
    }
  } else if ($_POST['txtType'] == "add") {
    $db->query("INSERT INTO booking_room VALUES($bookingID,$newRoomID)");
    if ($db->affected_rows > 0) {
      $result       = $db->query("SELECT * FROM booking WHERE BookingID=$bookingID");
      $row          = $result->fetch_assoc();
      $numberOfDays = count($system->getDatesFromRange($row['CheckInDate'], $row['CheckOutDate'])) - 1;
      $newPrice     = $room->getRoomPrice($room->getRoomType($newRoomID)) * $numberOfDays;
      $db->query("UPDATE booking_transaction SET TotalAmount = TotalAmount + $newPrice WHERE BookingID=$bookingID");
      $system->log("insert|booking.room|{$system->formatBookingID($bookingID)}|$newRoomID");
      echo true;
    } else {
      echo $db->error;
    }
  }
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>