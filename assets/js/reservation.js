$(document).ready(function () {
  $('.setup-content').hide();

  $('div.setup-panel div a').click(function (e) {
    e.preventDefault();
    if (!$(this).hasClass('disabled')) {
      $('div.setup-panel div a').removeClass('btn-primary').addClass('btn-default');
      $(this).addClass('btn-primary');
      $('.setup-content').hide();
      $($(this).attr('href')).fadeIn();
      $($(this).attr('href')).find('input:eq(0)').focus();
    }
  });

  $('.nextBtn').click(function () {
    $(this).html('<img src="' + root + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Submitting ...');
    $(this).prop('disabled', true);
    var step = $(this).closest(".setup-content").attr("id");
    $('#stepID').val(parseInt(step[step.length - 1]) + 1);
    if ($(this).closest(".setup-content").attr("id") == 'step-1' && !validateStep1()) {
      $(this).html('Next');
      $(this).prop('disabled', false);
      return;
    } else if ($(this).closest(".setup-content").attr("id") == 'step-2') {
      if (!validateStep2()) {
        $(this).html('Next');
        $(this).prop('disabled', false);
        return;
      }
      $.ajax({
        type: 'POST',
        url: root + 'files/checkRoomAvailability.php',
        data: $('#frmBookNow').serialize(),
        success: function (response) {
          $('#txtRoomID').val(response);
          location.href = root + 'reservation/?' + $('#frmBookNow').serialize();
        }
      });
      return;
    }
    location.href = root + 'reservation/?' + $('#frmBookNow').serialize();
  });

  if (location.href.includes("step=3")) {
    $('div.setup-panel div a[href="#step-3"]').click();
    $('a[href="#step-2"').attr("disabled", false);
  } else if (location.href.includes("txtBookingID")) {
    $('div.setup-panel div a[href="#step-4"]').click();
    $('a[href="#step-1"').attr("disabled", true);
    $('a[href="#step-2"').attr("disabled", true);
    $('a[href="#step-3"').attr("disabled", true);
  } else if (location.href.includes("step=2") || location.href.includes("txtCheckInDate") || location.href.includes("txtCheckOutDate")) {
    $('div.setup-panel div a[href="#step-2"]').click();
  } else {
    $('#step-1').fadeIn();
  }

  $('#step-1 input').keydown(function () {
    $('a[href="#step-2"').attr("disabled", true);
    $('a[href="#step-3"').attr("disabled", true);
    $('a[href="#step-4"').attr("disabled", true);
  });
  $('#step-2 input').keydown(function () {
    $('a[href="#step-3"').attr("disabled", true);
    $('a[href="#step-4"').attr("disabled", true);
  });
  $('#step-3 input').keydown(function () {
    $('a[href="#step-4"').attr("disabled", true);
  });
});

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
$('input[type="checkbox"]').on('change', function () {
  $('input[type="checkbox"]').not(this).prop('checked', false);
});