<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $file = fopen("../config.ini", "r");
  $data = "";
  while (!feof($file)) {
    $line        = fgets($file);
    $lineContent = explode(" = ", $line);
    if (key_exists(strtolower($lineContent[0]), $_POST)) {
      if ($_POST[$lineContent[0]] == "on") {
        $result = "true";
      } else if ($_POST[$lineContent[0]] == "off") {
        $result = "false";
      } else {
        $result = $_POST[$lineContent[0]];
      }
      $data .= $lineContent[0] . " = " . $result . PHP_EOL;
    } else {
      $data .= $line;
    }
  }
  fclose($file);
  unlink("../config.ini");
  $file = fopen("../config.ini", "w");
  fwrite($file, $data);
  fclose($file);
  echo true;
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>