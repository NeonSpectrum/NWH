String.prototype.includes = function (str) {
  var returnValue = false;

  if (this.indexOf(str) !== -1) {
    returnValue = true;
  }

  return returnValue;
}
function getQueryVariable(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split('&');
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split('=');
        if (decodeURIComponent(pair[0]) == variable) {
            return decodeURIComponent(pair[1]);
        }
    }
}
<?php
@session_start();
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
  if (!strpos($name, "paypal")) {
    if ($value == "1" && $value == true) {
      echo "," . strtoupper($name) . "=true";
    } else if ($value == "" && $value == false) {
      echo "," . strtoupper($name) . "=false";
    } else {
      echo "," . strtoupper($name) . "=\"$value\"";
    }
  }
}
echo ";const root=\"$root\", isLogged=" . (isset($_SESSION['account']) ? "true" : "false");
echo ", email_address=\"" . ($_SESSION['account']['email'] ?? "") . "\";";
?>
var socket;
if(location.hostname != "localhost"){
  socket = io(NODE_JS_URL);
} else {
  socket = io(NODE_JS_URL, {
    reconnection: false
  });
}
socket.on('connect', function(){
  socket.emit("access", (email_address == "" ? "Someone" : email_address));
});
function alertNotif(type, message, reload = false, timeout = 1300) {
  $.notify({
    icon:'glyphicon glyphicon-exclamation-sign',
    message: "<div style='text-align:center;margin-top:-20px'>" + message + "</div>"
  }, {
    type: type == "error" ? "danger" : type,
    placement: {
      from: "top",
      align: "center"
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
  }, timeout);
}