<?php
require_once '../../../header.php';
require_once '../../../files/sidebar.php';
?>
<main class="l-main">
  <div id="loadingMode" style="display:block"></div>
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">
      Accounts
      <span class="pull-right">
        <a style="cursor:pointer" title="Add" data-toggle='modal' data-target='#modalAddAccount'><span class="fa fa-plus"></span></a>
      </span>
    </h1>
    <div class="well">
      <div class="table-responsive">
        <table id="tblAccount" class="display">
          <thead>
            <tr>
              <th>Email Address</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Birth Date</th>
              <th>Contact Number</th>
              <th>Account Type</th>
<?php
if ($account->checkUserLevel(2)) {
  ?>
              <th>Status</th>
              <th>Action</th>
<?php
}
?>
            </tr>
          </thead>
          <tbody>
<?php
$view->accounts();
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
<div id="modalAddAccount" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Registration</h4>
      </div>
      <form id="frmAddAccount" data-toggle="validator">
        <div class="modal-body">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <div class="row">
            <div class="col-md-12">
              <b>Note:</b> You must verify the email address to register your account.
              <br/>
              <br/>
            </div>
            <div class="col-md-6">
              <div class="form-group has-feedback">
                <label>First Name<sup>*</sup>&emsp;<small>Only alphabets are allowed.</small></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-user-o"></span></span>
                  <input type="text" name="txtFirstName" id="txtFirstName" class="form-control" maxlength="50" pattern="[a-zA-Z][a-zA-Z ]+" placeholder="John" required>
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Last Name<sup>*</sup>&emsp;<small>Only alphabets are allowed.</small></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-user-o"></span></span>
                  <input type="text" name="txtLastName" id="txtLastName" class="form-control" maxlength="50" pattern="[a-zA-Z][a-zA-Z ]+" placeholder="Smith" required>
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Birth Date<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                  <input type="text" name="txtBirthDate" id="txtBirthDate" class="form-control birthDate" placeholder="mm/dd/yyyy" onkeypress="return disableKey(event,'letter') && disableKey(event,'number');" autocomplete="off" required>
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Contact Number<sup>*</sup>&emsp;<small>Only numbers are allowed.</small></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-mobile fa-lg"></span></span>
                  <input type="text" name="txtContactNumber" id="txtContactNumber" class="form-control" minlength="5" maxlength="20" pattern="[0-9]*$" onkeypress="return disableKey(event,'letter');" required>
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-feedback">
                <label>Email Address<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-envelope-o"></span></span>
                  <input type="email" name="txtEmail" id="txtEmail" class="form-control" placeholder="example@domain.com" maxlength="100" data-error="<?php echo REGISTER_EMAIL_ERROR; ?>" data-remote="<?php echo $root; ?>account?mode=checkEmail" required>
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Password<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-key"></span></span>
                  <input type="password" name="txtPassword" id="txtPassword" class="form-control" minlength="8" maxlength="50" pattern="[\s\S]*\S[\s\S]*" required>
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Verify Password<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-key"></span></span>
                  <input type="password" name="txtRetypePassword" id="txtRetypePassword" class="form-control" minlength="8" maxlength="50" pattern="[\s\S]*\S[\s\S]*" data-match="#txtPassword" data-match-error="Whoops, these don't match" required>
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="btnRegister" type="submit" class="btn btn-primary">Register</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="modalEditAccount" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <form id="frmEditAccount" class="form-horizontal">
        <div class="modal-body">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <input type="hidden" id="txtEmail" name="txtEmail">
          <div class="form-group">
            <label class="col-sm-4 control-label">Account Type: </label>
            <div class="col-sm-8">
              <select id="cmbAccountType" name="cmbAccountType" class="form-control" required/>
                <option value="User">User</option>
                <option value="Receptionist">Receptionist</option>
<?php
if ($account->checkUserLevel(2)) {
  echo "<option value='Admin'>Admin</option>";
}
?>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="btnUpdate" type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
   </div>
</div>
<?php require_once '../../../footer.php';?>