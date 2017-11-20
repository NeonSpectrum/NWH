$("#frmEditReservation").submit(function (e) {
	e.preventDefault();
	$("#btnEditReservation").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating...');
	$('#btnEditReservation').attr('disabled', true);
	$("#lblDisplayErrorEditReservation").html('');
	$.ajax({
		type: 'POST',
		url: '/nwh/login/checkEditReservation.php',
		data: $(this).serialize(),
		success: function (response) {
			if (response == "ok") {
				alertNotif('success', 'Updated Successfully!', false);
			} else {
				$("#btnEditReservation").html('Update');
				$('#btnEditReservation').attr('disabled', false);
				$("#lblDisplayErrorEditReservation").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>')
			}
		}
	});
});