function submitRegisterForm()
{		
  var data = $("#registerform").serialize();
  $.ajax({
    type : 'POST',
    url  : '../login/check_register.php',
    data : data,
    success :  function(response)
    {
      console.log(response);
      if(response=="ok")
      {
        $("#register").html('<img src="../images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Submitting...');
        $('#register').attr('disabled', true);
        setTimeout("alert('Registered Successfully!');$('#register').attr('disabled', false);document.getElementById('registerform').reset();$('#registrationModal').modal('hide');$('#register').html('Register')",2000);
      }
      else
      {
        $("#errorRegister").fadeIn(1000, function(){
            $("#errorRegister").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;'+response+'</div>')
        });
      }
    }
  });
  return false;
}