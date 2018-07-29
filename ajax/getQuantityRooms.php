<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $checkDate    = explode(' - ', $system->filter_input($_POST['checkDate']));
  $checkInDate  = $checkDate[0];
  $checkOutDate = $checkDate[1];
  $rooms        = [];
  $admin        = $_POST['admin'] ?? false;

  $result = $db->query('SELECT * FROM room_type');
  while ($row = $result->fetch_assoc()) {
    $rooms[] = count($room->generateRoomID($row['RoomType'], null, $checkInDate, $checkOutDate, $admin));
  }

  $arr = array_fill(0, count($rooms), '');

  for ($i = 0; $i < count($rooms); $i++) {
    for ($j = 0; $j <= $rooms[$i]; $j++) {
      $arr[$i] .= "<option value='$j'>$j</option>";
    }
  }
  echo json_encode($arr);
}
?>
