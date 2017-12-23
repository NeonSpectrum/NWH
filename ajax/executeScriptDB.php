<?php
require_once "../files/strings.php";

$db = new mysqli("localhost", "cp018101", PASSWORD);

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

$db->close();
echo true;
?>