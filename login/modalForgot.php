<div id="modalForgot" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Forgot Password</h4>
      </div>
      <div class="modal-body">
        <form id="frmForgot" method="post" class="form-horizontal">
          <div id="lblDisplayErrorForgot" class="lblDisplayError">
            <!-- error will be shown here ! -->
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input name="txtEmail" type="email" class="form-control" id="txtEmail" placeholder="Email" required/>
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnReset" type="submit" class="btn btn-info">Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
   </div>
</div>