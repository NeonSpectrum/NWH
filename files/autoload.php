<?php
require_once 'strings.php';

@date_default_timezone_set(TIMEZONE);
$date        = date("Y-m-d");
$dateandtime = date("Y-m-d H:i:s");

$db = new mysqli("localhost", "cp018101", PASSWORD, "cp018101_nwh");

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'classes.php';

if (DEBUG) {
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
}

// PAYPAL CREDENTIALS
$apiContext = new \PayPal\Rest\ApiContext(
  new \PayPal\Auth\OAuthTokenCredential(
    CLIENT_ID_PAYPAL,
    SECRET_PAYPAL
  )
);
?>