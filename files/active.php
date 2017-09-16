<?php
  $home = $gallery = $rates = $food = $amenities = $contact = '';
  if(strpos($_SERVER['PHP_SELF'],'home')){
    $home = 'class="active"';
  }
  elseif(strpos($_SERVER['PHP_SELF'],'gallery')){
    $gallery = 'class="active"';
  }
  elseif(strpos($_SERVER['PHP_SELF'],'rates')){
    $rates = 'class="active"';
  }
  elseif(strpos($_SERVER['PHP_SELF'],'foodanddrinks')){
    $food = 'class="active"';
  }
  elseif(strpos($_SERVER['PHP_SELF'],'amenities')){
    $amenities = 'class="active"';
  }
  elseif(strpos($_SERVER['PHP_SELF'],'contactus')){
    $contact = 'class="active"';
  }
?>