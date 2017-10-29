<div class="overlay">
	<div class="logo-overlay">
		<div class="logo-text">
			<div class="full-screen">
				<div id="pictures" class="carousel slide carousel-fade" data-ride="carousel">
					<!-- Indicators
					<ol class="carousel-indicators">
							<li data-target="#mycarousel" data-slide-to="0" class="active"></li>
							<li data-target="#mycarousel" data-slide-to="1"></li>
							<li data-target="#mycarousel" data-slide-to="2"></li>
							<li data-target="#mycarousel" data-slide-to="3"></li>
							<li data-target="#mycarousel" data-slide-to="4"></li>
					</ol> -->

					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<?php
							foreach (glob("images/carousel/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image)
							{
								$filename = str_replace("images/carousel/","",$image);
								echo "<div class='item'><img src='$image?v=".filemtime("$image")."' alt='$filename'></a></div>\n";
							}
						?>
					</div>

					<!-- Controls -->
					<a class="left carousel-control" href="#pictures" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#pictures" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>