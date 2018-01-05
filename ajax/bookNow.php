<?php
@session_start();
require_once '../files/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  parse_str($_POST['data'], $data);
  if ($system->validateToken($data['csrf_token'])) {
    $email         = $system->filter_input($_SESSION['account']['email']);
    $checkDate     = explode(" - ", $data['txtCheckDate']);
    $checkInDate   = date("Y-m-d", strtotime($checkDate[0]));
    $checkOutDate  = date("Y-m-d", strtotime($checkDate[1]));
    $adults        = $system->filter_input($data['txtAdults']);
    $children      = $system->filter_input($data['txtChildren']);
    $paymentMethod = $system->filter_input($data['txtPaymentMethod']);

    $arr = array();

    $db->query("INSERT INTO booking VALUES(NULL, '$email', '$checkInDate', '$checkOutDate', $adults, $children, 0,  NULL, '$paymentMethod','$date','$date')");

    if ($db->affected_rows > 0) {
      $bookingID = $db->insert_id;
      $system->createLog("insert|booking|" . $bookingID);
      $totalRoomPrice = 0;

      $arr[0] = $system->formatBookingID($bookingID);
      $arr[1] = "<br/><ul style='list-style-type:none'>";
      $table  = "<table border='1'><thead><th style='padding:10px'>Room Type</th><th style='padding:10px'>Quantity</th><th style='padding:10px'>Room Number(s)</th></thead><tbody>";
      foreach ($_POST['rooms'] as $key => $rooms) {
        $roomType     = str_replace(" ", "_", $rooms['roomType']);
        $roomQuantity = $system->filter_input($rooms['roomQuantity']);
        $roomIDs      = $room->generateRoomID($roomType, $roomQuantity, $checkInDate, $checkOutDate);
        for ($i = 1; $i <= $roomQuantity; $i++) {
          $roomPrice = $system->filter_input($room->getRoomPrice($roomType));
          $totalRoomPrice += $roomPrice;
          $roomID = $system->filter_input($roomIDs[$i - 1]);
          $db->query("INSERT INTO booking_room VALUES($bookingID, $roomID)");
        }
        $table .= "<tr><td style='padding:5px'>{$rooms['roomType']}</td><td style='padding:5px'>$roomQuantity</td><td style='padding:5px'>" . join(', ', $roomIDs) . "</td>";
        $arr[1] .= "<li>" . str_replace("_", " ", $roomType) . ": " . join(', ', $roomIDs) . "</li>";
      }

      $db->query("UPDATE booking SET TotalAmount=$totalRoomPrice WHERE BookingID=$bookingID");
      $table .= "</tbody></table>";
      $arr[1] .= "</ul>";

      $subject = "Northwood Hotel Reservation Confirmation";

      $body = "Dear {$_SESSION['account']['fname']} {$_SESSION['account']['lname']},<br/><br/>";
      $body .= "Booking ID: " . $system->formatBookingID($bookingID) . "<br/>";
      $body .= "Guest Type: {$_SESSION['account']['type']}<br/><br/>";
      $body .= "$table<br/><br/>";
      $body .= "Download and print this file: http://{$_SERVER['SERVER_NAME']}{$root}files/generateReservationConfirmation/?BookingID=" . $system->formatBookingID($bookingID);

      $system->sendMail($_SESSION['account']['email'], $subject, $body);
      echo json_encode($arr);
    } else {
      echo "There's something wrong in your book!";
    }
  }
}
?>