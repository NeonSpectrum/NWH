function verifyLoginSession() {
	$.ajax({
		url: '/files/verifyLoginSession.php',
		success: function (response) {
			if (!response) {
				$.ajax({
					url: '/files/checkLogout.php',
					success: function () {
						location.reload(true);
					}
				});
				alert("Your account has been logged in somewhere. Logging out...");
			}
		}
	});
	setTimeout("verifyLoginSession()", 5000);
}
Pace.ignore(verifyLoginSession());