<?php
session_start();
require_once '../files/db.php';

if (isset($_POST)) {
  try {
    $bookingID    = $_POST['cmbBookingID'];
    $roomType     = str_replace(" ", "_", $_POST['cmbRoomType']);
    $roomID       = generateRoomID($roomType);
    $checkInDate  = $_POST['txtCheckInDate'];
    $checkOutDate = $_POST['txtCheckOutDate'];
    $adults       = $_POST['txtAdults'];
    $children     = $_POST['txtChildren'];
    $query        = "UPDATE booking SET RoomID=$roomID,CheckInDate='$checkInDate',CheckOutDate='$checkOutDate',Adults=$adults,Children=$children WHERE BookingID=$bookingID";
    $result       = mysqli_query($db, $query);
    if (mysqli_affected_rows($db) > 0) {
      echo true;
    } else {
      echo $roomID;
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}
?>