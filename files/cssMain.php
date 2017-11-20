<?php
  $root = isset($root) ? $root : '';
  echo "\n<link rel='shortcut icon' href='/nwh/favicon.ico'/>\n";
  foreach (glob("$root../css/required/*min.css") as $css) {
    echo "<link type='text/css' rel='stylesheet' href='".$css."?v=".filemtime($css)."'>\n";
  }
  foreach (glob("$root../css/required/*.css") as $css) {
    if(strpos($css,"pace") || strpos($css,"min.css")) continue;
    echo "<link type='text/css' rel='stylesheet' href='".$css."?v=".filemtime($css)."'>\n";
  }
  echo "<link type='text/css' rel='stylesheet' id='pace' href='$root../css/required/pace-theme-center-simple.css'>\n";
  foreach (glob("$root../css/*.css") as $css) {
    echo "<link type='text/css' rel='stylesheet' href='".$css."?v=".filemtime($css)."'>\n";
  }
  foreach (glob("css/*.css") as $css) {
    echo "<link type='text/css' rel='stylesheet' href='".$css."?v=".filemtime($css)."'>\n";
  }
  // echo "<link href='http://fonts.googleapis.com/css?family=Museo+Slab' rel='stylesheet' type='text/css'>"
?>