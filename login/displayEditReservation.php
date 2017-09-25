<?php
  session_start();
  require_once '../files/db.php';
	if (isset($_POST))
	{
		try
		{
			$arr = array();
			$bookingID=$_POST['cmbBookingID'];
			$query = "SELECT * FROM `booking` WHERE BookingID=$bookingID";
			$result = mysqli_query($db, $query) or die(mysql_error());
			$row = $result->fetch_assoc();
			$count = mysqli_num_rows($result);
			if ($count==1)
			{
				$arr[0] = $row['RoomID'];
				$arr[1] = $row['CheckInDate'];
				$arr[2] = $row['CheckOutDate'];
				$arr[3] = $row['Adults'];
				$arr[4] = $row['Childrens'];
				
				echo json_encode($arr);
			}
			else
			{
				$arr[0] = 'error';
				echo json_encode($arr);
			}
		}
		catch (PDOException $e)
		{
    	echo $e->getMessage();
  	}
	}
?>