<?php
  session_start();
  require_once '../files/db.php';

  if (isset($_POST)) {
    try {
      // GENERATE ROOM ID
      $room = $_POST['rdbRoom'];
      $rooms = array();

      $query = "SELECT RoomID, RoomType, Status FROM room JOIN room_type ON room.RoomTypeID = room_type.RoomTypeID WHERE RoomType = '$room'";
      $result = mysqli_query($db, $query);
      
      while ($row = mysqli_fetch_assoc($result)) {
        if ($row['Status'] != 'Disabled' && $row['Status'] != 'Occupied')
          $rooms[] = $row['RoomID'];
      }
      if (count($rooms) == 0) {
        echo false;
        return;
      }
      $roomID = $rooms[array_rand($rooms, 1)];
      $email = $_SESSION['email'];
      $checkIn = $_POST['txtCheckInDate'];
      $checkOut = $_POST['txtCheckOutDate'];
      $adults = $_POST['txtAdults'];
      $children = $_POST['txtChildren'];
      
      $query = "SELECT BookingID FROM booking ORDER BY BookingID DESC";
      $result = mysqli_query($db, $query);
      $row = mysqli_fetch_assoc($result);
      $bookingID = $row['BookingID'] + 1;
      $arr = array();

      $query = "INSERT INTO booking VALUES(NULL, '$email', '$roomID', '$checkIn', '$checkOut', $adults, $children)";
      mysqli_query($db, $query);

      if (mysqli_affected_rows($db) != 0) {
        unset($_SESSION['roomID']);
        $arr[0] = mysqli_insert_id($db);
        $arr[1] = $roomID;
        echo json_encode($arr);
      } else {
        echo "There's something wrong in your book!";
      }
      $query = "UPDATE room SET Status='Occupied' WHERE RoomID=$roomID";
      mysqli_query($db, $query);
    } catch(PDOException $e) {
      echo $e->getMessage();
    }
  }
?>