<?php
@session_start();
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID = $system->filter_input($_POST['txtBookingID']);
  if ($_POST['mode'] == "cancel") {
    $db->query("INSERT INTO booking_cancelled VALUES($bookingID,'$date')");
    if ($db->affected_rows > 0) {
      $system->log("insert|booking|cancelled|$bookingID");
      echo true;
    } else {
      echo $db->error;
    }
  } else if ($_POST['mode'] == "revert") {
    $available = true;
    $result    = $db->query("SELECT * FROM booking JOIN booking_room ON booking.BookingID=booking_room.BookingID JOIN room ON booking_room.RoomID=room.RoomID JOIN room_type ON room.RoomTypeID=room_type.RoomTypeID WHERE booking.BookingID=$bookingID");
    while ($row = $result->fetch_assoc()) {
      $rooms = $room->generateRoomID($row['RoomType'], null, $row['CheckInDate'], $row['CheckOutDate']);
      if (!in_array($row['RoomID'], $rooms)) {
        $available = false;
      }
    }
    if ($available) {
      $db->query("DELETE FROM booking_cancelled WHERE BookingID=$bookingID");
      if ($db->affected_rows > 0) {
        $system->log("delete|booking|cancelled|$bookingID");
        echo true;
      } else {
        echo $db->error;
      }
    } else {
      echo REVERT_TAKEN_ERROR;
    }
  }
}
?>