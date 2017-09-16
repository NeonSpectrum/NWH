function submitLoginForm()
{		
  var data = $("#loginform").serialize();
  $.ajax({
    type : 'POST',
    url  : '../login/check_login.php',
    data : data,
    success :  function(response)
    {
      console.log(response);
      if(response=="ok")
      {
        $("#login").html('<img src="../images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Signing In ...');
        $("#login").prop('disabled',true);
        setTimeout('location.reload(); ',2000);
      }
      else
      {
        $("#errorLogin").fadeIn(1000, function(){
            $("#errorLogin").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>')
        });
      }
    }
  });
  return false;
}