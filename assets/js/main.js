var date = new Date();
var database = false;
$(document).ready(function() {
  scrolling(false);
  // HIDE CONTACT BOX IF MOBILE
  if ($(window).width() < 480 || $(window).height() < 480) {
    $('.contactbox').fadeOut();
  }
  // RESET FORM IF EXISTS IF MODAL IS EXITED
  var tempCheckDate;
  $('.modal').on('shown.bs.modal', function() {
    tempCheckDate = $(this).find("form").find("input.checkDate").val();
  });
  $('.modal').on('hidden.bs.modal', function() {
    $(this).find("form").trigger("reset");
    $(this).find("form").find("input.checkDate").val(tempCheckDate);
    $(this).find('.lblDisplayError').html('');
    if (typeof grecaptcha != 'undefined') {
      grecaptcha.reset();
    }
    $("#frmRegister").find('button[type=submit]').attr('disabled', true);
  });
  // FOCUS ON SELECT
  $('input').focus(function() {
    if (!($(this).attr("class") != null && $(this).attr("class").includes("check") && $(this).attr("class").includes("Date"))) {
      $(this).select();
    }
  });
  // MAKE NUMBER RESET TO MIN OR MAX
  $('input[type=number]').on('keyup keydown', function(e) {
    var min = parseInt($(this).attr("min"));
    var max = parseInt($(this).attr("max"));
    if ($(this).val() > max && e.keyCode != 46 && e.keyCode != 8) {
      e.preventDefault();
      $(this).val(max);
    }
  });
  $('[data-toggle="tooltip"]').tooltip();
  // // CONTACT BOX
  // $('.contactbox__title').on('click', function() {
  //   $('.contactbox').toggleClass('contactbox--tray');
  // });
  // $('.contactbox').on('transitionend', function() {
  //   if ($(this).hasClass('contactbox--closed')) $(this).remove();
  // });
  // BACK TO TOP
  $('a.back-to-top, a.simple-back-to-top').click(function() {
    $('html, body').animate({
      scrollTop: 0
    }, 700);
    return false;
  });
  // CLICKING ON HREF WITH # WILL ANIMATE TO THAT HASH
  $('a[href^="#"].anchor-animate').click(function() {
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
  $('.dropdown').on('show.bs.dropdown', function(e) {
    if ($(window).width() > 480) {
      $(this).find('.dropdown-menu').first().stop(true, true).slideDown("fast");
    }
    $(this).find("#txtEmail").focus();
  });
  // ADD SLIDEUP ANIMATION TO DROPDOWN //
  $('.dropdown').on('hidden.bs.dropdown', function(e) {
    if ($(window).width() > 480) {
      var me = this;
      $(this).find('.dropdown-menu').first().stop(true, true).slideUp("fast", function() {
        $(me).removeClass('open');
        $(me).find('.dropdown-toggle').attr('aria-expanded', 'false');
      });
    }
    $(this).find(".lblDisplayError").html("");
    // $(this).find("form").trigger("reset");
    // updateDate();
  });
});
Pace.track(function() {
  if (location.hostname.toLowerCase() == "localhost") {
    $.ajax({
      url: root + "ajax/checkDatabase.php",
      success: function(response) {
        if (response == false) {
          $("#loadingStatus").html(DATABASE_PROGRESS);
          $.ajax({
            url: root + "ajax/executeScriptDB.php",
            success: function(response) {
              $("#loadingStatus").html(DATABASE_SUCCESS);
              location.reload();
            }
          });
        } else if (response.includes("Access denied")) {
          $("#loadingStatus").html(DATABASE_LOGIN_ERROR);
        } else {
          database = true;
        }
      }
    })
  } else {
    database = true;
  }
});
// PACE DONE
Pace.on('done', function() {
  if ($('html, body').scrollTop() != 0) {
    $('html, body').scrollTop(0);
  }
  scrolling(true);
  new WOW({
    offset: 40
  }).init();
  if (database) {
    $(".loadingIcon").fadeOut("slow");
  }
  $('#pace').attr("href", $('#pace').attr("href").replace("pace-theme-center-simple", "pace-theme-minimal"));
  // BACK TO TOP
  $('body').append('<div id="backToTop" class="btn btn-sm"><span class="glyphicon glyphicon-chevron-up"></span></div>');
  // DATE PICKER SETTINGS
  // $('input.datepicker').datepicker({
  //   format: "yyyy-mm-dd",
  //   autoclose: true,
  //   todayHighlight: true
  // });
  $('input.birthDate').datepicker({
    format: DATE_FORMAT,
    autoclose: true,
    startView: 2,
    endDate: "-" + (date.getFullYear() - parseInt(MAX_BIRTH_YEAR)) + "y"
  });
  $('input.checkDate').keypress(function() {
    return false;
  });
  $("input.checkDate").each(function() {
    if (!$(this).val()) {
      $(this).daterangepicker({
        autoApply: true,
        minDate: moment(new Date()).add(1, 'days'),
        endDate: moment(new Date()).add(2, 'days'),
        locale: {
          format: DATE_FORMAT.toUpperCase()
        }
      });
    } else {
      $(this).daterangepicker({
        autoApply: true,
        minDate: moment(new Date()).add(1, 'days'),
        locale: {
          format: DATE_FORMAT.toUpperCase()
        }
      });
    }
  });
  $("input.checkDate").on('apply.daterangepicker', function(ev, picker) {
    if (picker.startDate.format('MM/DD/YYYY') == picker.endDate.format('MM/DD/YYYY')) {
      var nextDay = moment(picker.startDate).add(1, 'days').format("MM/DD/YYYY");
      $(this).val(picker.startDate.format('MM/DD/YYYY') + " - " + nextDay);
      $(this).data('daterangepicker').setEndDate(nextDay);
    }
  });
  // $('input.checkInDate, input.checkOutDate').datepicker({
  //   format: "yyyy-mm-dd",
  //   startDate: '+1d',
  //   autoclose: true,
  //   todayHighlight: true
  // });
  // DATE PICKER SCRIPTS
  // updateDate();
  // $('input.checkInDate, input.checkOutDate').each(function() {
  //   if ($(this).val()) {
  //     $(this).datepicker('update', $(this).val());
  //   }
  // });
  // $('input.checkInDate').change(function() {
  //   $(this).closest("form").find(".checkOutDate").datepicker('setStartDate', $(this).val())
  //   $(this).closest("form").find(".checkOutDate").datepicker('update', $(this).val());
  // });
  // ANIMATE TO HASH
  if (window.location.hash && $(window.location.hash).offset() != null && location.pathname.includes("/contactus/")) {
    $('html, body').animate({
      scrollTop: screen.width > 480 ? $(window.location.hash).offset().top - 60 : $(window.location.hash).offset().top - 10 + 'px'
    }, 1000, 'swing');
  }
  // BACK TO TOP
  $(window).scroll(function() {
    if ($(window).width() < 480 || $(window).height() < 480) {
      if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
        $('.mylivechat_collapsed').fadeOut();
      } else {
        $('.mylivechat_collapsed').fadeIn();
      }
    } else {
      // $('.dropdown.open .dropdown-toggle').dropdown('toggle');
      if ($('.dropdown.open').length) {
        $("body").trigger("click");
      }
    }
    // BACK TO TOP  
    if ($(this).scrollTop() <= 200) {
      $('#backToTop').fadeOut();
    } else {
      $('#backToTop').fadeIn();
    }
  });
  $('#backToTop').click(function() {
    $("html, body").animate({
      scrollTop: 0
    }, 600);
    return false;
  });
});
$(window).on('resize', function() {
  $('.loadingIcon').height($(window).height());
  if ($(window).width() < 480 || $(window).height() < 480) {
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
// DISPLAY BOOKING ID
$("#cmbBookingID").change(function() {
  displayBookingInfo();
});
// LOGIN
$("#frmLogin").submit(function(e) {
  e.preventDefault();
  $(this).find(".lblDisplayError").html('');
  $(this).find("#btnLogin").html('<i class="fa fa-spinner fa-pulse"></i> Signing In ...');
  $(this).find("#btnLogin").attr('disabled', true);
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'account/',
    data: $(this).serialize() + "&mode=login",
    success: function(response) {
      if (response == true) {
        $(this).closest(".modal").modal("hide");
        alertNotif("success", LOGIN_SUCCESS, false);
        setTimeout(function() {
          if (getQueryVariable("redirect")) {
            location.href = "//" + decodeURIComponent(getQueryVariable("redirect"));
          } else {
            location.reload();
          }
        }, 1300);
      } else {
        $(this).find("#btnLogin").html('Sign In');
        $(this).find("#btnLogin").attr('disabled', false);
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>');
        });
      }
    }
  });
});
//REGISTER
$("#frmRegister").validator().submit(function(e) {
  if (e.isDefaultPrevented()) {
    return;
  }
  e.preventDefault();
  if (!(grecaptcha && grecaptcha.getResponse().length !== 0)) {
    $(this).find(".lblDisplayError").show(function() {
      $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; ' + CAPTCHA_ERROR + '</div>');
    });
    return;
  }
  var pass = $(this).find('#txtPassword').val();
  var rpass = $(this).find('#txtRetypePassword').val();
  if (pass != rpass) {
    $(this).find(".lblDisplayError").show(function() {
      $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; ' + VERIFY_PASSWORD_ERROR + '</div>');
    });
    $(this).find("#txtPassword").focus();
    return;
  }
  $(this).find("#btnRegister").html('<i class="fa fa-spinner fa-pulse"></i> Submitting...');
  $(this).find('#btnRegister').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'account/',
    data: $(this).serialize() + "&verify=true&mode=register",
    success: function(response) {
      if (response == true) {
        $(this).closest(".modal").modal("hide");
        alertNotif('success', REGISTER_VERIFY, false);
        $(this).find('#btnRegister').attr('disabled', false);
        $(this).find('#frmRegister').trigger('reset');
        $(this).find('#btnRegister').html('Register');
      } else {
        $(this).find("#btnRegister").html('Register');
        $(this).find('#btnRegister').attr('disabled', false);
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>');
        });
      }
    }
  });
});
// FORGOT PASSWORD
$("#frmForgot").submit(function(e) {
  e.preventDefault();
  $(this).find("#btnReset").html('<i class="fa fa-spinner fa-pulse"></i> Sending ...');
  $(this).find("#btnReset").prop('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'account/',
    data: $(this).serialize() + "&mode=forgotPassword",
    success: function(response) {
      if (response == true) {
        $(this).closest(".modal").modal("hide");
        $('#frmForgot').trigger('reset');
        $(this).find("#btnReset").html('Submit');
        $(this).find("#btnReset").prop('disabled', false);
        alertNotif('success', FORGOT_EMAIL_SENT, false);
      } else {
        $(this).find("#btnReset").html('Submit');
        $(this).find("#btnReset").prop('disabled', false);
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>');
        });
      }
    }
  });
});
// CHANGE PASSWORD
$("#frmChange").submit(function(e) {
  e.preventDefault();
  var pass = $(this).find('#txtNewPass').val();
  var rpass = $(this).find('#txtRetypeNewPass').val();
  $(this).find("#btnUpdate").html('<i class="fa fa-spinner fa-pulse"></i> Updating...');
  $(this).find('#btnUpdate').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  if (pass != rpass) {
    $(this).find("#btnUpdate").html('Update');
    $(this).find('#btnUpdate').attr('disabled', false);
    $(this).find(".lblDisplayError").show(function() {
      $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; ' + VERIFY_PASSWORD_ERROR + '</div>');
    });
    $(this).find("#txtNewPass").focus();
    return;
  }
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'account/',
    data: $(this).serialize() + "&mode=changePassword",
    success: function(response) {
      if (response == true) {
        $(this).closest(".modal").modal("hide");
        $(this).find('#frmChange').trigger('reset');
        $(this).find('#btnUpdate').attr('disabled', false);
        alertNotif("success", UPDATE_SUCCESS, true);
      } else {
        $(this).find("#btnUpdate").html('Update');
        $(this).find('#btnUpdate').attr('disabled', false);
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>');
        });
      }
    }
  });
});
// EDIT PROFILE
$("#frmEditProfile").submit(function(e) {
  e.preventDefault();
  $(this).find("#btnEditProfile").html('<i class="fa fa-spinner fa-pulse"></i> Updating...');
  $(this).find('#btnEditProfile').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  if ($("#imgProfilePic")[0].files[0]) {
    if ($('#imgProfilePic').prop('files')[0].size > 2097152) {
      $(this).find("#btnEditProfile").html('Update');
      $(this).find('#btnEditProfile').attr('disabled', false);
      $(this).find(".lblDisplayError").show(function() {
        $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;The file size must under 2MB.</div>');
      });
      return;
    }
  }
  var form_data = new FormData();
  form_data.append("file", $('#imgProfilePic').prop('files')[0]);
  form_data.append("mode", "editAccount");
  form_data.append("csrf_token", $(this).find("input[name=csrf_token]").val());
  form_data.append("data", $(this).serialize());
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'account/',
    data: form_data,
    processData: false,
    contentType: false,
    success: function(response) {
      if (response == true) {
        $(this).closest(".modal").modal("hide");
        alertNotif("success", UPDATE_SUCCESS, true);
      } else {
        $(this).find("#btnEditProfile").html('Update');
        $(this).find('#btnEditProfile').attr('disabled', false);
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>');
        });
      }
    }
  });
});
// EDIT RESERVATION
$("#btnEditRoom").click(function() {
  var roomID = $(this).closest("#modalEditReservation").find("#currentRoomID").val();
  $("#modalEditRoom").find(".modal-title").html("Room ID: " + roomID);
  $("#modalEditRoom").modal("show");
});
$('#modalEditRoom').on('show.bs.modal', function() {
  generateRoomID();
});
$("#modalEditRoom").find("#cmbRoomType").change(function() {
  generateRoomID();
});
$("#frmEditRoom").submit(function(e) {
  e.preventDefault();
  $(this).find("#btnUpdate").html('<i class="fa fa-spinner fa-pulse"></i> Updating...');
  $(this).find('#btnUpdate').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/editReservation.php',
    data: $(this).serialize() + "&type=booking",
    success: function(response) {
      if (response == true) {
        $(this).closest(".modal").modal("hide");
        alertNotif('success', UPDATE_SUCCESS, true);
      } else {
        $(this).find("#btnUpdate").html('Update');
        $(this).find('#btnUpdate').attr('disabled', false);
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>');
        })
      }
    }
  });
});
$('#modalEditReservation').on('show.bs.modal', function() {
  displayBookingInfo();
});
$("#frmEditReservation").submit(function(e) {
  e.preventDefault();
  $(this).find("#btnUpdate").html('<i class="fa fa-spinner fa-pulse"></i> Updating...');
  $(this).find('#btnUpdate').attr('disabled', true);
  $(this).find(".lblDisplayError").html('');
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/editReservation.php',
    data: $(this).serialize() + "&type=booking",
    success: function(response) {
      if (response == true) {
        $(this).find(".modal").each(function() {
          $(this).modal("hide");
        });
        alertNotif('success', UPDATE_SUCCESS, true);
      } else {
        $(this).find("#btnUpdate").html('Update');
        $(this).find('#btnUpdate').attr('disabled', false);
        $(this).find(".lblDisplayError").show(function() {
          $(this).html('<div class="alert alert-danger animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;' + response + '</div>');
        })
      }
    }
  });
});
// BOOK NOW BUTTON
$('.frmBookCheck').submit(function(e) {
  var checkIn = new Date($(this).find("#txtCheckInDate").val());
  var checkOut = new Date($(this).find("#txtCheckOutDate").val());
  if (checkIn > checkOut) {
    alertNotif("error", INVALID_CHECK_DATE);
    return;
  }
  if (parseInt($(this).find('#txtAdults').val()) + parseInt($(this).find('#txtAdults').val()) == 0) {
    alertNotif("error", NOT_ENOUGH_GUESTS);
    return;
  }
  $(this).find("#btnBookNow").html('<i class="fa fa-spinner fa-pulse"></i> Booking...');
  $(this).find("#btnBookNow").prop('disabled', true);
  $(this).submit();
});
// CONTACT US FORM
$('#frmContact').submit(function(e) {
  e.preventDefault();
  if (!$(this).find('#txtEmail').val().includes('@') || !$(this).find('#txtEmail').val().includes('.')) {
    alertNotif("error", ERROR_EMAIL_FORMAT, false);
    $('#txtEmail').focus();
    return;
  }
  if ($(this).find("#txtMessage").val().trim() == "") {
    return;
  }
  $(this).find("#btnSubmit").html('<i class="fa fa-spinner fa-pulse"></i> Sending ...');
  $(this).find("#btnSubmit").prop('disabled', true);
  $.ajax({
    context: this,
    type: 'POST',
    url: root + 'ajax/contactForm.php',
    data: $(this).serialize(),
    success: function(response) {
      if (response == true) {
        alertNotif("success", SENT_SUCCESS, false);
        $(this).trigger("reset");
      } else {
        alertNotif("error", response, false);
      }
      $(this).find("#btnSubmit").html('Send');
      $(this).find("#btnSubmit").prop('disabled', false);
    }
  });
})

function displayBookingInfo() {
  $.ajax({
    url: root + 'ajax/cmbBookingIdDisplay.php',
    type: "POST",
    dataType: "json",
    data: "cmbBookingID=" + $("#modalEditReservation").find("#cmbBookingID").val(),
    success: function(response) {
      $("#modalEditReservation").closest("form").find("#currentRoomID").html('');
      response[0].forEach(function(roomID) {
        $("#modalEditReservation").closest("form").find("#currentRoomID").append("<option value='" + roomID + "'>" + roomID + "</option>")
      });
      $("#modalEditReservation").closest("form").find("#txtCheckDate").val(response[1]);
      $("#modalEditReservation").closest("form").find("#txtAdults").val(response[2]);
      $("#modalEditReservation").closest("form").find("#txtChildren").val(response[3]);
    }
  });
}

function generateRoomID() {
  var roomType = $("#frmEditReservation").find("#cmbRoomType").val();
  var checkDate = $("#frmEditReservation").find("#txtCheckDate").val();
  var roomList = [];
  $.ajax({
    type: 'POST',
    url: root + "ajax/generateRoomID.php",
    dataType: 'json',
    data: "roomType=" + roomType + "&checkDate=" + checkDate,
    success: function(response) {
      if (response) {
        $("#modalEditRoom").find("#cmbNewRoomID").html('');
        for (var i = 0; i < response.length; i++) {
          roomList.push(response[i]);
        }
        roomList.sort();
        roomList.forEach(function(room) {
          $("#modalEditRoom").find("#cmbNewRoomID").append("<option value='" + room + "'>" + room + "</option>");
        });
      }
    }
  });
}

function recaptchaCallback() {
  $('#frmRegister').find("button[type=submit]").removeAttr('disabled');
}

function expiredCallback() {
  $('#frmRegister').find("button[type=submit]").attr("disabled", true);
}
// READ PICTURE THEN DISPLAY
function readPicture(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#displayImage').attr('src', e.target.result).width(100).height(100);
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    $('#displayImage').attr('src', "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7");
  }
}
// UPDATE ALL DATES
function updateDate() {
  var tomorrow = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 1);
  $(".checkInDate, .checkOutDate").each(function() {
    if (!$(this).attr("value")) {
      $(this).datepicker("setDate", tomorrow);
    }
  });
}
// DISABLEKEY FUNCTION
function disableKey(evt, key) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (key == 'number') {
    if (charCode > 31 && (charCode > 48 || charCode < 57)) return false;
    return true;
  } else if (key == 'letter') {
    if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
    return true;
  } else {
    return true;
  }
}
// CAPSLOCK FUNCTION
function capsLock(e) {
  var kc = e.keyCode ? e.keyCode : e.which;
  var sk = e.shiftKey ? e.shiftKey : kc === 16;
  var display = ((kc >= 65 && kc <= 90) && !sk) || ((kc >= 97 && kc <= 122) && sk) ? 'block' : 'none';
  if (!(kc >= 48 && kc <= 57)) {
    $('#caps').css("display", display);
  }
}
// SCROLLING FUNCTION
function scrolling(enable) {
  if (!enable) {
    $('body').bind('DOMMouseScroll.prev mousewheel.prev', function(e) {
      e.preventDefault();
    });
  } else {
    $('body').unbind('DOMMouseScroll.prev mousewheel.prev');
  }
}

function ValidateSingleInput(oInput) {
  var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];
  var file_data = $('#imgProfilePic').prop('files')[0];
  if (file_data.size > 2097152) {
    $(this).find('#btnEditProfile').attr('disabled', true);
    $(this).find(".lblDisplayError").show(function() {
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
        $(this).find(".lblDisplayError").show(function() {
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