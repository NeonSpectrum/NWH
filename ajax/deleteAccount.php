<?php
  session_start();
  require_once '../files/db.php';

  if (isset($_POST)) {
    try {
      $email = $_POST['txtEmail'];

      $query = "DELETE FROM account WHERE EmailAddress='$email'";
      $result = mysqli_query($db,$query);
      if (mysqli_affected_rows($db)!=0) {
        echo true;
      }
    } catch(PDOException $e) {
      echo $e->getMessage();
    }
  }
?>