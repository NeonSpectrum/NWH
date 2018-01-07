<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $result    = $db->query("SELECT RoomID, Count(*) As CountUsed FROM booking_room GROUP BY RoomID");
  $roomIDs   = [];
  $countUsed = [];
  while ($row = $result->fetch_assoc()) {
    $roomIDs[]   = $row['RoomID'];
    $countUsed[] = $row['CountUsed'];
  }
  $arr    = [];
  $arr[0] = $roomIDs;
  $arr[1] = $countUsed;
  echo json_encode($arr);
}
?>