$(document).ready(function () {
	$("#cmbEmail").change(function () {
		$.ajax({
			url: "displayAccount.php",
			type: "POST",
			dataType: "json",
			data: $('#frmAccount').serialize(),
			success: function (data) {
				if (data[0] == 'error') {
					$("#cmbAccountType").val("");
					$("#txtFirstName").val("");
					$("#txtLastName").val("");
					return;
				}
				$("#cmbAccountType").val(data[0]);
				$("#txtFirstName").val(data[1]);
				$("#txtLastName").val(data[2]);
			}
		});
	});
});