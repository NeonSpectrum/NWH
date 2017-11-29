<?php
  session_start();
  require_once '../files/db.php';
  
  if (isset($_POST)) {
    $room = $_POST['rdbRoom'];
    $query = "SELECT * FROM room_type WHERE RoomType='$room'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    if (mktime(0, 0, 0, 10, 1, date('Y')) < mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y')) && mktime(11, 59, 59, 5, 31, date('Y') + 1) > mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y'))) {
      $price = $row['PeakRate'];
    } else if (mktime(0, 0, 0, 7, 1, date('Y')) < mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y')) && mktime(11, 59, 59, 8, 31, date('Y') + 1) > mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y'))) {
      $price = $row['LeanRate'];
    } else {
      $price = $row['DiscountedRate'];
    }
    echo $price;
  }
?>