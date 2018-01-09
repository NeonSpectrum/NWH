var bookingID, email, roomID, roomType, checkInDate, checkOutDate, adults, childrens, currentRoomIDs;
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
  $('#modalEditReservation').find("#cmbNewRoomID").html('');
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
          $("#modalEditReservation").find("#cmbNewRoomID").append("<option value='" + room + "' " + selected + ">" + room + "</option>");
        });
        currentRoomIDs = $("#cmbNewRoomID").html();
      } else {
        $("#modalEditReservation").find("#btnGenerateRoomID").after("<i class='fa fa-times' aria-hidden='true'></i>");
      }
    }
  });
});
$(".btnCancel").click(function() {
  swal({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, cancel it!'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        type: 'POST',
        url: root + 'ajax/bookCancel.php',
        data: "txtBookingID=" + $(this).attr("id") + "&csrf_token=" + $("input[name=csrf_token]").val() + "&mode=cancel",
        success: function(response) {
          if (response == true) {
            swal({
              title: 'Cancelled!',
              text: 'The book has been cancelled.',
              type: 'success'
            }).then((result) => {
              if (result.value) {
                location.reload();
              }
            });
          } else {
            swal({
              title: 'Error',
              text: 'There was an error cancelling the booking!',
              type: 'error'
            });
          }
        }
      });
    }
  })
});
$(".btnRevertCancel").click(function() {
  swal({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, revert the cancellation!'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        type: 'POST',
        url: root + 'ajax/bookCancel.php',
        data: "txtBookingID=" + $(this).attr("id") + "&csrf_token=" + $("input[name=csrf_token]").val() + "&mode=revert",
        success: function(response) {
          if (response == true) {
            swal({
              title: 'Reverted!',
              text: 'The cancellation of the booking has been reverted.',
              type: 'success'
            }).then((result) => {
              if (result.value) {
                location.reload();
              }
            });
          } else {
            swal({
              title: 'Error',
              text: 'There was an error cancelling the booking!',
              type: 'error'
            });
          }
        }
      });
    }
  })
});
$("#frmAddPayment").submit(function(e) {
  e.preventDefault();
  $(this).find("#btnAdd").html('<i class="fa fa-spinner fa-pulse"></i> Adding...');
  $(this).find('#btnAdd').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + "ajax/addPayment.php",
    data: $(this).serialize() + "&type=booking",
    success: function(response) {
      location.reload();
    }
  });
});
$("#cmbRoomType").change(function() {
  var roomList = [];
  if ($(this).val() == roomType) {
    $("#cmbNewRoomID").html(currentRoomIDs);
  } else {
    $.ajax({
      type: 'POST',
      url: root + "ajax/generateRoomID.php",
      data: "roomType=" + $("#cmbRoomType").val().replace(" ", "_") + "&checkDate=" + $("#txtCheckDate").val(),
      dataType: 'json',
      success: function(response) {
        if (response) {
          $("#modalEditReservation").find("#cmbNewRoomID").html('');
          for (var i = 0; i < response.length; i++) {
            roomList.push(response[i]);
          }
          roomList.sort();
          roomList.forEach(function(room) {
            var selected = room == roomID ? "selected" : "";
            $("#modalEditReservation").find("#cmbNewRoomID").append("<option value='" + room + "' " + selected + ">" + room + "</option>");
          });
        } else {
          $("#modalEditReservation").find("#cmbNewRoomID").html('');
        }
      }
    });
  }
});
$("#frmEditReservation").submit(function(e) {
  e.preventDefault();
  $(this).find("#btnUpdate").html('<i class="fa fa-spinner fa-pulse"></i> Updating...');
  $(this).find('#btnUpdate').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/editReservation.php',
    data: $(this).serialize() + "&currentRoomID=" + roomID + "&type=admin",
    success: function(response) {
      if (response == true) {
        $('#modalEditReservation').modal('hide');
        alertNotif('success', 'Updated Successfully!', true);
      } else {
        $(this).find("#btnUpdate").html('Update');
        $(this).find('#btnUpdate').attr('disabled', false);
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>');
        })
      }
    }
  });
});
$('#tblBooking').on('init.dt', function(e, settings, json) {
  $("#loadingMode").fadeOut();
});
$('#tblBooking').DataTable();
$('#tblBooking_length').find("select").addClass("form-control");
$('#tblBooking_filter').find("input[type=search]").addClass("form-control");
$('input[type="search"]').focus();