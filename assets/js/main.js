var root = location.pathname.includes("nwh") ? "/nwh/" : "/";

$(document).ready(function () {
  scrolling(false);

  // MAKE NAVBAR FIXED IF NOT MOBILE
  if (screen.width > 480) {
    $('.navbar').addClass("navbar-fixed-top");
  }

  // UPDATE ALL DATES
  var tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  tomorrow = new Date(tomorrow).toISOString().split('T')[0];;
  $(".checkInDate, .checkOutDate").each(function () {
    if (!$(this).attr("value")) {
      $(this).attr('min', tomorrow);
      $(this).val(tomorrow);
    }
  });
  $('.checkInDate').change(function () {
    if (!$(this).attr("value")) {
      $(this).closest("form").find(".checkOutDate").attr('min', $(this).val());
      $(this).closest("form").find(".checkOutDate").val($(this).val());
    }
  });

  // RESET FORM IF EXISTS IF MODAL IS EXITED
  $('.modal').on('hidden.bs.modal', function () {
    $(this).find('form')[0].reset();
    $(this).find('button').attr('disabled', false);
    $(this).find('.lblDisplayError').html('');
    $(this).find('#g-recaptcha-response').val('');
    scrolling(true);
  });

  // DISABLE SCROLL IF MODAL IS SHOWN
  $('.modal').on('shown.bs.modal', function () {
    scrolling(false);
  });

  // AUTO ENABLE DISABLED BUTTON IF THE TEXTBOX HAS VALUE
  $("input[type=text]").change(function () {
    if ($(this).val()) {
      $(this).find('button').removeAttr('disabled');
    }
  });
  // FOCUS ON SELECT
  $('input').focus(function () {
    $(this).select();
  });

  // MAKE NUMBER RESET TO MIN OR MAX WHEN LEAVE
  $('input[type=number]').on('keyup keydown', function (e) {
    var min = parseInt($(this).attr("min"));
    var max = parseInt($(this).attr("max"));

    if ($(this).val() > max &&
      e.keyCode != 46 &&
      e.keyCode != 8
    ) {
      e.preventDefault();
      $(this).val(max);
    }
  });

  // CONTACT BOX
  $('.contactbox__title').on('click', function () {
    $('.contactbox').toggleClass('contactbox--tray');
  });
  $('.contactbox').on('transitionend', function () {
    if ($(this).hasClass('contactbox--closed')) $(this).remove();
  });

  // BACK TO TOP
  $('a.back-to-top, a.simple-back-to-top').click(function () {
    $('html, body').animate({
      scrollTop: 0
    }, 700);
    return false;
  });

  // CLICKING ON HREF WITH # WILL ANIMATE TO THAT HASH
  $('a[href^="#"]').click(function () {
    if (window.width > 480) {
      $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top - 60
      }, 500);
    } else {
      $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top - 10
      }, 500);
    }
    return false;
  });

  // ANIMATE DROPDOWN
  // Add slideDown animation to Bootstrap dropdown when expanding.
  $('.dropdown').on('show.bs.dropdown', function () {
    $(this).find('.dropdown-menu').first().stop(true, true).slideDown("fast");
  });

  // Add slideUp animation to Bootstrap dropdown when collapsing.
  $('.dropdown').on('hide.bs.dropdown', function () {
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp("fast");
  });
});
// PACE DONE
Pace.on('done', function () {
  scrolling(true);
  $(".loadingIcon").fadeOut("slow");
  $('#pace').attr("href", $('#pace').attr("href").replace("pace-theme-center-simple", "pace-theme-minimal"));
  $("html,body").scrollTop(0);

  if (window.location.hash && $(window.location.hash).offset() != null) {
    $('html, body').animate({
      scrollTop: screen.width > 480 ? $(window.location.hash).offset().top - 60 : $(window.location.hash).offset().top - 10 + 'px'
    }, 1000, 'swing');
  }

  $(window).scroll(function () {

    // BACK TO TOP
    if ($(window).scrollTop() > 300) {
      $('a.back-to-top').fadeIn('slow');
    } else {
      $('a.back-to-top').fadeOut('slow');
    }

    // SCROLL EFFECT ON DESKTOP AND LAPTOP DEVICES
    if (screen.width > 480) {
      $("body").css("background-position", "50% " + (-($(this).scrollTop() / 10) - 100) + "px");
    }

    // SCROLL ANIMATION
    var winTop = $(window).scrollTop();
    var height = $(window).height() - 40;

    $(".scrollSlideUp").each(function () {
      if ($(this).offset().top < winTop + height) {
        $(this).removeClass("scrollSlideUp");
        $(this).addClass("slideInUp");
      }
    });
    $(".scrollSlideDown").each(function () {
      if ($(this).offset().top < winTop + height) {
        $(this).removeClass("scrollSlideDown");
        $(this).addClass("slideInDown");
      }
    });
    $(".scrollSlideLeft").each(function () {
      if ($(this).offset().top < winTop + height) {
        $(this).removeClass("scrollSlideLeft");
        $(this).addClass("slideInLeft");
      }
    });
    $(".scrollSlideRight").each(function () {
      if ($(this).offset().top < winTop + height) {
        $(this).removeClass("scrollSlideRight");
        $(this).addClass("slideInRight");
      }
    });
  });
});

$(window).on('resize', function () {
  if (screen.width <= 480) {
    $('.navbar').removeClass("navbar-fixed-top");
    $("body").css("background-position", "50% 0px");
  } else {
    $('.navbar').addClass("navbar-fixed-top");
  }
});

// RUN BAGUETTEBOX
baguetteBox.run('.img-baguette', {
  animation: 'fadeIn',
  fullscreen: true
});

// DISABLEKEY FUNCTION
function disableKey(evt, key) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (key == 'number') {
    if (charCode > 31 && (charCode > 48 || charCode < 57))
      return false;
    return true;
  } else if (key == 'letter') {
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
    return true;
  } else {
    return true;
  }
}

// ALERTNOTIF FUNCTION
function alertNotif(type, message, reload, timeout) {
  $.notify({
    icon: "glyphicon glyphicon-exclamation-sign",
    message: "<div style='text-align:center;margin-top:-20px'>" + message + "</div>"
  }, {
    type: type == 'error' ? 'danger' : type,
    placement: {
      from: "top",
      align: "center"
    },
    newest_on_top: true,
    mouse_over: true,
    delay: message.length > 100 ? 0 : 3000
  });
  setTimeout(function () {
    if (reload == null || !reload)
      return;
    else if (reload)
      location.reload();
    else
      location.href(reload);
  }, timeout != null ? timeout : 2000);
}

// CAPSLOCK FUNCTION
function capsLock(e) {
  var kc = e.keyCode ? e.keyCode : e.which;
  var sk = e.shiftKey ? e.shiftKey : kc === 16;
  var display = ((kc >= 65 && kc <= 90) && !sk) ||
    ((kc >= 97 && kc <= 122) && sk) ? 'block' : 'none';
  document.getElementById('caps').style.display = display;
}

// SCROLLING FUNCTION
function scrolling(enable) {
  if (!enable) {
    $('body').bind('DOMMouseScroll.prev mousewheel.prev', function (e) {
      e.preventDefault();
    });
  } else {
    $('body').unbind('DOMMouseScroll.prev mousewheel.prev');
  }
}

// DISPLAY BOOKING ID
$("#cmbBookingID").change(function () {
  if ($("#cmbBookingID").val() == '') {
    $(this).closest("form").find("#txtRoomID").val('');
    $(this).closest("form").find("#txtAdults").val('0');
    $(this).closest("form").find("#txtChildrens").val('0');
    $(this).closest("form").find("#btnEditReservation").prop("disabled", true);
    $(this).closest("form").find("#btnPrint").prop("disabled", true);
    return;
  }
  $(this).closest("form").find("#btnEditReservation").prop("disabled", false);
  $(this).closest("form").find("#btnPrint").prop("disabled", false);
  $.ajax({
    url: root + "files/displayEditReservation.php",
    context: this,
    type: "POST",
    dataType: "json",
    data: $(this).serialize(),
    success: function (data) {
      $(this).closest("form").find("#txtRoomID").val(data[0]);
      $(this).closest("form").find("#txtCheckInDate").val(data[1]);
      $(this).closest("form").find("#txtCheckOutDate").val(data[2]);
      $(this).closest("form").find("#txtAdults").val(data[3]);
      $(this).closest("form").find("#txtChildrens").val(data[4]);
    }
  });
});

// CHANGE PASSWORD
$("#frmChange").submit(function (e) {
  e.preventDefault();
  $(this).find("#btnUpdate").html('<img src="' + root + 'images/btn-ajax-loader.gif" height="20px" width="20px" alt=""/> &nbsp; Updating...');
  $(this).find('#btnUpdate').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'files/checkChange.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == "ok") {
        $('#modalChange').modal('hide');
        $(this).find('#frmChange').trigger('reset');
        $(this).find('#btnUpdate').attr('disabled', false);
        alertNotif("success", "Updated Successfully!", false);
      } else {
        $(this).find("#btnUpdate").html('Update');
        $(this).find('#btnUpdate').attr('disabled', false);
        $(this).find(".lblDisplayError").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>')
      }
    }
  });
});

// EDIT PROFILE
$("#frmEditProfile").submit(function (e) {
  e.preventDefault();
  $(this).find("#btnEditProfile").html('<img src="' + root + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating...');
  $(this).find('#btnEditProfile').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'files/checkEditProfile.php',
    data: $(this).serialize() + "&profilePic=" + document.getElementById("imgProfilePic").files.length,
    success: function (response) {
      if (response == "ok") {
        if (document.getElementById("imgProfilePic").files.length != 0) {
          var file_data = $('#imgProfilePic').prop('files')[0];
          var form_data = new FormData();
          form_data.append('file', file_data);
          if (file_data.size > 2097152) {
            $(this).find("#btnEditProfile").html('Update');
            $(this).find('#btnEditProfile').attr('disabled', false);
            $(this).find(".lblDisplayError").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;The file size must under 2MB.</div>');
          } else {
            $.ajax({
              url: root + 'files/uploadPicture.php',
              dataType: 'text',
              cache: false,
              contentType: false,
              processData: false,
              data: form_data,
              context: this,
              type: 'POST',
              success: function (responseUpload) {
                if (responseUpload == "ok") {
                  $('#modalEditProfile').modal('hide');
                  alertNotif("success", "Updated Successfully!", true);
                } else {
                  $(this).find("#btnEditProfile").html('Update');
                  $(this).find('#btnEditProfile').attr('disabled', false);
                  $(this).find(".lblDisplayError").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + responseUpload + '</div>');
                }
              }
            });
          }
        } else {
          $('#modalEditProfile').modal('hide');
          $(this).find('#frmEditProfile').trigger('reset');
          $(this).find('#btnEditProfile').attr('disabled', false);
          alertNotif("success", "Updated Successfully!");
        }
      } else {
        $(this).find("#btnEditProfile").html('Update');
        $(this).find('#btnEditProfile').attr('disabled', false);
        $(this).find(".lblDisplayError").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>')
      }
    }
  });
});

var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];

function ValidateSingleInput(oInput) {
  var file_data = $('#imgProfilePic').prop('files')[0];
  if (file_data.size > 2097152) {
    $(this).find('#btnEditProfile').attr('disabled', true);
    $(this).find(".lblDisplayError").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;The file size must be under 2MB.</div>');
    return false;
  }
  if (oInput.type == "file") {
    var sFileName = oInput.value;
    if (sFileName.length > 0) {
      var blnValid = false;
      for (var j = 0; j < _validFileExtensions.length; j++) {
        var sCurExtension = _validFileExtensions[j];
        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
          $(this).find(".lblDisplayError").html('');
          $(this).find('#btnEditProfile').attr('disabled', false);
          blnValid = true;
          break;
        }
      }
      if (!blnValid) {
        $(this).find(".lblDisplayError").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;Sorry, your file is invalid, allowed extensions are:' + _validFileExtensions.join(", ") + '</div>');
        $(this).find('#btnEditProfile').attr('disabled', true);
        oInput.value = "";
        return false;
      }
    }
  }
  return true;
}

// EDIT RESERVATION
$("#frmEditReservation").submit(function (e) {
  e.preventDefault();
  $(this).find("#btnEditReservation").html('<img src="' + root + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating...');
  $(this).find('#btnEditReservation').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'files/checkEditReservation.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == "ok") {
        $('#modalEditReservation').modal('hide');
        alertNotif('success', 'Updated Successfully!', false);
      } else {
        $(this).find("#btnEditReservation").html('Update');
        $(this).find('#btnEditReservation').attr('disabled', false);
        $(this).find(".lblDisplayError").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>')
      }
    }
  });
});

// FORGOT PASSWORD
$("#frmForgot").submit(function (e) {
  e.preventDefault();
  $(this).find("#btnReset").html('<img src="' + root + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Sending ...');
  $(this).find("#btnReset").prop('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'files/checkForgot.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == "ok") {
        $('#modalForgot').modal('hide');
        $('#frmForgot').trigger('reset');
        alertNotif('success', "Email sent!", true);
      } else {
        $(this).find("#btnReset").html('Submit');
        $(this).find("#btnReset").prop('disabled', false);
        $(this).find(".lblDisplayError").html('<div class="alert alert-danger fade in"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>')
      }
    }
  });
});

//REGISTER
$("#frmRegister").submit(function (e) {
  e.preventDefault();
  if (pass != rpass) {
    $(this).find(".lblDisplayError").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; Password is not the same</div>');
    return;
  }
  var pass = $(this).find('#txtPassword', this).val();
  var rpass = $(this).find('#txtRetypePassword', this).val();
  $(this).find("#btnRegister").html('<img src="' + root + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Submitting...');
  $(this).find('#btnRegister').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'files/checkRegister.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == "ok") {
        alertNotif('success', 'Email sent to verify your email!', false, 10000);
        $(this).find('#btnRegister').attr('disabled', false);
        $(this).find('#frmRegister').trigger('reset');
        $('#modalRegistration').modal('hide');
        $(this).find('#btnRegister').html('Register');
        if ($(this).find('#txtEmail').val().includes("gmail")) {
          location.href = "gmail.com";
        }
      } else {
        $(this).find("#btnRegister").html('Register');
        $(this).find('#btnRegister').attr('disabled', false);
        $(this).find(".lblDisplayError").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>')
      }
    }
  });
});

function recaptchaCallback() {
  $('#btnRegister').removeAttr('disabled');
}

// LOGIN
$("#frmLogin").submit(function (e) {
  e.preventDefault();
  $(this).find(".lblDisplayError").html('');
  $(this).find("#btnLogin").html('<img src="' + root + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Signing In ...');
  $(this).find("#btnLogin").prop('disabled', true);
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'files/checkLogin.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == "ok") {
        alertNotif("success", "Login Successfully", true);
      } else {
        $(this).find("#btnLogin").html('Sign In');
        $(this).find("#btnLogin").prop('disabled', false);
        $(this).find(".lblDisplayError").html('<div class="alert alert-danger fade in"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>')
      }
    }
  });
});

// BOOK NOW BUTTON
$('.frmBookCheck').submit(function (e) {
  e.preventDefault();
  var checkIn = new Date($(this).find("#txtCheckInDate").val());
  var checkOut = new Date($(this).find("#txtCheckOutDate").val());

  if (checkIn > checkOut) {
    alertNotif("error", "Check Out date must be greater than Check In date.");
    return;
  }
  if (parseInt($(this).find('#txtAdults').val()) + parseInt($(this).find('#txtAdults').val()) == 0) {
    alertNotif("error", "Please enter a valid number of guests!");
    return;
  }

  $(this).find("#btnBookNow").html('<img src="' + root + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Booking...');
  $(this).find("#btnBookNow").prop('disabled', true);

  location.href = root + "reservation/?" + $(this).serialize();
});

// BOOK NOW FORM
$("#frmBookNow").submit(function (e) {
  e.preventDefault();
  $(this).find("#btnBookNow").html('<img src="' + root + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Submitting ...');
  $(this).find("#btnBookNow").prop('disabled', true);
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'files/submitBookNow.php',
    data: $(this).serialize(),
    success: function (response) {
      $('#stepID').val('4');
      location.href = root + "reservation/?" + $("#frmBookNow").serialize() + "&txtBookingID=" + response;
    }
  });
});

// CONTACT US FORM
$('#frmContact').submit(function (e) {
  e.preventDefault();
  if (!$(this).find('#txtEmail').val().includes('@') || !$(this).find('#txtEmail').val().includes('.')) {
    alertNotif("error", "Invalid Format of Email Address", false);
    $('#txtEmail').focus();
    return;
  }
  $(this).find("#btnSubmit").html('<img src="' + root + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Sending ...');
  $(this).find("#btnSubmit").prop('disabled', true);
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'files/processContactForm.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == "ok") {
        alertNotif("success", "Sent Successfully", false);
        $(this).trigger("reset");
        $(this).parent().toggleClass('contactbox--tray');
      } else {
        alertNotif("error", response, false);
      }
      $(this).find("#btnSubmit").html('Send');
      $(this).find("#btnSubmit").prop('disabled', false);
    }
  });
})