String.prototype.includes = function (str) {
  var returnValue = false;

  if (this.indexOf(str) !== -1) {
    returnValue = true;
  }

  return returnValue;
}
<?php
$root     = strtolower($_SERVER['SERVER_NAME']) == "localhost" ? substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "/", 1) + 1) : "/";
$config   = parse_ini_file(__DIR__ . "/../../config.ini");
$jsonFile = file_get_contents(__DIR__ . "/../../strings.json");
$json     = json_decode($jsonFile, true);
$first    = true;
foreach ($json as $string) {
  if (isset($first)) {
    echo "var {$string['name']}=\"{$string['value']}\"";
    unset($first);
  }
  echo ",{$string['name']}=\"{$string['value']}\"";
}
foreach ($config as $name => $value) {
  $value = $value == false ? "false" : $value;
  echo "," . strtoupper($name) . "=\"$value\"";
}
echo ";const root=\"$root\";";
?>
function alertNotif(type, message, reload, timeout) {
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
  }, timeout != null ? timeout : 1300);
}