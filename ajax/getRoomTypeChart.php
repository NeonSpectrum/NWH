<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $roomTypes = [];
  $count     = [];
  $result    = $db->query('SELECT * FROM room_type');
  while ($row = $result->fetch_assoc()) {
    $roomTypes[] = str_replace('_', ' ', $row['RoomType']);
    $count[]     = (int) $db->query("
      SELECT COUNT(*) as total FROM room_type
      JOIN room
      ON room_type.RoomTypeID=room.RoomTypeID
      JOIN booking_room
      ON room.RoomID=booking_room.RoomID
      WHERE RoomType='{$row['RoomType']}'
    ")->fetch_assoc()['total'];
  }

  echo json_encode([$roomTypes, $count]);
}
?>
