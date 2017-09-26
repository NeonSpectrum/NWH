<?php
  session_start();
  $root = isset($root) ? $root : '';
	require_once $root.'../files/db.php';

	// $incrementalFileName=1;
	$name = $_SESSION['fname'].$_SESSION['lname'];
	$email = $_SESSION['email'];
	$target_dir = $_SERVER['DOCUMENT_ROOT']."/nwh/images/profilepics/";
	$target_file = basename($_FILES["file"]["name"]);
	$imageFileType = pathinfo($target_dir.$target_file,PATHINFO_EXTENSION);
	$target_file = basename($name) . "." . $imageFileType;

	/* while (file_exists($target_file))
	{
		$target_file = basename($name.'_'.$incrementalFileName++) . "." .$imageFileType;
	} */
	if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir . $target_file))
	{
		$query = "UPDATE account SET ProfilePicture='$target_file' WHERE EmailAddress='$email'";
		$result = mysqli_query($db,$query) or die(mysql_error());
		$_SESSION["picture"]=$target_file;
		echo "ok";
	}
	else
	{
		echo UPLOAD_ERROR;
	}
?>