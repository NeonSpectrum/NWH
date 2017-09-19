function submitLoginForm()
{
  $("#lblDisplayErrorLogin").html('');
  var data = $("#frmLogin").serialize();
  $.ajax({
    type : 'POST',
    url  : '/nwh/login/checkLogin.php',
    data : data,
    success :  function(response)
    {
      if(response=="ok")
      {
        $("#btnLogin").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Signing In ...');
        $("#btnLogin").prop('disabled',true);
        setTimeout('location.reload();',2000);
      }
      else
      {
        $("#lblDisplayErrorLogin").html('<div class="alert alert-danger fade in"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>')
      }
    }
  });
  return false;
}