<div class="well center-block" style="width:80%">
	<table id="table_id" class="display">
		<thead>
			<tr>
				<?php
					$query = "SHOW COLUMNS FROM booking";
					$result = mysqli_query($db,$query);
					while ($row = mysqli_fetch_array($result))
					{
						echo "<th>{$row['Field']}</th>\n";
					}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
				$query = "SELECT * FROM  booking";
				$result = mysqli_query($db,$query) or die(mysql_error());

				while ($row = mysqli_fetch_assoc($result))
				{
					echo "<tr>";
					echo "<td>{$row['BookingID']}</td>";
					echo "<td>{$row['EmailAddress']}</td>";
					echo "<td>{$row['RoomID']}</td>";
					echo "<td>{$row['CheckInDate']}</td>";
					echo "<td>{$row['CheckOutDate']}</td>";
					echo "<td>{$row['Adults']}</td>";
					echo "<td>{$row['Childrens']}</td>";
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>