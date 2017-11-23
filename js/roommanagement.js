$('#tblRoomManagement').fadeIn();
$('.cbxRoom').change(function () {
	$.ajax({
		type: 'POST',
		url: 'changeStatus.php',
		data: 'roomID=' + $(this).attr("id") + "&status=" + $('.cbxRoom').prop('checked')
	});
	// if ($('.cbxRoom').prop('checked')) {
	// 	$('body').css("background", "black");
	// } else {
	// 	$('body').css("background", "white");
	// }
});