// CAROUSEL
var $item = $('.carousel .item');
var $wHeight = $(window).width() > 480 ? $(window).height() : $(window).height() - 80;
$item.eq(0).addClass('active');
$item.height($wHeight);
$item.addClass('full-screen');
$('.carousel img').each(function() {
  var $src = $(this).attr('src');
  var $color = $(this).attr('data-color');
  $(this).parent().css({
    'background-image': 'url(' + $src + ')',
    'background-color': $color
  });
  $(this).remove();
});
$(window).on('resize', function() {
  $wHeight = $(window).width() > 480 ? $(window).height() : $(window).height() - 80;
  $item.height($wHeight);
});
$('.carousel').hover(function(e) {
  clearInterval(timer);
});
timer = setInterval(function() {
  $('.carousel').carousel('next');
}, 5000);
$(".carousel").on("touchstart", function(event) {
  var xClick = event.originalEvent.touches[0].pageX;
  $(this).one("touchmove", function(event) {
    var xMove = event.originalEvent.touches[0].pageX;
    if (Math.floor(xClick - xMove) > 5) {
      $(this).carousel('next');
    } else if (Math.floor(xClick - xMove) < -5) {
      $(this).carousel('prev');
    }
  });
  $(".carousel").on("touchend", function() {
    $(this).off("touchmove");
  });
});
var xClick;
var mouseDown;
$(".carousel").on("mousedown", function(event) {
  xClick = event.pageX;
  mouseDown = true;
});
$(".carousel").on("mousemove", function(event) {
  if (mouseDown) {
    var xMove = event.pageX;
    if (xClick > xMove) {
      $(this).carousel('next');
    } else if (xClick < xMove) {
      $(this).carousel('prev');
    }
  }
});
$(".carousel").on("mouseup", function(event) {
  mouseDown = false;
});
// MORE INFO BUTTON
$('.btnMoreInfo').click(function() {
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/supplyMoreInfo.php',
    data: 'roomType=' + $(this).attr("id"),
    dataType: 'json',
    success: function(response) {
      $("#modalRoom").find(".modal-title").html($(this).attr("id").replace("_", " "));
      $("#modalRoom").find("div[u='slides']").html(response[0]);
      $("#modalRoom").find("#description").html(response[1]);
      var options = {
        $DragOrientation: 1, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $Cols is greater than 1, or parking position is not 0)
        $ArrowNavigatorOptions: { //[Optional] Options to specify and enable arrow navigator or not
          $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
          $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
          $Steps: 1 //[Optional] Steps to go for each navigation request, default value is 1
        }
      };
      new $JssorSlider$('rooms_slider_container', options);
    }
  });
});
// YOUTUBE
(function() {
  var youtube = document.querySelectorAll(".youtube");
  for (var i = 0; i < youtube.length; i++) {
    var image = new Image();
    image.src = root + "images/nwh-sddefault.jpg";
    image.addEventListener("load", function() {
      youtube[i].appendChild(image);
    }(i));
    youtube[i].addEventListener("click", function() {
      var iframe = document.createElement("iframe");
      iframe.setAttribute("frameborder", "0");
      iframe.setAttribute("allowfullscreen", "");
      iframe.setAttribute("src", "https://www.youtube.com/embed/" + this.dataset.embed + "?rel=0&showinfo=0&autoplay=1");
      this.innerHTML = "";
      this.appendChild(iframe);
    });
  };
})();