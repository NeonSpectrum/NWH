$(document).ready(function(){
    $(".navbar").hide();
        // fade in .navbar
    $(function () {
        $(window).scroll(function () {
            // set distance user needs to scroll before we start fadeIn
            if ($(this).scrollTop() > 600) {
                $('.navbar').fadeIn();
            } 
            else {
                $('.navbar').fadeOut();
            }
        });
    });
});