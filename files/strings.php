<?php
$root = strtolower($_SERVER['SERVER_NAME']) == "localhost" ? substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "/", 1) + 1) : "/";

define("ENCRYPT_KEYWORD", "northwoodhotel");
define("SUPPORT_EMAIL", "support@northwoodhotel.xyz");
define("NOREPLY_EMAIL", "no-reply@northwoodhotel.xyz");
define("PASSWORD", openssl_decrypt("zsR90qYBI8Lc39xSj9uuwg==", "AES-128-ECB", ENCRYPT_KEYWORD));

$jsonFile = file_get_contents(__DIR__ . "/../strings.json");
$json     = json_decode($jsonFile, true);
$config   = parse_ini_file(__DIR__ . "/../config.ini");
foreach ($json as $string) {
  define($string['name'], $string['value']);
}
foreach ($config as $name => $value) {
  define(strtoupper($name), $value);
}
?>