<?php
require_once 'strings.php';

date_default_timezone_set(TIMEZONE);
$date        = date("Y-m-d");
$dateandtime = date("Y-m-d H:i:s");

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'classes.php';

$db = @new mysqli("localhost", "cp018101", PASSWORD, "cp018101_nwh");

if (DEBUG) {
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
}
?>