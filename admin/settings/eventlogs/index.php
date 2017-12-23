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
      Event Logs
      <span class="pull-right">
        <a style="cursor:pointer" data-toggle='modal' data-target='#modalAddAccount'><span class="fa fa-plus"></span></a>
      </span>
    </h1>
    <div class="well">
      <div class="table-responsive">
        <table id="tblEvents" class="table table-striped table-bordered table-hover">
          <thead>
            <th>ID</th>
            <th>Email Address</th>
            <th>Action</th>
            <th>Time Stamp</th>
          </thead>
          <tbody>
<?php
$result = $db->query("SELECT * FROM log");
while ($row = $result->fetch_assoc()) {
  echo "<tr>";
  echo "<td>{$row['id']}</td>";
  echo "<td>{$row['user']}</td>";
  echo "<td>" . str_replace("|", " | ", $row['action']) . "</td>";
  echo "<td>{$row['timestamp']}</td>";
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