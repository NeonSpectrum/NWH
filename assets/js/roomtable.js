$("td.using").click(function() {
  var bookingID = $(this).attr("data-original-title").substring($(this).attr("data-original-title").lastIndexOf("Booking ID: ") + 12, $(this).attr("data-original-title").lastIndexOf("<br/>Name")).trim();
  swal({
    title: 'Are you sure?',
    text: "You will redirect to check information!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Go'
  }).then((result) => {
    if (result.value) {
      location.href = root + "admin/check/?search=" + bookingID;
    }
  });
});