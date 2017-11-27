<?php
  define("ENCRYPT_KEYWORD", "northwoodhotel");
  define("EMAIL", "neonspectrumph@gmail.com");
  define("PASSWORD", openssl_decrypt("zsR90qYBI8Lc39xSj9uuwg==", "AES-128-ECB", ENCRYPT_KEYWORD));

  $jsonFile = file_get_contents(__DIR__."/../assets/strings.json");
  $json = json_decode($jsonFile, true);
  foreach ($json as $string) {
    define("{$string['name']}", "{$string['value']}");
  }
?>