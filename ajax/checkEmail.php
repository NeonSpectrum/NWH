<?php
require_once '../files/db.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  $result = $db->query("SELECT * FROM account WHERE EmailAddress='{$_GET['txtEmail']}'");
  $rows   = $result->num_rows;

  if ($rows > 0 || !filter_var($_GET['txtEmail'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(406);
  } else {
    http_response_code(200);
  }
}
?>