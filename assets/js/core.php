String.prototype.includes = function (str) {
  var returnValue = false;

  if (this.indexOf(str) !== -1) {
    returnValue = true;
  }

  return returnValue;
}

Number.prototype.formatMoney = function(c = 2, d = ".", t = ",") {
  var n = this,
    s = n < 0 ? "-" : "",
    i = String(parseInt((n = Math.abs(Number(n) || 0).toFixed(c)))),
    j = (j = i.length) > 3 ? j % 3 : 0
  return (
    s +
    (j ? i.substr(0, j) + t : "") +
    i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) +
    (c
      ? d +
        Math.abs(n - i)
          .toFixed(c)
          .slice(2)
      : "")
  )
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
  return false;
}
<?php
@session_start();
require_once '../../files/strings.php';

$root     = stripos($_SERVER['SERVER_NAME'], 'northwood-hotel.com') === false ? substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '/', 1) + 1) : '/';
$config   = parse_ini_file(__DIR__ . '/../../config.ini');
$jsonFile = file_get_contents(__DIR__ . '/../../strings.json');
$json     = json_decode($jsonFile, true);
$first    = true;
foreach ($json as $string) {
  if (isset($first)) {
    echo "const {$string['name']}=\"{$string['value']}\"";
    unset($first);
  } else {
    echo ",{$string['name']}=\"{$string['value']}\"";
  }
}
foreach ($config as $name => $value) {
  if (!strpos($name, 'paypal')) {
    if ($value == '1' && $value == true) {
      echo ',' . strtoupper($name) . '=true';
    } else if ($value == '' && $value == false) {
      echo ',' . strtoupper($name) . '=false';
    } else {
      echo ',' . strtoupper($name) . "=\"$value\"";
    }
  }
}
echo ", root=\"$root\", isLogged=" . (isset($_SESSION['account']) ? 'true' : 'false');
echo ', email_address="' . (isset($_SESSION['account']) ? openssl_decrypt(str_replace(' ', '+', $_SESSION['account']), 'AES-256-CTR', ENCRYPT_KEYWORD, OPENSSL_ZERO_PADDING, INITIALIZATION_VECTOR) : '') . '"';
echo ", date=\"$date\", dateandtime=\"$dateandtime\",session_id=\"" . session_id() . '";';
?>
const socket = io(NODE_JS_URL.includes("localhost") ? NODE_JS_URL.replace("localhost","<?php echo $_SERVER['SERVER_NAME']; ?>") : NODE_JS_URL);
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
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
  }
});
socket.on('all', function(data) {
  $.notify({
    icon: 'glyphicon glyphicon-bell',
    message: "<div style='text-align:center;margin-top:-20px'>" + data.user + "<br/>" + data.messages + "</div>"
  }, {
    type: "info",
    placement: {
      from: "bottom",
      align: "right"
    },
    mouse_over: true,
    delay: 5000
  });
});
socket.on("logout",function(data){
  if(email_address == data){
    $.ajax({
      url: root + 'account?mode=logout',
      success: function() {
        alert("Your account has been logged in somewhere. Logging out...");
        location.reload(true);
      }
    });
  }
})
socket.on('forcerefresh', function(data) {
  if(data == "all"){
    location.reload();
  } else if(data == email_address){
    location.reload();
  }
});
socket.on('playmusic', function(data) {
  $("audio.mw_added_css").remove();
  (function() {
    function c() {
      var e = document.createElement("link");
      e.setAttribute("type", "text/css");
      e.setAttribute("rel", "stylesheet");
      e.setAttribute("href", f);
      e.setAttribute("class", l);
      document.body.appendChild(e)
    }

    function h() {
      var e = document.getElementsByClassName(l);
      for (var t = 0; t < e.length; t++) {
        document.body.removeChild(e[t])
      }
    }

    function p() {
      var e = document.createElement("div");
      e.setAttribute("class", a);
      document.body.appendChild(e);
      setTimeout(function() {
        document.body.removeChild(e)
      }, 100)
    }

    function d(e) {
      return {
        height: e.offsetHeight,
        width: e.offsetWidth
      }
    }

    function v(i) {
      var s = d(i);
      return s.height > e && s.height < n && s.width > t && s.width < r
    }

    function m(e) {
      var t = e;
      var n = 0;
      while (!!t) {
        n += t.offsetTop;
        t = t.offsetParent
      }
      return n
    }

    function g() {
      var e = document.documentElement;
      if (!!window.innerWidth) {
        return window.innerHeight
      } else if (e && !isNaN(e.clientHeight)) {
        return e.clientHeight
      }
      return 0
    }

    function y() {
      if (window.pageYOffset) {
        return window.pageYOffset
      }
      return Math.max(document.documentElement.scrollTop, document.body.scrollTop)
    }

    function E(e) {
      var t = m(e);
      return t >= w && t <= b + w
    }

    function S() {
      var e = document.createElement("audio");
      e.setAttribute("class", l);
      e.src = i;
      e.loop = false;
      e.addEventListener("canplay", function() {
        setTimeout(function() {
          x(k)
        }, 500);
        setTimeout(function() {
          N();
          p();
          for (var e = 0; e < O.length; e++) {
            T(O[e])
          }
        }, 15500)
      }, true);
      e.addEventListener("ended", function() {
        N();
        h()
      }, true);
      e.innerHTML = " <p>If you are reading this, it is because your browser does not support the audio element. We recommend that you get a new browser.</p> <p>";
      document.body.appendChild(e);
      e.play()
    }

    function x(e) {
      e.className += " " + s + " " + o
    }

    function T(e) {
      e.className += " " + s + " " + u[Math.floor(Math.random() * u.length)]
    }

    function N() {
      var e = document.getElementsByClassName(s);
      var t = new RegExp("\\b" + s + "\\b");
      for (var n = 0; n < e.length;) {
        e[n].className = e[n].className.replace(t, "")
      }
    }
    var e = 30;
    var t = 30;
    var n = 350;
    var r = 350;
    var i = data.url;
    var s = "mw-harlem_shake_me";
    var o = "im_first";
    var u = ["im_drunk", "im_baked", "im_trippin", "im_blown"];
    var a = "mw-strobe_light";
    var f = data.shake == true ? "//" + location.hostname + root + "files/harlem-shake-style.css" : "";
    var l = "mw_added_css";
    var b = g();
    var w = y();
    var C = document.getElementsByTagName("*");
    var k = null;
    for (var L = 0; L < C.length; L++) {
      var A = C[L];
      if (v(A)) {
        if (E(A)) {
          k = A;
          break
        }
      }
    }
    if (A === null) {
      console.warn("Could not find a node of the right size. Please try a different page.");
      return
    }
    c();
    S();
    var O = [];
    for (var L = 0; L < C.length; L++) {
      var A = C[L];
      if (v(A)) {
        O.push(A)
      }
    }
  })()
});
socket.on("kickass", function() {
  var s = document.createElement('script');
  s.type = 'text/javascript';
  document.body.appendChild(s);
  s.src = root + 'files/kickass.js';
  void(0);
});

socket.on("shutdown", function() {
  alert("shutdown");
  $.ajax({
    type: 'POST',
    url: root + "ajax/shutdown.php"
  });
});

setTimeout(function(){
  swal({
    title: "Session has expired.",
    text: "Please click the button to reload.",
    allowOutsideClick: false,
    type: 'warning'
  }).then((result)=>{
    if(result.value){
      location.reload();
    }
  });
},3600000);

// DISABLEKEY FUNCTION
function disableKey(evt, key) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (key == 'number') {
    if (charCode > 31 && (charCode > 48 || charCode < 57)) return false;
    return true;
  } else if (key == 'letter') {
    if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
    return true;
  } else {
    return true;
  }
}

function FormatCurrency(ctrl) {
  //Check if arrow keys are pressed - we want to allow navigation around textbox using arrow keys
  if ((event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40 || event.keyCode == 17) || (event.keyCode > 31 && (event.keyCode < 48 || event.keyCode > 57))) {
    return;
  }
  var val = ctrl.value;

  val = val.replace(/,/g, "")
  ctrl.value = "";
  val += '';
  x = val.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';

  var rgx = /(\d+)(\d{3})/;

  while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
  }

  ctrl.value = x1 + x2;
  console.log(event.keyCode);
  return true;
}
