<?php
  $root = "http://" . $_SERVER['SERVER_NAME'] .'/nwh/';
	echo '<script src="'.$root.'js/jquery.min.js"></script>';
	echo '<script src="'.$root.'js/bootstrap.min.js"></script>';
  foreach (glob("js/*.js") as $js) {
    echo "<script src='".$js."'></script>\n";
  }
?>