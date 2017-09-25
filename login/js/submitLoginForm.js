$("#frmLogin").submit(function(e){
	e.preventDefault();
  $("#lblDisplayErrorLogin").html('');
	$("#btnLogin").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Signing In ...');
	$("#btnLogin").prop('disabled',true);
  $.ajax({
    type : 'POST',
    url  : '/nwh/login/checkLogin.php',
    data : $(this).serialize(),
    success :  function(response)
    {
      if(response=="ok")
      {
        location.reload();
      }
      else
      {
				$("#btnLogin").html('Sign In');
				$("#btnLogin").prop('disabled',false);
        $("#lblDisplayErrorLogin").html('<div class="alert alert-danger fade in"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>')
      }
    }
  });
  return false;
});