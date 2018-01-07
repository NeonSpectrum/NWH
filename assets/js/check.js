var date = new Date();
var today = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
$('input.checkInDate, input.checkOutDate').datepicker({
  format: "yyyy-mm-dd",
  startDate: '0d',
  autoclose: true,
  todayHighlight: true
});
$(".checkInDate, .checkOutDate").each(function() {
  $(this).datepicker("setDate", today);
});
$('input.checkInDate').change(function() {
  $(this).closest("form").find(".checkOutDate").datepicker('setStartDate', $(this).val());
  $(this).closest("form").find(".checkOutDate").datepicker('update', $(this).val());
});
$('#modalAddPayment').on('shown.bs.modal', function() {
  $('#txtPayment').focus();
});
$(".btnAddPayment").click(function() {
  $("#modalAddPayment").find(".modal-title").html("Booking ID: " + $(this).attr("id"));
  $("#modalAddPayment").find("#txtBookingID").val($(this).attr("id"));
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
                location.reload();
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
$("#frmAddReservation").submit(function(e) {
  e.preventDefault();
  $(this).find("#btnReservation").html('<i class="fa fa-spinner fa-pulse"></i> Updating...');
  $(this).find('#btnReservation').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/addReservation.php',
    data: $(this).serialize(),
    success: function(response) {
      if (response == true) {
        $('#modalAddReservation').modal('hide');
        alertNotif('success', 'Added Successfully!', true);
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
$('#tblBook').on('init.dt', function(e, settings, json) {
  $("#loadingMode").fadeOut();
});
$('#tblBook').DataTable();
$('#tblBook').parent().find('input[type="search"]').attr("placeholder", "Booking ID");
$('#tblBook').parent().find('input[type="search"]').on('keyup change', function(e) {
  e.preventDefault();
  $('#tblBook').DataTable().column(0).search($(this).val()).draw();
});
$('#tblBook_length').find("select").addClass("form-control");
$('#tblBook_filter').find("input[type=search]").addClass("form-control");
$('input[type="search"]').focus();