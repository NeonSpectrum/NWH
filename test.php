<?php
require_once "files/autoload.php";
$image = new \Gumlet\ImageResize('bg.jpg');
$image->resizeToHeight(720);
$image->save('bg.jpg');
?>