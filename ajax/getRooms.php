<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $htmls = array_fill(0, count($room->getRoomTypeList()), "");

  $guests       = $system->filter_input($_POST['txtAdults']);
  $checkDate    = explode(" - ", $_POST['txtCheckDate']);
  $checkInDate  = date("Y-m-d", strtotime($checkDate[0]));
  $checkOutDate = date("Y-m-d", strtotime($checkDate[1]));
  $result       = $db->query("SELECT DISTINCT(RoomType), RoomDescription, RoomSimplifiedDescription, Icons, COUNT(*) As NumberOfRooms FROM room_type JOIN room ON room_type.RoomTypeID = room.RoomTypeID WHERE Capacity >= $guests GROUP BY room_type.RoomTypeID");

  for ($i = 0; $row = $result->fetch_assoc(); $i++) {
    $numberOfRooms = count($room->generateRoomID($row['RoomType'], $row['NumberOfRooms'], $checkInDate, $checkOutDate));
    if ($numberOfRooms > 0) {
      $htmls[$i] .= "<div class='row'><div class='col-md-4 img-baguette' style='padding:10px' data-tooltip='tooltip' data-placement='bottom' title='Click to view images'>";
      $first = true;
      foreach (glob("../gallery/images/rooms/{$row['RoomType']}*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
        $filename  = str_replace("../gallery/images/rooms/", "", $image);
        $thumbnail = str_replace("../gallery/images/rooms/", "../gallery/images/rooms/thumbnail/", $image);
        $htmls[$i] .= "<a href='$image' style='" . ($first == true ? "" : "display:none") . "'><img src='$thumbnail?v=" . filemtime("$thumbnail") . "' alt='$filename' style='width:100%'></a>";
        $first = false;
      }
      $htmls[$i] .= "</div><div class='col-md-6' id='txtRooms'><h3 id='roomName' style='margin-bottom:20px;font-weight:bold'>" . str_replace("_", " ", $row['RoomType']) . "</h3>" . str_replace("\n", "<br/>", $row['RoomDescription']) . "<br/><div style='padding: 10px 10px' id='txtIcons'>";
      $icons = explode("\n", $row['Icons']);
      foreach ($icons as $key => $value) {
        $iconArr = explode("=", $value);
        $icon    = isset($iconArr[0]) ? $iconArr[0] : "";
        $title   = isset($iconArr[1]) ? $iconArr[1] : "";
        $htmls[$i] .= "<i class='fa fa-$icon fa-2x' data-tooltip='tooltip' data-placement='bottom' title='$title'style='margin-right:20px'></i>";
      }
      $htmls[$i] .= "</div><span style='text-style:bold;font-size:20px;margin-right:5px'>Price: ₱&nbsp;<span id='roomPrice'>" . number_format($room->getRoomPrice($row['RoomType'])) . "</span></span><small>(Per night)</small><span id='roomSimpDesc' style='display:none'><ul>";
      $roomSimpDesc = explode("\n", $row['RoomSimplifiedDescription']);
      foreach ($roomSimpDesc as $key => $value) {
        $htmls[$i] .= "<li>$value</li>";
      }
      $htmls[$i] .= "</ul></span></div><div class='col-md-2 numberOfRooms'>";
      $htmls[$i] .= "<select style='width:100%' class='form-control'>";
      for ($j = 0; $j <= $numberOfRooms; $j++) {
        $htmls[$i] .= "<option>$j</option>";
      }
      $htmls[$i] .= "</select>";
      $htmls[$i] .= "<small class='text-center center-block'>Only $numberOfRooms left.</small></div></div></div>";
    }
  }
  if (strlen(implode($htmls)) == 0) {
    echo json_encode([false]);
  } else {
    echo json_encode($htmls);
  }
}
?>