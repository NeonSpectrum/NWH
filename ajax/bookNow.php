<?php
@session_start();
require_once '../files/autoload.php';

parse_str($_POST['data'], $data);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $system->validateToken()) {
  $email         = $system->filter_input($data['txtEmail'] ?? $system->decrypt($_SESSION['account']));
  $checkDate     = explode(' - ', $data['txtCheckDate']);
  $checkInDate   = date('Y-m-d', strtotime($checkDate[0]));
  $checkOutDate  = date('Y-m-d', strtotime($checkDate[1]));
  $adults        = $system->filter_input($data['txtAdults']);
  $children      = $system->filter_input($data['txtChildren']);
  $paymentMethod = $system->filter_input($data['txtPaymentMethod']);

  $arr = [];

  $db->query("INSERT INTO booking VALUES(NULL, '{$data['type']}', '$email', '$checkInDate', '$checkOutDate', $adults, $children, '$dateandtime','$dateandtime')");

  if ($db->affected_rows > 0) {
    $bookingID = $db->insert_id;
    $system->log('insert|booking|' . $bookingID);
    $totalRoomPrice = 0;

    $arr[0] = $system->formatBookingID($bookingID);
    $arr[1] = "<table border='1' cellspacing='0' style='width:100%'><caption style='text-align:center;color:#333'><h3>Booking ID: {$arr[0]}</h3></caption><thead><th style='padding:10px;text-align:center'>Room Type</th><th style='padding:10px;text-align:center'>Quantity</th><th style='padding:10px;text-align:center'>Room ID(s)</th></thead><tbody>";
    $table  = "<table border='1' cellspacing='0'><thead><th style='padding:10px;text-align:center'>Room Type</th><th style='padding:10px;text-align:center'>Quantity</th><th style='padding:10px;text-align:center'>Room Number(s)</th></thead><tbody>";
    foreach ($_POST['rooms'] as $key => $rooms) {
      $roomType     = str_replace(' ', '_', $rooms['roomType']);
      $roomQuantity = $system->filter_input($rooms['roomQuantity']);
      $roomIDs      = $room->generateRoomID($roomType, $roomQuantity, $checkInDate, $checkOutDate);
      if (count($roomIDs) == $roomQuantity) {
        for ($i = 1; $i <= $roomQuantity; $i++) {
          $totalRoomPrice += $system->filter_input($room->getRoomPrice($roomType));
          $roomID = $system->filter_input($roomIDs[$i - 1]);
          $db->query("INSERT INTO booking_room VALUES($bookingID, $roomID)");
        }
      } else {
        $arr[0] = false;
        break;
      }
      $table .= "
        <tr>
          <td style='padding:5px'>{$rooms['roomType']}</td>
          <td style='padding:5px'>$roomQuantity</td>
          <td style='padding:5px'>" . join(', ', $roomIDs) . '</td>
        </tr>';
      $arr[1] .= "<tr><td style='padding:10px;text-align:center'>" . str_replace('_', ' ', $roomType) . "</td><td style='padding:10px;text-align:center'>$roomQuantity</td><td style='padding:10px;text-align:center'>" . join(', ', $roomIDs) . '</td>';
    }
    if ($arr[0] != false) {
      $totalRoomPrice *= count($system->getDatesFromRange($checkInDate, $checkOutDate)) - 1;
      $db->query("INSERT INTO booking_transaction VALUES($bookingID,'$paymentMethod',0,$totalRoomPrice,0,'$dateandtime')");
      $table .= '</tbody></table>';
      $arr[1] .= '</ul>';
      $roomsJson = json_encode($_POST['rooms']);
      $arr[2]    = "http://{$_SERVER['SERVER_NAME']}{$root}payment/process.php/?" . $system->encrypt("txtBookingID=$bookingID");
      $subject   = 'Northwood Hotel Reservation Confirmation';

      $body = "
Dear {$account->firstName} {$account->lastName},<br/><br/>
Booking ID: {$system->formatBookingID($bookingID)}<br/>
Guest Type: {$account->accountType}<br/><br/>
$table<br/><br/>
Download and print this file: <a href='http://{$_SERVER['SERVER_NAME']}{$root}files/generateReservationConfirmation/?BookingID={$system->formatBookingID($bookingID)}'>ReservationConfirmation.pdf</a>
";

      if (!isset($data['txtEmail'])) {
        $system->sendMail($email, $subject, $body);
      }
    } else {
      $db->query("DELETE FROM booking WHERE BookingID = $bookingID");
      $db->query("DELETE FROM booking_room WHERE BookingID = $bookingID");
    }
  } else {
    $arr[0] = false;
  }
  echo json_encode($arr);
} else if (!$system->validateToken()) {
  echo INVALID_TOKEN;
}
?>
