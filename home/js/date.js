$(document).ready( function() {
  var tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  tomorrow = new Date(tomorrow).toISOString().split('T')[0];;
  document.getElementsByName("txtBookCheckInDate")[0].setAttribute('min', tomorrow);
  document.getElementsByName("txtBookCheckOutDate")[0].setAttribute('min', tomorrow);
  $('#txtBookCheckInDate').val(tomorrow);
  $('#txtBookCheckOutDate').val(tomorrow);
});
$('#txtBookCheckInDate').change(function() { 
  checkIn = $(this).val();
  document.getElementsByName("txtBookCheckOutDate")[0].setAttribute('min', checkIn);
});
$('#txtBookCheckOutDate').change(function() { 
  checkIn = $('#txtBookCheckInDate').val();
  checkOut = $(this).val();
  if(checkIn == checkOut)
  {
    checkOut = '';
  }
  document.getElementsByName("txtBookCheckInDate")[0].setAttribute('max', checkOut);
});