<?php
  session_start();
	require_once '../../files/db.php';
  if (isset($_POST)){
    try{
      $arr = array();
      $email = stripslashes($_POST['cmbEmail']); // removes backslashes
      $email = mysqli_real_escape_string($db,$email); //escapes special characters in a string
     
      $query = "SELECT * FROM `account` WHERE EmailAddress='$email'";
      $result = mysqli_query($db,$query) or die(mysql_error());
      $row = $result->fetch_assoc();
      $count = mysqli_num_rows($result);
      if($count==1){
        $arr[0] = $row['AccountType'];
        $arr[1] = $row['ProfilePicture'];
        $arr[2] = $row['FirstName'];
        $arr[3] = $row['LastName'];
        $arr[4] = $row['isLogged'];
        
        echo json_encode($arr);
      }
      else
      {
        $arr[0] = 'error';
        echo json_encode($arr);
      }
    }
    catch(PDOException $e){
			echo $e->getMessage();
		}
  }
?>