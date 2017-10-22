<div class="booknow center-block">
	<div class="booknow-content">
		<form id="frmBookNow" class="form-inline">
			<label>Check In Date: </label>
			<input class="form-control" type="date" id="txtBookCheckInDate" name="txtBookCheckInDate" onkeydown="return disableKey(event,'number')" required/>
			<label>Check Out Date: </label>
			<input class="form-control" type="date" id="txtBookCheckOutDate" name="txtBookCheckOutDate" onkeydown="return disableKey(event,'number')" required/>
			<label>Adults: </label>
			<input class="form-control" type="number" id="txtBookAdults" name="txtBookAdults" value="0" onkeydown="return disableKey(event,'letter')" min="0" max="10" required/>
			<label>Children: </label>
			<input class="form-control" type="number" id="txtBookChildrens" name="txtBookChildrens"value="0" onkeydown="return disableKey(event,'letter')" min="0" max="10" required/>
			<label></label><button class="btn btn-primary" id="btnBookNow" name="btnBookNow">Book Now</button>
		</form>
	</div>
</div>