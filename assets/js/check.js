$('#modalAddExpenses').on('shown.bs.modal', function() {
  $(this).find('#txtPayment').focus();
});
$('#modalAddDiscount').on('shown.bs.modal', function() {
  $(this).find('#txtDiscount').focus();
});
$(".btnAddExpenses").click(function() {
  $("#modalAddExpenses").find(".modal-title").html("Booking ID: " + $(this).attr("id"));
  $("#modalAddExpenses").find("#txtBookingID").val($(this).attr("id"));
});
$("#modalAddExpenses").find("#cmbExpensesType").change(function() {
  $(this).closest("form").find("#txtQuantity").val("1");
  if ($(this).val() == "Others") {
    $(this).closest("form").find("#txtPayment").prop("readonly", false);
    $(this).closest("form").find("#txtPayment").val('0');
  } else {
    $(this).closest("form").find("#txtPayment").val($(this).val());
    $(this).closest("form").find("#txtPayment").prop("readonly", true);
  }
});
$("#modalAddExpenses").find("#txtQuantity").change(function() {
  var payment = $(this).closest("form").find("#cmbExpensesType").val() * $(this).val();
  $(this).closest("form").find("#txtPayment").val(payment);
});
$(".btnAddDiscount").click(function() {
  $("#modalAddDiscount").find(".modal-title").html("Booking ID: " + $(this).attr("id"));
  $("#modalAddDiscount").find("#txtBookingID").val($(this).attr("id"));
});
$("#modalAddDiscount").find("#cmbDiscountType").change(function() {
  if ($(this).val() == "Others") {
    $(this).closest("form").find("#txtDiscount").prop("readonly", false);
    $(this).closest("form").find("#txtDiscount").val('0');
  } else {
    $(this).closest("form").find("#txtDiscount").val($(this).val());
    $(this).closest("form").find("#txtDiscount").prop("readonly", true);
  }
});
$('.btnCheckIn').click(function() {
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
        data: "txtBookingID=" + $(this).attr("id") + "&csrf_token=" + $("input[name=csrf_token]").val() + "&type=checkIn",
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
        data: "txtBookingID=" + $(this).attr("id") + "&type=checkOut&csrf_token=" + $("input[name=csrf_token]").val() + "&type=checkOut",
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
                    $("#modalReceipt").find(".modal-body").html(response);
                    $("#modalReceipt").find("input[name=txtBookingID]").val($(this).attr("id"));
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
$("#frmAddExpenses").submit(function(e) {
  e.preventDefault();
  $(this).find("#btnAdd").html('<i class="fa fa-spinner fa-pulse"></i> Adding...');
  $(this).find('#btnAdd').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + "ajax/addPayment.php",
    data: $(this).serialize() + "&type=check&expensesType=" + $(this).find("#cmbExpensesType option:selected").html(),
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
    data: $(this).serialize() + "&discountType=" + $(this).find("#cmbDiscountType option:selected").html(),
    success: function(response) {
      // location.reload();
    }
  });
});
$("#btnPay").click(function() {
  swal({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Pay'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        context: this,
        type: 'POST',
        url: root + 'ajax/payBill.php',
        data: "txtBookingID=" + $(this).parent().find("input[name=txtBookingID]").val() + "&csrf_token=" + $("input[name=csrf_token]").val(),
        success: function(response) {
          if (response == true) {
            swal({
              title: $(this).closest(".modal").find(".modal-title").html(),
              text: 'Successfully Paid!',
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
$("#btnPrint").click(function() {
  var bookingID = $(this).closest(".modal").find(".modal-title").html().substr(-15);
  window.open("//" + location.hostname + root + "files/generateReceipt/?BookingID=" + bookingID, '_blank', 'height=650,width=1000');
});
$(".btnShowBill").click(function() {
  $("#modalReceipt").find("#loadingMode").fadeIn();
  $.ajax({
    context: this,
    type: 'POST',
    url: root + "ajax/getBill.php",
    data: "txtBookingID=" + $(this).attr("id") + "&csrf_token=" + $("input[name=csrf_token]").val(),
    success: function(response) {
      $("#modalReceipt").find(".modal-title").html("Booking ID: " + $(this).closest("tr").find("#txtBookingID").html());
      $("#modalReceipt").find(".modal-body").html(response);
      $("#modalReceipt").find("input[name=txtBookingID]").val($(this).attr("id"));
      $("#modalReceipt").find("#loadingMode").fadeOut();
      $("#modalReceipt").modal("show");
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