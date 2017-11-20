var $item = $('.carousel .item');
var $wHeight = $(window).height();
$item.eq(0).addClass('active');
$item.height($wHeight);
$item.addClass('full-screen');

$('.carousel img').each(function () {
	var $src = $(this).attr('src');
	var $color = $(this).attr('data-color');
	$(this).parent().css({
		'background-image': 'url(' + $src + ')',
		'background-color': $color
	});
	$(this).remove();
});

$(window).on('resize', function () {
	$wHeight = $(window).height();
	$item.height($wHeight);
});

// $('.carousel').carousel({
// 	pause: "hover"
// });

$('.carousel').hover(function (e) {
	clearInterval(timer);
});

timer = setInterval(function () {
	$('.carousel').carousel('next');
}, 5000);

$(".carousel").on("touchstart", function (event) {
	var xClick = event.originalEvent.touches[0].pageX;
	$(this).one("touchmove", function (event) {
		var xMove = event.originalEvent.touches[0].pageX;
		if (Math.floor(xClick - xMove) > 5) {
			$(this).carousel('next');
		} else if (Math.floor(xClick - xMove) < -5) {
			$(this).carousel('prev');
		}
	});
	$(".carousel").on("touchend", function () {
		$(this).off("touchmove");
	});
});

var xClick;
var mouseDown;

$(".carousel").on("mousedown", function (event) {
	xClick = event.pageX;
	mouseDown = true;
});

$(".carousel").on("mousemove", function (event) {
	if (mouseDown) {
		var xMove = event.pageX;
		if (xClick > xMove) {
			$(this).carousel('next');
		} else if (xClick < xMove) {
			$(this).carousel('prev');
		}
	}
});

$(".carousel").on("mouseup", function (event) {
	mouseDown = false;
});