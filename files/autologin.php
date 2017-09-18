<?php
  session_start();
  $root = isset($root) ? $root : '';
  require_once $root.'../files/db.php';
  if(isset($_COOKIE['nwhAuth']))
  {
    parse_str($_COOKIE['nwhAuth']);
    $query = "SELECT * FROM `account` WHERE EmailAddress='$email' AND Password='$password'";
    $result = mysqli_query($db,$query) or die(mysql_error());
    $row = $result->fetch_assoc();
    $count = mysqli_num_rows($result);
    if($count==1){
      $_SESSION['logged'] = true;
      $_SESSION['email'] = $row['EmailAddress'];
      $_SESSION['fname'] = $row['FirstName'];
      $_SESSION['lname'] = $row['LastName'];
      $_SESSION['picture'] = $row['ProfilePicture'];
      $_SESSION['accounttype'] = $row['AccountType'];
    }
  }
?>