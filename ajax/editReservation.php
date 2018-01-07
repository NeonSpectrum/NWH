<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $currentRoomID = $system->filter_input($_POST['currentRoomID']);
  $roomID        = isset($_POST['cmbNewRoomID']) ? $system->filter_input($_POST['cmbNewRoomID']) : $currentRoomID;
  $checkDate     = explode(" - ", $system->filter_input($_POST['txtCheckDate']));
  $checkInDate   = date("Y-m-d", strtotime($checkDate[0]));
  $checkOutDate  = date("Y-m-d", strtotime($checkDate[1]));
  $adults        = $system->filter_input($_POST['txtAdults']);
  $children      = $system->filter_input($_POST['txtChildren']);

  if ($_POST['type'] == "booking") {
    $bookingID = $system->filter_input($_POST['cmbBookingID']);
    $result    = $db->query("UPDATE booking JOIN booking_room ON booking.BookingID=booking_room.BookingID JOIN room ON room.RoomID=booking_room.RoomID JOIN room_type ON room_type.RoomTypeID=room.RoomTypeID SET booking_room.RoomID=$roomID, CheckInDate='$checkInDate', CheckOutDate='$checkOutDate',Adults=$adults,Children=$children WHERE booking.BookingID=$bookingID AND booking_room.RoomID=$currentRoomID");
  } else if ($_POST['type'] == "walkin") {
    $walkInID = $system->filter_input($_POST['cmbWalkInID']);
    $result   = $db->query("UPDATE `walk-in` JOIN `walk-in_room` ON `walk-in`.WalkInID=`walk-in_room`.WalkInID JOIN room ON room.RoomID=`walk-in_room`.RoomID JOIN room_type ON room_type.RoomTypeID=room.RoomTypeID SET `walk-in_room`.RoomID=$roomID, CheckInDate='$checkInDate', CheckOutDate='$checkOutDate',Adults=$adults,Children=$children WHERE `walk-in`.BookingID=$walkInID AND `walk-in_room`.RoomID=$currentRoomID");
  }

  if (!$db->error) {
    $system->log("update|booking|$bookingID");
    echo true;
  } else {
    echo $db->error;
  }
}
?>