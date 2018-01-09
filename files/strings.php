<?php
$root = strtolower($_SERVER['SERVER_NAME']) == "localhost" ? substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "/", 1) + 1) : "/";

define("ENCRYPT_KEYWORD", "1ff8cc6708848c57e84e67d67f599156");
define("INITIALIZATION_VECTOR", "northwoodhotelph");
define("SUPPORT_EMAIL", "support@northwoodhotel.xyz");
define("NOREPLY_EMAIL", "no-reply@northwoodhotel.xyz");
define("PASSWORD", openssl_decrypt("U1BjeLnt4mvvpQ9ZZg==", "AES-256-CTR", ENCRYPT_KEYWORD, OPENSSL_ZERO_PADDING, INITIALIZATION_VECTOR));

$jsonFile = file_get_contents(__DIR__ . "/../strings.json");
$json     = json_decode($jsonFile, true);
if (!file_exists(__DIR__ . "/../config.ini")) {
  copy(__DIR__ . "/../assets/config.example", __DIR__ . "/../config.ini");
}
$config = parse_ini_file(__DIR__ . "/../config.ini");
foreach ($json as $string) {
  define($string['name'], $string['value']);
}
foreach ($config as $name => $value) {
  define(strtoupper($name), $value);
}
?>