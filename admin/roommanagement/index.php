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
	<div class="room-tabs">
		<div class="tab">
			<button class="tablinks active" onclick="openTab(event, 'rooms')">Rooms</button>
			<button class="tablinks" onclick="openTab(event, 'roomtypes')">Room Types</button>
		</div>
		<div id="rooms" class="tabcontent" style="display:block">
			<div class="galleryContent">
				<table id="tblRooms" class="table table-striped table-bordered" cellspacing="0" style="display:none">
					<thead>
						<th>Room ID</th>
						<th>Room Type</th>
						<th>Switch</th>
					</thead>
					<tbody>
					<?php
						$query = "SELECT RoomID, RoomType, RoomDescription, Status FROM room JOIN room_type ON room.RoomTypeID = room_type.RoomTypeID ORDER BY RoomID";
						$result = mysqli_query($db, $query);
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<tr>";
							echo "<td>{$row['RoomID']}</td>";
							echo "<td>" . str_replace("_", " ", $row['RoomType']) . "</td>";
							$checked = $row['Status'] == 'Enabled' || $row['Status'] == 'Occupied' ? 'checked' : '';
							$disabled = $row['Status'] == "Occupied" ? "data-onstyle='danger' disabled" : "";
							$status = $row['Status'] == "Occupied" ? "Occupied" : "Enabled";
							echo "<td><input type='checkbox' data-toggle='toggle' data-on='$status' data-off='Disabled' class='cbxRoom' id='{$row['RoomID']}' $checked $disabled/></td>";
							echo "</tr>";
						}
					?>
					</tbody>
				</table>
			</div>
		</div>

		<div id="roomtypes" class="tabcontent">
			<div class="galleryContent">
				<table id="tblRoomTypes" class="table table-striped table-bordered" cellspacing="0" style="display:none">
					<thead>
						<th>Room Type</th>
						<th>Room Description</th>
						<th>Action</th>
					</thead>
					<tbody>
					<?php
						$query = "SELECT RoomType, RoomDescription FROM room_type";
						$result = mysqli_query($db, $query);
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<tr>";
							echo "<td>" . str_replace("_", " ", $row['RoomType']) . "</td>";
							echo "<td style='width:60%'>{$row['RoomDescription']}</td>";
							echo "<td style='width:20%'><button class='btn btn-primary'>Edit</button></td>";
							echo "</tr>";
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php require_once '../../footer.php';?>