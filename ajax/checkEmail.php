<?php
require_once '../files/db.php';

if (isset($_POST)) {
  $query  = "SELECT * FROM account WHERE EmailAddress='{$_POST['txtEmail']}'";
  $result = mysqli_query($db, $query);
  $rows   = mysqli_num_rows($result);
  if ($rows > 0 || !filter_var($_POST['txtEmail'], FILTER_VALIDATE_EMAIL)) {
    echo false;
  } else {
    echo true;
  }
}
?>