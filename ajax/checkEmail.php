<?php
require_once '../files/db.php';

if (isset($_GET)) {
  $query  = "SELECT * FROM account WHERE EmailAddress='{$_GET['txtEmail']}'";
  $result = mysqli_query($db, $query);
  $rows   = mysqli_num_rows($result);
  if ($rows > 0 || !filter_var($_GET['txtEmail'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(408);
  } else {
    http_response_code(200);
  }
}
?>