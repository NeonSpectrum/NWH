<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $type  = $system->filter_input($_POST['type']);
  $dates = explode(" - ", $system->filter_input($_POST['type']));
  echo $system->markEvent($type, $dates[0], $dates[1]);
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>