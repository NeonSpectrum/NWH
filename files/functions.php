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
  $result = executeQuery("SELECT * FROM room_type WHERE RoomType='$room'");
  $row    = $result->fetch_assoc();
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
  $result = executeQuery("SELECT RoomID, RoomType, Status FROM room JOIN room_type ON room.RoomTypeID = room_type.RoomTypeID WHERE RoomType = '$room'");

  while ($row = $result->fetch_assoc()) {
    if ($row['Status'] != 'Disabled' && $row['Status'] != 'Occupied') {
      $rooms[] = $row['RoomID'];
    }
  }
  if (empty($rooms)) {
    return "Full";
  }

  return $rooms[array_rand($rooms, 1)];
}

function getBetween($var1 = "", $var2 = "", $pool) {
  $temp1  = strpos($pool, $var1) + strlen($var1);
  $result = substr($pool, $temp1, strlen($pool));
  $dd     = strpos($result, $var2);
  if ($dd == 0) {
    $dd = strlen($result);
  }

  return substr($result, 0, $dd);
}

function nwh_encrypt($string) {
  return openssl_encrypt($string, "AES-128-ECB", ENCRYPT_KEYWORD);
}

function nwh_decrypt($string) {
  return openssl_decrypt($string, "AES-128-ECB", ENCRYPT_KEYWORD);
}
?>