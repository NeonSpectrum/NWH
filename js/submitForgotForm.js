function submitForgotForm()
{	
  var data = $("#forgotform").serialize();
  $("#errorForgot").html('');
  $.ajax({
    type : 'POST',
    url  : '/nwh/login/check_reset.php',
    data : data,
    success :  function(response)
    {
      if(response=="ok")
      {
        $("#forgotreset").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Resetting ...');
        $("#forgotreset").prop('disabled',true);
        setTimeout("alert('Your password has been reset to \"1234\"');location.reload();",2000);
      }
      else
      {
        $("#errorForgot").html('<div class="alert alert-danger fade in"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>')
      }
    }
  });
  return false;
}