<?php
require_once 'strings.php';
require_once 'functions.php';

function executeQuery($query) {
  $db = new mysqli("localhost", "cp018101", PASSWORD);
  if (!$db->select_db("cp018101_nwh")) {
    echo "Database Not Found!";
    return false;
  }
  $result = $db->query($query);
  $db->close();
  return $result;
}
?>