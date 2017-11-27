<?php
  session_start();
  require_once '../files/db.php';
  
  if (isset($_POST)) {
    $guests = $_POST['txtAdults'];
    $room = $_POST['rdbRoom'];
    $rooms = array();

    $query = "SELECT RoomID, RoomType, Status FROM room JOIN room_type ON room.RoomTypeID = room_type.RoomTypeID WHERE RoomType = '$room'";
    $result = mysqli_query($db, $query);
    
    while ($row = mysqli_fetch_assoc($result)) {
      if ($row['Status'] != 'Disabled')
        $rooms[] = $row['RoomID'];
    }

    echo nwh_encrypt($rooms[array_rand($rooms,1)]);
  }
?>