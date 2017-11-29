<?php
  session_start();
	require_once '../files/db.php';
	
  $adults = (int)$_POST['txtEditAdults'];
	$childrens = (int)$_POST['txtEditChildrens'];
	
  if ($adults == 0){
    echo NOT_ENOUGH_ADULTS;
    return;
  } elseif ($adults+$childrens==0) {
    echo INVALID_ADULTS_CHILDRENS;
    return;
  }
  if (isset($_POST)) {
    try {
      $bookingID = $_POST['cmbBookingID'];
      $roomID = $_POST['txtEditRoomID'];
      $checkInDate = $_POST['txtEditCheckInDate'];
      $checkOutDate = $_POST['txtEditCheckOutDate'];
      $adults = $_POST['txtEditAdults'];
      $childrens = $_POST['txtEditChildrens'];
      $query = "UPDATE booking SET RoomID=$roomID,CheckInDate='$checkInDate',CheckOutDate='$checkOutDate',Adults=$adults,Childrens=$childrens WHERE BookingID=$bookingID";
      $result = mysqli_query($db,$query) or die(mysql_error());
      if(mysqli_affected_rows($db)!=0)
      {
        echo true;
      }
      else
      {
        echo NO_UPDATE;
      }
    } catch(PDOException $e) {
      echo $e->getMessage();
    }
  }
?>