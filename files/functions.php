<?php
require_once __DIR__ . '/../assets/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../assets/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../assets/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

function sendMail($email, $subject, $body) {
  try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = "ssl://cpanel02wh.sin1.cloud.z.com";
    $mail->SMTPAuth   = true;
    $mail->Username   = NOREPLY_EMAIL;
    $mail->Password   = PASSWORD;
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 465;

    $mail->setFrom(NOREPLY_EMAIL, "Northwood Hotel");
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "$subject";
    $mail->Body    = "$body";

    $mail->send();
    return true;
  } catch (Exception $e) {
    return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
  }
}

function getRoomPrice($room) {
  global $db;
  $query  = "SELECT * FROM room_type WHERE RoomType='$room'";
  $result = mysqli_query($db, $query);
  $row    = mysqli_fetch_assoc($result);
  if (mktime(0, 0, 0, 10, 1, date('Y')) < mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y')) && mktime(11, 59, 59, 5, 31, date('Y') + 1) > mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y'))) {
    $price = $row['PeakRate'];
  } else if (mktime(0, 0, 0, 7, 1, date('Y')) < mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y')) && mktime(11, 59, 59, 8, 31, date('Y') + 1) > mktime(date('H'), date('m'), date('s'), date('m'), date('d'), date('Y'))) {
    $price = $row['LeanRate'];
  } else {
    $price = $row['DiscountedRate'];
  }
  return $price;
}
function generateRoomID($room) {
  global $db;
  $rooms  = array();
  $query  = "SELECT RoomID, RoomType, Status FROM room JOIN room_type ON room.RoomTypeID = room_type.RoomTypeID WHERE RoomType = '$room'";
  $result = mysqli_query($db, $query);

  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['Status'] != 'Disabled' && $row['Status'] != 'Occupied') {
      $rooms[] = $row['RoomID'];
    }
  }
  if (empty($rooms)) {
    return "Full";
  }

  return $rooms[array_rand($rooms, 1)];
}
function nwh_encrypt($string) {
  return openssl_encrypt($string, "AES-128-ECB", ENCRYPT_KEYWORD);
}

function nwh_decrypt($string) {
  return openssl_decrypt($string, "AES-128-ECB", ENCRYPT_KEYWORD);
}
?>