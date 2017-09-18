<div id="forgotModal" class="modal fade" role="dialog" data-backdrop="false" >
  <div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center">Forgot Password</h4>
			</div>
			<div class="modal-body">
				<form id="forgotform" method="post" class="form-horizontal">
          <div id="errorForgot">
            <!-- error will be shown here ! -->
          </div>
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input name="email" type="email" class="form-control" id="email" placeholder="Email" required/>
						</div>
					</div>
					<div class="modal-footer">
						<button id="forgotreset" type="submit" class="btn btn-info" onclick="submitForgotForm();return false;">Reset</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
 	</div>
</div>