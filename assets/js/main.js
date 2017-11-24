$(document).ready(function () {
  scrolling(false);

  if (screen.width > 480) {
    $('.navbar').addClass("navbar-fixed-top");
  }
  // reset form if exists if modal is exited
  $('.modal').on('hidden.bs.modal', function () {
    $(this).find('form')[0].reset();
    $(this).find('button').attr('disabled', false);
    $(this).find('.lblDisplayError').html('');
    $(this).find('#g-recaptcha-response').val('');
    scrolling(true);
  });

  // disable scroll if modal is shown
  $('.modal').on('shown.bs.modal', function () {
    scrolling(false);
  });

  // auto enable disabled button if the textbox has value
  $("input[type=text]").change(function () {
    if ($(this).val()) {
      $(this).find('button').removeAttr('disabled');
    }
  });

  // make number reset to min or max when leave
  $('input[type=number]').change(function () {
    var min = parseInt($(this).attr("min"));
    var max = parseInt($(this).attr("max"));

    if ($(this).val() > max) {
      $(this).val(max);
    } else if ($(this).val() < min) {
      $(this).val(min);
    }
  });

  // BACK TO TOP
  $('a.back-to-top, a.simple-back-to-top').click(function () {
    $('html, body').animate({
      scrollTop: 0
    }, 700);
    return false;
  });

  $('a[href^="#"]').click(function () {
    $('html, body').animate({
      scrollTop: $($.attr(this, 'href')).offset().top
    }, 500);

    return false;
  });
});

$(window).on("load", function () {
  scrolling(true);

  $(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
      $('a.back-to-top').fadeIn('slow');
    } else {
      $('a.back-to-top').fadeOut('slow');
    }

    if (screen.width > 480) {
      $(window).scroll(function () {
        $("body").css("background-position", "50% " + (-($(this).scrollTop() / 10) - 100) + "px");
      });
    }

    $(".scrollSlideUp").each(function () {
      var pos = $(this).offset().top;
      var winTop = $(window).scrollTop();
      var height = $(window).height() - 40;
      if (pos < winTop + height) {
        $(this).removeClass("scrollSlideUp");
        $(this).addClass("slideInUp");
      }
    });

    $(".scrollSlideDown").each(function () {
      var pos = $(this).offset().top;
      var winTop = $(window).scrollTop();
      var height = $(window).height() - 40;
      if (pos < winTop + height) {
        $(this).removeClass("scrollSlideDown");
        $(this).addClass("slideInDown");
      }
    });

    $(".scrollSlideLeft").each(function () {
      var pos = $(this).offset().top;
      var winTop = $(window).scrollTop();
      var height = $(window).height() - 40;
      if (pos < winTop + height) {
        $(this).removeClass("scrollSlideLeft");
        $(this).addClass("slideInLeft");
      }
    });

    $(".scrollSlideRight").each(function () {
      var pos = $(this).offset().top;
      var winTop = $(window).scrollTop();
      var height = $(window).height() - 40;
      if (pos < winTop + height) {
        $(this).removeClass("scrollSlideRight");
        $(this).addClass("slideInRight");
      }
    });
  });
});

$(window).on('resize', function () {
  if (screen.width <= 480) {
    $('.navbar').removeClass("navbar-fixed-top");
    $('#txtLoginEmail,#txtLoginPassword').click(function () {
      $('.navbar').removeClass("navbar-fixed-top");
      $('body').css("padding-top", "0px");
      $("html, body").animate({
        scrollTop: 230
      }, "slow");
    });
    $('.login-dropdown').on('hide.bs.dropdown', function () {
      $('.navbar').addClass("navbar-fixed-top");
    });
    $("body").css("background-position", "50% 0px");
  } else {
    $('.navbar').addClass("navbar-fixed-top");
  }
});

// PACE DONE
Pace.on('done', function () {
  $(".loadingIcon").fadeOut("slow");
  $('#pace').attr("href", "/css/pace-theme-minimal.css");
  $("html,body").scrollTop(0);

  if (window.location.hash) {
    $('html, body').animate({
      scrollTop: screen.width > 480 ? $(window.location.hash).offset().top - 60 : $(window.location.hash).offset().top - 10 + 'px'
    }, 1000, 'swing');
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
$(document).ready(function () {
  var tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  tomorrow = new Date(tomorrow).toISOString().split('T')[0];
  $('#txtEditCheckInDate').attr('min', tomorrow);
  $('#txtEditCheckOutDate').attr('min', tomorrow);
  $('#txtEditCheckInDate').val(tomorrow);
  $('#txtEditCheckOutDate').val(tomorrow);
  dateUpdate();
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
      url: "/files/displayEditReservation.php",
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
});

// UPDATE DATE
$('#txtEditCheckInDate').change(function () {
  $('#txtEditCheckOutDate').attr('min', $(this).val());
  $('#txtEditCheckOutDate').val($(this).val());
});

$('#txtEditCheckOutDate').change(function () {
  checkIn = $('#txtEditCheckInDate').val();
  $('#txtEditCheckInDate').attr('max', checkIn == checkOut ? checkOut = '' : $(this).val());
});

function dateUpdate() {
  var tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  tomorrow = new Date(tomorrow).toISOString().split('T')[0];;
  $('#txtEditCheckInDate').attr('min', tomorrow);
  $('#txtEditCheckOutDate').attr('min', tomorrow);
  $('#txtEditCheckInDate').val(tomorrow);
  $('#txtEditCheckOutDate').val(tomorrow);
}

// CHANGE PASSWORD
$("#frmChange").submit(function (e) {
  e.preventDefault();
  $("#btnUpdate").html('<img src="/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating...');
  $('#btnUpdate').attr('disabled', true);
  $("#lblDisplayErrorChange").html('');
  $.ajax({
    type: 'POST',
    url: '/files/checkChange.php',
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
  $("#btnEditProfile").html('<img src="/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating...');
  $('#btnEditProfile').attr('disabled', true);
  $("#lblDisplayErrorEditProfile").html('');
  $.ajax({
    type: 'POST',
    url: '/files/checkEditProfile.php',
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
              url: '/files/uploadPicture.php',
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
  $("#btnEditReservation").html('<img src="/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Updating...');
  $('#btnEditReservation').attr('disabled', true);
  $("#lblDisplayErrorEditReservation").html('');
  $.ajax({
    type: 'POST',
    url: '/files/checkEditReservation.php',
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
  $("#btnReset").html('<img src="/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Sending ...');
  $("#btnReset").prop('disabled', true);
  $("#lblDisplayErrorForgot").html('');
  $.ajax({
    type: 'POST',
    url: '/files/checkForgot.php',
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
  $("#btnRegister").html('<img src="/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Submitting...');
  $('#btnRegister').attr('disabled', true);
  $("#lblDisplayErrorRegister").html('');
  $.ajax({
    type: 'POST',
    url: '/files/checkRegister.php',
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
  $("#btnLogin").html('<img src="/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Signing In ...');
  $("#btnLogin").prop('disabled', true);
  $.ajax({
    type: 'POST',
    url: '/files/checkLogin.php',
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

// CONTACT US FORM
$('#frmContact').submit(function (e) {
  e.preventDefault();
  if (!$('#txtEmail').val().includes('@') || !$('#txtEmail').val().includes('.')) {
    alertNotif("error", "Invalid Format of Email Address", false);
    $('#txtEmail').focus();
    return;
  }
  $("#btnSubmit").html('<img src="/images/btn-ajax-loader.gif" height="20px" width="20px" /> &nbsp; Sending ...');
  $("#btnSubmit").prop('disabled', true);
  $.ajax({
    type: 'POST',
    url: 'processContactForm.php',
    data: $(this).serialize(),
    success: function (response) {
      if (response == "ok") {
        alertNotif("success", "Sent Successfully", false);
        $('#frmContact').trigger("reset");
      } else {
        alertNotif("error", response, false);
      }
      $("#btnSubmit").html('Send');
      $("#btnSubmit").prop('disabled', false);
    }
  });
})