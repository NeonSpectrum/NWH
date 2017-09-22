function submitEditForm() {
	var data = $("#frmAccount").serialize();
	$.ajax({
		type: 'POST',
		url: 'editAccount.php',
		data: data,
		success: function (response) {
			if (response == "ok") {
				$("#btnEdit").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Editing ...');
				$("#btnEdit").prop('disabled', true);
				setTimeout('alert("Records Updated Successfully!");location.reload();', 500);
			} else {
				$("#lblErrorDisplayAccount").fadeIn(1000, function () {
					$("#lblErrorDisplayAccount").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>')
				});
			}
		}
	});
	return false;
}