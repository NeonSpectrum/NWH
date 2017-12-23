<?php
session_start();
require_once '../files/db.php';

if (isset($_POST)) {
  try {
    $roomType     = $db->real_escape_string(str_replace(" ", "_", $_POST['cmbRoomType']));
    $email        = $db->real_escape_string($_POST['txtEmail']);
    $checkInDate  = $db->real_escape_string($_POST['txtCheckInDate']);
    $checkOutDate = $db->real_escape_string($_POST['txtCheckOutDate']);
    $adults       = $db->real_escape_string($_POST['txtAdults']);
    $children     = $db->real_escape_string($_POST['txtChildren']);
    $roomID       = generateRoomID($roomType);
    $price        = getRoomPrice($roomType);
    $db->query("INSERT INTO walk_in VALUES(NULL, '$email', $roomID, '$checkInDate', '$checkOutDate', $adults, $children, 0, $price)");
    if ($db->affected_rows > 0) {
      createLog("insert|walk_in|" . $db->insert_id);
      echo true;
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}
?>