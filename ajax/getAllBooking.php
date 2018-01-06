<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $result = $db->query("SELECT * FROM booking");
  $arr    = [];
  for ($i = 0; $row = $result->fetch_assoc(); $i++) {
    $arr[$i]['title'] = $row['EmailAddress'];
    $arr[$i]['start'] = "{$row['CheckInDate']}T14:00";
    $arr[$i]['end']   = "{$row['CheckOutDate']}T12:00";
  }
  echo json_encode($arr);
}
?>