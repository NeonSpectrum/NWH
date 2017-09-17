<?php
  session_start();
	require_once '../../files/db.php';
  if (isset($_POST['email'])){
    try{
      $email = $_POST['email'];
      $accounttype = $_POST['accounttype'];
      $profilepicture = $_POST['profilepicture'];
      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
      $islogged = $_POST['islogged'];
      $query = "UPDATE `account` SET AccountType='".$accounttype."',ProfilePicture='".$profilepicture."',Firstname='".$firstname."',Lastname='".$lastname."',isLogged=".$islogged." WHERE EmailAddress='".$email."'";
      $result = mysqli_query($db,$query) or die(mysql_error());
      if($result){
        echo "ok";
      }
    }
    catch(PDOException $e){
			echo $e->getMessage();
		}
  }
?>