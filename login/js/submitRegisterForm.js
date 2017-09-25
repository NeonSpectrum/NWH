$("#frmRegister").submit(function(e){
	e.preventDefault();
  var pass = $('#txtPassword').val();
  var vpass = $('#txtVerifyPassword').val();
	$("#btnRegister").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Submitting...');
	$('#btnRegister').attr('disabled', true);
	$("#lblDisplayErrorRegister").html('');
  if(pass!=vpass)
  {
    $("#lblDisplayErrorRegister").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; Password is incorrect!</div>');
    return false;
  }
  $.ajax({
    type : 'POST',
    url  : '/nwh/login/sendMail.php',
    data : $(this).serialize(),
    success :  function(response)
    {
      if(response=="ok")
      {
				alert('Email sent to verify your email!');
				$('#btnRegister').attr('disabled', false);
				document.getElementById('frmRegister').reset();
				$('#modalRegistration').modal('hide');
				$('#btnRegister').html('Register');
      }
      else
      {
				$("#btnRegister").html('Register');
				$('#btnRegister').attr('disabled', false);
        $("#lblDisplayErrorRegister").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;'+response+'</div>')
      }
    }
  });
  return false;
});