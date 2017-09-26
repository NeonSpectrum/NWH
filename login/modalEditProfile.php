<?php
	$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
	$fname = isset($_SESSION['fname']) ? $_SESSION['fname'] : '';
	$lname = isset($_SESSION['lname']) ? $_SESSION['lname'] : '';
?>
<div id="modalEditProfile" class="modal fade" role="dialog" data-backdrop="false">
<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title text-center">Edit Profile</h4>
		</div>
		<div class="modal-body">
			<form id="frmEditProfile" method="post" class="form-horizontal" enctype="multipart/form-data">
				<div id="lblDisplayErrorEditProfile">
					<!-- error will be shown here ! -->
				</div>
				<div class="form-group">
					<label for="email" class="col-sm-3 control-label">Profile Picture</label>
					<div class="col-sm-8">
						<input type="file" class="form-control" name="imgProfilePic" id="imgProfilePic" accept="image/x-png,image/gif,image/jpeg" onchange="ValidateSingleInput(this);">
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-sm-3 control-label">Email</label>
					<div class="col-sm-8">
						<input name="txtEmail" type="email" class="form-control" id="txtEmail" placeholder="Email" value="<?php echo $email;?>" readonly/>
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-sm-3 control-label">Name</label>
					<div class="col-sm-8">
						<div class="row">
							<div class="col-md-6">
								<input name="txtFirstName" type="text" class="form-control" placeholder="First Name" value="<?php echo $fname;?>" required />
							</div>
							<div class="col-md-6">
								<input name="txtLastName" type="text" class="form-control" placeholder="Last Name"value="<?php echo $lname;?>"  required/>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-sm-3 control-label">Old Password</label>
					<div class="col-sm-8">
						<input name="txtOldPassword" type="password" class="form-control" id="txtOldPassword" placeholder="Old Password"/>
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-sm-3 control-label">Password</label>
					<div class="col-sm-8">
						<input name="txtNewPassword" type="password" class="form-control" id="txtNewPassword" placeholder="New Password"/>
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-sm-3 control-label"></label>
					<div class="col-sm-8">
						<input name="txtRetypeNewPassword" type="password" class="form-control" id="txtRetypeNewPassword" placeholder="Retype New Password"/>
					</div>
				</div>
				<div class="modal-footer">
					<button id="btnEditProfile" type="submit" class="btn btn-info">Edit</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
 </div>
</div>