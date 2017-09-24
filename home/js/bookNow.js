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