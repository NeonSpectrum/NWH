function submitForgotForm()
{	
  $("#btnReset").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Sending ...');
  $("#btnReset").prop('disabled',true);

  var data = $("#frmForgot").serialize();
  $("#lblDisplayErrorForgot").html('');
  $.ajax({
    type : 'POST',
    url  : '/nwh/login/sendMail.php',
    data : data,
    success :  function(response)
    {
      if(response=="ok")
      {
        alert("Email sent!");
        location.reload();
      }
      else
      {
        $("#btnReset").html('Submit');
        $("#btnReset").prop('disabled',false);
        $("#lblDisplayErrorForgot").html('<div class="alert alert-danger fade in"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>')
      }
    }
  });
  return false;
}