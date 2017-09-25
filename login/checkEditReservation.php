<?php
  session_start();
  if(!isset($root))
    $root='';
	require_once $root.'../files/db.php';
	$adults = (int)$_POST['txtEditAdults'];
	$childrens = (int)$_POST['txtEditChildrens'];
	if($adults==0)
	{
		echo "1 Adult or more is required!";
		return;
	}
	elseif($adults+$childrens==0)
	{
		echo "Please fill up the Adults or Childrens!";
		return;
	}
  if (isset($_POST)){
    try{
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
        echo "ok";
      }
      else
      {
        echo "Nothing changed.";
      }
    }
    catch(PDOException $e){
			echo $e->getMessage();
		}
  }
?>