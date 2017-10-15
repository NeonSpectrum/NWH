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
					$("#txtProfilePicture").val("");
					$("#txtFirstName").val("");
					$("#txtLastName").val("");
					return;
				}
				$("#cmbAccountType").val(data[0]);
				$("#txtProfilePicture").val(data[1]);
				$("#txtFirstName").val(data[2]);
				$("#txtLastName").val(data[3]);
				if(data[0]!="Owner")
				{
					$('#btnDelete').prop("disabled",false);
				}
				else
				{
					$('#btnDelete').prop("disabled",true);
				}
			}
		});
	});
});