$("#frmChange").submit(function(e){
	e.preventDefault();
  var pass = $('#txtNewPass').val();
  var rpass = $('#txtRetypeNewPass').val();
	$("#btnUpdate").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating...');
	$('#btnUpdate').attr('disabled', true);
	$("#lblDisplayErrorChange").html('');
  if(pass!=rpass)
  {
    $("#lblDisplayErrorChange").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; Password is incorrect!</div>');
    return false;
  }
  $.ajax({
    type : 'POST',
    url  : '/nwh/login/checkChange.php',
    data : $(this).serialize(),
    success :  function(response)
    {
      if(response=="ok")
      {
				alert('Updated Successfully!');
				location.reload();
      }
      else
      {
				$("#btnUpdate").html('Update');
				$('#btnUpdate').attr('disabled', false);
        $("#lblDisplayErrorChange").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;'+response+'</div>')
      }
    }
  });
  return false;
});