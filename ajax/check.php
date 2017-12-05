<?php
  require_once '../files/db.php';

  date_default_timezone_set("Asia/Manila");
  $dateNow = date('Y-m-d H:i:s');
  $id = $_POST['txtID'];

  if ($_POST['type'] == "checkIn") {
    if ($_POST['table'] == "walk_in") {
      $query = "INSERT INTO reservation VALUES(NULL, NULL, $id, '$dateNow', NULL, NULL)";
    } else {
      $query = "INSERT INTO reservation VALUES(NULL, $id, NULL, '$dateNow', NULL, NULL)";
    }

  } else if ($_POST['type'] == "checkOut") {
    if ($_POST['table'] == "walk_in") {
      $query = "UPDATE reservation SET CheckOut='$dateNow' WHERE WalkInID=$id";
    } else {
      $query = "UPDATE reservation SET CheckOut='$dateNow' WHERE BookingID=$id";
    }
  }
  mysqli_query($db, $query);
  if (mysqli_affected_rows($db) > 0){
    echo true;
  } else {
    echo "No rows affected";
  }
?>