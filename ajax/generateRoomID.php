<?php
require_once "../files/autoload.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $checkDate = explode(" - ", $_POST['checkDate']);
  $rooms     = $room->generateRoomID($_POST['roomType'], null, $checkDate[0], $checkDate[1]);
  if (isset($_POST['roomID'])) {
    $result = $db->query("SELECT * FROM room JOIN room_type ON room_type.RoomTypeID=room.RoomTypeID WHERE RoomID={$_POST['roomID']}");
    $row    = $result->fetch_assoc();
    array_unshift($rooms, str_replace("_", " ", $row['RoomType']));
  }
  echo count($rooms) > 0 ? json_encode($rooms) : json_encode(false);
}
?>