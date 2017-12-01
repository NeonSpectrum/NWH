$(document).ready(function () {
  if ($('#btn-step2').hasClass("active")) {
    $.ajax({
      type: 'POST',
      url: root + 'ajax/getRooms.php',
      data: $('#frmBookNow').serialize(),
      success: function (response) {
        $('span#txtRooms').html(response);
        $('input[type="checkbox"]').change(function () {
          $('input[type="checkbox"]').not(this).prop('checked', false);
        });
      }
    });
  }
});

$('.btnPrev').click(function () {
  var step = parseInt($(this).closest(".step").attr("id").replace("step", ""));
  prev(step);
  $(this).each(function () {
    $(this).prop('disabled', false);
  });
});

$('.btnNext').click(function () {
  $(this).html('<i style="font-size:16px" class="fa fa-spinner fa-pulse"></i> Submitting...');
  $(this).attr('disabled', true);
  var step = parseInt($(this).closest(".step").attr("id").replace("step", ""));
  if (step == 1) {
    if (!validateStep1()) {
      $(this).html('Next');
      $(this).prop('disabled', false);
      return;
    }
    $.ajax({
      type: 'POST',
      url: root + 'ajax/getRooms.php',
      data: $('#frmBookNow').serialize(),
      success: function (response) {
        $('span#txtRooms').html(response);
        $('input[type="checkbox"]').change(function () {
          $('input[type="checkbox"]').not(this).prop('checked', false);
        });
      }
    });
  } else if (step == 2) {
    if (!validateStep2()) {
      $(this).html('Next');
      $(this).prop('disabled', false);
      return;
    }
    $.ajax({
      type: 'POST',
      url: root + 'ajax/getRoomPrice.php',
      data: $('#frmBookNow').serialize(),
      success: function (response) {
        $('span#txtRoomPrice').html(response);
      }
    });
  }
  next(step);
  $(this).each(function () {
    $(this).prop('disabled', false);
    $(this).html("Next");
  });
});
// BOOK NOW FORM
$("#btnSubmit").click(function (e) {
  var step = parseInt($(this).closest(".step").attr("id").replace("step", ""));
  $(this).html('<i style="font-size:16px" class="fa fa-spinner fa-pulse"></i> Submitting ...');
  $(this).prop('disabled', true);
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/bookNow.php',
    dataType: "json",
    data: $('#frmBookNow').serialize(),
    success: function (response) {
      if (!response) {
        alertNotif("error", "Full");
        return;
      }
      $('span#txtBookingID').html(response[0]);
      $('span#txtRoomID').html(response[1]);
      $('#frmBookNow').find('#btnPrint').attr("href", root + "files/generateReservationConfirmation/?BookingID=" + response[0]);
      next(step);
    }
  });
});

function prev(step) {
  $('.step').each(function () {
    $(this).css("display", "none");
  });
  $('.btn-stepwizard').each(function () {
    $(this).removeClass("active");
  });
  $('#step' + (step)).css("display", "none");
  $('#step' + (step - 1)).css("display", "");
  $('#btn-step' + (step - 1)).addClass("active");
  $(window).scrollTop(0);
}

function next(step) {
  $('.step').each(function () {
    $(this).css("display", "none");
  });
  $('.btn-stepwizard').each(function () {
    $(this).removeClass("active");
  });
  $('#step' + (step)).css("display", "none");
  $('#step' + (step + 1)).css("display", "");
  $('#btn-step' + (step + 1)).addClass("active");
  $(window).scrollTop(0);
}

function validateStep1() {
  var checkIn = new Date($('#frmBookNow').find("#txtCheckInDate").val());
  var checkOut = new Date($('#frmBookNow').find("#txtCheckOutDate").val());

  if (checkIn > checkOut) {
    alertNotif("error", "Check Out date must be greater than Check In date.");
    return false;
  }
  if (parseInt($('#frmBookNow').find('#txtAdults').val()) <= 0) {
    alertNotif("error", "An adult is a must!");
    return false;
  } else if (parseInt($('#frmBookNow').find('#txtAdults').val()) + parseInt($('#frmBookNow').find('#txtAdults').val()) == 0) {
    alertNotif("error", "Please enter a valid number of guests!");
    return false;
  }
  return true;
}

function validateStep2() {
  if (!$('#frmBookNow').find("input[name='rdbRoom']:checked").val()) {
    alertNotif("error", "Please choose a room before proceeding to next step.");
    return false;
  }
  return true;
}