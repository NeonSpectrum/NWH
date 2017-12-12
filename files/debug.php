<script src="../assets/js/required/1_jquery.min.js">
</script>
<script>
  function executecmd(command){
    $.ajax({
      type: 'POST',
      url: '../ajax/gitUpdate.php',
      data: "command="+command,
      success: function(response) {
        console.log(response);
        return true;
      }
    });
    return "Command Executed:";
  }
</script>