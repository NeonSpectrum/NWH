<?php
  session_start();
  require_once '../files/db.php';
  if(isset($_SESSION['email']))
  {
    $query = "SELECT * FROM `account` WHERE EmailAddress='{$_SESSION['email']}'";
    $result = mysqli_query($db,$query) or die(mysql_error());
    $row = mysqli_fetch_assoc($result);
    if(session_id()!=$row['SessionID'] && $row['AccountType'] != "Owner")
    {
      echo false;
      return;
    }
  }
  echo true;
?>