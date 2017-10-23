<?php 
	require '../files/header.php';
	require '../files/navbar.php';
?>
<div class="container-fluid">
	<div id="googleMap" style="height:550px;width:100%"></div>
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
</div>
<script>
	function myMap() {
		var myLatLng = {lat: 16.151583, lng: 119.983788};
		
		var map = new google.maps.Map(document.getElementById('googleMap'), {
			zoom: 17,
			center: myLatLng
		});

		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map,
			title: 'Hello World!'
		});
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdU9-yp6efQJtHGsYuGEgLd7xMqJujFh8&callback=myMap"></script>
<?php require '../files/footer.php';?>