<?php
  $root = "http://" . $_SERVER['SERVER_NAME'] .'/nwh/';
  echo "<link rel='shortcut icon' href='".$root."favicon.ico'/>\n";
  echo "<link rel='stylesheet' type='text/css' href='".$root."css/bootstrap.min.css'/>\n";
	foreach (glob("css/*.css") as $css) {
		echo "<link type='text/css' rel='stylesheet' href='".$css."'>\n";
	}
?>