<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $roomIDs = [];
  $result  = $db->query("SELECT * FROM room");
  while ($row = $result->fetch_assoc()) {
    $roomIDs[] = $row['RoomID'];
  }
  $result    = $db->query("SELECT RoomID, Count(*) As CountUsed FROM booking_room GROUP BY RoomID");
  $countUsed = array_fill(0, count($roomIDs), 0);
  while ($row = $result->fetch_assoc()) {
    for ($i = 0; $i < count($roomIDs); $i++) {
      if ($row['RoomID'] == $roomIDs[$i]) {
        $countUsed[$i] = $row['CountUsed'];
      }
    }
  }
  $arr    = [];
  $arr[0] = $roomIDs;
  $arr[1] = $countUsed;
  echo json_encode($arr);
}
?>