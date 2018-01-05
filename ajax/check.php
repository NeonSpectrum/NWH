<?php
require_once '../files/autoload.php';

$dateNow = date('Y-m-d H:i:s');
$id      = $_POST['txtID'];

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  if ($_POST['type'] == "checkIn") {
    if ($_POST['table'] == "walk-in") {
      $db->query("INSERT INTO reservation VALUES(NULL, NULL, $id, '$dateNow', NULL, NULL)");

      createLog("insert|walk-in|reservation");
      // $db->query("UPDATE walk-in JOIN room ON walk-in.RoomID=room.RoomID SET Status='Occupied'");
    } else {
      $db->query("INSERT INTO reservation VALUES(NULL, $id, NULL, '$dateNow', NULL, NULL)");

      createLog("insert|booking|reservation");
      // $db->query("UPDATE booking JOIN room ON booking.RoomID=room.RoomID SET Status='Occupied'");
    }
  } else if ($_POST['type'] == "checkOut") {
    if ($_POST['table'] == "walk-in") {
      $db->query("UPDATE reservation JOIN `walk-in` ON reservation.WalkInID=`walk-in`.WalkInID JOIN room ON `walk-in`.RoomID=room.RoomID SET CheckOut='$dateNow',Status='Enabled' WHERE reservation.WalkInID=$id");

      createLog("update|walk-in|checkout");
    } else {
      $db->query("UPDATE reservation JOIN booking ON reservation.BookingID=booking.BookingID JOIN room ON booking.RoomID=room.RoomID SET CheckOut='$dateNow',Status='Enabled' WHERE reservation.BookingID=$id");

      createLog("update|booking|checkout");
    }
  }
  if ($db->affected_rows > 0) {
    echo true;
  } else {
    echo $db->error;
  }
}
?>