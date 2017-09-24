<div class="booknow center-block">
	<div class="booknow-content">
		<form method="post" id="frmBookNow">
		<label style="margin-left:10px;">Check In Date: </label>
			<input type="date" id="txtCheckInDate" name="txtCheckInDate" onkeydown="return false" required/>
			<label style="margin-left:10px;">Check Out Date: </label>
			<input type="date" id="txtCheckOutDate" name="txtCheckOutDate" onkeydown="return false" required/>
			<label style="margin-left:10px;">Adults: </label>
			<input type="number" id="txtAdults" name="txtAdults" value="0" style="width: 100px;" min="0" required/>
			<label style="margin-left:10px;">Children: </label>
			<input type="number" id="txtChildrens" name="txtChildrens"value="0" style="width: 100px;" min="0" required/>
			<button class="btn btn-primary" id="btnBookNow" name="btnBookNow" style="margin-left:10px;">Book Now</button>
		</form>
	</div>
</div>