<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID = $system->filter_input($_POST['cmbBookingID']);
  $result    = $db->query("SELECT * FROM booking LEFT JOIN booking_room ON booking.BookingID=booking_room.BookingID WHERE booking.BookingID = $bookingID");
  $row       = $result->fetch_assoc();

  $arr            = [];
  $arr[0]         = date("m/d/Y", strtotime($row['CheckInDate'])) . " - " . date("m/d/Y", strtotime($row['CheckOutDate']));
  $arr[1]         = $row['Adults'];
  $arr[2]         = $row['Children'];
  $arr[3]         = $row['PaymentMethod'];
  $checkInDate    = $row['CheckInDate'];
  $checkOutDate   = $row['CheckOutDate'];
  $roomIDs        = $count        = [];
  $roomTypes      = $room->getRoomTypeList();
  $roomQuantities = array_fill(0, count($roomTypes), 0);
  $html           = array_fill(0, count($roomTypes), "");

  $result->data_seek(0);
  while ($row = $result->fetch_assoc()) {
    if ($row['RoomID'] != null) {
      $roomIDs[] = $row['RoomID'];
    }
  }
  if (count($roomIDs) > 0) {
    for ($i = 0; $i < count($roomIDs); $i++) {
      $roomType = $room->getRoomType($roomIDs[$i]);
      $roomQuantities[array_search($roomType, $roomTypes)]++;
    }
  }
  for ($i = 0; $i < count($roomTypes); $i++) {
    $count[] = count($room->generateRoomID($roomTypes[$i], null, $checkInDate, $checkOutDate));
  }
  for ($i = 0; $i < count($html); $i++) {
    for ($j = 0; $j <= $roomQuantities[$i] + $count[$i]; $j++) {
      $html[$i] .= "<option value='$j'" . ($roomQuantities[$i] == $j ? " selected='selected'" : "") . ">$j</option>";
    }
  }
  $arr[4] = array($roomTypes, $html);
  echo json_encode($arr);
}
?>