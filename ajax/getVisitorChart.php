<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $result = $db->query("SELECT * FROM `visitor-count` ORDER BY Date DESC LIMIT 7");
  $dates  = [];
  $count  = [];
  while ($row = $result->fetch_assoc()) {
    $roomIDs[]   = $row['Date'];
    $countUsed[] = $row['Count'];
  }
  $arr    = [];
  $arr[0] = array_reverse($roomIDs);
  $arr[1] = array_reverse($countUsed);
  echo json_encode($arr);
}
?>