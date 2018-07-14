<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $result = $db->query('SELECT * FROM `visitor_count` ORDER BY Date DESC LIMIT 7');
  $dates  = [];
  for ($i = 0; $i < 7; $i++) {
    $dates[$i] = date('Y-m-d', strtotime('now') - 86400 * $i);
  }
  $count = array_fill(0, count($dates), 0);
  while ($row = $result->fetch_assoc()) {
    for ($i = 0; $i < count($dates); $i++) {
      if ($dates[$i] == $row['Date']) {
        $count[$i] = $row['Count'];
      }
    }
  }
  $arr    = [];
  $arr[0] = array_reverse($dates);
  $arr[1] = array_reverse($count);
  echo json_encode($arr);
}
?>