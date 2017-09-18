function submitLoginForm()
{	
  var data = $("#loginform").serialize();
  $.ajax({
    type : 'POST',
    url  : '/nwh/login/check_login.php',
    data : data,
    success :  function(response)
    {
      if(response=="ok")
      {
        $("#login").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Signing In ...');
        $("#login").prop('disabled',true);
        setTimeout('location.reload();',2000);
      }
      else
      {
        $("#errorLogin").html('<div class="alert alert-danger fade in"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>')
      }
    }
  });
  return false;
}