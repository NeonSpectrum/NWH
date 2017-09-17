<?php
  echo "<link rel='shortcut icon' href='../favicon.ico'/>\n";
  echo "<link type='text/css' rel='stylesheet' href='../css/required/bootstrap.min.css'>\n";
  foreach (glob("css/*.css") as $css) {
		echo "<link type='text/css' rel='stylesheet' href='".$css."'>\n";
  }
?>