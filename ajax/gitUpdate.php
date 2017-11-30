<?php
  echo str_replace("\r\n", "\n", shell_exec("export PATH=$PATH:~/git-2.9.5 && cd ".str_replace("ajax","",__DIR__)." && git pull origin master 2>&1"));
?>