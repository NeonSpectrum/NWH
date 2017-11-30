<?php
  echo trim(preg_replace('/\s+/', ' ', nl2br(shell_exec("export PATH=$PATH:~/git-2.9.5 && cd ".str_replace("ajax","",__DIR__)." && git pull origin master 2>&1"))));
?>