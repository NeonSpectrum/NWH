$('#modalAddExpenses').on('shown.bs.modal', function() {
  $(this).find('#txtPayment').focus();
  if ($(this).find("#cmbExpensesType option:selected").html() != "Others") {
    $(this).find("#txtPayment").prop("readonly", true);
  }
});
$('#modalAddDiscount').on('shown.bs.modal', function() {
  $(this).find('#txtDiscount').focus();
  if ($(this).find("#cmbExpensesType option:selected").html() != "Others") {
    $(this).find("#txtDiscount").prop("readonly", true);
  }
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
      location.reload();
    }
  });
});
$('#modalReceipt').on('shown.bs.modal', function() {
  $(document).off('focusin.modal');
});
$("#btnPay").click(function() {
  var remainingAmount = parseInt($("#modalReceipt").find("input[name=payment]").val());
  swal({
    title: 'Are you sure?',
    text: "Remaining Amount: ₱ " + remainingAmount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'),
    type: 'warning',
    input: 'number',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Pay',
    inputValidator: function(number) {
      return number >= remainingAmount ? null : "Please input a valid amount!"
    }
  }).then((result) => {
    if (result.value) {
      $.ajax({
        context: this,
        type: 'POST',
        url: root + 'ajax/payBill.php',
        data: "txtBookingID=" + $(this).parent().find("input[name=txtBookingID]").val() + "&payment=" + result.value + "&csrf_token=" + $("input[name=csrf_token]").val(),
        success: function(response) {
          swal({
            title: $(this).closest(".modal").find(".modal-title").html(),
            html: 'Successfully Paid!<br/>Change: ₱ ' + response,
            type: 'success'
          }).then((result) => {
            if (result.value) {
              location.reload();
            }
          });
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
      if ($("#modalReceipt").find("input[name=payment]").val() <= 0) {
        $("#btnPay").css("display", "none");
      } else {
        $("#btnPay").css("display", "inline-block");
      }
    }
  });
});
$('#tblCheck').on('init.dt', function(e, settings, json) {
  $("#loadingMode").fadeOut();
});
var oTable = $('#tblCheck').DataTable({
  "scrollY": "300px",
  "scrollCollapse": true
});
oTable.order([0, 'desc']).draw();
$('#tblCheck_length').find("select").addClass("form-control");
$('#tblCheck_filter').find("input[type=search]").addClass("form-control");
$('input[type="search"]').focus();
if (getQueryVariable("search")) {
  $('input[type="search"]').val(getQueryVariable("search"));
  oTable.search(getQueryVariable("search")).draw();
}