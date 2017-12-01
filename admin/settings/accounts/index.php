<?php 
  require_once '../../../header.php';
  if($_SESSION['accountType']=='User' || !isset($_SESSION['accountType']))
  {
    header('location: ../../');
    exit();
  }
?>
<?php require_once '../../../files/sidebar.php';?>
<main class="l-main">
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">Accounts</h1>
    <div class="well">
      <div class="table-responsive">
        <table id="tblAccount" class="table table-striped table-bordered table-hover">
          <thead>
            <th>Email Address</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Account Type</th>
          </thead>
          <tbody>
            <?php
              $query = "SELECT * FROM account";
              $result = mysqli_query($db, $query);
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['EmailAddress']}</td>";
                echo "<td>{$row['FirstName']}</td>";
                echo "<td>{$row['LastName']}</td>";
                echo "<td>{$row['AccountType']}</td>";
                echo "</tr>";
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
<?php require_once '../../../footer.php';?>