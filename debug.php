<?php
require_once "files/autoload.php";
if (isset($_POST['command']) && $_POST['password'] === PASSWORD) {
  $command = filter_var($_POST['command'], FILTER_SANITIZE_STRING);
  $path    = strtolower($_SERVER['SERVER_NAME']) != "localhost" ? 'export PATH=$PATH:~/git-2.9.5 && ' : '';
  echo trim(preg_replace('/\s+/', ' ', nl2br(shell_exec($path . $command))));
  return;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Northwood Hotel</title>
<link rel="stylesheet" type="text/css" href="assets/css/required/1_bootstrap.min.css">
<style>

@font-face {
  font-family: 'Nunito';
  font-style: normal;
  font-weight: 400;
  src: url("assets/css/fonts/SourceCodePro-Regular.ttf");
}

html, body {
  height: 100%;
  overflow: hidden;
  margin:0;
  user-select: none;
}

body {
  background: #3a7bd5;
  background-image: -webkit-radial-gradient(top, circle cover, #00d2ff 0%, #3a7bd5 80%);
  display: flex;
  justify-content: center;
  align-items: center;
}

* {
  box-sizing: border-box;
}

textarea, input, button {
  outline: none;
}

.container{
  height: 100%;
  width: 100%;
}

.window {
  animation: fade 1s ease-in-out;
  width: 100%;
  height: 100%;
}
.window .handle {
  height: 22px;
  background: linear-gradient(0deg, #d8d8d8, #ececec);
  border-top: 1px solid white;
  border-bottom: 1px solid #b3b3b3;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  color: rgba(0, 0, 0, 0.7);
  font-family: Helvetica, sans-serif;
  font-size: 13px;
  line-height: 22px;
  text-align: center;
}
.window .buttons {
  position: absolute;
  float: left;
  margin: 0 8px;
}
.window .buttons .close {
  background-color: #ff6159;
}
.window .buttons .minimize {
  background-color: #ffbf2f;
}
.window .buttons .maximize {
  background-color: #25cc3e;
}
.window .terminal {
  padding: 4px;
  background-color: black;
  opacity: 0.7;
  height: 97%;
  color: white;
  font-family: 'Source Code Pro', monospace;
  font-weight: 200;
  font-size: 14px;
  white-space: pre-wrap;
  white-space: -moz-pre-wrap;
  white-space: -pre-wrap;
  white-space: -o-pre-wrap;
  word-wrap: break-word;
  border-bottom-left-radius: 5px;
  border-bottom-right-radius: 5px;
  overflow-y: auto;
}
.window .terminal::after {
  content: "|";
  animation: blink 2s steps(1) infinite;
}

.prompt {
  color: #bde371;
}

.path {
  color: #5ed7ff;
}

@keyframes blink {
  50% {
    color: transparent;
  }
}
@keyframes fade {
  from {
    opacity: 0
  }
  100% {
    opacity: 1
  }
}
</style>
</head>
<body>
<?php
if (!isset($_POST['password']) || $_POST['password'] !== PASSWORD) {
  ?>
<div style="width:100%;height:100%;position:fixed;z-index:1;background-color:rgba(255,255,255,0.7);padding:20% 40%">
  <div class="well center-block">
    <form method="POST">Access Code: <input type="password" name="password" class="form-control" autofocus></form>
  </div>
</div>
<?php
}
?>
<div class="container" style="margin:0;padding:0">
  <div class="window">
    <div class="handle">
      <span class="title"></span>
    </div>
    <div class="terminal"></div>
  </div>
</div>
<script src='assets/js/required/1_jquery.min.js'></script>
<script>
$(document).ready(function() {
  "use strict";

  function clear() {
    terminal.text("");
  }

  var title = $(".title");
  var terminal = $(".terminal");
  var prompt = "➜";
  var path = "~";
  var command = "";

  function displayPrompt() {
    terminal.append("<span class=\"prompt\">" + prompt + "</span> ");
    terminal.append("<span class=\"path\">" + path + "</span> ");
  }
  function erase(n) {
    command = command.slice(0, -n);
    terminal.html(terminal.html().slice(0, -n));
  }
  function appendCommand(str) {
    terminal.append(str);
    command += str;
  }
  $(document).keydown(function(e) {
    e = e || window.event;
    var keyCode = typeof e.which === "number" ? e.which : e.keyCode;

    if (keyCode === 8 && e.target.tagName !== "INPUT" && e.target.tagName !== "TEXTAREA") {
      e.preventDefault();
      if (command !== "") {
        erase(1);
      }
    }
  });
  $(document).keypress(function(e) {
    e = e || window.event;
    var keyCode = typeof e.which === "number" ? e.which : e.keyCode;

    switch (keyCode) {
      case 13:
      {
        terminal.append("\n");
        if(command.toLowerCase()=="clear"){
          terminal.text("");
          displayPrompt();
          command = "";
        } else {
          $.ajax({
            context: this,
            type: 'POST',
            data: "command="+command+"&password=<?php echo $_POST['password']; ?>",
            success: function(response) {
              if(response){
                terminal.append(response);
              } else {
                terminal.append("sh: command not found: " + command.replace(/<\/?[^>]+(>|$)/g, "") + "\n");
              }
              displayPrompt();
              command = "";
              $(".window .terminal").scrollTop($('.window .terminal')[0].scrollHeight);
            }
          });
        }
        break;
      }
      default:
      {
        if(!$("input[name=password]").is(":focus"))
          appendCommand(String.fromCharCode(keyCode));
      }
    }
  });

  title.text("NeonSpectrum@<?php echo $_SERVER['SERVER_NAME']; ?>: ~ (sh)");
  terminal.append("Logged In Time: " + new Date() + "\n"); displayPrompt();
});
</script>
</body>
</html>