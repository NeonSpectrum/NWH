/*! 
 * SmartWizard v4.2.2
 * The awesome jQuery step wizard plugin with Bootstrap support
 * http://www.techlaboratory.net/smartwizard
 *
 * Created by Dipu Raj
 * http://dipuraj.me
 *
 * Licensed under the terms of the MIT License
 * https://github.com/techlab/SmartWizard/blob/master/LICENSE
 */
! function(t, s, e, n) {
  "use strict";

  function i(s, e) {
    this.options = t.extend(!0, {}, o, e), this.main = t(s), this.nav = this.main.children("ul"), this.steps = t("li > a", this.nav), this.container = this.main.children("div"), this.pages = this.container.children("div"), this.current_index = null, this.init()
  }
  var o = {
    selected: 0,
    keyNavigation: !0,
    autoAdjustHeight: !0,
    cycleSteps: !1,
    backButtonSupport: !0,
    useURLhash: !0,
    showStepURLhash: !0,
    lang: {
      next: "Next",
      previous: "Previous"
    },
    toolbarSettings: {
      toolbarPosition: "bottom",
      toolbarButtonPosition: "right",
      showNextButton: !0,
      showPreviousButton: !0,
      toolbarExtraButtons: []
    },
    anchorSettings: {
      anchorClickable: !0,
      enableAllAnchors: !1,
      markDoneStep: !0,
      markAllPreviousStepsAsDone: !0,
      removeDoneStepOnNavigateBack: !1,
      enableAnchorOnDoneStep: !0
    },
    contentURL: null,
    contentCache: !0,
    ajaxSettings: {},
    disabledSteps: [],
    errorSteps: [],
    hiddenSteps: [],
    theme: "default",
    transitionEffect: "none",
    transitionSpeed: "400"
  };
  t.extend(i.prototype, {
    init: function() {
      this._setElements(), this._setToolbar(), this._setEvents();
      var e = this.options.selected;
      if (this.options.useURLhash) {
        var n = s.location.hash;
        if (n && n.length > 0) {
          var i = t("a[href*='" + n + "']", this.nav);
          if (i.length > 0) {
            var o = this.steps.index(i);
            e = o >= 0 ? o : e
          }
        }
      }
      e > 0 && this.options.anchorSettings.markDoneStep && this.options.anchorSettings.markAllPreviousStepsAsDone && this.steps.eq(e).parent("li").prevAll().addClass("done"), this._showStep(e)
    },
    _setElements: function() {
      this.main.addClass("sw-main sw-theme-" + this.options.theme), this.nav.addClass("nav nav-tabs step-anchor"), this.options.anchorSettings.enableAllAnchors !== !1 && this.options.anchorSettings.anchorClickable !== !1 && this.steps.parent("li").addClass("clickable"), this.container.addClass("sw-container tab-content"), this.pages.addClass("step-content");
      var s = this;
      return this.options.disabledSteps && this.options.disabledSteps.length > 0 && t.each(this.options.disabledSteps, function(t, e) {
        s.steps.eq(e).parent("li").addClass("disabled")
      }), this.options.errorSteps && this.options.errorSteps.length > 0 && t.each(this.options.errorSteps, function(t, e) {
        s.steps.eq(e).parent("li").addClass("danger")
      }), this.options.hiddenSteps && this.options.hiddenSteps.length > 0 && t.each(this.options.hiddenSteps, function(t, e) {
        s.steps.eq(e).parent("li").addClass("hidden")
      }), !0
    },
    _setToolbar: function() {
      if ("none" === this.options.toolbarSettings.toolbarPosition) return !0;
      var s = this.options.toolbarSettings.showNextButton !== !1 ? t("<button></button>").text(this.options.lang.next).addClass("btn btn-default sw-btn-next").attr("type", "button") : null,
        e = this.options.toolbarSettings.showPreviousButton !== !1 ? t("<button></button>").text(this.options.lang.previous).addClass("btn btn-default sw-btn-prev").attr("type", "button") : null,
        n = t("<div></div>").addClass("btn-group navbar-btn sw-btn-group pull-" + this.options.toolbarSettings.toolbarButtonPosition).attr("role", "group").append(e, s),
        i = null;
      this.options.toolbarSettings.toolbarExtraButtons && this.options.toolbarSettings.toolbarExtraButtons.length > 0 && (i = t("<div></div>").addClass("btn-group navbar-btn sw-btn-group-extra pull-" + this.options.toolbarSettings.toolbarButtonPosition).attr("role", "group"), t.each(this.options.toolbarSettings.toolbarExtraButtons, function(t, s) {
        i.append(s.clone(!0))
      }));
      var o, a;
      switch (this.options.toolbarSettings.toolbarPosition) {
        case "top":
          o = t("<nav></nav>").addClass("navbar btn-toolbar sw-toolbar sw-toolbar-top"), o.append(n), "left" === this.options.toolbarSettings.toolbarButtonPosition ? o.append(i) : o.prepend(i), this.container.before(o);
          break;
        case "bottom":
          a = t("<nav></nav>").addClass("navbar btn-toolbar sw-toolbar sw-toolbar-bottom"), a.append(n), "left" === this.options.toolbarSettings.toolbarButtonPosition ? a.append(i) : a.prepend(i), this.container.after(a);
          break;
        case "both":
          o = t("<nav></nav>").addClass("navbar btn-toolbar sw-toolbar sw-toolbar-top"), o.append(n), "left" === this.options.toolbarSettings.toolbarButtonPosition ? o.append(i) : o.prepend(i), this.container.before(o), a = t("<nav></nav>").addClass("navbar btn-toolbar sw-toolbar sw-toolbar-bottom"), a.append(n.clone(!0)), "left" === this.options.toolbarSettings.toolbarButtonPosition ? a.append(i.clone(!0)) : a.prepend(i.clone(!0)), this.container.after(a);
          break;
        default:
          a = t("<nav></nav>").addClass("navbar btn-toolbar sw-toolbar sw-toolbar-bottom"), a.append(n), "left" === this.options.toolbarSettings.toolbarButtonPosition ? a.append(i) : a.prepend(i), this.container.after(a)
      }
      return !0
    },
    _setEvents: function() {
      var n = this;
      return t(this.steps).on("click", function(t) {
        if (t.preventDefault(), n.options.anchorSettings.anchorClickable === !1) return !0;
        var s = n.steps.index(this);
        if (n.options.anchorSettings.enableAnchorOnDoneStep === !1 && n.steps.eq(s).parent("li").hasClass("done")) return !0;
        s !== n.current_index && (n.options.anchorSettings.enableAllAnchors !== !1 && n.options.anchorSettings.anchorClickable !== !1 ? n._showStep(s) : n.steps.eq(s).parent("li").hasClass("done") && n._showStep(s))
      }), t(".sw-btn-next", this.main).on("click", function(t) {
        t.preventDefault(), n.steps.index(this) !== n.current_index && n._showNext()
      }), t(".sw-btn-prev", this.main).on("click", function(t) {
        t.preventDefault(), n.steps.index(this) !== n.current_index && n._showPrevious()
      }), this.options.keyNavigation && t(e).keyup(function(t) {
        n._keyNav(t)
      }), this.options.backButtonSupport && t(s).on("hashchange", function(e) {
        if (!n.options.useURLhash) return !0;
        if (s.location.hash) {
          var i = t("a[href*='" + s.location.hash + "']", n.nav);
          i && i.length > 0 && (e.preventDefault(), n._showStep(n.steps.index(i)))
        }
      }), !0
    },
    _showNext: function() {
      for (var t = this.current_index + 1, s = t; s < this.steps.length; s++)
        if (!this.steps.eq(s).parent("li").hasClass("disabled") && !this.steps.eq(s).parent("li").hasClass("hidden")) {
          t = s;
          break
        }
      if (this.steps.length <= t) {
        if (!this.options.cycleSteps) return !1;
        t = 0
      }
      return this._showStep(t), !0
    },
    _showPrevious: function() {
      for (var t = this.current_index - 1, s = t; s >= 0; s--)
        if (!this.steps.eq(s).parent("li").hasClass("disabled") && !this.steps.eq(s).parent("li").hasClass("hidden")) {
          t = s;
          break
        }
      if (0 > t) {
        if (!this.options.cycleSteps) return !1;
        t = this.steps.length - 1
      }
      return this._showStep(t), !0
    },
    _showStep: function(t) {
      return !!this.steps.eq(t) && (t != this.current_index && (!this.steps.eq(t).parent("li").hasClass("disabled") && !this.steps.eq(t).parent("li").hasClass("hidden") && (this._loadStepContent(t), !0)))
    },
    _loadStepContent: function(s) {
      var e = this,
        n = this.steps.eq(this.current_index),
        i = "",
        o = this.steps.eq(s),
        a = o.data("content-url") && o.data("content-url").length > 0 ? o.data("content-url") : this.options.contentURL;
      if (null !== this.current_index && this.current_index !== s && (i = this.current_index < s ? "forward" : "backward"), null !== this.current_index && this._triggerEvent("leaveStep", [n, this.current_index, i]) === !1) return !1;
      if (!(a && a.length > 0) || o.data("has-content") && this.options.contentCache) this._transitPage(s);
      else {
        var r = o.length > 0 ? t(o.attr("href"), this.main) : null,
          h = t.extend(!0, {}, {
            url: a,
            type: "POST",
            data: {
              step_number: s
            },
            dataType: "text",
            beforeSend: function() {
              o.parent("li").addClass("loading")
            },
            error: function(s, e, n) {
              o.parent("li").removeClass("loading"), t.error(n)
            },
            success: function(t) {
              t && t.length > 0 && (o.data("has-content", !0), r.html(t)), o.parent("li").removeClass("loading"), e._transitPage(s)
            }
          }, this.options.ajaxSettings);
        t.ajax(h)
      }
      return !0
    },
    _transitPage: function(s) {
      var e = this,
        n = this.steps.eq(this.current_index),
        i = n.length > 0 ? t(n.attr("href"), this.main) : null,
        o = this.steps.eq(s),
        a = o.length > 0 ? t(o.attr("href"), this.main) : null,
        r = "";
      null !== this.current_index && this.current_index !== s && (r = this.current_index < s ? "forward" : "backward");
      var h = "middle";
      return 0 === s ? h = "first" : s === this.steps.length - 1 && (h = "final"), this.options.transitionEffect = this.options.transitionEffect.toLowerCase(), this.pages.finish(), "slide" === this.options.transitionEffect ? i && i.length > 0 ? i.slideUp("fast", this.options.transitionEasing, function() {
        a.slideDown(e.options.transitionSpeed, e.options.transitionEasing)
      }) : a.slideDown(this.options.transitionSpeed, this.options.transitionEasing) : "fade" === this.options.transitionEffect ? i && i.length > 0 ? i.fadeOut("fast", this.options.transitionEasing, function() {
        a.fadeIn("fast", e.options.transitionEasing, function() {
          t(this).show()
        })
      }) : a.fadeIn(this.options.transitionSpeed, this.options.transitionEasing, function() {
        t(this).show()
      }) : (i && i.length > 0 && i.hide(), a.show()), this._setURLHash(o.attr("href")), this._setAnchor(s), this._setButtons(s), this._fixHeight(s), this.current_index = s, this._triggerEvent("showStep", [o, this.current_index, r, h]), !0
    },
    _setAnchor: function(t) {
      return this.steps.eq(this.current_index).parent("li").removeClass("active danger loading"), this.options.anchorSettings.markDoneStep !== !1 && null !== this.current_index && (this.steps.eq(this.current_index).parent("li").addClass("done"), this.options.anchorSettings.removeDoneStepOnNavigateBack !== !1 && this.steps.eq(t).parent("li").nextAll().removeClass("done")), this.steps.eq(t).parent("li").removeClass("done danger loading").addClass("active"), !0
    },
    _setButtons: function(s) {
      return this.options.cycleSteps || (0 >= s ? t(".sw-btn-prev", this.main).addClass("disabled") : t(".sw-btn-prev", this.main).removeClass("disabled"), this.steps.length - 1 <= s ? t(".sw-btn-next", this.main).addClass("disabled") : t(".sw-btn-next", this.main).removeClass("disabled")), !0
    },
    _keyNav: function(t) {
      var s = this;
      switch (t.which) {
        case 37:
          s._showPrevious(), t.preventDefault();
          break;
        case 39:
          s._showNext(), t.preventDefault();
          break;
        default:
          return
      }
    },
    _fixHeight: function(s) {
      if (this.options.autoAdjustHeight) {
        var e = this.steps.eq(s).length > 0 ? t(this.steps.eq(s).attr("href"), this.main) : null;
        this.container.finish().animate({
          minHeight: e.outerHeight()
        }, this.options.transitionSpeed, function() {})
      }
      return !0
    },
    _triggerEvent: function(s, e) {
      var n = t.Event(s);
      return this.main.trigger(n, e), !n.isDefaultPrevented() && n.result
    },
    _setURLHash: function(t) {
      this.options.showStepURLhash && s.location.hash !== t && (s.location.hash = t)
    },
    theme: function(t) {
      if (this.options.theme === t) return !1;
      this.main.removeClass("sw-theme-" + this.options.theme), this.options.theme = t, this.main.addClass("sw-theme-" + this.options.theme), this._triggerEvent("themeChanged", [this.options.theme])
    },
    next: function() {
      this._showNext()
    },
    prev: function() {
      this._showPrevious()
    },
    reset: function() {
      if (this._triggerEvent("beginReset") === !1) return !1;
      this.container.stop(!0), this.pages.stop(!0), this.pages.hide(), this.current_index = null, this._setURLHash(this.steps.eq(this.options.selected).attr("href")), t(".sw-toolbar", this.main).remove(), this.steps.removeClass(), this.steps.parents("li").removeClass(), this.steps.data("has-content", !1), this.init(), this._triggerEvent("endReset")
    },
    stepState: function(s, e) {
      var n = this;
      s = t.isArray(s) ? s : [s];
      var i = t.grep(this.steps, function(e, i) {
        return t.inArray(i, s) !== -1 && i !== n.current_index
      });
      if (i && i.length > 0) switch (e) {
        case "disable":
          t(i).parents("li").addClass("disabled");
          break;
        case "enable":
          t(i).parents("li").removeClass("disabled");
          break;
        case "hide":
          t(i).parents("li").addClass("hidden");
          break;
        case "show":
          t(i).parents("li").removeClass("hidden")
      }
    }
  }), t.fn.smartWizard = function(s) {
    var e, n = arguments;
    return void 0 === s || "object" == typeof s ? this.each(function() {
      t.data(this, "smartWizard") || t.data(this, "smartWizard", new i(this, s))
    }) : "string" == typeof s && "_" !== s[0] && "init" !== s ? (e = t.data(this[0], "smartWizard"), "destroy" === s && t.data(this, "smartWizard", null), e instanceof i && "function" == typeof e[s] ? e[s].apply(e, Array.prototype.slice.call(n, 1)) : this) : void 0
  }
}(jQuery, window, document);
// SCRIPT
var rooms = [];
$(document).ready(function() {
  // Step show event 
  $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
    if (stepPosition === 'first') {
      $('#prev-btn').css("display", "none");
      $("#next-btn").prop("disabled", false);
    } else if (stepPosition === 'final') {
      $(".navbar-btn").remove();
    }
  });
  // Smart Wizard
  $('#smartwizard').smartWizard({
    selected: 0, // Initial selected step, 0 = first step 
    keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
    autoAdjustHeight: true, // Automatically adjust content height
    cycleSteps: false, // Allows to cycle the navigation of steps
    backButtonSupport: false, // Enable the back button support
    useURLhash: false, // Enable selection of the step based on url hash
    lang: { // Language variables
      next: 'Next',
      previous: 'Previous'
    },
    toolbarSettings: {
      toolbarPosition: 'none'
    },
    anchorSettings: {
      anchorClickable: false, // Enable/Disable anchor navigation
      enableAllAnchors: false, // Activates all anchors clickable all times
      markDoneStep: true, // add done css
      enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
    },
    contentURL: null, // content url, Enables Ajax content loading. can set as data data-content-url on anchor
    disabledSteps: [], // Array Steps disabled
    errorSteps: [], // Highlight step with errors
    theme: 'arrows',
    transitionEffect: 'fade', // Effect on navigation, none/slide/fade
    transitionSpeed: '400'
  });
  // Leave Step
  $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
    $(window).scrollTop(0);
    if (stepDirection == "forward") {
      if (stepNumber == 0) {
        $('#prev-btn').css("display", "block");
        var checkDate = $('#frmBookNow').find("#txtCheckDate").val().split(" - ");
        var checkIn = new Date(checkDate[0]);
        var checkOut = new Date(checkDate[1]);
        if (checkIn > checkOut) {
          alertNotif("error", "Check Out date must be greater than Check In date.");
          return false;
        }
        if (parseInt($('#frmBookNow').find('#txtAdults').val()) <= 0) {
          alertNotif("error", "An adult is a must!");
          return false;
        }
        $("#loadingMode").fadeIn();
        $.ajax({
          type: 'POST',
          url: root + 'ajax/getRooms.php',
          data: $('#frmBookNow').serialize(),
          dataType: 'json',
          success: function(response) {
            $("#roomList").html('');
            $("btnShowMore").html("Show Other Rooms");
            $("#txtSuggestedRooms").html('');
            $("#txtOtherRooms").html('').hide();
            if (response[0] === false) {
              $("#next-btn").prop("disabled", true);
              $("#txtSuggestedRooms").html("<div style='padding:15% 0%;width:100%;text-align:center;font-size:22px'>No Rooms Available</div>")
              $("#btnShowMore").hide();
            } else {
              $("#next-btn").prop("disabled", false);
              $("#btnShowMore").show();
              response = response.filter(function(a) {
                return a !== ''
              })
              if (response.length == 1) {
                $("#btnShowMore").hide();
              }
              for (var i = 0, first = true; i < response.length; i++) {
                if (first === true) {
                  $("#txtSuggestedRooms").html(response[i]);
                  first = false;
                } else {
                  $("#txtOtherRooms").append(response[i]);
                }
              }
            }
            $('[data-tooltip="tooltip"]').tooltip({
              container: 'body'
            });
            baguetteBox.run('.img-baguette', {
              animation: 'fadeIn',
              fullscreen: true
            });
            editBookingSummary("Check In Date: <span class='pull-right'>" + checkDate[0] + "</span><br/>Check Out Date: <span class='pull-right'>" + checkDate[1] + "</span><br/>Adults: <span class='pull-right'>" + $('#frmBookNow').find("#txtAdults").val() + "</span><br/>Children: <span class='pull-right'>" + $('#frmBookNow').find("#txtChildren").val() + "</span>", "info");
            $("#loadingMode").fadeOut();
          }
        });
      } else if (stepNumber == 1) {
        var roomSelected = false;
        $('.numberOfRooms').each(function() {
          if ($(this).find("select").val() != 0) {
            roomSelected = true;
          }
        });
        if (!roomSelected) {
          alertNotif("error", CHOOSE_ROOM_TO_PROCEED);
          return false;
        }
        var roomHtml = "",
          diffDays, total = 0;
        rooms = [];
        $("#loadingMode").fadeIn();
        $('.numberOfRooms').each(function() {
          if ($(this).find("select").val() != 0) {
            var roomName = $(this).parent().find("#roomName").html();
            var roomQuantity = $(this).find("select").val();
            rooms.push({
              roomType: roomName,
              roomQuantity: roomQuantity
            });
            var dates = $(this).closest("form").find("#txtCheckDate").val().split(" - ");
            var date1 = new Date(dates[0]);
            var date2 = new Date(dates[1]);
            diffDays = Math.ceil(Math.abs(date2.getTime() - date1.getTime()) / (1000 * 3600 * 24));
            roomHtml += roomName + " (" + $(this).find("select").val() + "): " + "<span class='pull-right'>₱" + (parseInt($(this).parent().find("#roomPrice").html().replace(/[^0-9\.-]+/g, "")) * parseInt($(this).find("select").val()) * diffDays).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + "</span><br>" + $(this).parent().find("span#roomSimpDesc").html();
            total += parseInt($(this).parent().find("#roomPrice").html().replace(/[^0-9\.-]+/g, "")) * parseInt($(this).find("select").val()) * diffDays;
            $("#loadingMode").fadeOut();
          }
        });
        $('span#txtRoomPrice').html(total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
        editBookingSummary("<hr style='margin:5px 0 5px 0;border-color:#ccc'>" + roomHtml + "<hr style='margin:5px 0 5px 0;border-color:#ccc'>Subtotal: <span class='pull-right'>₱" + (total - (total / 1.12 * .12)).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + "</span><br/>VAT: <span class='pull-right'>₱" + (total / 1.12 * .12).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + "</span><br/>Total: <span class='pull-right'>₱" + total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + "</span>", "roomList");
      } else if (stepNumber == 2) {
        $('#reset-btn').css("display", "none");
        $("#loadingMode").fadeIn();
        $.ajax({
          context: this,
          type: 'POST',
          url: root + 'ajax/bookNow.php',
          dataType: "json",
          data: {
            data: $('#frmBookNow').serialize() + "&type=reservation",
            rooms: rooms
          },
          success: function(response) {
            if (response[0] != false) {
              $('#modalRules').modal("show");
              $('span#txtBookingID').html(response[0]);
              $('span#txtRoomID').html(response[1]);
              if ($("input[name=txtPaymentMethod]:checked").val().toLowerCase() == "paypal") {
                $("#step-4").find("#btnPrint").before("<button type='button' style='margin-right:-10px' class='btn btn-primary' onclick='location.href=\"" + response[2] + "\";$(\"#loadingMode\").fadeIn();'>Pay now with Paypal</button>");
              }
              $('#frmBookNow').find('#btnPrint').attr("href", root + "files/generateReservationConfirmation/?BookingID=" + response[0]);
              editBookingSummary("Payment Method: <span class='pull-right'>" + $("#frmBookNow").find("input[name='txtPaymentMethod']:checked").val() + "</span>", "paymentMethod");
              $("#loadingMode").fadeOut();
              socket.emit('notification', {
                user: email_address,
                messages: "Booked from " + $('#frmBookNow').find("#txtCheckDate").val() + "<br/>Booking ID: " + response[0]
              });
              // $('#smartwizard ul').find("a").css("pointer-events", "none");
            } else {
              $("#loadingMode").fadeOut();
              $("#step-4").html("<div style='width:100%;text-align:center;font-size:30px;padding:100px'>Something went wrong!</div>");
              swal({
                title: 'Something went wrong!',
                text: ALREADY_RESERVED,
                type: 'error',
                allowOutsideClick: false
              }).then((result) => {
                if (result.value) {
                  location.reload();
                }
              });
            }
          }
        });
      }
    }
  });
  // External Button Events
  $("#reset-btn").on("click", function() {
    $('#smartwizard').smartWizard("reset");
    $('#bookingSummary').html('');
    $('#prev-btn').css("display", "none");
    $("#bookingSummary").html("<div id='info'></div><div id='roomList'></div><div id='paymentMethod'></div>");
    $("#frmBookNow").find("#txtAdults").val("1");
    $("#frmBookNow").find("#txtChildren").val("0");
    $("#frmBookNow").find(".checkDate").val(moment(new Date()).add(1, 'days').format("MM/DD/YYYY") + " - " + moment(new Date()).add(2, 'days').format("MM/DD/YYYY"));
    return true;
  });
  $("#prev-btn").on("click", function() {
    $('#smartwizard').smartWizard("prev");
    return true;
  });
  $("#next-btn").on("click", function() {
    if (location.hash == "#step-3") {
      if ($("input[name=cbxTermsAndConditions]").prop("checked") == false) {
        alertNotif("error", CHECK_TERMS_AND_CONDITIONS);
        return false;
      }
      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Submit'
      }).then((result) => {
        if (result.value) {
          $('#smartwizard').smartWizard("next");
        }
      })
    } else {
      $('#smartwizard').smartWizard("next");
    }
    return true;
  });
  $("#btnShowMore").click(function() {
    var btn = $(this);
    $("#txtOtherRooms").fadeToggle(function() {
      if ($(this).css("display") == "none") {
        btn.html("Show Other Rooms");
      } else {
        btn.html("Hide Other Rooms");
      }
    });
  });
  if ($("#step-1").hasClass("skip")) {
    $('#smartwizard').smartWizard("next");
  }
});

function editBookingSummary(html, type) {
  $('#bookingSummary').hide();
  $('#bookingSummary').find("#" + type).html(html);
  $('#bookingSummary').fadeIn();
}