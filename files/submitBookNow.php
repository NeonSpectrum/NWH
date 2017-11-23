<?php
  session_start();
  require_once 'db.php';

  $adults = (int)$_POST['txtBookAdults'];
	$childrens = (int)$_POST['txtBookChildrens'];
	
  if ($adults + $childrens == 0) {
    echo "Please fill up the Adults or Childrens!";
  } elseif (!isset($_SESSION['email'])) {
    echo "Please login first before booking.";
  } else {
    $checkInDate = new DateTime($_POST['txtBookCheckInDate']);
    $checkOutDate = new DateTime($_POST['txtBookCheckOutDate']);
    if ($checkInDate > $checkOutDate) {
      echo "The Check Out Date must greater than Check In Date";
      return;
    }
    if (isset($_POST)) {
      try {
        $email = $_SESSION['email'];
        $checkIn = $_POST['txtBookCheckInDate'];
        $checkOut = $_POST['txtBookCheckOutDate'];
        $adults = $_POST['txtBookAdults'];
        $childrens = $_POST['txtBookChildrens'];
        
        $query = "INSERT INTO booking VALUES(NULL, '$email', '101', '$checkIn', '$checkOut', $adults, $childrens)";
        $result = mysqli_query($db,$query) or die(mysql_error());
        if(mysqli_affected_rows($db)!=0) {
          echo "ok";
        } else {
          echo "There's something wrong in your book!";
        }
      } catch(PDOException $e) {
        echo $e->getMessage();
      }
    }
  }
?>