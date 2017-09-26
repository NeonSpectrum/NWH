<div class="datagrid center-block" style="width:80%;height:80%;">
	<table>
		<thead>
			<tr>
				<?php
					parse_str($_SERVER['QUERY_STRING']);
					$page = isset($page) ? $page : 1;
					$order = isset($order) ? $order : 'BookingID';
					$sort = isset($sort) ? $sort=='ASC' ? 'DESC' : 'ASC' : 'ASC';
					$entries = isset($entries) ? $entries : 10;

					$numberOfColumn = 0;
					$query = "SHOW COLUMNS FROM booking";
					$result = mysqli_query($db,$query);
					while ($row = mysqli_fetch_array($result))
					{
						if($order == $row["Field"])
							echo "<th><a href='index.php?page=$page&order=".$row["Field"]."&sort=$sort&entries=$entries' style='text-decoration:none;color:white'>".$row['Field']."</a></th>\n";
						else
							echo "<th><a href='index.php?page=$page&order=".$row["Field"]."&sort=ASC&entries=$entries' style='text-decoration:none;color:white'>".$row['Field']."</a></th>\n";
						$numberOfColumn++;
					}
					parse_str($_SERVER['QUERY_STRING']);
				?>
			</tr>
		</thead>
		<tfoot>
			<tr>
			<td colspan="<?php echo $numberOfColumn;?>">
				<div id="paging">
					<label style="float:left;margin:10px;font-size:15px;">Number of Entries: </label>
					<select style="float:left;margin:5px;width:100px;height:30px;font-size:15px;" id="cmbEntries" value="10">
						<option value="5" <?php if (isset($entries) && $entries=="5") echo "selected";?>>5</option>
						<option value="10" <?php if (isset($entries) && $entries=="10") echo "selected";?>>10</option>
						<option value="20" <?php if (isset($entries) && $entries=="20") echo "selected";?>>20</option>
						<option value="30" <?php if (isset($entries) && $entries=="30") echo "selected";?>>30</option>
						<option value="40" <?php if (isset($entries) && $entries=="40") echo "selected";?>>40</option>
						<option value="50" <?php if (isset($entries) && $entries=="50") echo "selected";?>>50</option>
					</select>
					<ul>
						<li><a href="<?php $previous = $page-1; if($previous==0) echo 'javascript:void(0);'; else echo 'index.php?page='.$previous.'&order='.$order.'&sort='.$sort.'&entries='.$entries;?>"><span>Previous</span></a></li>
						<?php
							$query = "SELECT * FROM booking";
							$result = mysqli_query($db,$query);
							$count = ceil(mysqli_num_rows($result)/$entries);
							for($i=1;$i<=$count;$i++)
							{
								echo "<li><a href='index.php?page=$i&order=$order&sort=$sort&entries=$entries'><span>$i</span></a>";
							}
						?>
						<li><a href="<?php $next = $page+1; if($next>$count) echo 'javascript:void(0);'; else echo 'index.php?page='.$next.'&order='.$order.'&sort='.$sort.'&entries='.$entries;?>"><span>Next</span></a></li>
					</ul>
				</div>
			</tr>
		</tfoot>
		<tbody>
			<?php
				$page = isset($page) ? $page*$entries-$entries : 0;
				$query = "SELECT * FROM  booking ORDER BY `$order` $sort LIMIT $page,$entries";
				$result = mysqli_query($db,$query) or die(mysql_error());

				while ($row = mysqli_fetch_assoc($result))
				{
					echo "<tr>";
					echo "<td>" . $row['BookingID'] . "</td>";
					echo "<td>" . $row['EmailAddress'] . "</td>";
					echo "<td>" . $row['RoomID'] . "</td>";
					echo "<td>" . $row['CheckInDate'] . "</td>";
					echo "<td>" . $row['CheckOutDate'] . "</td>";
					echo "<td>" . $row['Adults'] . "</td>";
					echo "<td>" . $row['Childrens'] . "</td>";
					echo "</tr>";
					$row=mysqli_fetch_assoc($result);
					echo "<tr class='alt'>";
					echo "<td>" . $row['BookingID'] . "</td>";
					echo "<td>" . $row['EmailAddress'] . "</td>";
					echo "<td>" . $row['RoomID'] . "</td>";
					echo "<td>" . $row['CheckInDate'] . "</td>";
					echo "<td>" . $row['CheckOutDate'] . "</td>";
					echo "<td>" . $row['Adults'] . "</td>";
					echo "<td>" . $row['Childrens'] . "</td>";
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>