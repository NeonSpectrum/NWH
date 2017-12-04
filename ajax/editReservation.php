<?php
  session_start();
  require_once '../files/db.php';
  
  if (isset($_POST)) {
    try {
      $bookingID = $_POST['cmbBookingID'];
      $roomID = $_POST['txtRoomID'];
      $checkInDate = $_POST['txtCheckInDate'];
      $checkOutDate = $_POST['txtCheckOutDate'];
      $adults = $_POST['txtAdults'];
      $children = $_POST['txtChildren'];
      $query = "UPDATE booking SET RoomID=$roomID,CheckInDate='$checkInDate',CheckOutDate='$checkOutDate',Adults=$adults,Children=$children WHERE BookingID=$bookingID";
      $result = mysqli_query($db,$query) or die(mysql_error());
      if(mysqli_affected_rows($db)!=0) {
        echo true;
      } else {
        echo NO_UPDATE;
      }
    } catch(PDOException $e) {
      echo $e->getMessage();
    }
  }
?>