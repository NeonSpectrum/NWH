$("#frmBookNow").submit(function(e){
	e.preventDefault();
  $("#btnBookNow").html('<img src="/nwh/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Booking...');
	$("#btnBookNow").prop('disabled',true);
  $.ajax({
    type : 'POST',
    url  : 'submitBookNow.php',
    data : $(this).serialize(),
    success :  function(response)
    {
      if(response=="ok")
      {
        setTimeout("alertNotif('success','Booked Successfully!');location.reload();",2000);
      }
      else
      {
				alertNotif("error",response);
				$("#btnBookNow").html('Book Now');
				$("#btnBookNow").prop('disabled',false);
				if(response.includes('login'))
				{
					$(".login-dropdown").addClass("open");
				}
			}
    }
  });
});