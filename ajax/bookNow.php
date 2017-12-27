<?php
@session_start();
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $room = $db->real_escape_string($_POST['rdbRoom']);

  $roomID   = $room->generateRoomID($room);
  $email    = $db->real_escape_string($_SESSION['email']);
  $checkIn  = $db->real_escape_string($_POST['txtCheckInDate']);
  $checkOut = $db->real_escape_string($_POST['txtCheckOutDate']);
  $adults   = $db->real_escape_string($_POST['txtAdults']);
  $children = $db->real_escape_string($_POST['txtChildren']);
  $price    = $db->real_escape_string($_POST['txtRoomPrice']);

  $arr = array();

  $db->query("INSERT INTO booking VALUES(NULL, '$email', '$roomID', '$checkIn', '$checkOut', $adults, $children, 0,  $price)");

  if ($db->affected_rows > 0) {
    createLog("insert|booking|" . $db->insert_id);
    unset($_SESSION['roomID']);
    $arr[0] = $db->insert_id;
    $arr[1] = $roomID;
    echo json_encode($arr);
  } else {
    echo "There's something wrong in your book!";
  }
}
?>