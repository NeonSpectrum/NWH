<?php
require_once '../files/db.php';

date_default_timezone_set("Asia/Manila");
$dateNow = date('Y-m-d H:i:s');
$id      = $_POST['txtID'];

if ($_POST['type'] == "checkIn") {
  if ($_POST['table'] == "walk_in") {
    $query = "INSERT INTO reservation VALUES(NULL, NULL, $id, '$dateNow', NULL, NULL)";
    mysqli_query($db, $query);
    $query = "UPDATE walk_in JOIN room ON walk_in.RoomID=room.RoomID SET Status='Occupied'";
    mysqli_query($db, $query);
  } else {
    $query = "INSERT INTO reservation VALUES(NULL, $id, NULL, '$dateNow', NULL, NULL)";
    mysqli_query($db, $query);
    $query = "UPDATE booking JOIN room ON booking.RoomID=room.RoomID SET Status='Occupied'";
    mysqli_query($db, $query);
  }
} else if ($_POST['type'] == "checkOut") {
  if ($_POST['table'] == "walk_in") {
    $query = "UPDATE reservation JOIN walk_in ON reservation.WalkInID=walk_in.WalkInID JOIN room ON walk_in.RoomID=room.RoomID SET CheckOut='$dateNow',Status='Enabled' WHERE reservation.WalkInID=$id";
    mysqli_query($db, $query);
  } else {
    $query = "UPDATE reservation JOIN booking ON reservation.BookingID=booking.BookingID JOIN room ON walk_in.RoomID=room.RoomID SET CheckOut='$dateNow',Status='Enabled' WHERE reservation.BookingID=$id";
    mysqli_query($db, $query);
  }
}
if (mysqli_affected_rows($db) > 0) {
  echo true;
} else {
  echo "No rows affected";
}
?>