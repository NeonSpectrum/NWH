$(function() {
	$("#txtEditCheckInDate").keypress(function(event) {
			if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
					return false;
			}
	});
});
$(function() {
	$("#txtEditCheckOutDate").keypress(function(event) {
			if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
					return false;
			}
	});
});
$(function() {
	$("#txtBookCheckInDate").keypress(function(event) {
			if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
					return false;
			}
	});
});
$(function() {
	$("#txtBookCheckOutDate").keypress(function(event) {
			if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
					return false;
			}
	});
});