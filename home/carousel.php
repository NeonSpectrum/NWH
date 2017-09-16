<?php
    $query = "select * from carousel";
    $result = mysqli_query($db, $query);
?>
<div class="overlay">
    <div class="logo-overlay">
        <div class="logo-text">
            <div class="full-screen">
            	<div id="mycarousel" class="carousel slide carousel-fade" data-ride="carousel">
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
                            while ($row = mysqli_fetch_assoc($result))
                            {
                                echo "<div class='item'><img src='/nwh/images/".$row['Source']."' alt='".$row['Name']."'></div>\n";
                            }
                        ?>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#mycarousel" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#mycarousel" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>