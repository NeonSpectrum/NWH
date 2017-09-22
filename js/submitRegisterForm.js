function submitRegisterForm()
{
  var pass = $('#txtPassword').val();
  var vpass = $('#txtVerifyPassword').val();
  if(pass!=vpass)
  {
    $("#lblDisplayErrorRegister").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; Password is incorrect!</div>');
    return false;
  }
  $("#errorRegister").html('');
  var data = $("#frmRegister").serialize();
  $.ajax({
    type : 'POST',
    url  : '/nwh/login/checkRegister.php',
    data : data,
    success :  function(response)
    {
      if(response=="ok")
      {
        $("#btnRegister").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Submitting...');
        $('#btnRegister').attr('disabled', true);
        $("#lblDisplayErrorRegister").html('');
        setTimeout("alert('Registered Successfully!');$('#btnRegister').attr('disabled', false);document.getElementById('frmRegister').reset();$('#modalRegistration').modal('hide');$('#btnRegister').html('Register')",2000);
      }
      else
      {
        $("#lblDisplayErrorRegister").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;'+response+'</div>')
      }
    }
  });
  return false;
}