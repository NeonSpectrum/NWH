<div id="modalChange" class="modal fade" role="dialog" data-backdrop="false">
  <div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center">Change Password</h4>
			</div>
			<div class="modal-body">
        <form id="frmChange" method="post" class="form-horizontal">
          <div id="lblDisplayErrorChange">
            <!-- error will be shown here ! -->
          </div>
					<div class="form-group">
						<label for="email" class="col-sm-3 control-label">Email</label>
						<div class="col-sm-8">
							<input name="txtEmail" type="email" class="form-control" id="txtEmail" placeholder="Email" required/>
						</div>
					</div>
					<div class="form-group">
						<label for="oldpass" class="col-sm-3 control-label">Old Password</label>
						<div class="col-sm-8">
							<input name="txtOldPass" type="password" class="form-control" id="txtOldPass" placeholder="Old Password" required/>
						</div>
					</div>
					<div class="form-group">
						<label for="newpass" class="col-sm-3 control-label">New Password</label>
						<div class="col-sm-8">
							<input name="txtNewPass" type="password" class="form-control" id="txtNewPass" placeholder="New Password" required/>
						</div>
					</div>
					<div class="form-group">
						<label for="verifynewpass" class="col-sm-3 control-label"></label>
						<div class="col-sm-8">
							<input name="txtVerifyNewPass" type="password" class="form-control" id="txtVerifyNewPass" placeholder="Verify New Password" required/>
						</div>
					</div>
					<div class="modal-footer">
						<button id="btnUpdate" type="submit" class="btn btn-info">Update</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
 	</div>
</div>