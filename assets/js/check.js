$('#modalAddPayment').on('shown.bs.modal', function() {
  $(this).find('#txtPayment').focus();
});
$('#modalAddDiscount').on('shown.bs.modal', function() {
  $(this).find('#txtDiscount').focus();
});
$(".btnAddPayment").click(function() {
  $("#modalAddPayment").find(".modal-title").html("Booking ID: " + $(this).attr("id"));
  $("#modalAddPayment").find("#txtBookingID").val($(this).attr("id"));
});
$(".btnAddDiscount").click(function() {
  $("#modalAddDiscount").find(".modal-title").html("Booking ID: " + $(this).attr("id"));
  $("#modalAddDiscount").find("#txtBookingID").val($(this).attr("id"));
});
$(".checkDate").change(function() {
  $.ajax({
    type: 'POST',
    url: root + "ajax/getQuantityRooms.php",
    data: "checkDate=" + $(this).val(),
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
$('.btnCheckIn').click(function() {
  var table = $(this).closest("table").attr("id") == "tblWalkIn" ? "walk_in" : "booking";
  swal({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Check In'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        type: 'POST',
        url: root + 'ajax/check.php',
        data: "txtBookingID=" + $(this).attr("id") + "&type=checkIn&table=" + table + "&csrf_token=" + $("input[name=csrf_token]").val(),
        success: function(response) {
          if (response == true) {
            var date = new Date();
            swal({
              title: 'Checked In!',
              text: 'Started at ' + date.toLocaleString(),
              type: 'success'
            }).then((result) => {
              if (result.value) {
                location.reload();
              }
            });
          } else {
            swal({
              title: 'Something went wrong!',
              text: 'Error : ' + response,
              type: 'warning'
            }).then((result) => {
              if (result.value) {
                location.reload();
              }
            });
          }
        }
      });
    }
  });
});
$('.btnCheckOut').click(function() {
  var table = $(this).closest("table").attr("id") == "tblWalkIn" ? "walk_in" : "booking";
  swal({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Check Out'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        context: this,
        type: 'POST',
        url: root + 'ajax/check.php',
        data: "txtBookingID=" + $(this).attr("id") + "&type=checkOut&table=" + table + "&csrf_token=" + $("input[name=csrf_token]").val(),
        success: function(response) {
          if (response == true) {
            var date = new Date();
            swal({
              title: 'Checked Out!',
              text: 'Ended at ' + date.toLocaleString(),
              type: 'success'
            }).then((result) => {
              if (result.value) {
                $.ajax({
                  context: this,
                  type: 'POST',
                  url: root + "ajax/getBill.php",
                  data: "txtBookingID=" + $(this).attr("id") + "&csrf_token=" + $("input[name=csrf_token]").val(),
                  success: function(response) {
                    $("#modalReceipt").find(".modal-title").html("Booking ID: " + $(this).closest("tr").find("#txtBookingID").html());
                    $("#modalReceipt").find(".modal-body").html("<h1 style='text-align:center'>Total Amount: ₱&nbsp;" + parseInt(response).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + "</h1>");
                    $("#modalReceipt").modal("show");
                    $("#modalReceipt").on("hidden.bs.modal", function() {
                      location.reload();
                    });
                  }
                });
              }
            });
          }
        }
      });
    }
  });
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
    data: $(this).serialize() + "&type=check",
    success: function(response) {
      location.reload();
    }
  });
});
$("#frmAddDiscount").submit(function(e) {
  e.preventDefault();
  $(this).find("#btnAdd").html('<i class="fa fa-spinner fa-pulse"></i> Adding...');
  $(this).find('#btnAdd').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + "ajax/addDiscount.php",
    data: $(this).serialize(),
    success: function(response) {
      location.reload();
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
$('#tblBook').on('init.dt', function(e, settings, json) {
  $("#loadingMode").fadeOut();
});
var oTable = $('#tblBook').DataTable();
$('#tblBook_length').find("select").addClass("form-control");
$('#tblBook_filter').find("input[type=search]").addClass("form-control");
$('input[type="search"]').focus();
if (getQueryVariable("search")) {
  $('input[type="search"]').val(getQueryVariable("search"));
  oTable.search(getQueryVariable("search")).draw();
}