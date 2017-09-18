function submitRegisterForm()
{
  var pass = $('#password').val();
  var vpass = $('#verifypassword').val();
  if(pass!=vpass)
  {
    $("#errorRegister").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; Password is incorrect!</div>');
    return false;
  }
  var email = $('#email').val();
  $("#errorRegister").html('');
  var data = $("#registerform").serialize();
  $.ajax({
    type : 'POST',
    url  : '/nwh/login/check_register.php',
    data : data,
    success :  function(response)
    {
      if(response=="ok")
      {
        $("#register").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Submitting...');
        $('#register').attr('disabled', true);
        $("#errorRegister").html('');
        setTimeout("alert('Registered Successfully!');$('#register').attr('disabled', false);document.getElementById('registerform').reset();$('#registrationModal').modal('hide');$('#register').html('Register')",2000);
      }
      else
      {
        $("#errorRegister").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;'+response+'</div>')
      }
    }
  });
  return false;
}