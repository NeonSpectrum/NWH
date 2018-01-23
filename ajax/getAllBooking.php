<?php
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $result = $db->query("SELECT * FROM booking JOIN account ON booking.EmailAddress=account.EmailAddress");
  $arr    = [];
  for ($i = 0; $row = $result->fetch_assoc(); $i++) {
    $arr[$i]['title'] = $row['EmailAddress'];
    $arr[$i]['name']  = $row['FirstName'] . " " . $row['LastName'];
    $roomResult       = $db->query("SELECT * FROM booking_room WHERE BookingID={$row['BookingID']}");
    $rooms            = [];
    while ($roomRow = $roomResult->fetch_assoc()) {
      $rooms[] = $roomRow['RoomID'];
    }
    sort($rooms);
    $arr[$i]['bookingID']    = $system->formatBookingID($row['BookingID']);
    $arr[$i]['room']         = join(", ", $rooms) . " (" . count($rooms) . ")";
    $arr[$i]['checkInDate']  = date("m/d/Y", strtotime($row['CheckInDate']));
    $arr[$i]['checkOutDate'] = date("m/d/Y", strtotime($row['CheckOutDate']));
    $arr[$i]['start']        = "{$row['CheckInDate']}T14:00";
    $arr[$i]['end']          = "{$row['CheckOutDate']}T12:00";
    $checkResult             = $db->query("SELECT * FROM booking_check WHERE BookingID={$row['BookingID']} AND CheckIn IS NOT NULL AND CheckOut IS NULL");
    $arr[$i]['checked']      = $checkResult->num_rows > 0;
    $paymentResult           = $db->query("SELECT AmountPaid FROM booking WHERE AmountPaid>0 UNION SELECT PaymentAmount FROM booking_paypal WHERE BookingID={$row['BookingID']}");
    $arr[$i]['paid']         = $paymentResult->num_rows > 0;
  }
  echo json_encode($arr);
}
?>