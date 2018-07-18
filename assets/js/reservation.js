$.getScript(root + 'assets/js/smartwizard.js', function() {
  var rooms = []
  var quantity = 0
  $(document).ready(function() {
    // Smart Wizard
    $('#smartwizard').smartWizard({
      selected: 0, // Initial selected step, 0 = first step
      keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
      autoAdjustHeight: true, // Automatically adjust content height
      cycleSteps: false, // Allows to cycle the navigation of steps
      backButtonSupport: false, // Enable the back button support
      useURLhash: false, // Enable selection of the step based on url hash,
      showStepURLhash: false,
      lang: {
        // Language variables
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
    })
    // Show step
    $('#smartwizard').on('showStep', function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
      if (stepPosition === 'first') {
        $('#prev-btn').css('display', 'none')
        $('#next-btn').prop('disabled', false)
        $('#btnShowMore').html('Show Other Rooms')
      } else if (stepPosition === 'final') {
        $('.navbar-btn').remove()
      }
    })
    // Leave Step
    $('#smartwizard').on('leaveStep', function(e, anchorObject, stepNumber, stepDirection) {
      $(window).scrollTop(0)
      if (stepDirection == 'forward') {
        if (stepNumber == 0) {
          $('#prev-btn').css('display', 'block')
          var checkDate = $('#frmBookNow')
            .find('#txtCheckDate')
            .val()
            .split(' - ')
          var checkIn = new Date(checkDate[0])
          var checkOut = new Date(checkDate[1])
          if (checkIn > checkOut) {
            alertNotif('error', 'Check Out date must be greater than Check In date.')
            return false
          }
          if (
            parseInt(
              $('#frmBookNow')
                .find('#txtAdults')
                .val()
            ) <= 0
          ) {
            alertNotif('error', 'An adult is a must!')
            return false
          }
          $('#smartwizard')
            .find('#loadingMode')
            .fadeIn()
          $.ajax({
            type: 'POST',
            url: root + 'ajax/getRooms.php',
            data: $('#frmBookNow').serialize(),
            dataType: 'json',
            success: function(response) {
              $('#roomList').html('')
              $('btnShowMore').html('Show Other Rooms')
              $('#txtSuggestedRooms').html('')
              $('#txtOtherRooms')
                .html('')
                .hide()
              if (response[0] === false) {
                $('#next-btn').prop('disabled', true)
                $('#txtSuggestedRooms').html(
                  "<div style='padding:15% 0%;width:100%;text-align:center;font-size:22px'>No Rooms Available</div>"
                )
                $('#btnShowMore').hide()
              } else {
                $('#next-btn').prop('disabled', false)
                $('#btnShowMore').show()
                response = response.filter(function(a) {
                  return a !== ''
                })
                if (response.length == 1) {
                  $('#btnShowMore').hide()
                }
                for (var i = 0; i < response[0].length; i++) {
                  if (i == 0) {
                    $('#txtSuggestedRooms').html(response[0][i])
                  } else {
                    $('#txtOtherRooms').append(response[0][i])
                  }
                }
              }
              $('[data-tooltip="tooltip"]').tooltip({
                container: 'body'
              })
              baguetteBox.run('.img-baguette', {
                animation: 'fadeIn',
                fullscreen: true
              })
              editBookingSummary(
                "Check In Date: <span class='pull-right'>" +
                  checkDate[0] +
                  "</span><br/>Check Out Date: <span class='pull-right'>" +
                  checkDate[1] +
                  "</span><br/>Adults: <span class='pull-right'>" +
                  $('#frmBookNow')
                    .find('#txtAdults')
                    .val() +
                  "</span><br/>Children: <span class='pull-right'>" +
                  $('#frmBookNow')
                    .find('#txtChildren')
                    .val() +
                  "</span><br/>Number of Days: <span class='pull-right'>" +
                  response[1] +
                  '</span>',
                'info'
              )
              $('#smartwizard')
                .find('#loadingMode')
                .fadeOut()
            }
          })
        } else if (stepNumber == 1) {
          var roomSelected = false
          $('.numberOfRooms').each(function() {
            if (
              $(this)
                .find('select')
                .val() != 0
            ) {
              roomSelected = true
            }
          })
          if (!roomSelected) {
            alertNotif('error', CHOOSE_ROOM_TO_PROCEED)
            return false
          }
          var roomHtml = [],
            diffDays,
            total = 0
          rooms = []
          quantity = 0
          $('.numberOfRooms').each(function() {
            if (
              $(this)
                .find('select')
                .val() != 0
            ) {
              var roomName = $(this)
                .parent()
                .find('#roomName')
                .html()
              var roomQuantity = $(this)
                .find('select')
                .val()
              rooms.push({
                roomType: roomName,
                roomQuantity: roomQuantity
              })
              quantity += parseInt(
                $(this)
                  .find('select')
                  .val()
              )
              var dates = $(this)
                .closest('form')
                .find('#txtCheckDate')
                .val()
                .split(' - ')
              var date1 = new Date(dates[0])
              var date2 = new Date(dates[1])
              diffDays = Math.ceil(Math.abs(date2.getTime() - date1.getTime()) / (1000 * 3600 * 24))
              roomHtml.push(
                roomName +
                  ': ' +
                  "<span class='pull-right'>" +
                  $(this)
                    .find('select')
                    .val() +
                  ' x ' +
                  '₱' +
                  parseInt(
                    $(this)
                      .parent()
                      .find('#roomPrice')
                      .html()
                      .replace(/[^0-9\.-]+/g, '')
                  )
                    .toFixed(2)
                    .replace(/(\d)(?=(\d{3})+\.)/g, '$1,') +
                  '</span><br>' +
                  $(this)
                    .parent()
                    .find('span#roomSimpDesc')
                    .html() +
                  "Total: <span class='pull-right'>₱&nbsp;" +
                  (
                    parseInt(
                      $(this)
                        .parent()
                        .find('#roomPrice')
                        .html()
                        .replace(/[^0-9\.-]+/g, '')
                    ) *
                    parseInt(
                      $(this)
                        .find('select')
                        .val()
                    ) *
                    diffDays
                  )
                    .toFixed(2)
                    .replace(/(\d)(?=(\d{3})+\.)/g, '$1,') +
                  '</span>'
              )
              total +=
                parseInt(
                  $(this)
                    .parent()
                    .find('#roomPrice')
                    .html()
                    .replace(/[^0-9\.-]+/g, '')
                ) *
                parseInt(
                  $(this)
                    .find('select')
                    .val()
                ) *
                diffDays
            }
          })
          if (quantity > MAX_ROOM_ALLOWED) {
            swal({
              title: 'Error!<br/>Only ' + MAX_ROOM_ALLOWED + ' rooms and below are allowed',
              html:
                MAX_ROOM_ERROR.replace('{0}', MAX_ROOM_ALLOWED) +
                '<br/><small>(075) 636-0910 / (075) 205-0647 0929-789-0088 / 0995-408-6292</small>',
              type: 'warning'
            })
            return false
          }
          $('span#txtRoomPrice').html(total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'))
          editBookingSummary(
            "<hr style='margin:5px 0 5px 0;border-color:#ccc'>" +
              roomHtml.join("<hr style='margin:5px 0 5px 0;border-color:#ccc'/>") +
              "<hr style='margin:5px 0 5px 0;border-color:#ccc'>VATable: <span class='pull-right'>₱&nbsp;" +
              (total - (total / 1.12) * 0.12).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') +
              "</span><br/>VAT (12%): <span class='pull-right'>₱&nbsp;" +
              ((total / 1.12) * 0.12).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') +
              "</span><hr style='margin:5px 0 5px 0;border-color:#ccc'/>Total: <span class='pull-right' style='font-weight:bold'>₱&nbsp;" +
              total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') +
              '</span>' +
              (diffDays > 1
                ? "<br/>50% of the Total: <span class='pull-right' style='font-weight:bold'>₱&nbsp;" +
                  (total / 2).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') +
                  '</span>'
                : ''),
            'roomList'
          )
        } else if (stepNumber == 2) {
          $('#reset-btn').css('display', 'none')
          $('#smartwizard')
            .find('#loadingMode')
            .fadeIn()
          $.ajax({
            context: this,
            type: 'POST',
            url: root + 'ajax/bookNow.php',
            dataType: 'json',
            data: {
              data: $('#frmBookNow').serialize() + '&type=reservation',
              rooms: rooms
            },
            success: function(response) {
              if (response[0] != false) {
                $('#modalRules').modal('show')
                $('#tblResult').html(response[1])
                if (
                  $('input[name=txtPaymentMethod]:checked')
                    .val()
                    .toLowerCase() == 'paypal'
                ) {
                  $('#step-4')
                    .find('#btnPrint')
                    .before(
                      "<button type='button' style='margin-right:-10px' class='btn btn-primary' onclick='window.open(\"" +
                        response[2] +
                        '");\'>Pay now with Paypal</button>'
                    )
                }
                $('#frmBookNow')
                  .find('#btnPrint')
                  .attr(
                    'onclick',
                    "window.open('//" +
                      location.hostname +
                      root +
                      'files/generateReservationConfirmation/?BookingID=' +
                      response[0] +
                      "','_blank','height=650,width=1000')"
                  )
                editBookingSummary(
                  "Payment Method: <span class='pull-right'>" +
                    $('#frmBookNow')
                      .find("input[name='txtPaymentMethod']:checked")
                      .val() +
                    '</span>',
                  'paymentMethod'
                )
                $('#smartwizard')
                  .find('#loadingMode')
                  .fadeOut()
                socket.emit('notification', {
                  user: email_address,
                  type: 'book',
                  messages:
                    'Booking ID: <a href="' +
                    root +
                    'admin/booking/?search=' +
                    response[0] +
                    '">' +
                    response[0] +
                    '</a><br/>Booked from ' +
                    $('#frmBookNow')
                      .find('#txtCheckDate')
                      .val() +
                    '<br/>Number of Rooms: ' +
                    quantity
                })
              } else {
                $('#smartwizard')
                  .find('#loadingMode')
                  .fadeOut()
                $('#step-4').html(
                  "<div style='width:100%;text-align:center;font-size:30px;padding:100px'>Something went wrong!</div>"
                )
                swal({
                  title: 'Something went wrong!',
                  text: ALREADY_RESERVED,
                  type: 'error',
                  allowOutsideClick: false
                }).then(result => {
                  if (result.value) {
                    location.reload()
                  }
                })
              }
            }
          })
        }
      }
    })
    // External Button Events
    $('#reset-btn').on('click', function() {
      if (confirm('Do you want to reset the process?')) {
        $('#smartwizard').smartWizard('reset')
        $('#bookingSummary').html('')
        $('#prev-btn').css('display', 'none')
        $('#bookingSummary').html("<div id='info'></div><div id='roomList'></div><div id='paymentMethod'></div>")
        $('#frmBookNow')
          .find('#txtAdults')
          .val('1')
        $('#frmBookNow')
          .find('#txtChildren')
          .val('0')
        $('#frmBookNow')
          .find('.checkDate')
          .val(
            moment(new Date())
              .add(1, 'days')
              .format('MM/DD/YYYY') +
              ' - ' +
              moment(new Date())
                .add(2, 'days')
                .format('MM/DD/YYYY')
          )
      }
    })
    $('#prev-btn').on('click', function() {
      $('#smartwizard').smartWizard('prev')
      return true
    })
    $('#next-btn').on('click', function() {
      if (location.hash == '#step-3') {
        if ($('input[name=cbxTermsAndConditions]').prop('checked') == false) {
          alertNotif('error', CHECK_TERMS_AND_CONDITIONS)
          return false
        }
        swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Submit'
        }).then(result => {
          if (result.value) {
            $('#smartwizard').smartWizard('next')
          }
        })
      } else {
        $('#smartwizard').smartWizard('next')
      }
      return true
    })
    $('#btnShowMore').click(function() {
      var btn = $(this)
      $('#txtOtherRooms').fadeToggle(function() {
        if ($(this).css('display') == 'none') {
          btn.html('Show Other Rooms')
        } else {
          btn.html('Hide Other Rooms')
        }
      })
    })
    if ($('#step-1').hasClass('skip')) {
      $('#smartwizard').smartWizard('next')
    }
  })
})
function editBookingSummary(html, type) {
  $('#bookingSummary').hide()
  $('#bookingSummary')
    .find('#' + type)
    .html(html)
  $('#bookingSummary').fadeIn()
}
