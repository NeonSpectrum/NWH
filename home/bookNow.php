<div class="booknow center-block">
	<div class="booknow-content">
		<form method="post" id="frmBookNow">
		<label style="margin-left:20px;">Check In Date: </label>
			<input type="date" id="txtBookCheckInDate" name="txtBookCheckInDate" onkeydown="return disableNumber(event)" required/>
			<label style="margin-left:20px;">Check Out Date: </label>
			<input type="date" id="txtBookCheckOutDate" name="txtBookCheckOutDate" onkeydown="return disableNumber(event)" required/>
			<label style="margin-left:20px;">Adults: </label>
			<input type="number" id="txtBookAdults" name="txtBookAdults" value="0" style="width: 100px;" onkeypress="return disableLetter(event)" min="0" max="10" required/>
			<label style="margin-left:20px;">Children: </label>
			<input type="number" id="txtBookChildrens" name="txtBookChildrens"value="0" style="width: 100px;" onkeypress="return disableLetter(event)" min="0" max-"10" required/>
			<button class="btn btn-primary" id="btnBookNow" name="btnBookNow" style="margin-left:20px;">Book Now</button>
		</form>
	</div>
</div>