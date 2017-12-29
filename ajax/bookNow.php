<?php
@session_start();
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  parse_str($_POST['data'], $data);

  $email         = $db->real_escape_string($_SESSION['email']);
  $checkDate     = explode(" - ", $data['txtCheckDate']);
  $checkInDate   = date("Y-m-d", strtotime($checkDate[0]));
  $checkOutDate  = date("Y-m-d", strtotime($checkDate[1]));
  $adults        = $db->real_escape_string($data['txtAdults']);
  $children      = $db->real_escape_string($data['txtChildren']);
  $paymentMethod = $db->real_escape_string($data['txtPaymentMethod']);

  $arr = array();

  $db->query("INSERT INTO booking VALUES(NULL, '$email', '$checkInDate', '$checkOutDate', $adults, $children, 0,  NULL, '$paymentMethod','$date')");

  if ($db->affected_rows > 0) {
    $bookingID = $db->insert_id;
    $system->createLog("insert|booking|" . $bookingID);
    $totalRoomPrice = 0;

    $arr[0] = $bookingID;
    $arr[1] = "<br/><ol type='1'>";

    foreach ($_POST['rooms'] as $key => $rooms) {
      $roomType     = str_replace(" ", "_", $rooms['roomType']);
      $roomQuantity = $db->real_escape_string($rooms['roomQuantity']);
      $roomIDs      = $room->generateRoomID($roomType, $roomQuantity, $checkInDate, $checkOutDate);
      for ($i = 1; $i <= $roomQuantity; $i++) {
        $roomPrice = $db->real_escape_string($room->getRoomPrice($roomType));
        $totalRoomPrice += $roomPrice;
        $roomID = $db->real_escape_string($roomIDs[$i - 1]);
        $db->query("INSERT INTO booking_room VALUES($bookingID, $roomID)");
      }
      $arr[1] .= "<li>" . str_replace("_", " ", $roomType) . ": " . join(', ', $roomIDs) . "</li>";
    }

    $db->query("UPDATE booking SET TotalAmount=$totalRoomPrice WHERE BookingID=$bookingID");
    $arr[1] .= "</ol>";
    echo json_encode($arr);
  } else {
    echo "There's something wrong in your book!";
  }
}
;
?>