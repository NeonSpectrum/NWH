$(document).ready(function () {
	disableScrolling();
	$(this).scrollTop(0);
	$('.modal').on('hidden.bs.modal', function () {
		$(this).find('form')[0].reset();
		$(this).find('button').attr('disabled', false);
		$(this).find('.lblDisplayError').html('');
		$(this).find('#g-recaptcha-response').val('');
	});

	$("input[type=text]").change(function () {
		if ($(this).val()) {
			$(this).find('button').removeAttr('disabled');
		}
	});
});

$(window).on("load", function () {
	setTimeout(function(){
		$(".loadingIcon").fadeOut("slow");

		enableScrolling();
		$(this).scrollTop(0);
		
		$('pace').css("display","none");
		$('#pace').attr("href",$('#pace').attr("href").replace("center-simple","minimal"));

		if(window.location.hash) {
			$('html, body').animate({
				scrollTop: $(window.location.hash).offset().top + 'px'
			}, 1000, 'swing');
		}

		$(window).scroll(function() {
			$(".scrollSlideUp").each(function(){
				var pos = $(this).offset().top;
				var winTop = $(window).scrollTop();
				var height = $(window).height()-40;
				if (pos < winTop + height) {
					$(this).removeClass("scrollSlideUp");
					$(this).addClass("slideInUp");
				}
			});
			
			$(".scrollSlideDown").each(function(){
				var pos = $(this).offset().top;
				var winTop = $(window).scrollTop();
				var height = $(window).height()-40;
				if (pos < winTop + height) {
					$(this).removeClass("scrollSlideDown");
					$(this).addClass("slideInDown");
				}
			});
			
			$(".scrollSlideLeft").each(function(){
				var pos = $(this).offset().top;
				var winTop = $(window).scrollTop();
				var height = $(window).height()-40;
				if (pos < winTop + height) {
					$(this).removeClass("scrollSlideLeft");
					$(this).addClass("slideInLeft");
				}
			});
			
			$(".scrollSlideRight").each(function(){
				var pos = $(this).offset().top;
				var winTop = $(window).scrollTop();
				var height = $(window).height()-40;
				if (pos < winTop + height) {
					$(this).removeClass("scrollSlideRight");
					$(this).addClass("slideInRight");
				}
			});
		});
	},500);
});

$(window).on('resize', function (){
	if(screen.width <= 480){
		$('#txtLoginEmail,#txtLoginPassword').click(function(){
			$('.navbar').removeClass("navbar-fixed-top");
			$('body').css("padding-top","0px");
			$("html, body").animate({ scrollTop: 230 }, "slow");
		});
		$('.login-dropdown').on('hide.bs.dropdown', function () {
			$('.navbar').addClass("navbar-fixed-top");
		});
		$("body").css("background-position","50% 0px");
	}
	else if(screen.width > 480){
		$(window).scroll(function () {
			$("body").css("background-position","50% " + (-($(this).scrollTop() / 10)-100) + "px");
		});
	}
});




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

(function($) {
	$.fn.hasVerticalScrollBar = function() {
			return this.get(0) ? this.get(0).scrollHeight > this.innerheight() : false;
	}
})(jQuery);

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
		if (reload == null || !reload)
			return;
		else if (reload)
			location.reload();
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

function disableScrolling(){
	$('body').bind('mousedown.prev DOMMouseScroll.prev mousewheel.prev keydown.prev keyup.prev', function(e, d){  
		e.preventDefault();
	});			
}

function enableScrolling(){
	$('body').unbind('mousedown.prev DOMMouseScroll.prev mousewheel.prev keydown.prev keyup.prev');
}

function centerSlideImages( event ) {
	var $slide = $(event.target);
	var $conts = $slide.find('.owl-item');
	$conts.each(function() {
		var img = $(this).children('img');
		var conRatio = $(this).width() / $(this).height();
		var imgRatio = img.width() / img.height();
		var mode = (conRatio > imgRatio) ? 'portrait' : 'landscape';
		if( mode === 'portrait') {
			$(this).removeClass('landscape');
			$(this).addClass('portrait');
			img.css({
				marginTop: ($(this).height() - img.height()) / 2,
				marginLeft: 0,
			});
		} else {
			$(this).removeClass('portrait');
			$(this).addClass('landscape');
			img.css({
				marginTop: 0,
				marginLeft: ($(this).width() - img.width()) / 2,
			});
		};
	});
}

function hasVerticalScroll(node){
  if(node == undefined){
    if(window.innerHeight){
      return document.body.offsetHeight> innerHeight;
    }
    else {
      return  document.documentElement.scrollHeight > 
        document.documentElement.offsetHeight ||
        document.body.scrollHeight>document.body.offsetHeight;
    }
  }
  else {
    return node.scrollHeight> node.offsetHeight;
  }
}