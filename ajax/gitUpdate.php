<?php
if ($_SERVER['SERVER_NAME'] == "localhost") {
  echo false;
  return;
}
createLog("git|update");
echo trim(preg_replace('/\s+/', ' ', nl2br(shell_exec("export PATH=$PATH:~/git-2.9.5 && cd " . str_replace("ajax", "", __DIR__) . " && git pull origin master 2>&1"))));
?>