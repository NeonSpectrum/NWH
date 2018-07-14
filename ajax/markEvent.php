<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $type  = $system->filter_input($_POST['type']);
  $dates = explode(' - ', $system->filter_input($_POST['date']));
  echo $system->markEvent($type, $dates[0], $dates[1]);
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>