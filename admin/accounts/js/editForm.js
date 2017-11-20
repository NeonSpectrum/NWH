function submitEditForm() {
	$("#btnEdit").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Editing ...');
	$("#btnEdit").attr('disabled', true);
	$.ajax({
		type: 'POST',
		url: 'editAccount.php',
		data: $("#frmAccount").serialize(),
		success: function (response) {
			if (response == "ok") {
				alertNotif("success", "Records Updated Successfully!", true);
			} else {
				$("#btnEdit").html('Edit');
				$("#btnEdit").attr('disabled', false);
				$("#lblErrorDisplayAccount").fadeIn(1000, function () {
					$("#lblErrorDisplayAccount").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>')
				});
			}
		}
	});
	return false;
}