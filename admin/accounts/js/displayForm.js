$(document).ready(function () {
	$("#cmbEmail").change(function () {
		$.ajax({
			url: "displayAccount.php",
			type: "POST",
			dataType: "json",
			data: $('#frmAccount').serialize(),
			success: function (data) {
				if (data[0] == 'error') {
					document.getElementById("cmbAccountType").value = '';
					document.getElementById("txtProfilePicture").value = '';
					document.getElementById("txtFirstName").value = '';
					document.getElementById("txtLastName").value = '';
					document.getElementById("txtIsLogged").value = '';
					return;
				}
				document.getElementById("cmbAccountType").value = data[0];
				document.getElementById("txtProfilePicture").value = data[1];
				document.getElementById("txtFirstName").value = data[2];
				document.getElementById("txtLastName").value = data[3];
				document.getElementById("txtIsLogged").value = data[4];
			}
		});
	});
});