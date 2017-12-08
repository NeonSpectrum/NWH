<?php
session_start();
require_once '../files/db.php';

if (isset($_POST)) {
  try {
    $roomType     = str_replace(" ", "_", $_POST['cmbRoomType']);
    $email        = $_POST['txtEmail'];
    $checkInDate  = $_POST['txtCheckInDate'];
    $checkOutDate = $_POST['txtCheckOutDate'];
    $adults       = $_POST['txtAdults'];
    $children     = $_POST['txtChildren'];
    $roomID       = generateRoomID($roomType);
    $price        = getRoomPrice($roomType);
    $query        = "INSERT INTO walk_in VALUES(NULL, '$email', $roomID, '$checkInDate', '$checkOutDate', $adults, $children, 0, $price)";
    mysqli_query($db, $query);
    if (mysqli_affected_rows($db) > 0) {
      echo true;
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}
?>