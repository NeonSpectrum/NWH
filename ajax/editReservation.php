<?php
require_once '../files/autoload.php';
if (isset($_POST['data'])) {
  parse_str($_POST['data'], $data);
  $resultToken = $system->validateToken($data['csrf_token']);
} else {
  $resultToken = $system->validateToken($_POST['csrf_token']);
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && $resultToken) {
  if (isset($_POST['type']) && $_POST['type'] == "admin") {
    $currentRoomID = $system->filter_input($_POST['currentRoomID']);
    $roomID        = isset($_POST['cmbNewRoomID']) ? $system->filter_input($_POST['cmbNewRoomID']) : $currentRoomID;
    $checkDate     = explode(" - ", $system->filter_input($_POST['txtCheckDate']));
    $checkInDate   = date("Y-m-d", strtotime($checkDate[0]));
    $checkOutDate  = date("Y-m-d", strtotime($checkDate[1]));
    $adults        = $system->filter_input($_POST['txtAdults']);
    $children      = $system->filter_input($_POST['txtChildren']);

    $bookingID = $system->filter_input($_POST['cmbBookingID']);
    $result    = $db->query("UPDATE booking JOIN booking_room ON booking.BookingID=booking_room.BookingID JOIN room ON room.RoomID=booking_room.RoomID JOIN room_type ON room_type.RoomTypeID=room.RoomTypeID SET booking_room.RoomID=$roomID, CheckInDate='$checkInDate', CheckOutDate='$checkOutDate',Adults=$adults,Children=$children WHERE booking.BookingID=$bookingID AND booking_room.RoomID=$currentRoomID");

    if (!$db->error) {
      $system->log("update|booking|$bookingID");
      echo true;
    } else {
      echo $db->error;
    }
  } else if ($data['type'] == "booking") {
    $arr           = [];
    $bookingID     = $system->filter_input($data['cmbBookingID']);
    $checkDate     = explode(" - ", $system->filter_input($data['txtCheckDate']));
    $checkInDate   = date("Y-m-d", strtotime($checkDate[0]));
    $checkOutDate  = date("Y-m-d", strtotime($checkDate[1]));
    $adults        = $system->filter_input($data['txtAdults']);
    $children      = $system->filter_input($data['txtChildren']);
    $paymentMethod = $system->filter_input($data['txtPaymentMethod']);

    $db->query("UPDATE booking SET CheckInDate='$checkInDate', CheckOutDate='$checkOutDate', Adults=$adults, Children=$children, PaymentMethod='$paymentMethod' WHERE BookingID=$bookingID");
    $db->query("DELETE FROM booking_room WHERE BookingID=$bookingID");

    $arr[0]         = true;
    $totalRoomPrice = 0;
    foreach ($_POST['rooms'] as $key => $rooms) {
      $roomType     = str_replace(" ", "_", $rooms['roomType']);
      $roomQuantity = $system->filter_input($rooms['roomQuantity']);
      $roomIDs      = $room->generateRoomID($roomType, $roomQuantity, $checkInDate, $checkOutDate);
      if (count($roomIDs) > 0) {
        for ($i = 1; $i <= $roomQuantity; $i++) {
          $totalRoomPrice += $system->filter_input($room->getRoomPrice($roomType));
          $roomID = $system->filter_input($roomIDs[$i - 1]);
          $db->query("INSERT INTO booking_room VALUES($bookingID, $roomID)");
        }
      } else {
        $arr[0] = false;
        break;
      }
    }
    if ($arr[0] != false) {
      $totalRoomPrice *= count($system->getDatesFromRange($checkInDate, $checkOutDate)) - 1;
      $db->query("UPDATE booking SET TotalAmount=$totalRoomPrice, DateUpdated='$date' WHERE BookingID=$bookingID");
    }
    echo json_encode($arr);
  }
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>