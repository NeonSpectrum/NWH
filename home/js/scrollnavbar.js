/* $(document).ready(function(){
    $(".navbar").hide();
        // fade in .navbar
    $(function () {
        $(window).scroll(function () {
          console.log($(this).scrollTop());
            // set distance user needs to scroll before we start fadeIn
            if ($(this).scrollTop() > $(".overlay").height()) {
              $('.navbar').fadeIn();
            } 
            else if ($(this).scrollTop()==0){
              $('.navbar').fadeOut();
            }
        });
    });
}); */
$('.navbar').affix({
  offset: {
    top: $(".overlay").height()
  }
}); 