var bookingID, email, roomID, roomType, checkInDate, checkOutDate, adults, childrens, currentRoomIDs;
$('input[type="search"]').focus();
$('#modalAddPayment').on('shown.bs.modal', function() {
  $('#txtPayment').focus();
});
$(".btnAddPayment").click(function() {
  $("#modalAddPayment").find(".modal-title").html("Booking ID: " + $(this).attr("id"));
  $("#modalAddPayment").find("#txtBookingID").val($(this).attr("id"));
});
$('.btnEditReservation').click(function() {
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
    success: function(response) {
      if (response) {
        $("#modalEditReservation").find("#cmbRoomType").val(response[0]);
        for (var i = 1; i < response.length; i++) {
          if (roomList.indexOf(response[i]) == -1) {
            roomList.push(response[i]);
          }
        }
        roomList.sort();
        roomList.forEach(function(room) {
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
$("#frmAddWalkIn").submit(function(e) {
  e.preventDefault();
  var rooms = [];
  $(this).find(".cmbRoomType").each(function() {
    console.log($(this).val());
    console.log($(this).parent().parent().find("#txtQuantity").val());
  });
})
$("#frmAddPayment").submit(function(e) {
  e.preventDefault();
  $.ajax({
    context: this,
    type: 'POST',
    url: root + "ajax/addPayment.php",
    data: $(this).serialize(),
    success: function(response) {
      $(this).closest(".modal").modal("hide");
      alertNotif("success", "Added Successfully", true);
    }
  });
});
$("#cmbRoomType").change(function() {
  var roomList = [];
  if ($(this).val() == roomType) {
    $("#cmbRoomID").html(currentRoomIDs);
  } else {
    $.ajax({
      type: 'POST',
      url: root + "ajax/generateRoomID.php",
      data: "roomType=" + $("#cmbRoomType").val().replace(" ", "_") + "&checkDate=" + $("#txtCheckDate").val(),
      dataType: 'json',
      success: function(response) {
        if (response) {
          $("#modalEditReservation").find("#cmbRoomID").html('');
          for (var i = 0; i < response.length; i++) {
            roomList.push(response[i]);
          }
          roomList.sort();
          roomList.forEach(function(room) {
            var selected = room == roomID ? "selected" : "";
            $("#modalEditReservation").find("#cmbRoomID").append("<option value='" + room + "' " + selected + ">" + room + "</option>");
          });
        }
      }
    });
  }
});
$("#frmEditReservation").submit(function(e) {
  e.preventDefault();
  $(this).find("#btnReservation").html('<i class="fa fa-spinner fa-pulse"></i> Updating...');
  $(this).find('#btnReservation').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/editReservation.php',
    data: $(this).serialize() + "&currentRoomID=" + roomID + "&type=walkin",
    success: function(response) {
      if (response == true) {
        $('#modalEditReservation').modal('hide');
        alertNotif('success', 'Updated Successfully!', true);
      } else {
        $(this).find("#btnReservation").html('Update');
        $(this).find('#btnReservation').attr('disabled', false);
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>');
        })
      }
    }
  });
});
$('#tblWalkIn').on('init.dt', function(e, settings, json) {
  $("#loadingMode").fadeOut();
});
$('#tblWalkIn').DataTable();
$('#tblWalkIn_length').find("select").addClass("form-control");
$('#tblWalkIn_filter').find("input[type=search]").addClass("form-control");