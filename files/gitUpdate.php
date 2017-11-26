<?php
  $root = substr($_SERVER['PHP_SELF'], 0, 5) == '/nwh/' ? '/nwh/' : '/';
  echo trim(preg_replace('/\s+/', ' ', nl2br(shell_exec("cd /var/www/html{$root} && git pull origin master 2>&1"))));
?>