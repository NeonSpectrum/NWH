var oTable = $('#tblReservation').DataTable();
$('input[type="search"]').attr("placeholder", "Booking ID");
$('input[type="search"]').on('keyup change', function (e) {
  e.preventDefault();
  oTable.column(0).search($(this).val()).draw();
});

$('.btnEditReservation').click(function () {
  var bookingID = $(this).attr("id");
  var email = $(this).closest("tr").find("#txtEmail").html();
  var roomID = $(this).closest("tr").find("#txtRoomID").html();
  var checkInDate = $(this).closest("tr").find("#txtCheckInDate").html();
  var checkOutDate = $(this).closest("tr").find("#txtCheckOutDate").html();
  var adults = $(this).closest("tr").find("#txtAdults").html();
  var children = $(this).closest("tr").find("#txtChildren").html();
  $('#modalEditReservation').find('.modal-title').html("Booking ID: " + bookingID);
  $('#modalEditReservation').find('#cmbBookingID').val(bookingID);
  $('#modalEditReservation').find("#txtEmail").val(email);
  $('#modalEditReservation').find("#txtRoomID").val(roomID);
  $('#modalEditReservation').find("#txtCheckInDate").val(checkInDate);
  $('#modalEditReservation').find("#txtCheckOutDate").val(checkOutDate);
  $('#modalEditReservation').find("#txtAdults").val(adults);
  $('#modalEditReservation').find("#txtChildren").val(children);
});

$("#frmEditReservation").submit(function (e) {
  e.preventDefault();
  $(this).find("#btnReservation").html('<i class="fa fa-spinner fa-pulse"></i> Updating...');
  $(this).find('#btnReservation').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/editReservation.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == true) {
        $('#modalEditReservation').modal('hide');
        alertNotif('success', 'Updated Successfully!', true);
      } else {
        $(this).find("#btnReservation").html('Update');
        $(this).find('#btnReservation').attr('disabled', false);
        $(this).find(".lblDisplayError").show(function () {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>');
        })
      }
    }
  });
});