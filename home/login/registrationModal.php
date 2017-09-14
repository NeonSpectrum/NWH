<div id="registrationModal" class="modal fade" role="dialog" style="z-index:100;">
  	<div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Registration</h4>
			</div>
			<div class="modal-body">
				<form name="registration" action="" method="post" class="form-horizontal">
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
							<input name="emailreg" type="email" class="form-control" id="email" placeholder="Email" required/>
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10">
							<input name="password" type="password" class="form-control" id="password" placeholder="Password" required/>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info" style="">Register</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
  	</div>
</div>