$(window).on("load", function() {
  $(".loadingIcon").fadeOut("slow");
  $(this).scrollTop(0);
});

$(document).ready(function(){
	$(this).scrollTop(0);
});

function disableLetter(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
	return true;
}

function disableNumber(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode > 48 || charCode < 57))
			return false;
	return true;
}