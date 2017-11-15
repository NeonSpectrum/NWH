<?php 
  $root = '../';
  $adminPage=true;
  require $root.'../files/header.php';
  if($_SESSION['accountType']=='User' || !isset($_SESSION['accountType']))
  {
    header('location: ../../home');
    exit();
  }
?>
<?php require '../sidebar.php';?>
<h2 id="header">Account Management</h2>
<div class="well center-block" id="account-body">
  <form id="frmAccount">
    <div id="lblErrorDisplayAccount">
      <!-- error will be shown here ! -->
    </div>
    Email Address: <select id="cmbEmail" name="cmbEmail" class="form-control" style="width:95%">
      <option></option>
      <?php
        $query = "SELECT * FROM account";
        $result = mysqli_query($db,$query) or die(mysql_error());
        while($row=mysqli_fetch_assoc($result))
        {                                                 
          echo "<option value='".$row['EmailAddress']."'>".$row['EmailAddress']."</option>\n";
        }
      ?>
    </select>
    <br/> 
    Account Type: <select id="cmbAccountType" name="cmbAccountType" class="form-control" style="width:95%">
      <option></option>
      <option>User</option>
      <option>Admin</option>
      <option>Owner</option>
    </select>
    <br/>
    First Name: <input type="text" id="txtFirstName" name="txtFirstName" class="form-control" style="width:95%" required>
    <br/>
    Last Name: <input type="text" id="txtLastName" name="txtLastName" class="form-control" style="width:95%" required>
    <br/>
    <div class="text-right">
      <button id="btnEdit" type="submit" class="btn btn-primary" onclick="submitEditForm();return false;">Update</button>
      <!-- <button id="btnDelete" type="submit" class="btn btn-primary" onclick="submitDeleteForm();return false;">Delete</button> -->
    </div>
  </form>
</div>
<?php require $root.'../files/footer.php';?>