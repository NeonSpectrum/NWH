$("#frmBookNow").submit(function(e){
	e.preventDefault();
  $("#btnBookNow").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Booking...');
	$("#btnBookNow").prop('disabled',true);
	var data = $("#frmBookNow").serialize();
  $.ajax({
    type : 'POST',
    url  : 'submitBookNow.php',
    data : data,
    success :  function(response)
    {
      if(response=="ok")
      {
        setTimeout("alert('Booked Successfully!');location.reload();",2000);
      }
      else
      {
				alert(response);
				$("#btnBookNow").html('Book Now');
				$("#btnBookNow").prop('disabled',false);
				$(".login-dropdown").addClass("open");
			}
    }
  });
  return false;
});
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
	console.log(checkOut);
	document.getElementsByName("txtCheckInDate")[0].setAttribute('max', checkOut);
});