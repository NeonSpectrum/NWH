$("#frmRegister").submit(function (e) {
	e.preventDefault();
	if (pass != rpass) {
		$("#lblDisplayErrorRegister").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; Password is not the same</div>');
		return;
	}
	var pass = $('#txtPassword', this).val();
	var rpass = $('#txtRetypePassword', this).val();
	$("#btnRegister").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Submitting...');
	$('#btnRegister').attr('disabled', true);
	$("#lblDisplayErrorRegister").html('');
	$.ajax({
		type: 'POST',
		url: '/nwh/login/checkRegister.php',
		data: $(this).serialize(),
		success: function (response) {
			if (response == "ok") {
				alertNotif('success', 'Email sent to verify your email!', false, 10000);
				$('#btnRegister').attr('disabled', false);
				$('#frmRegister').trigger('reset');
				$('#modalRegistration').modal('hide');
				$('#btnRegister').html('Register');
			} else {
				$("#btnRegister").html('Register');
				$('#btnRegister').attr('disabled', false);
				$("#lblDisplayErrorRegister").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>')
			}
		}
	});
});

function recaptchaCallback() {
	$('#btnRegister').removeAttr('disabled');
}