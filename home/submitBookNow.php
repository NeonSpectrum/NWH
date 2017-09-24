<?php
	session_start();
	if(!isset($root))
		$root='';
	require_once $root.'../files/db.php';
	if(!isset($_SESSION['email']))
	{
		echo "Please login first before booking.";
	}
	else
	{
		$adults = (int)$_POST['txtAdults'];
		$childrens = (int)$_POST['txtAdults'];
		if($adults+$childrens==0)
		{
			echo "Please fill up the Adults or Childrens!";
			return;
		}
		$checkInDate = new DateTime($_POST['txtCheckInDate']);
		$checkOutDate= new DateTime($_POST['txtCheckOutDate']);
		if($checkInDate>$checkOutDate)
		{
			echo "The Check Out Date must greater than Check In Date";
			return;
		}
		if (isset($_POST)){
			try{
				$email = $_SESSION['email'];
				$checkIn = $_POST['txtCheckInDate'];
				$checkOut = $_POST['txtCheckOutDate'];
				$adults = $_POST['txtAdults'];
				$childrens = $_POST['txtChildrens'];
				
				$query = "INSERT INTO booking VALUES(NULL, '$email', '101', '$checkIn', '$checkOut', $adults, $childrens)";
				$result = mysqli_query($db,$query) or die(mysql_error());
				if(mysqli_affected_rows($db)!=0)
				{
					echo "ok";
				}
				else
				{
					echo "There's something wrong in your book!";
				}
			}
			catch(PDOException $e){
				echo $e->getMessage();
			}
		}
	}
?>