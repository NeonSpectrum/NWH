<?php
require_once "../files/autoload.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $roomType = $db->real_escape_string($_POST['roomType']);

  $result = $db->query("SELECT * FROM room_type WHERE RoomType='$roomType'");
  $row    = $result->fetch_assoc();

  $arr[0] = "";
  foreach (glob("../gallery/images/rooms/{$roomType}*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
    $src = str_replace("../", "", $image);
    $arr[0] .= "<div><img u='image' src='$src?v=" . filemtime($image) . "'/></div>\n";
  }
  $arr[1] = "{$row['RoomDescription']}<br/><div style='padding:20px;text-align:center;font-size:30px;font-style:bold'>₱&nbsp;" . number_format($room->getRoomPrice($row['RoomType'])) . "</div>";

  echo json_encode($arr);
}
?>