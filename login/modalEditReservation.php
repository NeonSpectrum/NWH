<div id="modalEditReservation" class="modal fade" role="dialog" data-backdrop="false">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center">Edit Reservation</h4>
			</div>
			<div class="modal-body">
				<form id="frmEditReservation" method="post" class="form-horizontal">
					<div id="lblDisplayErrorEditReservation" class="lblDisplayError">
						<!-- error will be shown here ! -->
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Booking ID</label>
						<div class="col-sm-2">
							<select class="form-control" id="cmbBookingID" name="cmbBookingID">
								<option></option>
								<?php
									require_once $root.'../files/db.php';
									$email = $_SESSION['email'];
									$query = "SELECT * FROM booking WHERE EmailAddress='$email'";
									$result = mysqli_query($db,$query) or die(mysql_error());
									while($row=mysqli_fetch_assoc($result))
									{
										$tomorrow = time()+86400;
										$checkInDate = strtotime($row['CheckInDate']);
										if($tomorrow < $checkInDate)
											echo "<option value='".$row['BookingID']."'>".$row['BookingID']."</option>\n";
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Room ID</label>
						<div class="col-sm-3">
							<input name="txtEditRoomID" type="text" class="form-control" id="txtEditRoomID" placeholder="RoomID" required/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Check In Date</label>
						<div class="col-sm-7">
							<input name="txtEditCheckInDate" type="date" class="form-control" id="txtEditCheckInDate" onkeydown="return disableKey(event,'number')" required/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Check Out Date</label>
						<div class="col-sm-7">
							<input name="txtEditCheckOutDate" type="date" class="form-control" id="txtEditCheckOutDate" onkeydown="return disableKey(event,'number')" required/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Adults</label>
						<div class="col-sm-3">
							<input name="txtEditAdults" type="number" class="form-control" id="txtEditAdults" placeholder="Adults" onkeypress="disableKey(event,'letter');" min="0" max="10" value="0" required/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Childrens</label>
						<div class="col-sm-3">
							<input name="txtEditChildrens" type="number" class="form-control" id="txtEditChildrens" placeholder="Childrens" onkeypress="return disableKey(event,'letter');" min="0" max="10" value="0" required/>
						</div>
					</div>
					<div class="modal-footer">
						<button id="btnPrint" type="reset" class="btn btn-info" onclick="redirectTo();" disabled>Print</button>
						<button id="btnEditReservation" type="submit" class="btn btn-info" disabled>Update</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
 	</div>
</div>
<script>
	function redirectTo(){
		location.href="/nwh/files/generateReservationConfirmation.php?BookingID="+$('#cmbBookingID').val();
	}
</script>