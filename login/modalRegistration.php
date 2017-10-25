<div id="modalRegistration" class="modal fade" role="dialog" data-backdrop="false">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center">Registration</h4>
			</div>
			<div class="modal-body">
				<form id="frmRegister" method="post" class="form-horizontal">
					<div id="lblDisplayErrorRegister" class="lblDisplayError">
						<!-- error will be shown here ! -->
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<div class="row">
								<div class="col-md-6">
									<input name="txtFirstName" type="text" class="form-control" placeholder="First Name" required />
								</div>
								<div class="col-md-6">
									<input name="txtLastName" type="text" class="form-control" placeholder="Last Name" required/>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input name="txtEmail" type="email" class="form-control" id="txtEmail" placeholder="Email" required/>
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10">
							<input name="txtPassword" type="password" class="form-control" id="txtPassword" placeholder="Password" minlength="8" required/>
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<input name="txtRetypePassword" type="password" class="form-control" id="txtRetypePassword" placeholder="Retype Password" minlength="8" required/>
						</div>
					</div>
					<div class="form-group">
						<label for="captcha" class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="6Ler0DUUAAAAAK0dRPfLXX4i3HXRKZCmvdLzyRDp"></div>
						</div>
					</div>
					<div class="modal-footer">
						<br/><button id="btnRegister" type="submit" class="btn btn-info" disabled>Register</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
 	</div>
</div>