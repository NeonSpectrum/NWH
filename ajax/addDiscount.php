<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($_POST['csrf_token'])) {
  $bookingID    = $system->filter_input($_POST['txtBookingID']);
  $discount     = $system->filter_input($_POST['txtDiscount']);
  $discountType = $system->filter_input($_POST['discountType']);
  $result       = $db->query("SELECT * FROM discount WHERE Name='$discountType'");
  $discountID   = $result->fetch_assoc()['DiscountID'];
  $result       = $db->query("SELECT * FROM booking_discount WHERE BookingID=$bookingID");
  if ($result->num_rows > 0) {
    echo "hi";
    if ($discountType == "Others") {
      echo "others";
      $db->query("UPDATE booking_discount SET DiscountID=$discountID, Amount='$discount' WHERE BookingID=$bookingID");
    } else {
      $db->query("UPDATE booking_discount SET DiscountID=$discountID WHERE BookingID=$bookingID");
    }
  } else {
    echo "hello";
    if ($discountType == "Others") {
      echo "others";
      $db->query("INSERT INTO booking_discount VALUES($bookingID,$discountID,$discount)");
    } else {
      $db->query("INSERT INTO booking_discount VALUES($bookingID,$discountID,NULL)");
    }
  }
  if ($db->affected_rows > 0) {
    $system->log("insert|booking.discount|{$system->formatBookingID($bookingID)}|$discount");
  }
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>