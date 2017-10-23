<?php
	if($adminPage == true)
	{
		require $root.'../files/scriptAdmin.php';
	}
	else
	{
		require $root.'../files/scriptMain.php';
	}
	if(isset($_SESSION['email'])){
?>
		<script>
			function verifyLoginSession(){
				$.ajax({
					url:'/nwh/files/verifyLoginSession.php',
					success:function(response){
						if(!response){
							$.ajax({
								url:'/nwh/login/checkLogout.php',
								success:function(){
									location.reload(true);
								}
							});
							alert("Your account has been logged in somewhere. Logging out...");
						}
					}
				});
				setTimeout("verifyLoginSession()",5000);
			}
			verifyLoginSession();
		</script>
<?php
	}
?>
	</body>
</html>