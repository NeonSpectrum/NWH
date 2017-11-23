<?php 
  require_once '../../header.php';
  if ($_SESSION['accountType']=='User' || !isset($_SESSION['accountType'])) {
    header('location: ../../');
    exit();
  }
?>
<?php require_once '../../files/sidebar.php';?>
<h2 id="header">Room Management</h2>
<div class="well center-block" id="body">
	<table id="tblRoomManagement" class="table table-striped table-bordered" cellspacing="0" style="display:none">
		<thead>
			<th>Room ID</th>
			<th>Room Type</th>
			<th>Switch</th>
		</thead>
		<tbody>
		<?php
			$query = "SELECT RoomID, RoomType, Active FROM room JOIN room_type ON room.RoomTypeID = room_type.RoomTypeID";
			$result = mysqli_query($db, $query);
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td>{$row['RoomID']}</td>";
				echo "<td>" . str_replace("_", " ", $row['RoomType']) . "</td>";
				$status = $row['Active'] == 1  ? 'checked' : '';
				echo "<td><input type='checkbox' data-toggle='toggle' class='cbxRoom' id='{$row['RoomID']}' $status/></td>";
				echo "</tr>";
			}
		?>
		</tbody>
	</table>
</div>
<?php require_once '../../footer.php';?>