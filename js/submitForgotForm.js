function submitForgotForm()
{	
  var data = $("#frmForgot").serialize();
  $("#lblDisplayErrorForgot").html('');
  $.ajax({
    type : 'POST',
    url  : '/nwh/login/checkReset.php',
    data : data,
    success :  function(response)
    {
      if(response=="ok")
      {
        $("#btnReset").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Resetting ...');
        $("#btnReset").prop('disabled',true);
        setTimeout("alert('Your password has been reset to \"1234\"');location.reload();",2000);
      }
      else
      {
        $("#lblDisplayErrorForgot").html('<div class="alert alert-danger fade in"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>')
      }
    }
  });
  return false;
}