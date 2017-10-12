$(document).ready(function () {
	var tomorrow = new Date();
	tomorrow.setDate(tomorrow.getDate() + 1);
	tomorrow = new Date(tomorrow).toISOString().split('T')[0];
	$('#txtEditCheckInDate').attr('min', tomorrow);
	$('#txtEditCheckOutDate').attr('min', tomorrow);
	$('#txtEditCheckInDate').val(tomorrow);
	$('#txtEditCheckOutDate').val(tomorrow);
	dateUpdate();
	$("#cmbBookingID").change(function () {
		if ($("#cmbBookingID").val()=='') {
			dateUpdate();
			$("#txtEditRoomID").val('');
			$("#txtEditAdults").val('0');
			$("#txtEditChildrens").val('0');
			$("#btnEditReservation").prop("disabled", true);
			$("#btnPrint").prop("disabled", true);
			return;
		}
		$("#btnEditReservation").prop("disabled", false);
		$("#btnPrint").prop("disabled", false);
		$.ajax({
			url: "/nwh/login/displayEditReservation.php",
			type: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function (data) {
				$("#txtEditRoomID").val(data[0]);
				$("#txtEditCheckInDate").val(data[1]);
				$("#txtEditCheckOutDate").val(data[2]);
				$("#txtEditAdults").val(data[3]);
				$("#txtEditChildrens").val(data[4]);
			}
		});
	});
});

$('#txtEditCheckInDate').change(function() { 
	checkIn = $(this).val();
	$('#txtEditCheckOutDate').attr('min', checkIn);
});

$('#txtEditCheckOutDate').change(function() { 
	checkIn = $('#txtEditCheckInDate').val();
	checkOut = $(this).val();
	if(checkIn == checkOut)
	{
		checkOut = '';
	}
	$('#txtEditCheckInDate').attr('max', checkOut);
});

function dateUpdate(){
	var tomorrow = new Date();
	tomorrow.setDate(tomorrow.getDate() + 1);
	tomorrow = new Date(tomorrow).toISOString().split('T')[0];;
	$('#txtEditCheckInDate').attr('min', tomorrow);
	$('#txtEditCheckOutDate').attr('min', tomorrow);
	$('#txtEditCheckInDate').val(tomorrow);
	$('#txtEditCheckOutDate').val(tomorrow);
}