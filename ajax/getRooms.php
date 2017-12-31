<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $guests       = $system->filter_input($_POST['txtAdults']);
  $checkDate    = explode(" - ", $_POST['txtCheckDate']);
  $checkInDate  = date("Y-m-d", strtotime($checkDate[0]));
  $checkOutDate = date("Y-m-d", strtotime($checkDate[1]));

  $result = $db->query("SELECT DISTINCT(RoomType), RoomDescription, COUNT(*) As NumberOfRooms FROM room_type JOIN room ON room_type.RoomTypeID = room.RoomTypeID WHERE Capacity >= $guests GROUP BY room_type.RoomTypeID");

  while ($row = $result->fetch_assoc()) {
    $numberOfRooms = count($room->generateRoomID($row['RoomType'], $row['NumberOfRooms'], $checkInDate, $checkOutDate));
    if ($numberOfRooms > 0) {
      echo "<div class='row'>";
      echo "<div class='col-md-4 img-baguette' style='padding:10px'>";
      $first = true;
      foreach (glob("../gallery/images/rooms/{$row['RoomType']}*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
        $filename = str_replace("../gallery/images/rooms/", "", $image);
        $caption  = str_replace([".jpg", ".bmp", ".jpeg", ".png"], "", $filename);
        echo "<a href='$image' data-caption='$caption' style='";
        echo $first == true ? "" : "display:none";
        echo "'><img src='$image?v=" . filemtime("$image") . "' alt='$filename' style='width:100%'></a>\n";
        $first = false;
      }
      echo "</div>";
      echo "<div class='col-md-6' style='vertical-align:top;padding:10px'>
            <h3 id='roomName'>" . str_replace("_", " ", $row['RoomType']) . "</h3><br/>
            {$row['RoomDescription']}<br/><br/>
            <span style='text-style:bold;font-size:20px;'>Price: ₱&nbsp;<span id='roomPrice'>" . number_format($room->getRoomPrice($row['RoomType'])) . "</span></span>
          </div>";
      echo "<div class='col-md-2' style='padding:85px 30px;height:220px' class='numberOfRooms'>";
      echo "<select style='width:100%' class='form-control'>";
      for ($i = 0; $i <= $numberOfRooms; $i++) {
        echo "<option>$i</option>";
      }
      echo "</select>";
      echo "<small class='text-center center-block'>Only $numberOfRooms left.</small></div></div>";
      $hasRooms = true;
    } else {
      $hasRooms = false;
    }
  }
  echo $hasRooms ? "\n</div>\n</table>" : "<div style='padding:15% 0%;width:100%;text-align:center;font-size:22px'>No Rooms Available</div>\n</div>\n</table>";
}
?>