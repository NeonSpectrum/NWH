<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $result = $db->query("SELECT CheckInDate, CheckOutDate, COUNT(*) AS CountUser FROM `booking` WHERE Type='walkin' GROUP BY CheckInDate,CheckOutDate ORDER BY CheckInDate DESC");
  $dates  = $arr  = [];
  for ($i = 0; $i < 7; $i++) {
    $dates[$i] = date('M d', strtotime('now') - 86400 * $i);
  }
  $count = array_fill(0, 7, 0);
  while ($row = $result->fetch_assoc()) {
    $rowDate = $system->getDatesFromRange($row['CheckInDate'], $row['CheckOutDate']);
    foreach ($rowDate as $key => $value) {
      for ($i = 0; $i < count($dates); $i++) {
        if ($value == $dates[$i]) {
          $count[$i]++;
        }
      }
    }
  }
  $arr[0] = array_reverse($dates);
  $arr[1] = array_reverse($count);
  echo json_encode($arr);
}
?>