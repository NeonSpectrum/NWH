<?php
require_once "../files/strings.php";
require_once "../files/classes.php";

$db = new mysqli("localhost", "root", "");

$contents = file_get_contents("../cp018101_nwh.sql");

$comment_patterns = array('/\/\*.*(\n)*.*(\*\/)?/',
  '/\s*--.*\n/',
  '/\s*#.*\n/',
);
$contents = preg_replace($comment_patterns, "\n", $contents);

$statements = explode(";\n", $contents);
$statements = preg_replace("/\s/", ' ', $statements);
foreach ($statements as $query) {
  if (trim($query) != '') {
    $res = $db->query($query);
  }
}
// add user cp018101 to database
$db->query("GRANT ALL PRIVILEGES ON *.* TO 'cp018101'@'localhost' IDENTIFIED BY PASSWORD '" . $system->nwh_decrypt("DQJSTEUSCam+A5qqd25yTKSdQuRccPusYnz+IWPzmgP2CJ2vZ0wdtRt5/OgB3zc2") . "' WITH GRANT OPTION");

$db->close();
echo true;
?>