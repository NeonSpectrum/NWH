var date = new Date();
var today = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
$('#tblWalkIn').DataTable();
$('#tblBook').DataTable();

$('#tblWalkIn').parent().find('input[type="search"]').attr("placeholder", "Walk In ID");
$('#tblWalkIn').parent().find('input[type="search"]').on('keyup change', function (e) {
  e.preventDefault();
  $('#tblWalkIn').DataTable().column(0).search($(this).val()).draw();
});
$('#tblBook').parent().find('input[type="search"]').attr("placeholder", "Booking ID");
$('#tblBook').parent().find('input[type="search"]').on('keyup change', function (e) {
  e.preventDefault();
  $('#tblBook').DataTable().column(0).search($(this).val()).draw();
});

$('input.checkInDate, input.checkOutDate').datepicker({
  format: "yyyy-mm-dd",
  startDate: '0d',
  autoclose: true,
  todayHighlight: true
});
$(".checkInDate, .checkOutDate").each(function () {
  $(this).datepicker("setDate", today);
});
$('input.checkInDate').change(function () {
  $(this).closest("form").find(".checkOutDate").datepicker('setStartDate', $(this).val());
  $(this).closest("form").find(".checkOutDate").datepicker('update', $(this).val());
});
$('.btnCheckIn').click(function () {
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
        data: "txtID=" + $(this).attr("id") + "&type=checkIn&table=" + table,
        success: function (response) {
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

$('.btnCheckOut').click(function () {
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
        data: "txtID=" + $(this).attr("id") + "&type=checkOut&table=" + table,
        success: function (response) {
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

$("#frmAddReservation").submit(function (e) {
  e.preventDefault();
  $(this).find("#btnReservation").html('<i class="fa fa-spinner fa-pulse"></i> Updating...');
  $(this).find('#btnReservation').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/addReservation.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == true) {
        $('#modalAddReservation').modal('hide');
        alertNotif('success', 'Added Successfully!', true);
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