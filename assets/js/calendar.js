$(document).ready(function() {
  $.ajax({
    type: 'POST',
    url: root + "ajax/getAllBooking.php/",
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
        events: response,
        eventClick: function(calEvent, jsEvent, view) {
          alert('Name: ' + calEvent.name + "\nRoom: " + calEvent.room + "\nCheck In Date: " + calEvent.checkInDate + "\nCheck Out Date: " + calEvent.checkOutDate);
        }
      });
      $(window).on('resize', function() {
        $('#calendar').fullCalendar('option', 'contentHeight', $("main.l-main").height() - 70);
      });
      $("#loadingMode").fadeOut();
    }
  })
});