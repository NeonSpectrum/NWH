$("#frmChange").submit(function (e) {
	e.preventDefault();
	$("#btnUpdate").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating...');
	$('#btnUpdate').attr('disabled', true);
	$("#lblDisplayErrorChange").html('');
	$.ajax({
		type: 'POST',
		url: '/nwh/login/checkChange.php',
		data: $(this).serialize(),
		success: function (response) {
			if (response == "ok") {
				$('#modalChange').modal('hide');
				$('#frmChange').trigger('reset');
				$('#btnUpdate').attr('disabled', false);
				alertNotif("success", "Updated Successfully!", false);
			} else {
				$("#btnUpdate").html('Update');
				$('#btnUpdate').attr('disabled', false);
				$("#lblDisplayErrorChange").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>')
			}
		}
	});
});