<?php
require_once "../files/strings.php";

$db = new mysqli("localhost", "root", "");

if (!$db->select_db("cp018101_nwh")) {
  echo false;
} else {
  echo true;
}

$db->close();
?>