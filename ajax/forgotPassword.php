<?php
$domain = strpos($_SERVER['REQUEST_URI'], "nwh") ? "{$_SERVER['SERVER_NAME']}/nwh" : $_SERVER['SERVER_NAME'];

require_once '../files/autoload.php';

parse_str(decrypt($_SERVER['QUERY_STRING']));

if (isset($newPass)) {
  $newPass = password_hash($newPass, PASSWORD_DEFAULT);

  $result = $db->query("UPDATE account SET Password='$newPass' WHERE EmailAddress='$email'");

  if ($db->affected_rows > 0) {
    createLog("update|account.password|$email");
    echo '<script>alert("Reset Successfully!");location.href="../";</script>';
    exit();
  } else {
    echo $db->error;
  }
} else if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $email = $system->filter_input($_POST['txtEmail']);

  $result = $db->query("SELECT * FROM `account` WHERE EmailAddress='$email'");
  $row    = $result->fetch_assoc();

  if ($result->num_rows == 1) {
    createLog("sent|forgot.password|$email");
    $data    = encrypt("email=$email&newPass=" . getRandomString(8));
    $subject = "Northwood Hotel Forgot Password";
    $body    = "Please proceed to this link to reset your password:<br/>http://$domain/files/checkForgot.php?$data<br/><br/>Your new password will be: <b>$randomNumber</b>";

    echo sendMail("$email", "$subject", "$body");
  } else {
    echo INVALID_EMAIL;
  }
}
?>