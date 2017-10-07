$(window).on("load", function(){
  $(".loadingIcon").fadeOut("slow");
  $(this).scrollTop(0);
});

$(document).ready(function(){
	$(this).scrollTop(0);
	$('.modal').on('hidden.bs.modal', function(){
		$(this).find('form')[0].reset();
		$(this).find('button').attr('disabled',false);
		$(this).find('.lblDisplayError').html('');
	});
	$("input[type=text]").change(function() {
		if ($(this).val())
		{
			$(this).find('button').removeAttr('disabled');
		}
	});
});

function disableKey(evt,key)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if(key=='number')
	{
		if (charCode > 31 && (charCode > 48 || charCode < 57))
				return false;
		return true;
	}
	else if(key=='letter')
	{
		if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
		return true;
	}
	else
	{
		return true;
	}
}

function adjustValue(min,max){
	if($(this).val() < min)
	{
		$(this).val(min);
	}
	else if($(this).val() > max)
	{
		$(this).val(max);
	}
}

function sendMsg(msg){
	console.log(msg);
}

/* function wait(ms){
	var start = new Date().getTime();
	var end = start;
	while(end < start + ms) {
		end = new Date().getTime();
 }
} */

function alertNotif(type,message,reload){
	if(type == "success")
		type = "alert-success";
	else if(type == "error")
		type = "alert-danger";
	$('#alertBox').html('<div data-notify="container" class="col-xs-11 col-sm-4 alert animated fadeInDown text-center '+type+'" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; z-index: 1031; top: 20px; left: 0px; right: 0px;"><span data-notify="icon"></span><span data-notify="title"></span><span data-notify="message">'+message+'</span></div>');
	$('#alertBox').fadeIn();
	setTimeout(function(){
		$('#alertBox').fadeOut();
		$('#alertBox').html('');
		if(typeof reload == 'undefined') return;
		if(reload || !reload)
			location.reload(reload);
		else
			location.href(reload);
	},2000);
}