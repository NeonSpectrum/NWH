<?php
@session_start();
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/*--------------- VARIABLES --------------*/
$levels = ["User", "Receptionist", "Admin", "Creator"];
/*----------------------------------------*/

/*----------------------------------------*/
/*-------------Account Class--------------*/
/*----------------------------------------*/
class Account extends System {

  public function login($credentials) {
    global $db;
    $email    = $this->filter_input($credentials['email']);
    $password = $this->filter_input($credentials['password'], true);

    $result = $db->query("SELECT * FROM `account` WHERE EmailAddress='$email'");
    $row    = $result->fetch_assoc();

    if ($result->num_rows == 1 && password_verify($password, $row['Password'])) {
      $_SESSION['account']['email']         = $row['EmailAddress'];
      $_SESSION['account']['fname']         = $row['FirstName'];
      $_SESSION['account']['lname']         = $row['LastName'];
      $_SESSION['account']['picture']       = $row['ProfilePicture'];
      $_SESSION['account']['type']          = $row['AccountType'];
      $_SESSION['account']['birthDate']     = $row['BirthDate'];
      $_SESSION['account']['contactNumber'] = $row['ContactNumber'];

      $db->query("UPDATE account SET SessionID='" . session_id() . "' WHERE EmailAddress='$email'");
      $this->log("login|account", $email);
      return true;
    } else {
      return false;
    }
  }

  public function logout() {
    global $root;
    if (isset($_COOKIE['nwhAuth'])) {
      setcookie('nwhAuth', '', time() - (60 * 60 * 24 * 7), '/');
      unset($_COOKIE['nwhAuth']);
    }
    unset($_SESSION['account']);
    $referrer = $_SERVER['HTTP_REFERER'] ?? $root;
    if (stripos($referrer, "/reservation") || stripos($referrer, "/admin")) {
      header("location: $root");
    } else {
      header("location: $referrer");
    }
  }

  public function verifyRegistration($credentials) {
    global $db, $date, $root;
    $fname         = ucwords(strtolower($this->filter_input($credentials['txtFirstName'])));
    $lname         = ucwords(strtolower($this->filter_input($credentials['txtLastName'])));
    $email         = $this->filter_input($credentials['txtEmail']);
    $password      = $this->filter_input($credentials['txtPassword'], true);
    $contactNumber = $this->filter_input($credentials['txtContactNumber']);
    $birthDate     = $this->filter_input($credentials['txtBirthDate']);

    $result = $db->query("SELECT * FROM account WHERE EmailAddress='$email'");

    if ($result->num_rows == 0) {
      $data     = $this->encrypt("txtFirstName=$fname&txtLastName=$lname&txtEmail=$email&txtPassword=$password&txtContactNumber=$contactNumber&txtBirthDate=$birthDate&TimeStamp=" . strtotime("now"));
      $subject  = "Northwood Hotel Account Creation";
      $body     = "Please proceed to this link to register your account:<br/>Click <a href='http://{$_SERVER['SERVER_NAME']}{$root}account/?mode=register&token=$data'>here</a> to register.";
      $sentMail = $this->sendMail($email, $subject, $body);
      if ($sentMail == true) {
        $this->log("sent|registration|$email");
        echo true;
      } else {
        echo $sentMail;
      }
    } else {
      echo ALREADY_REGISTERED;
    }
  }

  public function register($credentials, $verify = true) {
    global $db, $date, $root;
    $fname         = ucwords(strtolower($this->filter_input($credentials['txtFirstName'])));
    $lname         = ucwords(strtolower($this->filter_input($credentials['txtLastName'])));
    $email         = $this->filter_input($credentials['txtEmail']);
    $password      = password_hash($this->filter_input($credentials['txtPassword'], true), PASSWORD_DEFAULT);
    $contactNumber = $this->filter_input($credentials['txtContactNumber']);
    $birthDate     = date("Y-m-d", strtotime($this->filter_input($credentials['txtBirthDate'])));

    if (isset($credentials['expirydate']) && $this->isExpired($credentials['TimeStamp'], EMAIL_EXPIRATION)) {
      return "<script>alert('Link Expired. Please register again.');location.href='$root';</script>";
    }

    $db->query("INSERT INTO `account`(EmailAddress,Password,FirstName,LastName,ContactNumber,BirthDate,DateRegistered) VALUES ('$email', '$password', '$fname', '$lname','$contactNumber','$birthDate','$date')");

    if (!$verify) {
      if ($db->affected_rows > 0) {
        $this->log("insert|account.register|$email']}", (VERIFY_REGISTER ? $_SESSION['account']['email'] : ""));
        return true;
      } else {
        return ALREADY_REGISTERED;
      }
    } else {
      if ($db->affected_rows > 0) {
        if (AUTO_LOGIN_AT_REGISTER) {
          $_SESSION['account']['email']         = $email;
          $_SESSION['account']['fname']         = $fname;
          $_SESSION['account']['lname']         = $lname;
          $_SESSION['account']['picture']       = "default.png";
          $_SESSION['account']['type']          = "User";
          $_SESSION['account']['birthDate']     = $birthDate;
          $_SESSION['account']['contactNumber'] = $contactNumber;
        }
        $this->log("registered|account|$email");
        return "<script>alert('Registered Successfully!');location.href='$root';</script>";
      } else {
        return "<script>alert('Already Registered!');location.href='$root';</script>";
      }
    }
  }

  public function checkEmail($email) {
    global $db;
    $result = $db->query("SELECT * FROM account WHERE EmailAddress='$email'");

    if ($result->num_rows > 0 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return true;
    } else {
      return false;
    }
  }

  public function changePassword($credentials, $forgot) {
    global $db;
    $email   = $credentials['email'];
    $oldpass = $forgot == false ? $credentials['oldpass'] : null;
    $newpass = $credentials['newpass'];
    if ($forgot == true) {
      $db->query("UPDATE account SET Password='$newpass' WHERE EmailAddress='$email'");
      if ($db->affected_rows > 0) {
        $this->log("update|user.password|$email");
        $this->expireToken($email, $credentials['token']);
        return true;
      } else {
        return $db->error;
      }
    } else {
      $result = $db->query("SELECT * FROM `account` WHERE EmailAddress='$email'");
      $row    = $result->fetch_assoc();

      if ($result->num_rows == 1 && password_verify($oldpass, $row['Password'])) {
        $result = $db->query("UPDATE account SET Password='$newpass' WHERE EmailAddress='$email'");
        if ($db->affected_rows > 0) {
          $this->log("update|user.password");
          return true;
        } else {
          return $db->error;
        }
      }
    }
  }

  public function forgotPassword($email) {
    global $db, $root;
    $result = $db->query("SELECT * FROM `account` WHERE EmailAddress='$email'");
    $row    = $result->fetch_assoc();

    if ($result->num_rows > 0) {
      $this->log("sent|forgot.password|$email");
      $data    = "email=$email&token=" . $this->generateForgotToken($email);
      $subject = "Northwood Hotel Forgot Password";
      $body    = "Please proceed to this link to reset your password:<br/>Click <a href='http://{$_SERVER['SERVER_NAME']}{$root}?$data'>here</a> to change your password.";

      return $this->sendMail("$email", "$subject", "$body");
    }
  }

  private function generateForgotToken($email) {
    global $db, $dateandtime;
    $token = $this->getRandomString(50);
    $db->query("INSERT INTO forgot_password VALUES(NULL, '$email', '$token', 0, '$dateandtime')");
    if ($db->affected_rows > 0) {
      $this->log("insert|account.generate.token|$email");
      return $token;
    } else {
      return $db->error;
    }
  }

  public function verifyForgotToken($email, $token) {
    global $db;
    $result = $db->query("SELECT * FROM forgot_password WHERE EmailAddress='$email' AND Token='$token'");
    $row    = $result->fetch_assoc();
    if ($result->num_rows > 0 && !$row['Used'] && !$this->isExpired($row['TimeStamp'], FORGOT_EXPIRATION)) {
      return true;
    } else {
      return $db->error;
    }
  }

  public function expireToken($email, $token) {
    global $db;
    $db->query("UPDATE forgot_password SET Used=1 WHERE EmailAddress='$email' AND Token='$token'");
    if ($db->affected_rows > 0) {
      return true;
    } else {
      return $db->error;
    }
  }

  public function editProfile($credentials, $admin = false) {
    global $db, $root;
    $output = NOTHING_CHANGED;
    if ($admin) {
      $email       = $credentials['email'];
      $accountType = $credentials['accountType'];
      $firstName   = $credentials['firstName'];
      $lastName    = $credentials['lastName'];

      $result = $db->query("UPDATE `account` SET AccountType='$accountType',FirstName='$firstName',LastName='$lastName' WHERE EmailAddress='$email'");
      if ($db->affected_rows > 0) {
        $this->log("update|account|$email");
        echo true;
      } else {
        echo $output;
      }
    } else {
      if (isset($credentials['image'])) {
        $directory = $_SERVER['DOCUMENT_ROOT'] . "{$root}images/profilepics/";
        $filename  = basename($_SESSION['account']['fname'] . $_SESSION['account']['lname']) . "." . pathinfo($directory . basename($credentials['image']["name"]), PATHINFO_EXTENSION);
        $output    = $this->saveImage($credentials['image'], $directory, $filename);
        if ($output == true) {
          $db->query("UPDATE account SET ProfilePicture='$filename' WHERE EmailAddress='{$_SESSION['account']['email']}'");
          $this->log("update|account.profilepicture");
          $_SESSION['account']["picture"] = $filename;
        } else {
          return $output;
        }
      }

      $email         = $this->filter_input($_SESSION['account']['email']);
      $fname         = $this->filter_input($credentials['fname']);
      $lname         = $this->filter_input($credentials['lname']);
      $birthDate     = date("Y-m-d", strtotime($this->filter_input($credentials['birthDate'])));
      $contactNumber = $this->filter_input($credentials['contactNumber']);

      $db->query("UPDATE account SET FirstName='$fname', LastName='$lname', BirthDate='$birthDate', ContactNumber='$contactNumber' WHERE EmailAddress='$email'");

      if ($db->affected_rows > 0) {
        $_SESSION['account']['fname']         = $fname;
        $_SESSION['account']['lname']         = $lname;
        $_SESSION['account']['birthDate']     = $birthDate;
        $_SESSION['account']['contactNumber'] = $contactNumber;
        $this->log("update|account.profile");
        $output = true;
      }
      return $output;
    }
  }

  public function deleteAccount($email) {
    global $db;
    if ($this->checkUserLevel(3)) {
      $result = $db->query("DELETE FROM account WHERE EmailAddress='$email'");

      if ($db->affected_rows > 0) {
        $this->log("delete|account|$email");
        return true;
      } else {
        return $db->error;
      }
    }
    return ERROR_OCCURED;
  }

}

/*----------------------------------------*/
/*----------------Room Class--------------*/
/*----------------------------------------*/
class Room extends System {

  public function editRoomDescription($roomType, $description, $simpDesc, $icon) {
    global $db;
    $db->query("UPDATE room_type SET RoomDescription='$description', RoomSimplifiedDescription='$simpDesc', Icons='$icon' WHERE RoomType='$roomType'");

    if ($db->affected_rows > 0) {
      $this->log("update|room_type|$roomType");
      return true;
    } else {
      return NOTHING_CHANGED;
    }
  }

  public function updateRoomStatus($roomID, $status) {
    global $db;
    $result = $db->query("UPDATE room SET Status = '$status' WHERE RoomID = $roomID");

    if ($db->affected_rows > 0) {
      $this->log("update|room.status|$roomID|$status");
      echo true;
    } else {
      echo ERROR_OCCURED;
    }
  }

  public function getRoomInfo($roomID) {
    global $db;
    $result = $db->query("SELECT * FROM account JOIN booking ON account.EmailAddress=booking.EmailAddress JOIN booking_room ON booking.BookingID=booking_room.BookingID JOIN booking_check ON booking.BookingID=booking_check.BookingID WHERE RoomID=$roomID AND CheckIn IS NOT NULL AND CheckOut IS NULL ORDER BY CheckIn DESC LIMIT 1");
    $row    = $result->fetch_assoc();
    $infos  = [
      "bookingID"    => $this->formatBookingID($row['BookingID']),
      "name"         => $row['FirstName'] . " " . $row['LastName'],
      "email"        => $row['EmailAddress'],
      "checkInDate"  => $row['CheckInDate'],
      "checkOutDate" => $row['CheckOutDate'],
    ];
    $rooms  = [];
    $result = $db->query("SELECT * FROM booking JOIN booking_room ON booking.BookingID=booking_room.BookingID WHERE booking.BookingID={$row['BookingID']}");
    while ($row = $result->fetch_assoc()) {
      $rooms[] = $row['RoomID'];
    }
    $infos["rooms"] = join($rooms, ", ");
    return $infos;
  }

  public function getRoomIDList($bookingID = null) {
    global $db;
    $rooms = [];
    if ($bookingID != null) {
      $result = $db->query("SELECT * FROM booking_room WHERE BookingID=$bookingID");
    } else {
      $result = $db->query("SELECT * FROM room");
    }
    while ($row = $result->fetch_assoc()) {
      $rooms[] = $row['RoomID'];
    }
    sort($rooms);
    return $rooms;
  }

  public function getRoomTypeList() {
    global $db;
    $roomType = [];
    $result   = $db->query("SELECT * FROM room_type");
    while ($row = $result->fetch_assoc()) {
      $roomType[] = $row['RoomType'];
    }
    return $roomType;
  }

  public function getRoomType($roomID) {
    global $db;
    $result = $db->query("SELECT * FROM room JOIN room_type ON room.RoomTypeID=room_type.RoomTypeID WHERE RoomID=$roomID");
    $row    = $result->fetch_assoc();
    return $row['RoomType'];
  }

  public function getRoomPrice($room) {
    global $db, $date;
    $room   = str_replace(" ", "_", $room);
    $result = $db->query("SELECT * FROM room_type WHERE RoomType='$room'");
    $row    = $result->fetch_assoc();
    if ((strtotime(date("Y") . "-10-01") <= strtotime($date) && strtotime(date("Y") . "-12-31") >= strtotime($date)) || (strtotime(date("Y") . "-01-01") <= strtotime($date) && strtotime(date("Y") . "-05-31") >= strtotime($date))) {
      // September 1 - May 31
      $price = $row['PeakRate'];
    } else if (strtotime(date("Y") . "-07-01") <= strtotime($date) && strtotime(date("Y") . "-08-31") >= strtotime($date)) {
      // July 1 - August 31
      $price = $row['LeanRate'];
    } else {
      $price = $row['DiscountedRate'];
    }
    return $price;
  }

  public function getUsingRoomList() {
    global $db, $date;
    $rooms  = [];
    $result = $db->query("SELECT RoomID FROM booking JOIN booking_room ON booking.BookingID=booking_room.BookingID JOIN booking_check ON booking.BookingID=booking_check.BookingID WHERE CheckOut IS NULL AND CheckInDate='$date'");
    while ($row = $result->fetch_assoc()) {
      $rooms[] = $row['RoomID'];
    }
    return $rooms;
  }

  public function generateRoomID($room = 1, $quantity, $checkInDate, $checkOutDate) {
    global $db, $date;
    $room   = $room != 1 ? "RoomType = '$room'" : $room;
    $rooms  = [];
    $result = $db->query("SELECT RoomID, RoomType, Status FROM room JOIN room_type ON room.RoomTypeID = room_type.RoomTypeID WHERE $room");
    while ($row = $result->fetch_assoc()) {
      $roomResult = $db->query("SELECT * FROM room JOIN booking_room ON room.RoomID=booking_room.RoomID JOIN booking ON booking_room.BookingID=booking.BookingID LEFT JOIN booking_cancelled ON booking.BookingID=booking_cancelled.BookingID WHERE room.RoomID = '{$row['RoomID']}' AND CheckOutDate>='$date' AND DateCancelled IS NULL");
      if ($roomResult->num_rows > 0) {
        while ($roomRow = $roomResult->fetch_assoc()) {
          if ($this->isBetweenDate($checkInDate, $checkOutDate, $roomRow['CheckInDate'], $roomRow['CheckOutDate'])) {
            $roomAvailable = false;
            break;
          }
          $roomAvailable = true;
        }
      } else {
        $roomAvailable = true;
      }
      if ($row['Status'] != 'Disabled' && $roomAvailable && !in_array($row['RoomID'], $rooms)) {
        $rooms[] = $row['RoomID'];
      }
    }
    shuffle($rooms);
    return count($rooms) > 0 ? array_slice($rooms, 0, $quantity) : $rooms;
  }

}

/*----------------------------------------*/
/*--------------Booking Class-------------*/
/*----------------------------------------*/
class Booking {
  public function revertCheck($bookingID, $type) {
    global $db;
    if ($type == "checkIn") {
      $db->query("DELETE FROM booking_check WHERE BookingID=$bookingID");
    } else if ($type == "checkOut") {
      $result = $db->query("SELECT * FROM booking_check WHERE BookingID=$bookingID");
      if ($result->num_rows > 0) {
        $db->query("UPDATE booking_check SET CheckOut=NULL WHERE BookingID=$bookingID");
      } else {
        return false;
      }
    }
    return $db->affected_rows > 0;
  }
}

/*----------------------------------------*/
/*---------------View Class---------------*/
/*----------------------------------------*/
class View extends Room {
  public function promoPictures() {
    foreach (glob("images/promos/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
      $filename = str_replace("images/promos/", "", $image);
      echo "      ";
      echo "<div>
        <img data-u='image' src='$image?v=" . filemtime("$image") . "' alt='$filename'>
        <div u='thumb'>Slide Description 001</div>
      </div>\n";
    }
  }
  public function homeJssor() {
    foreach (glob("images/carousel/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
      $filename = str_replace("images/carousel/", "", $image);
      echo "      ";
      echo "<div data-b='0' data-p='112.50' style='display: none;'>
        <img data-u='image' src='$image?v=" . filemtime("$image") . "' alt='$filename'>
      </div>\n";
    }
  }

  public function homeRooms() {
    global $db;
    $result = $db->query("SELECT * FROM room_type");
    while ($row = $result->fetch_assoc()) {
      echo "      ";
      echo "<div class='wow slideInUp center-block text-center col-md-4' style='margin-bottom:40px'>
        <figure class='imghvr-fade-in'>
          <img src='gallery/images/rooms/{$row['RoomType']}.jpg?v=" . filemtime("gallery/images/rooms/{$row['RoomType']}.jpg") . "'>
          <figcaption style='background: url(\"gallery/images/rooms/{$row['RoomType']}.jpg\") center;text-align:center;color:black;padding:0px'>
            <div style='background-color:rgba(255,255,255,0.8);position:relative;height:100%;width:100%;'>
              <div style='text-align:center;color:black;font-size:22px;padding-top:10px'>" . str_replace("_", " ", $row['RoomType']) . "<br/><div style='font-size:15px'>Price starts at <i>₱" . number_format($this->getRoomPrice($row['RoomType'])) . "</i></div></div>
              <p style='padding:40px 20px'>{$row['RoomDescription']}</p>
            </div>
          </figcaption>
          <div style='text-align:center;color:black;font-size:22px'>" . str_replace("_", " ", $row['RoomType']) . "<br/><div style='font-size:15px'>Price starts at <i>₱" . number_format($this->getRoomPrice($row['RoomType'])) . "</i></div></div>
        </figure>
        <div style='position:relative;height:20px;margin-top:-6px'>
          <button id='{$row['RoomType']}' class='btn btn-info btnMoreInfo' style='width:50%;position:absolute;left:0' data-toggle='modal' data-target='#modalRoom'>More Info</button>
          <button onclick='location.href=\"reservation\"' class='btn btn-primary' style='width:50%;position:absolute;right:0'>Book Now</button>
        </div>
      </div>\n";
    }
  }

  public function gallery($category) {
    foreach (glob("images/{$category}/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
      $filename  = str_replace("images/{$category}/", "", $image);
      $thumbnail = str_replace("images/{$category}/", "images/{$category}/thumbnail/", $image);
      echo "<a href='$image' data-caption='$filename'><img src='$thumbnail?v=" . filemtime("$thumbnail") . "' alt='$filename' class='zoom'></a>\n";
    }
  }

  public function roomandrates() {
    global $db;
    $result = $db->query("SELECT * FROM room_type");
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td class='img-baguette' data-tooltip='tooltip' data-placement='bottom' title='Click to view images'>";
      $first = true;
      foreach (glob("../gallery/images/rooms/{$row['RoomType']}*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
        $filename = str_replace("../gallery/images/rooms/", "", $image);
        $caption  = str_replace([".jpg", ".bmp", ".jpeg", ".png"], "", $filename);
        echo "<a href='$image' data-caption='$caption' style='";
        echo $first == true ? "" : "display:none";
        echo "'><img src='$image?v=" . filemtime("$image") . "' alt='$filename' height='200px'></a>\n";
        $first = false;
      }
      echo "</td>";
      echo "<td style='vertical-align:top'>
          <h3><b>" . str_replace("_", " ", $row['RoomType']) . "</b></h3><br/>
          {$row['RoomDescription']}";
      echo "<div style='padding: 10px 10px'>";
      $icons = explode("\n", $row['Icons']);
      foreach ($icons as $key => $value) {
        $iconArr = explode("=", $value);
        $icon    = $iconArr[0] ?? "";
        $title   = $iconArr[1] ?? "";
        echo "<i class='fa fa-$icon fa-2x' data-tooltip='tooltip' data-placement='bottom' title='$title' style='margin-right:20px'></i>";
      }
      echo "</div>";
      echo "</td>";
      echo "<td><center>From<br/><br/><span style='font-size:20px;'><b>₱&nbsp;" . number_format($this->getRoomPrice($row['RoomType'])) . "</b></span></center></td>";
      echo "</tr>";
    }
  }

  public function booking() {
    global $db, $root, $date;
    $result = $db->query("SELECT booking.BookingID, EmailAddress, CheckInDate, CheckOutDate, Adults, Children, AmountPaid, TotalAmount,PaymentMethod, DateCreated, RoomType, booking_room.RoomID, DateCancelled FROM booking JOIN booking_room ON booking.BookingID=booking_room.BookingID JOIN room ON room.RoomID=booking_room.RoomID JOIN room_type ON room_type.RoomTypeID=room.RoomTypeID LEFT JOIN booking_cancelled ON booking.BookingID=booking_cancelled.BookingID");
    while ($row = $result->fetch_assoc()) {
      $cancelled = $row['DateCancelled'] == null ? false : true;
      if ($row['PaymentMethod'] == "PayPal") {
        $paypalResult = $db->query("SELECT BookingID, SUM(PaymentAmount) As TotalAmount FROM `booking_paypal` WHERE BookingID={$row['BookingID']} GROUP BY BookingID");
        $paypalRow    = $paypalResult->fetch_assoc();
        $amountPaid   = $row['AmountPaid'] + $paypalRow['TotalAmount'];
      } else {
        $amountPaid = $row['AmountPaid'];
      }
      if (strtotime($row['CheckInDate']) >= strtotime($date) && !$cancelled) {
        echo "<td id='txtBookingID'>{$this->formatBookingID($row['BookingID'])}</td>";
        echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
        echo "<td id='txtRoomID'>{$row['RoomID']}</td>";
        echo "<td id='txtRoomType' style='display:none'>" . str_replace("_", " ", $row['RoomType']) . "</td>";
        echo "<td id='txtCheckInDate'>" . date("m/d/Y", strtotime($row['CheckInDate'])) . "</td>";
        echo "<td id='txtCheckOutDate'>" . date("m/d/Y", strtotime($row['CheckOutDate'])) . "</td>";
        echo "<td id='txtAdults'>{$row['Adults']}</td>";
        echo "<td id='txtChildren'>{$row['Children']}</td>";
        echo "<td id='txtAmountPaid'>₱&nbsp;" . number_format($amountPaid) . "</td>";
        echo "<td id='txtBalance'>₱&nbsp;" . number_format(($row['TotalAmount'] - $amountPaid)) . "</td>";
        echo "<td id='txtTotalAmount'>₱&nbsp;" . number_format($row['TotalAmount']) . "</td>";
        echo "<td>";
        echo "<a class='btnEditReservation col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0' data-toggle='modal' data-target='#modalEditReservation' data-tooltip='tooltip' data-placement='bottom' title='Edit'><i class='fa fa-pencil fa-2x'></i></a>";
        echo "<a class='btnCancel col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0' data-tooltip='tooltip' data-placement='bottom' title='Cancel'" . (!$this->checkUserLevel(2) ? " disabled" : "") . "><i class='fa fa-ban fa-2x' style='color:red'></i></a>";
        echo "<a class='btnAddPayment col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0' data-toggle='modal' data-target='#modalAddPayment' data-tooltip='tooltip' data-placement='bottom' title='Add Payment'><i class='fa fa-money fa-2x' style='color:green'></i></a>";
        echo "<a class='col-md-6' onclick='window.open(\"{$root}files/generateReservationConfirmation?BookingID=" . $this->formatBookingID($row['BookingID']) . "\",\"_blank\",\"height=650,width=1000\")' style='padding:0;cursor:pointer' data-tooltip='tooltip' data-placement='bottom' title='Print'><i class='fa fa-print fa-2x'></i></a>";
        echo "</td>";
        echo "</tr>";
      }
    }
  }

  public function check() {
    global $db, $date;
    $result = $db->query("SELECT booking.BookingID, EmailAddress, CheckInDate, CheckOutDate, CheckIn, CheckOut, Adults, Children, ExtraCharges, Discount, TotalAmount FROM booking LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID LEFT JOIN booking_cancelled ON booking.BookingID=booking_cancelled.BookingID WHERE DateCancelled IS NULL");
    while ($row = $result->fetch_assoc()) {
      $roomResult = $db->query("SELECT * FROM booking_room WHERE BookingID={$row['BookingID']}");
      $rooms      = [];
      while ($roomRow = $roomResult->fetch_assoc()) {
        $rooms[] = $roomRow['RoomID'];
      }
      $checkInStatus  = $row['CheckIn'] == '' ? false : true;
      $checkOutStatus = $row['CheckOut'] == '' ? false : true;
      $checkIn        = $row['CheckIn'] != null ? date("m/d/Y h:i:s A", strtotime($row['CheckIn'])) : "";
      $checkOut       = $row['CheckOut'] != null ? date("m/d/Y h:i:s A", strtotime($row['CheckOut'])) : "";
      $dates          = $this->getDatesFromRange($row['CheckInDate'], date("Y-m-d", strtotime($row['CheckOutDate']) - 86400));
      if (in_array($date, $dates) || ($checkIn != "" && $checkOut == "")) {
        echo "<tr>";
        echo "<td id='txtBookingID'>{$this->formatBookingID($row['BookingID'])}</td>";
        echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
        echo "<td id='txtRoomID'>" . join(", ", $rooms) . "</td>";
        echo "<td id='txtAdults'>{$row['Adults']}</td>";
        echo "<td id='txtChildren'>{$row['Children']}</td>";
        echo "<td id='txtCheckIn'>$checkIn</td>";
        echo "<td id='txtCheckOut'>$checkOut</td>";
        echo "<td id='txtExtraCharges'>₱&nbsp;" . number_format($row['ExtraCharges']) . "</td>";
        echo "<td id='txtDiscount'>" . (strpos($row['Discount'], "%") ? $row['Discount'] : "₱&nbsp;" . number_format($row['Discount'])) . "</td>";
        echo "<td id='txtTotalAmount'>₱&nbsp;" . number_format($row['TotalAmount'] + $row['ExtraCharges']) . "</td>";
        echo "<td>";
        echo "<a data-tooltip='tooltip' data-placement='bottom' title='Check In' class='btnCheckIn col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0'" . ($checkInStatus ? ' disabled' : '') . "><i class='fa fa-calendar-plus-o fa-2x'></i></a>";
        echo "<a data-tooltip='tooltip' data-placement='bottom' title='Check Out' class='btnCheckOut col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0'" . ($checkOutStatus || !$checkInStatus ? ' disabled' : '') . "><i class='fa fa-calendar-minus-o fa-2x'></i></a>";
        echo !$checkOutStatus && $checkInStatus ? "<a class='btnAddExpenses col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0' data-toggle='modal' data-target='#modalAddExpenses' data-tooltip='tooltip' data-placement='bottom' title='Add Expenses'><i class='fa fa-money fa-2x' style='color:green'></i></a>" : "";
        echo !$checkOutStatus && $checkInStatus ? "<a class='btnAddDiscount col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0' data-toggle='modal' data-target='#modalAddDiscount' data-tooltip='tooltip' data-placement='bottom' title='Add Discount'><i class='fa fa-gift fa-2x' style='color:red'></i></a>" : "";
        echo $checkOutStatus && $checkInStatus ? "<a class='btnShowBill col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0' data-tooltip='tooltip' data-placement='bottom' title='Show Bill'><i class='fa fa-money fa-2x' style='color:red'></i></a>" : "";
        echo "</td>";
        echo "</tr>";
      }
    }
  }

  public function listOfReservation() {
    global $db;
    $result = $db->query("SELECT booking.BookingID, EmailAddress, CheckInDate, CheckOutDate, CheckIn, CheckOut, Adults, Children FROM booking LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID");
    while ($row = $result->fetch_assoc()) {
      $roomResult = $db->query("SELECT * FROM booking_room WHERE BookingID={$row['BookingID']}");
      $rooms      = [];
      while ($roomRow = $roomResult->fetch_assoc()) {
        $rooms[] = $roomRow['RoomID'];
      }
      $checkIn  = $row['CheckIn'] != null ? date("m/d/Y h:i:s A", strtotime($row['CheckIn'])) : "";
      $checkOut = $row['CheckOut'] != null ? date("m/d/Y h:i:s A", strtotime($row['CheckOut'])) : "";
      echo "<tr>";
      echo "<td>{$this->formatBookingID($row['BookingID'])}</td>";
      echo "<td>{$row['EmailAddress']}</td>";
      echo "<td>" . join(", ", $rooms) . "</td>";
      echo "<td>" . date("m/d/Y", strtotime($row['CheckInDate'])) . "</td>";
      echo "<td>" . date("m/d/Y", strtotime($row['CheckOutDate'])) . "</td>";
      echo "<td>$checkIn</td>";
      echo "<td>$checkOut</td>";
      echo "<td>{$row['Adults']}</td>";
      echo "<td>{$row['Children']}</td>";
      echo "</tr>";
    }
  }

  public function listOfCancelledBooking() {
    global $db;
    $result = $db->query("SELECT booking.BookingID, EmailAddress, CheckInDate, CheckOutDate, Adults, Children FROM booking JOIN booking_cancelled ON booking.BookingID=booking_cancelled.BookingID");
    while ($row = $result->fetch_assoc()) {
      $roomResult = $db->query("SELECT * FROM booking_room WHERE BookingID={$row['BookingID']}");
      $rooms      = [];
      while ($roomRow = $roomResult->fetch_assoc()) {
        $rooms[] = $roomRow['RoomID'];
      }
      echo "<tr>";
      echo "<td>{$this->formatBookingID($row['BookingID'])}</td>";
      echo "<td>{$row['EmailAddress']}</td>";
      echo "<td>" . join(", ", $rooms) . "</td>";
      echo "<td>" . date("m/d/Y", strtotime($row['CheckInDate'])) . "</td>";
      echo "<td>" . date("m/d/Y", strtotime($row['CheckOutDate'])) . "</td>";
      echo "<td>{$row['Adults']}</td>";
      echo "<td>{$row['Children']}</td>";
      echo "</tr>";
    }
  }

  public function listOfPaypalPayment() {
    global $db;
    $result = $db->query("SELECT * FROM account JOIN booking ON account.EmailAddress=booking.EmailAddress JOIN booking_paypal ON booking.BookingID=booking_paypal.BookingID");
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>{$this->formatBookingID($row['BookingID'])}</td>";
      echo "<td>{$row['EmailAddress']}</td>";
      echo "<td>{$row['PayerID']}</td>";
      echo "<td>{$row['PaymentID']}</td>";
      echo "<td>{$row['InvoiceNumber']}</td>";
      echo "<td>{$row['PaymentAmount']}</td>";
      echo "<td>" . date("m/d/Y h:i:s A", strtotime($row['TimeStamp'])) . "</td>";
      echo "</tr>";
    }
  }

  public function accounts() {
    global $db;
    $result = $db->query("SELECT * FROM account");
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
      echo "<td id='txtFirstName'>{$row['FirstName']}</td>";
      echo "<td id='txtLastName'>{$row['LastName']}</td>";
      echo "<td id='txtBirthDate'>" . date("m/d/Y", strtotime($row['BirthDate'])) . "</td>";
      echo "<td id='txtContactNumber'>{$row['ContactNumber']}</td>";
      echo "<td id='txtAccountType'>{$row['AccountType']}</td>";
      echo "<td>";
      if ($row['AccountType'] != "Owner" || $this->checkUserLevel(2)) {
        echo "<a class='btnEditAccount' data-tooltip='tooltip' data-placement='bottom' title='Edit' id='{$row['EmailAddress']}' style='cursor:pointer' data-toggle='modal' data-target='#modalEditAccount'><i class='fa fa-pencil fa-2x' aria-hidden='true'></i></a>";

        echo "&nbsp;&nbsp;";
      }
      if ($_SESSION['account']['email'] != $row['EmailAddress'] && $this->checkUserLevel(3)) {
        echo "<a class='btnDeleteAccount' data-tooltip='tooltip' data-placement='bottom' title='Delete' id='{$row['EmailAddress']}' style='cursor:pointer'><i class='fa fa-trash fa-2x' aria-hidden='true'></i></a>";

      }
      echo "</td>";
      echo "</tr>";
    }
  }

  public function eventLogs() {
    global $db;
    $result = $db->query("SELECT * FROM log");
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>{$row['ID']}</td>";
      echo "<td>{$row['EmailAddress']}</td>";
      echo "<td>" . str_replace("|", " | ", $row['Action']) . "</td>";
      echo "<td>" . date("m/d/Y h:i:s A", strtotime($row['TimeStamp'])) . "</td>";
      echo "</tr>";
    }
  }

  public function listBookingID($type = "get") {
    global $db;
    $email      = $this->filter_input($_SESSION['account']['email']);
    $result     = $db->query("SELECT * FROM booking WHERE EmailAddress = '$email'");
    $first      = true;
    $bookingIDs = [];
    while ($row = $result->fetch_assoc()) {
      $tomorrow = strtotime(date("Y-m-d")) + 86400 * EDIT_RESERVATION_DAYS;
      if ($tomorrow <= strtotime($row['CheckInDate'])) {
        if ($type == "combobox") {
          if ($first) {
            $adults   = $row['Adults'];
            $children = $row['Children'];
            $first    = false;
          }
          echo "                ";
          echo "<option value='" . $row['BookingID'] . "'>" . $this->formatBookingID($row['BookingID']) . "</option>\n";
        } else {
          $bookingIDs[] = $row['BookingID'];
        }
      }
    }
    if ($type == "get") {
      return count($bookingIDs) > 0 ? $bookingIDs : false;
    }
  }

  public function rooms($category) {
    global $db;
    if ($category == "statuses") {
      $query  = "SELECT RoomID, RoomType, RoomDescription, Status FROM room JOIN room_type ON room.RoomTypeID = room_type.RoomTypeID ORDER BY RoomID";
      $result = mysqli_query($db, $query);
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['RoomID']}</td>";
        echo "<td>" . str_replace("_", " ", $row['RoomType']) . "</td>";
        $checked  = $row['Status'] == 'Enabled' || $row['Status'] == 'Occupied' ? 'checked' : '';
        $disabled = $row['Status'] == "Occupied" ? "data-onstyle='danger' disabled" : "";
        $status   = $row['Status'] == "Occupied" ? "Occupied" : "Enabled";
        echo "<td><input type='checkbox' data-toggle='toggle' data-on='$status' data-off='Disabled' class='cbxRoom' id='{$row['RoomID']}' $checked $disabled/></td>";
        echo "</tr>";
      }
    } else if ($category == "descriptions") {
      $result = $db->query("SELECT RoomType, RoomDescription, RoomSimplifiedDescription, Icons FROM room_type");
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='width:10%'>" . str_replace("_", " ", $row['RoomType']) . "</td>";
        echo "<td style='width:40%' id='txtRoomDescription'>{$row['RoomDescription']}</td>";
        echo "<td style='width:20%' id='txtRoomSimpDesc'>" . nl2br($row['RoomSimplifiedDescription']) . "</td>";
        echo "<td style='width:20%' id='txtIcon'>" . nl2br($row['Icons']) . "</td>";
        echo "<td style='width:10%'><a class='btnEditRoom' style='cursor:pointer' data-toggle='modal' data-target='#modalEditRoom' id='{$row['RoomType']}' data-tooltip='tooltip' data-placement='bottom' title='Edit'><i class='fa fa-pencil fa-2x' aria-hidden='true'></i></a></td>";
        echo "</tr>";
      }
    }

  }

}

/*----------------------------------------*/
/*--------------System Class--------------*/
/*----------------------------------------*/
class System {

  public function addVisitorCount() {
    global $db, $date;
    $result = $db->query("SELECT * FROM `visitor-count` WHERE Date='$date'");
    if ($result->num_rows == 0) {
      $db->query("INSERT INTO `visitor-count` VALUES('$date','1')");
    } else {
      $db->query("UPDATE `visitor-count` SET Count=Count+1 WHERE Date='$date'");
    }
  }

  public function getAllEmailAddress() {
    global $db;
    $result = $db->query("SELECT * FROM account");
    $list   = [];
    while ($row = $result->fetch_assoc()) {
      $list[] = $row['EmailAddress'];
    }
    return $list;
  }

  public function getNextBookingID() {
    global $db;
    $result = $db->query("SHOW TABLE STATUS LIKE 'booking'");
    $row    = $result->fetch_assoc();
    return $row['Auto_increment'];
  }

  public function computeBill($bookingID) {
    global $db;
    $result      = $db->query("SELECT * FROM booking LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID LEFT JOIN booking_paypal ON booking.BookingID=booking_paypal.BookingID WHERE booking.BookingID=$bookingID");
    $row         = $result->fetch_assoc();
    $totalAmount = $row['TotalAmount'] + $row['ExtraCharges'];
    $amountPaid  = $row['AmountPaid'] + $row['PaymentAmount'];
    if (strpos($row['Discount'], "%")) {
      return $totalAmount - ($totalAmount * $this->percentToDecimal($row['Discount'])) - $amountPaid;
    } else {
      return $totalAmount - $row['Discount'] - $amountPaid;
    }
  }

  public function payBill($bookingID) {
    global $db;
    $result      = $db->query("SELECT * FROM booking JOIN booking_check ON booking.BookingID=booking_check.BookingID WHERE booking.BookingID=$bookingID");
    $row         = $result->fetch_assoc();
    $totalAmount = $row['TotalAmount'] + $row['ExtraCharges'];
    $db->query("UPDATE booking SET AmountPaid=$totalAmount WHERE BookingID=$bookingID");
    return $db->affected_rows > 0;
  }

  public function isLogged() {
    return isset($_SESSION['account']) ? true : false;
  }

  public function checkUserLevel($reqLevel, $kick = false) {
    global $root, $levels;
    if ($this->isLogged()) {
      $currentLevel = array_search($_SESSION['account']['type'], $levels);
      if ($currentLevel < $reqLevel && !($currentLevel >= 1 && ALLOW_CREATOR_PRIVILEGES)) {
        if ($kick) {
          header("location: http://{$_SERVER['SERVER_NAME']}{$root}");
        } else {
          return false;
        }
      } else {
        return true;
      }
    } else if ($kick) {
      $this->redirectLogin();
    }
  }

  public function redirectLogin() {
    global $root;
    if (!strpos($_SERVER['QUERY_STRING'], $_SERVER['SERVER_NAME']) && !$this->isLogged()) {
      $referrer = "//" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
      $url      = rawurlencode($referrer);
      echo "<script>location.replace('//{$_SERVER['SERVER_NAME']}{$root}account/login.php?redirect=$url')</script>";
    }
  }

  public function sendContactForm($name, $email, $contactNumber, $message) {
    $subject = "Message from $email";
    $body    = "Name: $name<br/>Email: $email<br/>Contact Number: $contactNumber<br/>Message: $message";
    return $this->sendMail(SUPPORT_EMAIL, $subject, $body, "Northwood Hotel Support");
  }

  public function sendMail($email, $subject, $body, $title = "") {
    try {
      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host     = "ssl://cpanel02wh.sin1.cloud.z.com:465";
      $mail->SMTPAuth = true;
      $mail->Username = NOREPLY_EMAIL;
      $mail->Password = PASSWORD;

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

  public function saveImage($image, $directory, $filename) {
    return move_uploaded_file($image["tmp_name"], $directory . $filename) ? true : UPLOAD_ERROR;
  }

  public function validateToken($token) {
    return $_SESSION['csrf_token'] === $this->decrypt($token);
  }

  public function log($action, $email = "") {
    global $db;
    $email = $email == "" && isset($_SESSION['account']['email']) ? $_SESSION['account']['email'] : $email;
    $date  = date("Y-m-d H:i:s");
    $db->query("INSERT INTO log VALUES(NULL, '$email', '$action', '$date')");
  }

  public function formatBookingID($id) {
    global $db;
    $result = $db->query("SELECT * FROM booking WHERE BookingID=$id");
    $row    = $result->fetch_assoc();
    return "nwh" . date("mdy", strtotime($row['DateCreated'])) . "-" . sprintf("% '04d", $id);
  }

  public function verifyCaptcha($captcha) {
    if (!$captcha) {
      return 'Please check the the captcha form.';
    }
    $secretKey    = "6Ler0DUUAAAAABE_r5gAH7LhkRPAavkyNkUOOQZd";
    $ip           = $_SERVER['REMOTE_ADDR'];
    $response     = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
    $responseKeys = json_decode($response, true);
    if (intval($responseKeys["success"]) !== 1) {
      return 'You are spammer ! Get the @$%K out';
    }
    return true;
  }

  public function isExpired($date, $time) {
    $seconds = $time * 60;
    return strtotime($date) + $seconds < strtotime("now");
  }

  public function isBetweenDate($checkDate1, $checkDate2, $date1, $date2) {
    $checkDate = $this->getDatesFromRange($checkDate1, date("Y-m-d", strtotime($checkDate2) - 86400));
    $date      = $this->getDatesFromRange($date1, date("Y-m-d", strtotime($date2) - 86400));

    foreach ($checkDate as $key => $value) {
      if (in_array($value, $date)) {
        return true;
      }
    }
    return false;
  }

  public function getDatesFromRange($start, $end) {
    $dates = [];
    if ($start != $end) {
      $end = new DateTime($end);
      $end->add(new DateInterval('P1D'));

      $period = new DatePeriod(new DateTime($start), new DateInterval('P1D'), $end);

      foreach ($period as $date) {
        $dates[] = $date->format("Y-m-d");
      }
    } else {
      $dates[] = date("Y-m-d", strtotime($start));
    }
    return $dates;
  }
  public function importdb($file) {
    $contents = file_get_contents($file);

    $comment_patterns = array('/\/\*.*(\n)*.*(\*\/)?/',
      '/\s*--.*\n/',
      '/\s*#.*\n/',
    );
    $contents = preg_replace($comment_patterns, "\n", $contents);

    $statements = explode(";", $contents);
    $statements = preg_replace("/\s/", ' ', $statements);
    foreach ($statements as $query) {
      if (trim($query) != '') {
        $res = $db->query($query);
      }
    }
  }

  public function backupdb($tables, $type) {
    global $db;
    $hasData = false;
    @mkdir("../files/backup");
    @mkdir("../files/backup/sql");
    @mkdir("../files/backup/excel");
    $filename = date('Y-m-d h-i-s A') . " [" . join($tables, "][") . ']';
    if ($type == "sql" || $type == "all") {
      $filedir  = "../files/backup/sql/$filename.sql";
      $filedata = "";
      foreach ($tables as $table) {
        $columns = [];
        $result  = $db->query("SHOW COLUMNS FROM $table");
        while ($row = $result->fetch_assoc()) {
          $columns[] = $row['Field'];
        }
        $result = $db->query("SELECT * FROM $table");
        while ($row = $result->fetch_assoc()) {
          $hasData = true;
          $data    = [];
          foreach ($columns as $column) {
            $data[] = $row["$column"];
          }
          $query = "INSERT INTO $table (" . join($columns, ",") . ") VALUES('" . join($data, "','") . "')";
          $filedata .= $query . PHP_EOL;
        }
      }
      if (trim($filedata) != "") {
        $file = fopen($filedir, 'w');
        fwrite($file, $filedata);
        fclose($file);
      }
    }
    if ($type == "excel" || $type == "all") {
      $spreadsheet = new Spreadsheet();
      for ($x = 0; $x < count($tables); $x++) {
        if ($x > 0) {
          $spreadsheet->createSheet();
        }
        $spreadsheet->setActiveSheetIndex($x);
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle($tables[$x]);
        $result  = $db->query("SHOW COLUMNS FROM {$tables[$x]}");
        $columns = [];
        for ($i = 'A'; $row = $result->fetch_assoc(); $i++) {
          $columns[] = $row['Field'];
          $sheet->setCellValue("{$i}1", $row['Field']);
          $sheet->getStyle("{$i}1")->getFont()->setBold(true);
          $sheet->getColumnDimension($i)->setAutoSize(true);
        }
        $result = $db->query("SELECT * FROM {$tables[$x]}");
        for ($i = 2; $row = $result->fetch_assoc(); $i++) {
          $hasData = true;
          for ($j = 'A', $k = 0; $k < count($columns); $j++, $k++) {
            $sheet->setCellValue("{$j}{$i}", $row["{$columns[$k]}"]);
          }
        }
      }
      $spreadsheet->setActiveSheetIndex(0);
      if ($hasData) {
        $writer = new Xlsx($spreadsheet);
        $writer->save("../files/backup/excel/$filename.xlsx");
      }
    }
    return $hasData ? $filename : false;
  }

  public function percentToDecimal($percent) {
    $percent = str_replace('%', '', $percent);
    return $percent / 100;
  }

  public function getBetweenString($var1 = "", $var2 = "", $pool) {
    $temp1  = strpos($pool, $var1) + strlen($var1);
    $result = substr($pool, $temp1, strlen($pool));
    $dd     = strpos($result, $var2);
    if ($dd == 0) {
      $dd = strlen($result);
    }

    return substr($result, 0, $dd);
  }

  public function getRandomString($length) {
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$-_.!*(),";
    $string     = '';

    for ($i = 0; $i < $length; $i++) {
      $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
  }

  public function filter_input($string, $isPassword = false) {
    global $db;
    $output = $db->real_escape_string($string);
    return $isPassword == false ? filter_var($output, FILTER_SANITIZE_STRING) : $output;
  }

  public function encrypt($string) {
    return openssl_encrypt($string, "AES-256-CTR", ENCRYPT_KEYWORD, OPENSSL_ZERO_PADDING, INITIALIZATION_VECTOR);
  }

  public function decrypt($string) {
    return openssl_decrypt(str_replace(" ", "+", $string), "AES-256-CTR", ENCRYPT_KEYWORD, OPENSSL_ZERO_PADDING, INITIALIZATION_VECTOR);
  }

};

$account = new Account();
$room    = new Room();
$booking = new Booking();
$view    = new View();
$system  = new System();
?>