$(document).ready( function() {
	var tomorrow = new Date();
	tomorrow.setDate(tomorrow.getDate() + 1);
	tomorrow = new Date(tomorrow).toISOString().split('T')[0];;
	document.getElementsByName("txtCheckInDate")[0].setAttribute('min', tomorrow);
	document.getElementsByName("txtCheckOutDate")[0].setAttribute('min', tomorrow);
	$('#txtCheckInDate').val(tomorrow);
	$('#txtCheckOutDate').val(tomorrow);
});
$('#txtCheckInDate').change(function() { 
	checkIn = $(this).val();
	console.log(checkIn);
	document.getElementsByName("txtCheckOutDate")[0].setAttribute('min', checkIn);
});
$('#txtCheckOutDate').change(function() { 
	checkIn = $('#txtCheckInDate').val();
	checkOut = $(this).val();
	if(checkIn == checkOut)
	{
		checkOut = '';
	}
	document.getElementsByName("txtCheckInDate")[0].setAttribute('max', checkOut);
});