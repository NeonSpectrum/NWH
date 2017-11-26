<?php 
  require_once '../../header.php';
  if($_SESSION['accountType']=='User' || !isset($_SESSION['accountType']))
  {
    header('location: ../../');
    exit();
  }
?>
<?php require_once '../../files/sidebar.php';?>
<h2 id="header">Account Management</h2>
<div class="well center-block" id="account-body">
  <form id="frmAccount">
    <div class="lblDisplayError">
      <!-- error will be shown here ! -->
    </div>
    <div class="form-group">
      <label>Email Address: </label>
      <select id="cmbEmail" name="cmbEmail" class="form-control" style="width:95%">
        <?php
          $query = "SELECT * FROM account";
          $result = mysqli_query($db,$query) or die(mysql_error());
          while($row=mysqli_fetch_assoc($result))
          {                                                 
            echo "<option value='".$row['EmailAddress']."'>".$row['EmailAddress']."</option>\n";
          }
        ?>
      </select>
    </div>
    <div class="form-group">
      <label>Account Type: </label>
      <select id="cmbAccountType" name="cmbAccountType" class="form-control" style="width:95%">
        <option></option>
        <option>User</option>
        <option>Admin</option>
        <option>Owner</option>
      </select>
    </div>
    <div class="form-group">
      <label>First Name: </label>
      <input type="text" id="txtFirstName" name="txtFirstName" class="form-control" style="width:95%" required>
      <label>Last Name: </label>
      <input type="text" id="txtLastName" name="txtLastName" class="form-control" style="width:95%" required>
    </div>
    <div class="form-group text-right">
      <button id="btnEdit" type="submit" class="btn btn-primary">Update</button>
      <!-- <button id="btnDelete" type="submit" class="btn btn-primary" onclick="submitDeleteForm();return false;">Delete</button> -->
    </div>
  </form>
</div>
<?php require_once '../../footer.php';?>