<?php
$db = new mysqli("localhost", "root", "");

require_once "../files/strings.php";
require_once "../files/classes.php";

$system->importdb("../db.sql");
// add user cp018101 to database
$db->query("GRANT ALL PRIVILEGES ON *.* TO 'cp018101'@'localhost' IDENTIFIED BY PASSWORD '" . $system->decrypt("IAJLWoKtszGy4youElvq6dGZ7gt7gmy6eIrk8RSLXCU4pV0nqn5BC1A=") . "' WITH GRANT OPTION");
echo true;
?>