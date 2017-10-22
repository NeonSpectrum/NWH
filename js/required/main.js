$(window).on("load", function () {
	$(".loadingIcon").fadeOut("slow");
	$(this).scrollTop(0);
});

$(document).ready(function () {
	$(this).scrollTop(0);
	$('.modal').on('hidden.bs.modal', function () {
		$(this).find('form')[0].reset();
		$(this).find('button').attr('disabled', false);
		$(this).find('.lblDisplayError').html('');
	});
	$("input[type=text]").change(function () {
		if ($(this).val()) {
			$(this).find('button').removeAttr('disabled');
		}
	});
});

if(screen.width <= 480){
	$('#txtLoginEmail,#txtLoginPassword').click(function(){
		$('.navbar').removeClass("navbar-fixed-top");
		$('body').css("padding-top","0px");
		$("html, body").animate({ scrollTop: 230 }, "slow");
	});
	$('.login-dropdown').on('hide.bs.dropdown', function () {
		$('.navbar').addClass("navbar-fixed-top");
	});
}
function disableKey(evt, key) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (key == 'number') {
		if (charCode > 31 && (charCode > 48 || charCode < 57))
			return false;
		return true;
	}
	else if (key == 'letter') {
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}
	else {
		return true;
	}
}

// $('input[type="number"]').on('keyup keydown', function (e) {
// 	console.log($(this).val()+" "+$(this).attr('max'));
// 	var max = $(this).attr('max') != null ? $(this).attr('max') : 9999;
// 	if ($(this).val() > max && e.keyCode != 46 && e.keyCode != 8) {
// 		e.preventDefault();
// 		$(this).val(max);
// 	}
// });

function sendMsg(msg) {
	console.log(msg);
}

function alertNotif(type, message, reload, timeout) {
	if (type == "success")
		type = "alert-success";
	else if (type == "error")
		type = "alert-danger";
	if (timeout == null)
		timeout = 2000;
	$('#alertBox').html('<div data-notify="container" class="col-xs-11 col-sm-4 alert animated fadeInDown text-center ' + type + '" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; z-index: 1031; top: 20px; left: 0px; right: 0px;"><span data-notify="icon"></span><span data-notify="title"></span><span data-notify="message">' + message + '</span><button type="button" aria-hidden="true" class="close" data-dismiss = "alert" style="position: absolute; right: 10px; top: 20px; margin-top: -13px; z-index: 1033;">×</button></div>');
	$('#alertBox').fadeIn();
	setTimeout(function () {
		$('#alertBox').fadeOut();
		$('#alertBox').html('');
		if (reload == null)
			return;
		else if (reload || !reload)
			location.reload(reload);
		else
			location.href(reload);
	}, timeout);
}

function capsLock(e) {
	var kc = e.keyCode ? e.keyCode : e.which;
	var sk = e.shiftKey ? e.shiftKey : kc === 16;
	var display = ((kc >= 65 && kc <= 90) && !sk) ||
		((kc >= 97 && kc <= 122) && sk) ? 'block' : 'none';
	document.getElementById('caps').style.display = display;
}