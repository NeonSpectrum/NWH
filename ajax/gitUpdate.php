<?php
require_once "../files/db.php";

if ($_SERVER['SERVER_NAME'] == "localhost") {
  echo false;
} else {
  $output = trim(preg_replace('/\s+/', ' ', nl2br(shell_exec('export PATH=$PATH:~/git-2.9.5 && cd ' . str_replace("ajax", "", __DIR__) . ' && git pull origin master 2>&1'))));
  if (strpos($output, "files changed")) {
    createLog("git|update|" . shell_exec('export PATH=$PATH:~/git-2.9.5 && cd ' . str_replace("ajax", "", __DIR__) . ' && git log -1 --pretty=%B 2>&1'));
  }
  echo $output;
}
?>