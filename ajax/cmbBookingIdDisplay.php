<?php
session_start();
require_once '../files/db.php';

if (isset($_POST)) {
  $arr       = array();
  $bookingID = $db->real_escape_string($_POST['cmbBookingID']);
  $result    = $db->query("SELECT * FROM booking JOIN room ON booking.RoomID = room.RoomID JOIN room_type ON room_type.RoomTypeID = room.RoomTypeID WHERE BookingID = $bookingID");
  $row       = $result->fetch_assoc();

  if ($result->num_rows == 1) {
    $arr[0] = $row['RoomType'];
    $arr[1] = $row['CheckInDate'];
    $arr[2] = $row['CheckOutDate'];
    $arr[3] = $row['Adults'];
    $arr[4] = $row['Childrens'];

    echo json_encode($arr);
  }
}
?>