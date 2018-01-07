<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $result = $db->query("SELECT * FROM booking JOIN account ON booking.EmailAddress=account.EmailAddress");
  $arr    = [];
  for ($i = 0; $row = $result->fetch_assoc(); $i++) {
    $arr[$i]['title'] = $row['EmailAddress'];
    $arr[$i]['name']  = $row['FirstName'] . " " . $row['LastName'];
    $roomResult       = $db->query("SELECT * FROM booking_room WHERE BookingID={$row['BookingID']}");
    $rooms            = [];
    while ($roomRow = $roomResult->fetch_assoc()) {
      $rooms[] = $roomRow['RoomID'];
    }
    sort($rooms);
    $arr[$i]['room']         = join(", ", $rooms) . " (" . count($rooms) . ")";
    $arr[$i]['checkInDate']  = date("m/d/Y", strtotime($row['CheckInDate']));
    $arr[$i]['checkOutDate'] = date("m/d/Y", strtotime($row['CheckOutDate']));
    $arr[$i]['start']        = "{$row['CheckInDate']}T14:00";
    $arr[$i]['end']          = "{$row['CheckOutDate']}T12:00";
  }
  echo json_encode($arr);
}
?>