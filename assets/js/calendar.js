$(document).ready(function() {
  $.ajax({
    type: 'POST',
    url: root + "ajax/getAllBooking.php",
    dataType: 'json',
    success: function(response) {
      $('#calendar').fullCalendar({
        contentHeight: $("main.l-main").height() - 70,
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay,listWeek'
        },
        displayEventTime: false,
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        eventStartEditable: false,
        events: response,
        eventRender: function(event, element) {
          var today = new Date().getFullYear() + "-" + new Date().getMonth() + "-" + new Date().getDate();
          if (new Date(event.checkInDate).getTime() < new Date(today).getTime()) {
            element.addClass("disabled");
          }
          if (event.checked == true) {
            element.css("background-color", "black");
            element.css("border-color", "black");
            element.css("color", "white");
          } else if (event.check == true) {
            element.css("background-color", "red");
            element.css("border-color", "red");
            element.css("color", "white");
          } else if (event.paid == true) {
            element.css("background-color", "darkblue");
            element.css("border-color", "darkblue");
            element.css("color", "white");
          }
          element.css("cursor", "pointer");
          element.attr("data-html", true);
          element.attr("data-tooltip", "tooltip");
          element.attr("title", 'BookingID: ' + event.bookingID + '<br/>Name: ' + event.name + "<br/>Room: " + event.room + "<br/>Check In Date: " + event.checkInDate + "<br/>Check Out Date: " + event.checkOutDate);
          element.click(function() {
            if (!$(this).hasClass("disabled")) {
              var bookingID = $(this).attr("data-original-title").substring($(this).attr("data-original-title").lastIndexOf("Booking ID: ") + 12, $(this).attr("data-original-title").lastIndexOf("<br/>Name")).trim();
              swal({
                title: 'Are you sure?',
                text: "You will redirect to booking information!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Go'
              }).then((result) => {
                if (result.value) {
                  location.href = root + "admin/reports/listofreservation/?search=" + bookingID;
                }
              });
            }
          });
          element.tooltip({
            container: 'body'
          });
        }
      });
      $(window).on('resize', function() {
        $('#calendar').fullCalendar('option', 'contentHeight', $("main.l-main").height() - 70);
      });
      $("#loadingMode").fadeOut();
    }
  })
});