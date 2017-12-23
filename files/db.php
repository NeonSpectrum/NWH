<?php
require_once 'strings.php';
require_once 'functions.php';

date_default_timezone_set("Asia/Manila");

ini_set("display_errors", "0");
$db = new mysqli("localhost", "cp018101", PASSWORD, "cp018101_nwh");
ini_set("display_errors", "1");
?>