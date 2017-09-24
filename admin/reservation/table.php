<div class="datagrid center-block" style="width:80%;height:80%;">
	<table>
		<thead>
			<tr>
				<?php
					if(isset($_SERVER['QUERY_STRING']))
					{
						parse_str($_SERVER['QUERY_STRING']);
					}
					$page = isset($page) ? $page : 1;
					$order = isset($order) ? $order : 'BookingID';
					$sort = isset($sort) ? $sort=='ASC' ? 'DESC' : 'ASC' : 'ASC';
					$numberOfColumn = 0;
					$query = "SHOW COLUMNS FROM booking";
					$result = mysqli_query($db,$query);
					while ($row = mysqli_fetch_array($result))
					{
						if($order == $row["Field"])
							echo "<th><a href='index.php?page=$page&order=".$row["Field"]."&sort=$sort' style='text-decoration:none;color:white'>".$row['Field']."</a></th>\n";
						else
							echo "<th><a href='index.php?page=$page&order=".$row["Field"]."&sort=ASC' style='text-decoration:none;color:white'>".$row['Field']."</a></th>\n";
						$numberOfColumn++;
					}
				?>
			</tr>
		</thead>
		<tfoot>
			<tr>
			<td colspan="<?php echo $numberOfColumn;?>">
				<div id="paging">
					<ul>
						<li><a href="<?php $previous = $page-1; if($previous==0) echo 'javascript:void(0);'; else echo 'index.php?page='.$previous;?>"><span>Previous</span></a></li>
						<?php
							$query = "SELECT * FROM booking";
							$result = mysqli_query($db,$query);
							$count = ceil(mysqli_num_rows($result)/10);
							for($i=1;$i<=$count;$i++)
							{
								echo "<li><a href='index.php?page=$i'><span>$i</span></a>";
							}
							?><li><a href="<?php $next = $page+1; if($next>$count) echo 'javascript:void(0);'; else echo 'index.php?page='.$next;?>"><span>Next</span></a></li>
					</ul>
				</div>
			</tr>
		</tfoot>
		<tbody>
			<?php
				$page = isset($page) ? $page*10-10 : 0;
				$query = "SELECT * FROM  booking ORDER BY `$order` $sort LIMIT $page,10";
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