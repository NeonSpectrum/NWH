<?php
  require_once 'header.php';
  require_once 'files/navbar.php';
?>
<div class="overlay">
  <div class="logo-overlay">
    <div class="logo-text">
      <div class="full-screen">
        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
          <div class="carousel-inner" role="listbox">
            <?php
              foreach (glob("images/carousel/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image)
              {
                $filename = str_replace("images/carousel/","",$image);
                echo "<div class='item'><img src='$image?v=".filemtime("$image")."' alt='$filename'></div>\n";
              }
            ?>
          </div>
          <a class="left carousel-control" href="javascript:void(0)" role="button" onclick="$('#carousel').carousel('prev')" style="background:transparent !important">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="javascript:void(0)" role="button" onclick="$('#carousel').carousel('next')" style="background:transparent !important">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<div style="padding-top:40px">
	<div class="booknow center-block">
		<div class="booknow-content text-center">
			<form id="frmBookNow" class="form-inline">
					<div class="form-group">
						<label>Check In Date: </label>
						<input class="form-control" type="date" id="txtBookCheckInDate" name="txtBookCheckInDate" onkeypress="return disableKey(event,'number')" required/>
					</div>
					<div class="form-group">
						<label>Check Out Date: </label>
						<input class="form-control" type="date" id="txtBookCheckOutDate" name="txtBookCheckOutDate" onkeypress="return disableKey(event,'number')" required/>
					</div>
					<div class="form-group">
						<label>Adults: </label>
						<input class="form-control" type="number" id="txtBookAdults" name="txtBookAdults" value="0" onkeypress="return disableKey(event,'letter')" min="0" max="10" required/>
					</div>
					<div class="form-group">
						<label>Children: </label>
						<input class="form-control" type="number" id="txtBookChildrens" name="txtBookChildrens"value="0" onkeypress="return disableKey(event,'letter')" min="0" max="10" required/>
					</div>
					<div class="form-group">
						<label></label>
						<button class="btn btn-primary" id="btnBookNow">Book Now</button>
					</div>
			</form>
		</div>
	</div>
	<div class="homeContent">
		<div style="background: rgba(255, 255, 255, 0.3);height:100%;width:100%;">
			<div class="center-block" style="width:80%;margin-bottom:20px;padding-top:5px">
				<h1 class="animated scrollSlideUp" style="color:#2389c9;padding:10px;text-align:center;text-shadow: 1px 1px #FFFFFF">LUXURY MEETS AFFORDABILITY IN THE<br/>HEART OF ALAMINOS CITY</h1>
				<hr style="border-color:white;border-width:3px;width:10%"/>
				<div style="background:rgba(255,255,255,0.6)">
					<div class="p-home animated scrollSlideLeft">
						<p style="font-style:italic;">One of the most exciting and amazing tourist destination in the Philippines, The Hundred Islands National Park in Alaminos, Pangasinan that covers 123 islands with 1,844 hectares. Northwood Hotel is just a few minutes away from Don Gonzalo Montemayor wharf in Barangay Lucap where you can rent a boat and start exploring the beautiful paradise of Governor’s Island, Quezon Island, Marcos Island, Children Island and some other islets.</p>
					</div>
					<div class="youtube-iframe animated scrollSlideRight">
						<div class="youtube" data-embed="izqnhjcyP0E"> 
							<div class="play-button"></div> 
						</div>
					</div>
				</div>
				<hr style="border-color:white;border-width:3px;width:10%"/>
				<div class="center-block text-center">
					<div class="box-content animated scrollSlideLeft">
						<h2 style="color:#2389c9">Location</h2>
						<p style="font-style:italic;padding:30px;font-size:15px;">
							The Northwood Hotel is conveniently located at 21 Quezon Avenue, Poblacion Alaminos City, Pangasinan, the home of the famous “Hundred Islands National Park”.
							The hotel enjoys close proximity to churches, Nepo and Suki Markets, Bus and Van stations.
						</p>
						<a style="text-decoration:none;vertical-align: text-bottom;" href="https://www.google.com.ph/maps/place/Northwood+Hotel/@16.1515829,119.9837877,15z/data=!4m2!3m1!1s0x0:0x7c1d4eb8d67dd9fc?sa=X&ved=0ahUKEwjE0K2wqpXXAhXFp5QKHYJdAowQ_BIIbTAK">Read More...</a>
					</div>
					<div class="box-content animated scrollSlideUp">
						<h2 style="color:#2389c9">Rooms & Rates</h2>
						<p style="font-style:italic;padding:30px;font-size:15px;">
							Time to relax and indulge. Choose from our most beautiful rooms for your enjoyment.
						</p>
						<a style="text-decoration:none;vertical-align: text-bottom;" href="/roomandrates">Read More...</a>
					</div>
					<div class="box-content animated scrollSlideRight">
						<h2 style="color:#2389c9">Food</h2>
						<p style="font-style:italic;padding:30px;font-size:15px;">
							Enjoy our refreshing swimming pool, spa, and also our newly BigBite restaurant with out special brick oven pizza.
						</p>
						<a style="text-decoration:none;vertical-align: text-bottom;" href="/foodanddrinks">Read More...</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once 'footer.php';?>