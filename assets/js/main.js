var currentDirectory = location.pathname.includes("nwh") ? "/nwh/" : "/";

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
    $(this).attr('min', tomorrow);
    $(this).val(tomorrow);
  });
  $('.checkInDate').change(function () {
    $(this).closest("form").find(".checkOutDate").attr('min', $(this).val());
    $(this).closest("form").find(".checkOutDate").val($(this).val());
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
    $('html, body').animate({
      scrollTop: $($.attr(this, 'href')).offset().top
    }, 500);

    return false;
  });
});
// PACE DONE
Pace.on('done', function () {
  scrolling(true);

  $(".loadingIcon").fadeOut("slow");
  $('#pace').attr("href", "/css/pace-theme-minimal.css");
  $("html,body").scrollTop(0);

  if (window.location.hash) {
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
  if (type == "success")
    type = "alert-success";
  else if (type == "error")
    type = "alert-danger";
  if (timeout == null)
    timeout = 2000;
  $('#alertBox').html('<div data-notify="container" class="col-xs-11 col-sm-4 alert animated fadeInDown text-center ' + type + '" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; z-index: 1031; top: 20px; left: 0px; right: 0px;"><span data-notify="icon"></span><span data-notify="title"></span><span data-notify="message">' + message + '</span><button type="button" aria-hidden="true" class="close" data-dismiss = "alert" style="position: absolute; right: 10px; top: 20px; margin-top: -13px; z-index: 1033;">×</button></div>');
  $('#alertBox').fadeIn();
  setTimeout(function () {
    $('#alertBox').fadeOut();
    $('#alertBox').html('');
    if (reload == null || !reload)
      return;
    else if (reload)
      location.reload();
    else
      location.href(reload);
  }, timeout);
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
    dateUpdate();
    $("#txtEditRoomID").val('');
    $("#txtEditAdults").val('0');
    $("#txtEditChildrens").val('0');
    $("#btnEditReservation").prop("disabled", true);
    $("#btnPrint").prop("disabled", true);
    return;
  }
  $("#btnEditReservation").prop("disabled", false);
  $("#btnPrint").prop("disabled", false);
  $.ajax({
    url: currentDirectory + "files/displayEditReservation.php",
    type: "POST",
    dataType: "json",
    data: $(this).serialize(),
    success: function (data) {
      $("#txtEditRoomID").val(data[0]);
      $("#txtEditCheckInDate").val(data[1]);
      $("#txtEditCheckOutDate").val(data[2]);
      $("#txtEditAdults").val(data[3]);
      $("#txtEditChildrens").val(data[4]);
    }
  });
});

// CHANGE PASSWORD
$("#frmChange").submit(function (e) {
  e.preventDefault();
  $("#btnUpdate").html('<img src="' + currentDirectory + 'images/btn-ajax-loader.gif" height="20px" width="20px" alt=""/> &nbsp; Updating...');
  $('#btnUpdate').attr('disabled', true);
  $("#lblDisplayErrorChange").html('');
  $.ajax({
    type: 'POST',
    url: currentDirectory + 'files/checkChange.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == "ok") {
        $('#modalChange').modal('hide');
        $('#frmChange').trigger('reset');
        $('#btnUpdate').attr('disabled', false);
        alertNotif("success", "Updated Successfully!", false);
      } else {
        $("#btnUpdate").html('Update');
        $('#btnUpdate').attr('disabled', false);
        $("#lblDisplayErrorChange").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>')
      }
    }
  });
});

// EDIT PROFILE
$("#frmEditProfile").submit(function (e) {
  e.preventDefault();
  $("#btnEditProfile").html('<img src="' + currentDirectory + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating...');
  $('#btnEditProfile').attr('disabled', true);
  $("#lblDisplayErrorEditProfile").html('');
  $.ajax({
    type: 'POST',
    url: currentDirectory + 'files/checkEditProfile.php',
    data: $(this).serialize() + "&profilePic=" + document.getElementById("imgProfilePic").files.length,
    success: function (response) {
      if (response == "ok") {
        if (document.getElementById("imgProfilePic").files.length != 0) {
          var file_data = $('#imgProfilePic').prop('files')[0];
          var form_data = new FormData();
          form_data.append('file', file_data);
          if (file_data.size > 2097152) {
            $("#btnEditProfile").html('Update');
            $('#btnEditProfile').attr('disabled', false);
            $("#lblDisplayErrorEditProfile").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;The file size must under 2MB.</div>');
          } else {
            $.ajax({
              url: currentDirectory + 'files/uploadPicture.php',
              dataType: 'text',
              cache: false,
              contentType: false,
              processData: false,
              data: form_data,
              type: 'POST',
              success: function (responseUpload) {
                if (responseUpload == "ok") {
                  $('#modalEditProfile').modal('hide');
                  alertNotif("success", "Updated Successfully!", true);
                } else {
                  $("#btnEditProfile").html('Update');
                  $('#btnEditProfile').attr('disabled', false);
                  $("#lblDisplayErrorEditProfileEditProfile").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + responseUpload + '</div>');
                }
              }
            });
          }
        } else {
          $('#modalEditProfile').modal('hide');
          $('#frmEditProfile').trigger('reset');
          $('#btnEditProfile').attr('disabled', false);
          alertNotif("success", "Updated Successfully!");
        }
      } else {
        $("#btnEditProfile").html('Update');
        $('#btnEditProfile').attr('disabled', false);
        $("#lblDisplayErrorEditProfileEditProfile").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>')
      }
    }
  });
});

var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];

function ValidateSingleInput(oInput) {
  var file_data = $('#imgProfilePic').prop('files')[0];
  if (file_data.size > 2097152) {
    $('#btnEditProfile').attr('disabled', true);
    $("#lblDisplayErrorEditProfileEditProfile").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;The file size must be under 2MB.</div>');
    return false;
  }
  if (oInput.type == "file") {
    var sFileName = oInput.value;
    if (sFileName.length > 0) {
      var blnValid = false;
      for (var j = 0; j < _validFileExtensions.length; j++) {
        var sCurExtension = _validFileExtensions[j];
        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
          $("#lblDisplayErrorEditProfileEditProfile").html('');
          $('#btnEditProfile').attr('disabled', false);
          blnValid = true;
          break;
        }
      }
      if (!blnValid) {
        $("#lblDisplayErrorEditProfileEditProfile").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;Sorry, your file is invalid, allowed extensions are:' + _validFileExtensions.join(", ") + '</div>');
        $('#btnEditProfile').attr('disabled', true);
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
  $("#btnEditReservation").html('<img src="' + currentDirectory + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating...');
  $('#btnEditReservation').attr('disabled', true);
  $("#lblDisplayErrorEditReservation").html('');
  $.ajax({
    type: 'POST',
    url: currentDirectory + 'files/checkEditReservation.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == "ok") {
        $('#modalEditReservation').modal('hide');
        alertNotif('success', 'Updated Successfully!', false);
      } else {
        $("#btnEditReservation").html('Update');
        $('#btnEditReservation').attr('disabled', false);
        $("#lblDisplayErrorEditReservation").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>')
      }
    }
  });
});

// FORGOT PASSWORD
$("#frmForgot").submit(function (e) {
  e.preventDefault();
  $("#btnReset").html('<img src="' + currentDirectory + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Sending ...');
  $("#btnReset").prop('disabled', true);
  $("#lblDisplayErrorForgot").html('');
  $.ajax({
    type: 'POST',
    url: currentDirectory + 'files/checkForgot.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == "ok") {
        $('#modalForgot').modal('hide');
        $('#frmForgot').trigger('reset');
        alertNotif('success', "Email sent!", true);
      } else {
        $("#btnReset").html('Submit');
        $("#btnReset").prop('disabled', false);
        $("#lblDisplayErrorForgot").html('<div class="alert alert-danger fade in"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>')
      }
    }
  });
});

//REGISTER
$("#frmRegister").submit(function (e) {
  e.preventDefault();
  if (pass != rpass) {
    $("#lblDisplayErrorRegister").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; Password is not the same</div>');
    return;
  }
  var pass = $('#txtPassword', this).val();
  var rpass = $('#txtRetypePassword', this).val();
  $("#btnRegister").html('<img src="' + currentDirectory + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Submitting...');
  $('#btnRegister').attr('disabled', true);
  $("#lblDisplayErrorRegister").html('');
  $.ajax({
    type: 'POST',
    url: currentDirectory + 'files/checkRegister.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == "ok") {
        alertNotif('success', 'Email sent to verify your email!', false, 10000);
        $('#btnRegister').attr('disabled', false);
        $('#frmRegister').trigger('reset');
        $('#modalRegistration').modal('hide');
        $('#btnRegister').html('Register');
        if ($('#txtEmail').val().includes("gmail")) {
          location.href = "gmail.com";
        }
      } else {
        $("#btnRegister").html('Register');
        $('#btnRegister').attr('disabled', false);
        $("#lblDisplayErrorRegister").html('<div class="alert alert-danger fade in"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>')
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
  $("#lblDisplayErrorLogin").html('');
  $("#btnLogin").html('<img src="' + currentDirectory + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Signing In ...');
  $("#btnLogin").prop('disabled', true);
  $.ajax({
    type: 'POST',
    url: currentDirectory + 'files/checkLogin.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == "ok") {
        alertNotif("success", "Login Successfully", true);
      } else {
        $("#btnLogin").html('Sign In');
        $("#btnLogin").prop('disabled', false);
        $("#lblDisplayErrorLogin").html('<div class="alert alert-danger fade in"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>')
      }
    }
  });
});

// BOOK NOW FORM
$("#frmBookNow").submit(function (e) {
  e.preventDefault();
  $(this).closest("form").find("#btnBookNow").html('<img src=images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Booking...');
  $(this).closest("form").find("#btnBookNow").prop('disabled', true);
  setTimeout("location.href='roomandrates?" + $(this).serialize() + "'", 2000);
});

// CONTACT US FORM
$('#frmContact').submit(function (e) {
  e.preventDefault();
  if (!$('#txtEmail').val().includes('@') || !$('#txtEmail').val().includes('.')) {
    alertNotif("error", "Invalid Format of Email Address", false);
    $('#txtEmail').focus();
    return;
  }
  $("#btnSubmit").html('<img src="' + currentDirectory + 'images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Sending ...');
  $("#btnSubmit").prop('disabled', true);
  $.ajax({
    type: 'POST',
    url: currentDirectory + 'files/processContactForm.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == "ok") {
        alertNotif("success", "Sent Successfully", false);
        $('#frmContact').trigger("reset");
        $('.contactbox').toggleClass('contactbox--tray');
      } else {
        alertNotif("error", response, false);
      }
      $("#btnSubmit").html('Send');
      $("#btnSubmit").prop('disabled', false);
    }
  });
})