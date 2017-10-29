$('#frmContact').submit(function(e){
	e.preventDefault();
	$("#btnSubmit").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Sending ...');
	$("#btnSubmit").prop('disabled',true);
	$.ajax({
		type : 'POST',
		url  : 'processContactForm.php',
		data : $(this).serialize(),
		success :  function(response)
		{
			if(response=="ok")
			{
				alertNotif("success","Sent Successfully",false);
				$('#frmContact').trigger("reset");
			}
			else
			{
				alertNotif("error",response,false);
			}
			$("#btnSubmit").html('Send');
			$("#btnSubmit").prop('disabled',false);
		}
	});
})