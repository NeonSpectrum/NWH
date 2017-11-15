<?php
  echo "<link rel='shortcut icon' href='/nwh/favicon.ico'/>\n";
  foreach (glob("$root../css/required/*.css") as $css)
  {
    if(strpos($css,"pace")) continue;
    echo "<link type='text/css' rel='stylesheet' href='".$css."?v=".filemtime($css)."'>\n";
  }
  echo "<link type='text/css' rel='stylesheet' href='$root../css/required/pace-theme-minimal.css'>\n";
  foreach (glob("css/*.css") as $css) {
    echo "<link type='text/css' rel='stylesheet' href='".$css."?v=".filemtime($css)."'>\n";
  }
  if($root!='')
  {
    foreach (glob("{$root}css/*.css") as $css) {
      echo "<link type='text/css' rel='stylesheet' href='".$css."?v=".filemtime($css)."'>\n";
    }
  }
?>