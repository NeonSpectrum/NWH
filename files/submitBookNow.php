<?php
  session_start();
  require_once 'db.php';
  require_once 'functions.php';

  if (isset($_POST)) {
    try {
      $email = $_SESSION['email'];
      $checkIn = $_POST['txtCheckInDate'];
      $checkOut = $_POST['txtCheckOutDate'];
      $adults = $_POST['txtAdults'];
      $children = $_POST['txtChildren'];
      $roomID = nwh_decrypt($_POST['txtRoomID']);
      
      $query = "SELECT BookingID FROM booking ORDER BY BookingID DESC";
      $result = mysqli_query($db, $query);
      $row = mysqli_fetch_assoc($result);
      $bookingID = $row['BookingID'] + 1;

      $query = "INSERT INTO booking VALUES(NULL, '$email', '$roomID', '$checkIn', '$checkOut', $adults, $children)";
      $result = mysqli_query($db, $query);
      if(mysqli_affected_rows($db)!=0) {
        unset($_SESSION['roomID']);
        echo "$bookingID";
      } else {
        echo "There's something wrong in your book!";
      }
    } catch(PDOException $e) {
      echo $e->getMessage();
    }
  }
?>