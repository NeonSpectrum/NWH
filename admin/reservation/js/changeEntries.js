$(document).ready(function () {
	$("#cmbEntries").change(function () {
		var value = $("#cmbEntries").val();
		$("#cmbEntries").attr('selected','selected');
		$(location).attr('href', 'index.php?page=1&order=BookingID&sort=ASC&entries='+value);
	});
	$('#tblReservation').DataTable();
	$('#tblReservation').fadeIn();
});