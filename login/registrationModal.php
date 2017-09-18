<div id="registrationModal" class="modal fade" role="dialog" data-backdrop="false" >
  <div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center">Registration</h4>
			</div>
			<div class="modal-body">
				<form id="registerform" method="post" class="form-horizontal">
          <div id="errorRegister">
            <!-- error will be shown here ! -->
          </div>
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<div class="row">
								<div class="col-md-5">
									<input name="fname" type="text" class="form-control" placeholder="First Name" required />
								</div>
								<div class="col-md-5">
									<input name="lname" type="text" class="form-control" placeholder="Last Name" required/>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input name="email" type="email" class="form-control" id="email" placeholder="Email" required/>
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10">
							<input name="password" type="password" class="form-control" id="password" placeholder="Password" required/>
						</div>
					</div>
					<div class="modal-footer">
						<button id="register" type="submit" class="btn btn-info" onclick="submitRegisterForm();return false;">Register</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
 	</div>
</div>