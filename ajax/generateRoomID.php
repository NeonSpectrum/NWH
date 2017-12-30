<?php
require_once "../files/autoload.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $checkDate = explode(" - ", $_POST['checkDate']);
  echo $room->generateRoomID($_POST['roomType'], 1, $checkDate[0], $checkDate[1])[0];
}
?>