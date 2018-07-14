<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  echo $system->backupdb($_POST['tables'], $_POST['type']);
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>