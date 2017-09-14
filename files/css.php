<?php
  $root = "http://" . $_SERVER['SERVER_NAME'] .'/nwh/';
  echo '<link rel="shortcut icon" href="'.$root.'favicon.ico"/>';
  echo '<link rel="stylesheet" type="text/css" href="'.$root.'css/bootstrap.min.css"/>';
	foreach (glob("css/*.css") as $css) {
		echo '<link type="text/css" rel="stylesheet" href="'.$css.'">';
	}
?>