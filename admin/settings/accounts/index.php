<?php
require_once '../../../header.php';
if ($_SESSION['accountType'] == 'User' || !isset($_SESSION['accountType'])) {
  header('location: ../../');
  exit();
}
?>
<?php require_once '../../../files/sidebar.php';?>
<main class="l-main">
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">
      Accounts
      <span class="pull-right">
        <a style="cursor:pointer" data-toggle='modal' data-target='#modalAddAccount'><span class="fa fa-plus"></span></a>
      </span>
    </h1>
    <div class="well">
      <div class="table-responsive">
        <table id="tblAccount" class="table table-striped table-bordered table-hover">
          <thead>
            <th>Email Address</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Account Type</th>
            <th>Action</th>
          </thead>
          <tbody>
<?php
$query  = "SELECT * FROM account";
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
  echo "<td id='txtFirstName'>{$row['FirstName']}</td>";
  echo "<td id='txtLastName'>{$row['LastName']}</td>";
  echo "<td id='txtAccountType'>{$row['AccountType']}</td>";
  echo "<td>";
  if ($row['AccountType'] != "Owner" || $_SESSION['accountType'] == "Owner") {
    echo "<a class='btnEditAccount' title='Edit' id='{$row['EmailAddress']}' style='cursor:pointer' data-toggle='modal' data-target='#modalEditAccount'><i class='fa fa-pencil' aria-hidden='true'></i></a>";
    echo "&nbsp;&nbsp;";
  }
  if ($_SESSION['accountType'] == "Owner") {
    echo "<a class='btnDeleteAccount' title='Delete' id='{$row['EmailAddress']}' style='cursor:pointer'><i class='fa fa-trash' aria-hidden='true'></i></a>";
  }

  echo "</td>";
  echo "</tr>";
}
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
<div id="modalAddAccount" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Registration</h4>
      </div>
      <form id="frmRegister" data-toggle="validator">
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
                <label>First Name<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-user-o"></span></span>
                  <input type="text" name="txtFirstName" id="txtFirstName" class="form-control" pattern="[a-zA-Z ]*$" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Last Name<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-user-o"></span></span>
                  <input type="text" name="txtLastName" id="txtLastName" class="form-control" pattern="[a-zA-Z ]*$" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Birth Date<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                  <input type="text" name="txtBirthDate" id="txtBirthDate" class="form-control datepicker" required readonly autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Contact Number<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-mobile fa-lg"></span></span>
                  <input type="text" name="txtContactNumber" id="txtContactNumber" class="form-control" pattern="[0-9]*$" onkeypress="return disableKey(event,'letter');" required autocomplete="off">
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
                  <input type="email" name="txtEmail" id="txtEmail" class="form-control" data-error="Email is invalid or missing" data-remote="<?php echo $root; ?>ajax/checkEmail.php" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Password<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-key"></span></span>
                  <input type="password" name="txtPassword" id="txtPassword" class="form-control" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group has-feedback">
                <label>Verify Password<sup>*</sup></label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-key"></span></span>
                  <input type="password" name="txtRetypePassword" id="txtRetypePassword" class="form-control" data-match="#txtPassword" data-match-error="Whoops, these don't match" required autocomplete="off">
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="btnRegister" type="submit" class="btn btn-info" disabled>Register</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="modalEditAccount" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">
        <form id="frmEditAccount" class="form-horizontal">
          <div class="lblDisplayError">
            <!-- errors will be shown here ! -->
          </div>
          <input type="hidden" id="txtEmail" name="txtEmail">
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Name: </label>
            <div class="col-sm-10">
              <div class="row">
                <div class="col-md-5">
                  <input id="txtFirstName" name="txtFirstName" type="text" class="form-control" placeholder="First Name" required />
                </div>
                <div class="col-md-5">
                  <input id="txtLastName" name="txtLastName" type="text" class="form-control" placeholder="Last Name" required/>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Account Type: </label>
            <div class="col-sm-5">
              <select id="cmbAccountType" name="cmbAccountType" class="form-control" required>
                <option>User</option>
                <option>Admin</option>
<?php
if ($_SESSION['accountType'] == "Owner") {
  echo "<option>Owner</option>";
}
?>
              </select>
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
<?php require_once '../../../footer.php';?>