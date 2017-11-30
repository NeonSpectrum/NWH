<?php
  $root = substr($_SERVER['PHP_SELF'], 0, 5) == '/nwh/' ? '/nwh/' : '/';
  // echo str_replace("\r\n", "\n", shell_exec("cd ".str_replace("\ajax","",__DIR__)." && git pull origin master 2>&1"));
  echo "cd ".str_replace("\ajax","",__DIR__)." && git pull origin master 2>&1";
?>