<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $checkDate    = explode(" - ", $system->filter_input($_POST['checkDate']));
  $checkInDate  = $checkDate[0];
  $checkOutDate = $checkDate[1];
  $rooms        = [];
  $arr          = array_fill(0, 6, "");
  $rooms[0]     = count($room->generateRoomID("Standard_Single", null, $checkInDate, $checkOutDate));
  $rooms[1]     = count($room->generateRoomID("Standard_Double", null, $checkInDate, $checkOutDate));
  $rooms[2]     = count($room->generateRoomID("Family_Room", null, $checkInDate, $checkOutDate));
  $rooms[3]     = count($room->generateRoomID("Junior_Suites", null, $checkInDate, $checkOutDate));
  $rooms[4]     = count($room->generateRoomID("Studio_Type", null, $checkInDate, $checkOutDate));
  $rooms[5]     = count($room->generateRoomID("Barkada_Room", null, $checkInDate, $checkOutDate));
  for ($i = 0; $i < count($rooms); $i++) {
    for ($j = 0; $j <= $rooms[$i]; $j++) {
      $arr[$i] .= "<option value='$j'>$j</option>";
    }
  }
  echo json_encode($arr);
}
?>