<?php
	if($adminPage == true)
	{
		require $root.'../files/scriptAdmin.php';
	}
	else
	{
?>
<div style="background:rgba(142, 196, 231, 1);width:100%;height:auto;">
	<div class="center-block" style="width:80%;padding-left:10%;font-size:15px">
		<div class="footer-content">
			<hr style="border-color:white;border-width:3px;width:10%;" align="left"/>
			<a href="/nwh/contactus/#googleMap">No. 21 Quezon Ave. Poblacion, <br/>Alaminos City Pangasinan</a>
		</div>
		<div class="footer-content">
			<hr style="border-color:white;border-width:3px;width:10%;" align="left"/>
			Follow Us
			<br/>
			<a href="https://www.facebook.com/Northwoodhotel/"><img src="/nwh/images/fb.png" height="25px" width="25px"/></a>
		</div>
		<div class="footer-content">
			<hr style="border-color:white;border-width:3px;width:10%;" align="left"/>
			&copy; 2017 Northwood Hotel
			<br/><br/>
			(075) 636-0910 / (075) 205-0647<br/>
			09297890088 / 09954086292
		</div>
	</div>
</div>
<?php
		require $root.'../files/scriptMain.php';
	}
?>
	</body>
</html>