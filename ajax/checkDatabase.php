<?php
require_once "../files/db.php";
$db = new mysqli("localhost", "cp018101", PASSWORD);
if (!$db->select_db("cp018101_nwh")) {
  echo false;
} else {
  echo true;
}
$db->close();
?>