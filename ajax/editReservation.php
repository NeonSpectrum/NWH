<?php
require_once '../files/autoload.php';
if (isset($_POST['data'])) {
  parse_str($_POST['data'], $data);
  $resultToken = $system->validateToken($data['csrf_token']);
} else {
  $resultToken = $system->validateToken($_POST['csrf_token']);
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && $resultToken) {
  if (isset($_POST['type']) && $_POST['type'] == "admin") {
    $checkDate    = explode(" - ", $system->filter_input($_POST['txtCheckDate']));
    $checkInDate  = $system->formatDate($checkDate[0], "Y-m-d");
    $checkOutDate = $system->formatDate($checkDate[1], "Y-m-d");
    $adults       = $system->filter_input($_POST['txtAdults']);
    $children     = $system->filter_input($_POST['txtChildren']);
    $bookingID    = $system->filter_input($_POST['cmbBookingID']);

    $row          = $db->query("SELECT * FROM booking JOIN booking_transaction ON booking.BookingID=booking_transaction.BookingID WHERE booking.BookingID=$bookingID")->fetch_assoc();
    $numberOfDays = count($system->getDatesFromRange($row['CheckInDate'], $row['CheckOutDate'])) - 1;
    $db->query("UPDATE booking SET CheckInDate='$checkInDate', CheckOutDate='$checkOutDate',Adults=$adults,Children=$children,DateUpdated='$dateandtime' WHERE BookingID=$bookingID");

    if ($db->affected_rows > 0) {
      $amount       = $row['TotalAmount'] / $numberOfDays;
      $numberOfDays = count($system->getDatesFromRange($checkInDate, $checkOutDate)) - 1;
      $amount *= $numberOfDays;
      $db->query("UPDATE booking_transaction SET TotalAmount=$amount WHERE BookingID=$bookingID");
      $system->log("update|booking|$bookingID");
      echo true;
    } else {
      echo $db->error;
    }
  } else if ($data['type'] == "booking") {
    $bookingID     = $system->filter_input($data['cmbBookingID']);
    $checkDate     = explode(" - ", $system->filter_input($data['txtCheckDate']));
    $checkInDate   = $system->formatDate($checkDate[0], "Y-m-d");
    $checkOutDate  = $system->formatDate($checkDate[1], "Y-m-d");
    $adults        = $system->filter_input($data['txtAdults']);
    $children      = $system->filter_input($data['txtChildren']);
    $paymentMethod = $system->filter_input($data['txtPaymentMethod']);

    $db->query("UPDATE booking JOIN booking_transaction ON booking.BookingID=booking_transaction.BookingID SET CheckInDate='$checkInDate', CheckOutDate='$checkOutDate', Adults=$adults, Children=$children, PaymentMethod='$paymentMethod' WHERE booking.BookingID=$bookingID");
    $db->query("DELETE FROM booking_room WHERE BookingID=$bookingID");

    $output         = true;
    $totalRoomPrice = 0;
    foreach (json_decode($_POST['rooms'], true) as $key => $rooms) {
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
        $output = false;
        break;
      }
    }
    if ($output != false) {
      $totalRoomPrice *= count($system->getDatesFromRange($checkInDate, $checkOutDate)) - 1;
      $db->query("UPDATE booking JOIN booking_transaction ON booking.BookingID=booking_transaction.BookingID SET TotalAmount=$totalRoomPrice, DateUpdated='$date' WHERE booking.BookingID=$bookingID");
    }
    if (isset($_FILES['file'])) {
      $directory = $_SERVER['DOCUMENT_ROOT'] . "{$root}images/bankreferences/";
      @mkdir($directory);
      $bankResult = $db->query("SELECT * FROM booking_bank WHERE BookingID=$bookingID");
      $bankRow    = $bankResult->fetch_assoc();
      if ($bankResult->num_rows == 0) {
        do {
          $randomName = $system->getRandomString(20);
        } while (file_exists($directory . $randomName));
      } else {
        $randomName = $bankRow['Filename'];
      }
      $filename = basename($randomName);
      $moveFile = $system->saveImage($_FILES['file'], $directory, $filename);
      if ($moveFile === true) {
        $bankResult = $db->query("SELECT * FROM booking_bank WHERE BookingID=$bookingID");
        if ($bankResult->num_rows > 0) {
          $system->log("update|bankreference|$bookingID");
        } else {
          $db->query("INSERT INTO booking_bank VALUES($bookingID,'$randomName')");
          $system->log("insert|bankreference|$bookingID");
        }
      } else {
        $output = $moveFile;
      }
    }
    echo $output;
  }
} else if (!$system->validateToken($_POST['csrf_token'])) {
  echo INVALID_TOKEN;
}
?>