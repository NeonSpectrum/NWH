var bookingID, email, roomID, roomType, checkInDate, checkOutDate, adults, childrens, currentRoomIDs;
$(".checkDate").change(function() {
  $.ajax({
    type: 'POST',
    url: root + "ajax/getQuantityRooms.php",
    data: "checkDate=" + $(this).val() + "&admin=true",
    dataType: 'json',
    success: function(response) {
      $('#modalAddBooking').find("label#Standard_Single").parent().find(".cmbQuantity").html(response[0]);
      $('#modalAddBooking').find("label#Standard_Double").parent().find(".cmbQuantity").html(response[1]);
      $('#modalAddBooking').find("label#Family_Room").parent().find(".cmbQuantity").html(response[2]);
      $('#modalAddBooking').find("label#Junior_Suites").parent().find(".cmbQuantity").html(response[3]);
      $('#modalAddBooking').find("label#Studio_Type").parent().find(".cmbQuantity").html(response[4]);
      $('#modalAddBooking').find("label#Barkada_Room").parent().find(".cmbQuantity").html(response[5]);
    }
  });
});
$("#frmAddBooking").submit(function(e) {
  e.preventDefault();
  $(this).find("#btnAdd").html('<i class="fa fa-spinner fa-pulse"></i> Adding...');
  $(this).find('#btnAdd').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  var rooms = [],
    roomSelected = false;
  $(this).find(".cmbQuantity").each(function() {
    if ($(this).val() != 0) {
      var roomType = $(this).parent().parent().find(".lblRoomType").attr("id");
      var quantity = $(this).val();
      rooms.push({
        roomType: roomType,
        roomQuantity: quantity
      });
      roomSelected = true;
    }
  });
  if (!roomSelected) {
    $(this).find("#btnAdd").html('Add');
    $(this).find('#btnAdd').attr('disabled', false);
    $(this).find(".lblDisplayError").show(function() {
      $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + CHOOSE_ROOM_TO_PROCEED + '</div>');
    })
    return;
  }
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/bookNow.php',
    data: {
      data: $(this).serialize() + "&type=walkin",
      rooms: rooms
    },
    dataType: 'json',
    success: function(response) {
      if (response[0] != false) {
        $('#modalAddBooking').modal('hide');
        alertNotif('success', 'Added Successfully!', true);
      } else {
        $(this).find("#btnAdd").html('Add');
        $(this).find('#btnAdd').attr('disabled', false);
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>');
        })
      }
    }
  });
});
$('#modalAddPayment').on('shown.bs.modal', function() {
  $('#txtPayment').focus();
});
$(".btnAddPayment").click(function() {
  $("#modalAddPayment").find(".modal-title").html("Booking ID: " + $(this).attr("id"));
  $("#modalAddPayment").find("#txtBookingID").val($(this).attr("id"));
});
$('.btnAddRoom').click(function() {
  roomID = $(this).attr("id");
  bookingID = $(this).closest("tr").find("#txtBookingID").html();
  email = $(this).closest("tr").find("#txtEmail").html();
  checkInDate = $(this).closest("tr").find("#txtCheckInDate").html();
  checkOutDate = $(this).closest("tr").find("#txtCheckOutDate").html();
  adults = $(this).closest("tr").find("#txtAdults").html();
  children = $(this).closest("tr").find("#txtChildren").html();
  $('#modalEditRoom').find('.modal-title').html("Booking ID: " + bookingID);
  $('#modalEditRoom').find('#txtType').val("add");
  $('#modalEditRoom').find('#txtBookingID').val(bookingID);
  $('#modalEditRoom').find('#txtRoomID').val(roomID);
  $('#modalEditRoom').find('#btnUpdate').html("Add");
  $.ajax({
    type: 'POST',
    url: root + "ajax/generateRoomID.php",
    data: "roomType=" + $("#cmbRoomType").val().replace(" ", "_") + "&checkDate=" + checkInDate + " - " + checkOutDate + "&roomID=" + roomID,
    dataType: 'json',
    success: function(response) {
      if (response[0] != false) {
        var roomList = [];
        $("#modalEditRoom").find("#cmbRoomType").val(response[0]);
        for (var i = 1; i < response.length; i++) {
          if (roomList.indexOf(response[i]) == -1) {
            roomList.push(response[i]);
          }
        }
        roomList.sort();
        roomList.forEach(function(room) {
          var selected = room == roomID ? "selected" : "";
          $("#modalEditRoom").find("#cmbNewRoomID").append("<option value='" + room + "' " + selected + ">" + room + "</option>");
        });
        currentRoomIDs = $("#cmbNewRoomID").html();
        $("#modalEditRoom").modal("show");
      }
    }
  });
});
$('.btnEditRoom').click(function() {
  roomID = $(this).attr("id");
  bookingID = $(this).closest("tr").find("#txtBookingID").html();
  email = $(this).closest("tr").find("#txtEmail").html();
  checkInDate = $(this).closest("tr").find("#txtCheckInDate").html();
  checkOutDate = $(this).closest("tr").find("#txtCheckOutDate").html();
  adults = $(this).closest("tr").find("#txtAdults").html();
  children = $(this).closest("tr").find("#txtChildren").html();
  $('#modalEditRoom').find('.modal-title').html("Booking ID: " + bookingID);
  $('#modalEditRoom').find('#txtBookingID').val(bookingID);
  $('#modalEditRoom').find('#txtType').val("edit");
  $('#modalEditRoom').find('#txtRoomID').val(roomID);
  $('#modalEditRoom').find('#btnUpdate').html("Update");
  $.ajax({
    type: 'POST',
    url: root + "ajax/generateRoomID.php",
    data: "roomType=" + $("#cmbRoomType").val().replace(" ", "_") + "&checkDate=" + checkInDate + " - " + checkOutDate + "&roomID=" + roomID,
    dataType: 'json',
    success: function(response) {
      if (response[0] != false) {
        var roomList = [];
        $("#modalEditRoom").find("#cmbRoomType").val(response[0]);
        for (var i = 1; i < response.length; i++) {
          if (roomList.indexOf(response[i]) == -1) {
            roomList.push(response[i]);
          }
        }
        roomList.sort();
        roomList.forEach(function(room) {
          var selected = room == roomID ? "selected" : "";
          $("#modalEditRoom").find("#cmbNewRoomID").append("<option value='" + room + "' " + selected + ">" + room + "</option>");
        });
        currentRoomIDs = $("#cmbNewRoomID").html();
        $("#modalEditRoom").modal("show");
      }
    }
  });
});
$('.btnDeleteRoom').click(function() {
  roomID = $(this).attr("id");
  bookingID = $(this).closest("tr").find("#txtBookingID").html();
  swal({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        type: 'POST',
        url: root + 'ajax/deleteRoomFromBooking.php',
        data: "txtBookingID=" + bookingID + "&roomID=" + roomID + "&csrf_token=" + $("input[name=csrf_token]").val(),
        success: function(response) {
          if (response == true) {
            swal({
              title: 'Booking ID: ' + bookingID,
              text: 'The room ' + roomID + ' has been removed.',
              type: 'success'
            }).then((result) => {
              if (result.value) {
                location.reload();
              }
            });
          } else {
            swal({
              title: 'Error',
              text: 'There was an error removing the room!',
              type: 'error'
            });
          }
        }
      });
    }
  })
});
$('.btnEditReservation').click(function() {
  bookingID = $(this).attr("id");
  email = $(this).closest("tr").find("#txtEmail").html();
  checkInDate = $(this).closest("tr").find("#txtCheckInDate").html();
  checkOutDate = $(this).closest("tr").find("#txtCheckOutDate").html();
  adults = $(this).closest("tr").find("#txtAdults").html();
  children = $(this).closest("tr").find("#txtChildren").html();
  $('#modalEditReservation').find('.modal-title').html("Booking ID: " + bookingID);
  $('#modalEditReservation').find('#cmbBookingID').val(bookingID);
  $('#modalEditReservation').find("#txtEmail").val(email);
  $('#modalEditReservation').find("#txtCheckDate").val(checkInDate + " - " + checkOutDate);
  $('#modalEditReservation').find("#txtAdults").val(adults);
  $('#modalEditReservation').find("#txtChildren").val(children);
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
        data: "txtBookingID=" + $(this).attr("id") + "&csrf_token=" + $("input[name=csrf_token]").val(),
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
          $("#modalEditRoom").find("#cmbNewRoomID").html('');
          for (var i = 0; i < response.length; i++) {
            roomList.push(response[i]);
          }
          roomList.sort();
          roomList.forEach(function(room) {
            var selected = room == roomID ? "selected" : "";
            $("#modalEditRoom").find("#cmbNewRoomID").append("<option value='" + room + "' " + selected + ">" + room + "</option>");
          });
        } else {
          $("#modalEditRoom").find("#cmbNewRoomID").html('');
        }
      }
    });
  }
});
$("#frmEditRoom").submit(function(e) {
  e.preventDefault();
  $(this).find("#btnUpdate").html('<i class="fa fa-spinner fa-pulse"></i> Updating...');
  $(this).find('#btnUpdate').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/editRoomFromBooking.php',
    data: $(this).serialize(),
    success: function(response) {
      if (response == true) {
        $('#modalEditRoom').modal('hide');
        alertNotif('success', UPDATE_SUCCESS, true);
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
$("#frmEditReservation").submit(function(e) {
  e.preventDefault();
  $(this).find("#btnUpdate").html('<i class="fa fa-spinner fa-pulse"></i> Updating...');
  $(this).find('#btnUpdate').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/editReservation.php',
    data: $(this).serialize() + "&type=admin",
    success: function(response) {
      if (response == true) {
        $('#modalEditReservation').modal('hide');
        alertNotif('success', UPDATE_SUCCESS, true);
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
var oTable = $('#tblBooking').DataTable({
  "scrollY": "300px",
  "scrollCollapse": true
});
oTable.order([0, 'desc']).draw();
$('#tblBooking_length').find("select").addClass("form-control");
$('#tblBooking_filter').find("input[type=search]").addClass("form-control");
$('input[type="search"]').focus();
if (getQueryVariable("search")) {
  $('input[type="search"]').val(getQueryVariable("search"));
  oTable.search(getQueryVariable("search")).draw();
}