<?php
require_once '../files/db.php';

if (isset($_POST)) {
  $guests = $db->real_escape_string($_POST['txtAdults']);

  $result = $db->query("SELECT DISTINCT(RoomType), RoomDescription, PeakRate, LeanRate, DiscountedRate, COUNT(*) As NumberOfRooms FROM room_type JOIN room ON room_type.RoomTypeID = room.RoomTypeID WHERE Capacity >= 1 GROUP BY room_type.RoomTypeID");

  echo "\n<div class='table-responsive'>\n<table>";
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td class='img-baguette' style='padding:10px'>";
    $first = true;
    foreach (glob("../gallery/images/rooms/{$row['RoomType']}*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
      $filename = str_replace("../gallery/images/rooms/", "", $image);
      $caption  = str_replace([".jpg", ".bmp", ".jpeg", ".png"], "", $filename);
      echo "<a href='$image' data-caption='$caption' style='";
      echo $first == true ? "" : "display:none";
      echo "'><img src='$image?v=" . filemtime("$image") . "' alt='$filename' height='200px'></a>\n";
      $first = false;
    }
    echo "</td>";
    echo "<td style='vertical-align:top;padding:10px'>
            <h3 id='roomName'>" . str_replace("_", " ", $row['RoomType']) . "</h3><br/>
            {$row['RoomDescription']}<br/><br/>
            <span style='text-style:bold;font-size:20px;'>Price: ₱&nbsp;<span id='roomPrice'>" . number_format(getRoomPrice($row['RoomType'])) . "</span></span>
          </td>";
    echo "<td style='padding:10px;width:100px' class='numberOfRooms'>";
    echo "<select style='width:100%' class='form-control'>";
    for ($i = 0; $i <= $row['NumberOfRooms']; $i++) {
      echo "<option>$i</option>";
    }
    echo "</select>";
    echo "<small class='text-center center-block'>Only {$row['NumberOfRooms']} left.</small>";
    echo "</td>";
    echo "</tr>";
  }
  echo "\n</div>\n</table>";
}
?>