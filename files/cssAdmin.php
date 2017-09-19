<?php
  echo "<link rel='shortcut icon' href='/nwh/favicon.ico'/>\n";
  echo "<link type='text/css' rel='stylesheet' href='/nwh/css/required/bootstrap.min.css'>\n";
  echo "<link type='text/css' rel='stylesheet' href='/nwh/css/required/loader.css'>\n";
  foreach (glob("css/*.css") as $css) {
		echo "<link type='text/css' rel='stylesheet' href='".$css."'>\n";
  }
  if($root!='')
  {
    foreach (glob($root."css/*.css") as $css) {
      echo "<link type='text/css' rel='stylesheet' href='".$css."'>\n";
    }
  }
?>