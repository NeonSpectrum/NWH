<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $result   = $db->query("SELECT CheckInDate, CheckOutDate, COUNT(*) AS CountUser FROM `booking` GROUP BY CheckInDate,CheckOutDate ORDER BY CheckInDate DESC");
  $dates    = $arr    = [];
  $dates[0] = date("Y-m-d", strtotime('now') - 86400 * 1);
  $dates[1] = date("Y-m-d", strtotime('now') - 86400 * 2);
  $dates[2] = date("Y-m-d", strtotime('now') - 86400 * 3);
  $dates[3] = date("Y-m-d", strtotime('now') - 86400 * 4);
  $dates[4] = date("Y-m-d", strtotime('now') - 86400 * 5);
  $dates[5] = date("Y-m-d", strtotime('now') - 86400 * 6);
  $dates[6] = date("Y-m-d", strtotime('now') - 86400 * 7);
  $count    = array_fill(0, 7, 0);
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