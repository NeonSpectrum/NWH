<?php require_once $root.'../files/db.php';?>

<div class="galleryDiv">
	<div class="tab">
		<button class="tablinks active" onclick="openTab(event, 'bigbite')">BigBite</button>
		<button class="tablinks" onclick="openTab(event, 'family')">Family Room</button>
		<button class="tablinks" onclick="openTab(event, 'function')">Function Hall</button>
		<button class="tablinks" onclick="openTab(event, 'junior')">Junior Suite</button>
		<button class="tablinks" onclick="openTab(event, 'single')">Standard Single Room</button>
		<button class="tablinks" onclick="openTab(event, 'double')">Standard Double Room</button>
		<button class="tablinks" onclick="openTab(event, 'pool')">Swimming Pool</button>
	</div>

	<div id="bigbite" class="tabcontent" style="display:block">
		<div class="galleryContent">
			<?php
				$query = "select * from gallery where category='bigbite'";
				$result = mysqli_query($db, $query);
				while ($row = mysqli_fetch_assoc($result))
				{
					echo "<img src='images/".$row['Category']."/".$row['Source']."' class='zoom' alt='".$row['Name']."'/>\n";
				}
			?>
		</div>
	</div>

	<div id="family" class="tabcontent">
		<div class="galleryContent">
			<?php
				$query = "select * from gallery where category='family'";
				$result = mysqli_query($db, $query);
				while ($row = mysqli_fetch_assoc($result))
				{
					echo "<img src='images/".$row['Category']."/".$row['Source']."' class='zoom' alt='".$row['Name']."'/>\n";
				}
			?>
		</div>
	</div>

	<div id="function" class="tabcontent">
		<div class="galleryContent">
			<?php
				$query = "select * from gallery where category='function'";
				$result = mysqli_query($db, $query);
				while ($row = mysqli_fetch_assoc($result))
				{
					echo "<img src='images/".$row['Category']."/".$row['Source']."' class='zoom' alt='".$row['Name']."'/>\n";
				}
			?>
		</div>
	</div>
	
	<div id="junior" class="tabcontent">
		<div class="galleryContent">
			<?php
				$query = "select * from gallery where category='junior'";
				$result = mysqli_query($db, $query);
				while ($row = mysqli_fetch_assoc($result))
				{
					echo "<img src='images/".$row['Category']."/".$row['Source']."' class='zoom' alt='".$row['Name']."'/>\n";
				}
			?>
		</div>
	</div>
	
	<div id="single" class="tabcontent">
		<div class="galleryContent">
			<?php
				$query = "select * from gallery where category='single'";
				$result = mysqli_query($db, $query);
				while ($row = mysqli_fetch_assoc($result))
				{
					echo "<img src='images/".$row['Category']."/".$row['Source']."' class='zoom' alt='".$row['Name']."'/>\n";
				}
			?>
		</div>
	</div>
	
	<div id="double" class="tabcontent">
		<div class="galleryContent">
			<?php
				$query = "select * from gallery where category='double'";
				$result = mysqli_query($db, $query);
				while ($row = mysqli_fetch_assoc($result))
				{
					echo "<img src='images/".$row['Category']."/".$row['Source']."' class='zoom' alt='".$row['Name']."'/>\n";
				}
			?>
		</div>
	</div>
	
	<div id="pool" class="tabcontent">
		<div class="galleryContent">
			<?php
				$query = "select * from gallery where category='pool'";
				$result = mysqli_query($db, $query);
				while ($row = mysqli_fetch_assoc($result))
				{
					echo "<img src='images/".$row['Category']."/".$row['Source']."' class='zoom' alt='".$row['Name']."'/>\n";
				}
			?>
		</div>
	</div>
</div>