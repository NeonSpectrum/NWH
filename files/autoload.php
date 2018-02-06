<?php
use Bt51\NTP\Client;
use Bt51\NTP\Socket;

require_once 'strings.php';

$db = new mysqli("localhost", "cp018101", PASSWORD, "cp018101_nwh");

require_once __DIR__ . '/../vendor/autoload.php';

@date_default_timezone_set(TIMEZONE);

try {
  if (!OFFLINE_MODE) {
    $socket      = new Client(new Socket('ph.pool.ntp.org', 123));
    $ntp         = $socket->getTime();
    $date        = $ntp->setTimezone(new DateTimeZone(TIMEZONE))->format("Y-m-d");
    $dateandtime = $ntp->setTimezone(new DateTimeZone(TIMEZONE))->format("Y-m-d H:i:s");
  } else {
    throw new Exception;
  }
} catch (Exception $e) {
  $date        = date("Y-m-d");
  $dateandtime = date("Y-m-d H:i:s");
}

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

require_once 'classes.php';
?>