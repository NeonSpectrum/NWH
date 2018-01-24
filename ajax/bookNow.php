<?php
@session_start();
require_once '../files/autoload.php';

parse_str($_POST['data'], $data);
if ($_SERVER['REQUEST_METHOD'] == "POST" && $system->validateToken($data['csrf_token'])) {
  $email         = $system->filter_input($data['txtEmail'] ?? $_SESSION['account']['email']);
  $checkDate     = explode(" - ", $data['txtCheckDate']);
  $checkInDate   = date("Y-m-d", strtotime($checkDate[0]));
  $checkOutDate  = date("Y-m-d", strtotime($checkDate[1]));
  $adults        = $system->filter_input($data['txtAdults']);
  $children      = $system->filter_input($data['txtChildren']);
  $paymentMethod = $system->filter_input($data['txtPaymentMethod']);

  $arr = array();

  $db->query("INSERT INTO booking VALUES(NULL, '{$data['type']}', '$email', '$checkInDate', '$checkOutDate', $adults, $children, 0,  NULL, '$paymentMethod','$date','$date')");

  if ($db->affected_rows > 0) {
    $bookingID = $db->insert_id;
    $system->log("insert|booking|" . $bookingID);
    $totalRoomPrice = 0;

    $arr[0] = $system->formatBookingID($bookingID);
    $arr[1] = "<br/><ul style='list-style-type:none'>";
    $table  = "<table border='1' cellspacing='0'><thead><th style='padding:10px'>Room Type</th><th style='padding:10px'>Quantity</th><th style='padding:10px'>Room Number(s)</th></thead><tbody>";
    foreach ($_POST['rooms'] as $key => $rooms) {
      $roomType     = str_replace(" ", "_", $rooms['roomType']);
      $roomQuantity = $system->filter_input($rooms['roomQuantity']);
      $roomIDs      = $room->generateRoomID($roomType, $roomQuantity, $checkInDate, $checkOutDate);
      if (count($roomIDs) > 0) {
        for ($i = 1; $i <= $roomQuantity; $i++) {
          $totalRoomPrice += $system->filter_input($room->getRoomPrice($roomType));
          $roomID = $system->filter_input($roomIDs[$i - 1]);
          $db->query("INSERT INTO booking_room VALUES($bookingID, $roomID)");
        }
      } else {
        $arr[0] = false;
        break;
      }
      $table .= "<tr><td style='padding:5px'>{$rooms['roomType']}</td><td style='padding:5px'>$roomQuantity</td><td style='padding:5px'>" . join(', ', $roomIDs) . "</td>";
      $arr[1] .= "<li>" . str_replace("_", " ", $roomType) . ": " . join(', ', $roomIDs) . "</li>";
    }
    if ($arr[0] != false) {
      $totalRoomPrice *= count($system->getDatesFromRange($checkInDate, $checkOutDate)) - 1;
      $db->query("UPDATE booking SET TotalAmount=$totalRoomPrice WHERE BookingID=$bookingID");
      $table .= "</tbody></table>";
      $arr[1] .= "</ul>";
      $roomsJson = json_encode($_POST['rooms']);
      $arr[2]    = "http://{$_SERVER['SERVER_NAME']}{$root}payment/process.php/?" . $system->encrypt("txtBookingID=$bookingID&csrf_token={$data['csrf_token']}");
      $subject   = "Northwood Hotel Reservation Confirmation";

      $body = "Dear {$_SESSION['account']['fname']} {$_SESSION['account']['lname']},<br/><br/>";
      $body .= "Booking ID: " . $system->formatBookingID($bookingID) . "<br/>";
      $body .= "Guest Type: {$_SESSION['account']['type']}<br/><br/>";
      $body .= "$table<br/><br/>";
      $body .= "Download and print this file: http://{$_SERVER['SERVER_NAME']}{$root}files/generateReservationConfirmation/?BookingID=" . $system->formatBookingID($bookingID);

      if (!isset($data['txtEmail']) && $_SERVER['SERVER_NAME'] != "localhost") {
        $system->sendMail($email, $subject, $body);
      }
    }
  } else {
    $arr[0] = false;
  }
  echo json_encode($arr);
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>