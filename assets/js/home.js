// CAROUSEL
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

// YOUTUBE
(function () {

  var youtube = document.querySelectorAll(".youtube");

  for (var i = 0; i < youtube.length; i++) {

    var image = new Image();
    image.src = currentDirectory + "images/nwh-sddefault.jpg";
    image.addEventListener("load", function () {
      youtube[i].appendChild(image);
    }(i));

    youtube[i].addEventListener("click", function () {
      var iframe = document.createElement("iframe");
      iframe.setAttribute("frameborder", "0");
      iframe.setAttribute("allowfullscreen", "");
      iframe.setAttribute("src", "https://www.youtube.com/embed/" + this.dataset.embed + "?rel=0&showinfo=0&autoplay=1");

      this.innerHTML = "";
      this.appendChild(iframe);
    });
  };

})();