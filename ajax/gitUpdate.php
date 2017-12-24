<?php
require_once "../files/db.php";

if ($_SERVER['SERVER_NAME'] != "localhost") {
  echo false;
} else {
  $output = trim(preg_replace('/\s+/', ' ', nl2br(shell_exec('export PATH=$PATH:~/git-2.9.5 && cd ' . str_replace("ajax", "", __DIR__) . ' && git pull origin master 2>&1'))));
  if (strpos($output, "files changed")) {
    createLog("git|update|" . substr(str_replace("<br>", "", substr($output, strrpos($output, "<br>", "-5"), "-1")), 0, strpos(str_replace("<br>", "", substr($output, strrpos($output, "<br>", "-5"), "-1")), ",")));
  }
  echo $output;
}
?>