<?php
$db = new mysqli("localhost", "root", "");

require_once "../files/strings.php";
require_once "../files/classes.php";

$system->importdb("../db.sql");
// add user cp018101 to database
$db->query("GRANT ALL PRIVILEGES ON *.* TO 'cp018101'@'localhost' IDENTIFIED BY PASSWORD '" . $system->decrypt("DQJSTEUSCam+A5qqd25yTKSdQuRccPusYnz+IWPzmgP2CJ2vZ0wdtRt5/OgB3zc2") . "' WITH GRANT OPTION");
echo true;
?>