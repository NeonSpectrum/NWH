<?php
  echo trim(preg_replace('/\s+/', ' ', nl2br(shell_exec('cd /var/www/html/nwh && git pull origin master 2>&1'))));
?>