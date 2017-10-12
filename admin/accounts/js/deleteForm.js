function submitDeleteForm()
{
	$("#btnDelete").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Deleting ...');
	$("#btnDelete").prop('disabled', true);
	$.ajax({
		type: 'POST',
		url: 'deleteAccount.php',
		data: $('#frmAccount').serialize(),
		success: function (response)
		{
			if (response == "ok") {
				alertNotif("success","Records Deleted Successfully!",false);
			}
			else
			{
				$("#btnDelete").html('Delete');
				$("#btnDelete").prop('disabled', false);
				$("#lblErrorDisplayAccount").fadeIn(1000, function () {
					$("#lblErrorDisplayAccount").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>')
				});
			}
		}
	});
	return false;
}