var oTable = $('#tblReservation').DataTable();
var bookingID, email, roomID, roomType, checkInDate, checkOutDate, adults, childrens, currentRoomIDs;
$('#tblReservation_length').find("select").addClass("form-control");
$('#tblReservation_filter').find("input[type=search]").addClass("form-control");
$('input[type="search"]').focus();
$('.btnEditReservation').click(function () {
  bookingID = $(this).attr("id");
  email = $(this).closest("tr").find("#txtEmail").html();
  roomID = $(this).closest("tr").find("#txtRoomID").html();
  roomType = $(this).closest("tr").find("#txtRoomType").html();
  checkInDate = $(this).closest("tr").find("#txtCheckInDate").html();
  checkOutDate = $(this).closest("tr").find("#txtCheckOutDate").html();
  adults = $(this).closest("tr").find("#txtAdults").html();
  children = $(this).closest("tr").find("#txtChildren").html();
  $('#modalEditReservation').find('.modal-title').html("Booking ID: " + bookingID);
  $('#modalEditReservation').find('#cmbBookingID').val(bookingID);
  $('#modalEditReservation').find("#txtEmail").val(email);
  $('#modalEditReservation').find("#cmbRoomID").html('');
  $('#modalEditReservation').find("#txtCheckDate").val(checkInDate + " - " + checkOutDate);
  $('#modalEditReservation').find("#txtAdults").val(adults);
  $('#modalEditReservation').find("#txtChildren").val(children);
  var roomList = [];
  roomList.push(roomID);
  $.ajax({
    type: 'POST',
    url: root + "ajax/generateRoomID.php",
    data: "roomType=" + $("#cmbRoomType").val().replace(" ", "_") + "&checkDate=" + $("#txtCheckDate").val() + "&roomID=" + roomID,
    dataType: 'json',
    success: function (response) {
      if (response) {
        $("#modalEditReservation").find("#cmbRoomType").val(response[0]);
        for (var i = 1; i < response.length; i++) {
          roomList.push(response[i]);
        }
        roomList.sort();
        roomList.forEach(function (room) {
          var selected = room == roomID ? "selected" : "";
          $("#modalEditReservation").find("#cmbRoomID").append("<option value='" + room + "' " + selected + ">" + room + "</option>");
        });
        currentRoomIDs = $("#cmbRoomID").html();
      } else {
        $("#modalEditReservation").find("#btnGenerateRoomID").after("<i class='fa fa-times' aria-hidden='true'></i>");
      }
    }
  });
});
$("#cmbRoomType").change(function () {
  var roomList = [];
  if ($(this).val() == roomType) {
    $("#cmbRoomID").html(currentRoomIDs);
  } else {
    $.ajax({
      type: 'POST',
      url: root + "ajax/generateRoomID.php",
      data: "roomType=" + $("#cmbRoomType").val().replace(" ", "_") + "&checkDate=" + $("#txtCheckDate").val(),
      dataType: 'json',
      success: function (response) {
        if (response) {
          $("#modalEditReservation").find("#cmbRoomID").html('');
          for (var i = 0; i < response.length; i++) {
            roomList.push(response[i]);
          }
          roomList.sort();
          roomList.forEach(function (room) {
            var selected = room == roomID ? "selected" : "";
            $("#modalEditReservation").find("#cmbRoomID").append("<option value='" + room + "' " + selected + ">" + room + "</option>");
          });
        }
      }
    });
  }
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
    data: $(this).serialize() + "&currentRoomID=" + roomID,
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