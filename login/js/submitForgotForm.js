$("#frmForgot").submit(function(e){
	e.preventDefault();
	$("#btnReset").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Sending ...');
	$("#btnReset").prop('disabled',true);
	$("#lblDisplayErrorForgot").html('');
	$.ajax({
		type : 'POST',
		url  : '/nwh/login/checkForgot.php',
		data : $(this).serialize(),
		success :  function(response)
		{
			if(response=="ok")
			{
				$('#modalForgot').modal('hide');
				$('#frmForgot').trigger('reset');
				alertNotif('success',"Email sent!",true);
			}
			else
			{
				$("#btnReset").html('Submit');
				$("#btnReset").prop('disabled',false);
				$("#lblDisplayErrorForgot").html('<div class="alert alert-danger fade in"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>')
			}
		}
	});
});