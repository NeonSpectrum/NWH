$(document).ready(function () {
	$("#cmbEmail").change(function () {
		$.ajax({
			url: "displayAccount.php",
			type: "POST",
			dataType: "json",
			data: $('#frmAccount').serialize(),
			success: function (data) {
				if (data[0] == 'error') {
					$("cmbAccountType").val("");
					$("txtProfilePicture").val("");
					$("txtFirstName").val("");
					$("txtLastName").val("");
					$("txtIsLogged").val("");
					return;
				}
				$("cmbAccountType").val(data[0]);
				$("txtProfilePicture").val(data[1]);
				$("txtFirstName").val(data[2]);
				$("txtLastName").val(data[3]);
				$("txtIsLogged").val(data[4]);
			}
		});
	});
});