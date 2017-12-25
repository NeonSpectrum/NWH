<?php
date_default_timezone_set("Asia/Manila");
$date        = date("Y-m-d");
$dateandtime = date("Y-m-d H:i:s");

require_once 'strings.php';
require_once 'classes.php';

// COMPOSER
require_once __DIR__ . '/../vendor/autoload.php';

ini_set("display_errors", "0");
$db = new mysqli("localhost", "cp018101", PASSWORD, "cp018101_nwh");
ini_set("display_errors", "1");

?>