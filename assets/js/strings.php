<?php
  $root = substr($_SERVER['PHP_SELF'], 0, 5) == '/nwh/' ? '/nwh/' : '/';
  $jsonFile = file_get_contents(__DIR__."/../../assets/strings.json");
  $json = json_decode($jsonFile, true);
  $first = true;
  foreach ($json as $string) {
    if (isset($first)) {
      echo "var {$string['name']}=\"{$string['value']}\"";
      unset($first);
    }
    echo ",{$string['name']}=\"{$string['value']}\"";
  }
  echo ";const root=\"$root\";";
  echo "function alertNotif(type, message, reload, timeout) {
    $.notify({
      icon:'glyphicon glyphicon-exclamation-sign',
      message: '<div style=\'text-align:center;margin-top:-20px\'>' + message + '</div>'
    }, {
      type: type == 'error' ? 'danger' : type,
      placement: {
        from: 'top',
        align: 'center'
      },
      newest_on_top: true,
      mouse_over: true,
      delay: message.length > 100 ? 0 : 3000
    });
    setTimeout(function () {
      if (reload)
        location.reload();
      else
        return
    }, timeout != null ? timeout : 2000);
  }\n";
?>