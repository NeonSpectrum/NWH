<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $star    = $system->filter_input($_POST['rating']);
  $comment = $system->filter_input($_POST['txtComment']);
  echo $account->addFeedback($star, $comment);
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>