<div id="changeModal" class="modal fade" role="dialog" data-backdrop="false" >
  <div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center">Change Password</h4>
			</div>
			<div class="modal-body">
				<form id="changeform" method="post" class="form-horizontal">
          <div id="errorChange">
            <!-- error will be shown here ! -->
          </div>
					<div class="form-group">
						<label for="email" class="col-sm-3 control-label">Email</label>
						<div class="col-sm-8">
							<input name="email" type="email" class="form-control" id="email" placeholder="Email" required/>
						</div>
					</div>
					<div class="form-group">
						<label for="oldpass" class="col-sm-3 control-label">Old Password</label>
						<div class="col-sm-8">
							<input name="oldpass" type="password" class="form-control" id="oldpass" placeholder="Old Password" required/>
						</div>
					</div>
					<div class="form-group">
						<label for="newpass" class="col-sm-3 control-label">New Password</label>
						<div class="col-sm-8">
							<input name="newpass" type="password" class="form-control" id="newpass" placeholder="New Password" required/>
						</div>
					</div>
					<div class="form-group">
						<label for="verifynewpass" class="col-sm-3 control-label"></label>
						<div class="col-sm-8">
							<input name="verifynewpass" type="password" class="form-control" id="verifynewpass" placeholder="Verify New Password" required/>
						</div>
					</div>
					<div class="modal-footer">
						<button id="changepass" type="submit" class="btn btn-info" onclick="submitChangeForm();return false;">Update</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
 	</div>
</div>