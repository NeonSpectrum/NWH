$(document).ready(function () {
  scrolling(false);
  if (screen.width <= 480) {
    $('.contactbox').fadeOut();
  }
  // RESET FORM IF EXISTS IF MODAL IS EXITED
  $('.modal').on('hidden.bs.modal', function () {
    $(this).find('form')[0].reset();
    $(this).find('button').attr('disabled', false);
    $(this).find('.lblDisplayError').html('');
    $(this).find('#g-recaptcha-response').val('');
    // scrolling(true);
  });

  // DISABLE SCROLL IF MODAL IS SHOWN
  $('.modal').on('shown.bs.modal', function () {
    // scrolling(false);
  });

  // AUTO ENABLE DISABLED BUTTON IF THE TEXTBOX HAS VALUE
  $("input[type=text]").change(function () {
    if ($(this).val()) {
      $(this).closest('form').find("button").removeAttr('disabled');
    }
  });

  // FOCUS ON SELECT
  $('input').focus(function () {
    if (!($(this).attr("class").includes("check") && $(this).attr("class").includes("Date"))) {
      $(this).select();
    }
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
    if ($(window).width() > 480) {
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

  // ADD SLIDEDOWN ANIMATION TO DROPDOWN //
  $('.dropdown').on('show.bs.dropdown', function (e) {
    if ($(window).width() > 480) {
      $(this).find('.dropdown-menu').first().stop(true, true).slideDown("fast");
    }
    $(this).find("#txtEmail").focus();
  });

  // ADD SLIDEUP ANIMATION TO DROPDOWN //
  $('.dropdown').on('hidden.bs.dropdown', function (e) {
    if ($(window).width() > 480) {
      var me = this;
      $(this).find('.dropdown-menu').first().stop(true, true).slideUp("fast", function () {
        $(me).removeClass('open');
        $(me).find('.dropdown-toggle').attr('aria-expanded', 'false');
      });
    }
    $(this).find(".lblDisplayError").html("");
    $(this).find("form").trigger("reset");
    updateDate();
  });
});
// PACE DONE
Pace.on('done', function () {
  scrolling(true);
  $("html,body").scrollTop(0);
  $(".loadingIcon").fadeOut("slow");
  $('#pace').attr("href", $('#pace').attr("href").replace("pace-theme-center-simple", "pace-theme-minimal"));

  // WOW SETTINGS
  new WOW({
    offset: 40
  }).init();

  // DATE PICKER SETTINGS
  $('input.checkInDate, input.checkOutDate').datepicker({
    format: "yyyy-mm-dd",
    startDate: '+1d',
    autoclose: true,
    todayHighlight: true
  });

  // DATE PICKER SCRIPTS
  updateDate();
  $('input.checkInDate, input.checkOutDate').each(function () {
    if ($(this).val()) {
      $(this).datepicker('update', $(this).val());
    }
  });
  $('input.checkInDate').change(function () {
    $(this).closest("form").find(".checkOutDate").datepicker('update', $(this).val());
    $(this).closest("form").find(".checkOutDate").datepicker('setStartDate', $(this).val())
  });

  // ANIMATE TO HASH
  if (window.location.hash && $(window.location.hash).offset() != null) {
    $('html, body').animate({
      scrollTop: screen.width > 480 ? $(window.location.hash).offset().top - 60 : $(window.location.hash).offset().top - 10 + 'px'
    }, 1000, 'swing');
  }

  // BACK TO TOP
  $(window).scroll(function () {
    // BACK TO TOP  
    if ($(window).scrollTop() > 300) {
      $('a.back-to-top').fadeIn('slow');
    } else {
      $('a.back-to-top').fadeOut('slow');
    }
  });
});

$(window).on('resize', function () {
  $('.loadingIcon').height($(window).height());
  if (screen.width <= 480) {
    $('.navbar').removeClass("navbar-fixed-top");
    $("body").css("background-position", "50% 0px");
    $('.contactbox').fadeOut();
  } else {
    $('.navbar').addClass("navbar-fixed-top");
    $('.contactbox').fadeIn();
  }
});

// RUN BAGUETTEBOX
baguetteBox.run('.img-baguette', {
  animation: 'fadeIn',
  fullscreen: true
});

// UPDATE ALL DATES
function updateDate() {
  var date = new Date();
  var tomorrow = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 1);
  $(".checkInDate, .checkOutDate").each(function () {
    if (!$(this).attr("value")) {
      $(this).datepicker("setDate", tomorrow);
    }
  });
}
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
    context: this,
    url: root + 'ajax/cmbBookingIdDisplay.php',
    type: "POST",
    dataType: "json",
    data: $(this).serialize(),
    success: function (response) {
      console.log("hi");
      $(this).closest("form").find("#txtRoomID").val(response[0]);
      $(this).closest("form").find("#txtCheckInDate").val(response[1]);
      $(this).closest("form").find("#txtCheckOutDate").val(response[2]);
      $(this).closest("form").find("#txtAdults").val(response[3]);
      $(this).closest("form").find("#txtChildrens").val(response[4]);
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
    url: root + 'ajax/changePassword.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response) {
        $('#modalChange').modal('hide');
        $(this).find('#frmChange').trigger('reset');
        $(this).find('#btnUpdate').attr('disabled', false);
        alertNotif("success", "Updated Successfully!");
      } else {
        $(this).find("#btnUpdate").html('Update');
        $(this).find('#btnUpdate').attr('disabled', false);
        $(this).find(".lblDisplayError").show(function () {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>');
        });
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
    url: root + 'ajax/editProfile.php',
    data: $(this).serialize() + "&profilePic=" + document.getElementById("imgProfilePic").files.length,
    success: function (response) {
      if (response) {
        if (document.getElementById("imgProfilePic").files.length != 0) {
          var file_data = $('#imgProfilePic').prop('files')[0];
          var form_data = new FormData();
          form_data.append('file', file_data);
          if (file_data.size > 2097152) {
            $(this).find("#btnEditProfile").html('Update');
            $(this).find('#btnEditProfile').attr('disabled', false);
            $(this).find(".lblDisplayError").show(function () {
              $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;The file size must under 2MB.</div>');
            });
          } else {
            $.ajax({
              url: root + 'ajax/uploadPicture.php',
              dataType: 'text',
              cache: false,
              contentType: false,
              processData: false,
              data: form_data,
              context: this,
              type: 'POST',
              success: function (responseUpload) {
                if (responseUpload) {
                  $('#modalEditProfile').modal('hide');
                  alertNotif("success", "Updated Successfully!", true);
                } else {
                  $(this).find("#btnEditProfile").html('Update');
                  $(this).find('#btnEditProfile').attr('disabled', false);
                  $(this).find(".lblDisplayError").show(function () {
                    $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + responseUpload + '</div>');
                  });
                }
              }
            });
          }
        } else {
          $('#modalEditProfile').modal('hide');
          $(this).find('#frmEditProfile').trigger('reset');
          alertNotif("success", "Updated Successfully!", true);
        }
      } else {
        $(this).find("#btnEditProfile").html('Update');
        $(this).find('#btnEditProfile').attr('disabled', false);
        $(this).find(".lblDisplayError").show(function () {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>');
        });
      }
    }
  });
});

var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];

function ValidateSingleInput(oInput) {
  var file_data = $('#imgProfilePic').prop('files')[0];
  if (file_data.size > 2097152) {
    $(this).find('#btnEditProfile').attr('disabled', true);
    $(this).find(".lblDisplayError").show(function () {
      $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;The file size must be under 2MB.</div>');
    });
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
        $(this).find(".lblDisplayError").show(function () {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;Sorry, your file is invalid, allowed extensions are:' + _validFileExtensions.join(", ") + '</div>');
        });
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
    url: root + 'ajax/editReservation.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response) {
        $('#modalEditReservation').modal('hide');
        alertNotif('success', 'Updated Successfully!', false);
      } else {
        $(this).find("#btnEditReservation").html('Update');
        $(this).find('#btnEditReservation').attr('disabled', false);
        $(this).find(".lblDisplayError").show(function () {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>');
        })
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
    url: root + 'ajax/forgotPassword.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response) {
        $('#modalForgot').modal('hide');
        $('#frmForgot').trigger('reset');
        alertNotif('success', "Email sent!", true);
      } else {
        $(this).find("#btnReset").html('Submit');
        $(this).find("#btnReset").prop('disabled', false);
        $(this).find(".lblDisplayError").show(function () {
          $(this).html('<div class="alert alert-danger animated bounceIn"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>');
        });
      }
    }
  });
});

//REGISTER
$("#frmRegister").submit(function (e) {
  e.preventDefault();
  var pass = $(this).find('#txtPassword').val();
  var rpass = $(this).find('#txtRetypePassword').val();
  if (pass != rpass) {
    $(this).find(".lblDisplayError").show(function () {
      $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; ' + VERIFY_PASSWORD_ERROR + '</div>');
    });
    $(this).find("#txtPassword").focus();
    return;
  }
  $(this).find("#btnRegister").html('<img src="' + root + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Submitting...');
  $(this).find('#btnRegister').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  console.log("hello");
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/register.php',
    data: $(this).serialize(),
    success: function (response) {
      console.log("hi");
      if (response) {
        alertNotif('success', 'Email sent to verify your email!', false, 10000);
        $(this).find('#btnRegister').attr('disabled', false);
        $(this).find('#frmRegister').trigger('reset');
        $('#modalRegistration').modal('hide');
        $(this).find('#btnRegister').html('Register');
      } else {
        $(this).find("#btnRegister").html('Register');
        $(this).find('#btnRegister').attr('disabled', false);
        $(this).find(".lblDisplayError").show(function () {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>');
        });
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
  $(this).find("#btnLogin").attr('disabled', true);
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/login.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response) {
        alertNotif("success", "Login Successfully", true);
      } else {
        $(this).find("#btnLogin").html('Sign In');
        $(this).find("#btnLogin").attr('disabled', false);
        $(this).find(".lblDisplayError").show(function () {
          $(this).html('<div class="alert alert-danger animated bounceIn"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>');
        });
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
    url: root + 'ajax/contactForm.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == true) {
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