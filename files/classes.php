<?php
@session_start();
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/*--------------- VARIABLES --------------*/
$levels = ['User', 'Receptionist', 'Admin', 'Creator'];
/*----------------------------------------*/

/*----------------------------------------*/
/*-------------Account Class--------------*/
/*----------------------------------------*/
class Account extends System {

  /**
   * @var mixed
   */
  public $email, $firstName, $lastName, $profilePicture, $accountType, $birthDate, $contactNumber;

  public function __construct() {
    global $db;
    if (isset($_SESSION['account']) && !$db->connect_error && $db->select_db('cp018101_nwh')) {
      $this->email          = $this->decrypt($_SESSION['account']);
      $result               = $db->query("SELECT * FROM account WHERE EmailAddress='{$this->email}'");
      $row                  = $result->fetch_assoc();
      $this->firstName      = $row['FirstName'];
      $this->lastName       = $row['LastName'];
      $this->profilePicture = $row['ProfilePicture'];
      $this->accountType    = $row['AccountType'];
      $this->birthDate      = $row['BirthDate'];
      $this->contactNumber  = $row['ContactNumber'];
      $this->nationality    = $row['Nationality'];
      if ($row['Status'] == 0) {
        $this->logout();
      }
    }
  }

  /**
   * @param $credentials
   */
  public function login($credentials) {
    global $db, $levels;
    $email    = $this->filter_input($credentials['email']);
    $password = $this->filter_input($credentials['password'], true);

    $result = $db->query("SELECT * FROM `account` WHERE EmailAddress='$email' AND Status=1");
    $row    = $result->fetch_assoc();

    if ($result->num_rows == 1 && password_verify($password, $row['Password'])) {
      $_SESSION['account'] = $this->encrypt($row['EmailAddress']);
      if (array_search($row['AccountType'], $levels) > 0) {
        setcookie('nwhAuth', $this->encrypt(json_encode(['email' => $email, 'password' => $password])), time() + (86400 * LOGIN_EXPIRED_DAYS), '/');
      }
      $db->query("UPDATE account SET SessionID='" . session_id() . "' WHERE EmailAddress='$email'");
      $this->log('login|account', $email);
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
    if (stripos($referrer, '/reservation') || stripos($referrer, '/admin')) {
      header("location: $root");
    } else {
      header("location: $referrer");
    }
  }

  /**
   * @param $credentials
   */
  public function verifyRegistration($credentials) {
    global $db, $date, $root;
    $fname         = ucwords(strtolower($this->filter_input($credentials['txtFirstName'])));
    $lname         = ucwords(strtolower($this->filter_input($credentials['txtLastName'])));
    $email         = $this->filter_input($credentials['txtEmail']);
    $password      = $this->filter_input($credentials['txtPassword'], true);
    $contactNumber = $this->filter_input($credentials['txtContactNumber']);
    $birthDate     = $this->filter_input($credentials['txtBirthDate']);
    $nationality   = $this->filter_input($credentials['txtNationality']);

    $result = $db->query("SELECT * FROM account WHERE EmailAddress='$email'");

    if ($result->num_rows == 0) {
      $data     = $this->encrypt("txtFirstName=$fname&txtLastName=$lname&txtEmail=$email&txtPassword=$password&txtContactNumber=$contactNumber&txtBirthDate=$birthDate&txtNationality=$nationality&TimeStamp=" . strtotime('now'));
      $subject  = 'Northwood Hotel Account Creation';
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

  /**
   * @param $credentials
   * @param $verify
   */
  public function register($credentials, $verify = true) {
    global $db, $date, $root;
    $fname         = ucwords(strtolower($this->filter_input($credentials['txtFirstName'])));
    $lname         = ucwords(strtolower($this->filter_input($credentials['txtLastName'])));
    $email         = $this->filter_input($credentials['txtEmail']);
    $password      = password_hash($this->filter_input($credentials['txtPassword'], true), PASSWORD_DEFAULT);
    $contactNumber = $this->filter_input($credentials['txtContactNumber']);
    $birthDate     = date('Y-m-d', strtotime($this->filter_input($credentials['txtBirthDate'])));
    $nationality   = $this->filter_input($credentials['txtNationality']);

    if (isset($credentials['expirydate']) && $this->isExpired($credentials['TimeStamp'], EMAIL_EXPIRATION)) {
      return "<script>alert('Link Expired. Please register again.');location.href='$root';</script>";
    }

    $db->query("INSERT INTO account VALUES ('$email', '$password', 'User', 'default', '$fname', '$lname', '$contactNumber', '$birthDate', '$nationality', '1', '0', '$date', NULL)");

    if (!$verify) {
      if ($db->affected_rows > 0) {
        $this->log("insert|account.register|$email", (VERIFY_REGISTER ? $this->email : null));
        return true;
      } else {
        return ALREADY_REGISTERED;
      }
    } else {
      if ($db->affected_rows > 0) {
        if (AUTO_LOGIN_AT_REGISTER) {
          $_SESSION['account'] = $this->encrypt($email);
        }
        $this->log("registered|account|$email");
        return "<script>alert('Registered Successfully!');location.href='$root';</script>";
      } else {
        return "<script>alert('Already Registered!');location.href='$root';</script>";
      }
    }
  }

  /**
   * @param $email
   */
  public function checkEmail($email) {
    global $db;
    $result = $db->query("SELECT * FROM account WHERE EmailAddress='$email'");

    if ($result->num_rows > 0 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * @param $credentials
   * @param $forgot
   * @return mixed
   */
  public function changePassword($credentials, $forgot) {
    global $db, $levels;
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

        if (isset($_COOKIE['nwhAuth'])) {
          setcookie('nwhAuth', '', time() - (60 * 60 * 24 * 7), '/');
          unset($_COOKIE['nwhAuth']);
        }
        unset($_SESSION['account']);
        if ($db->affected_rows > 0) {
          $this->log('update|user.password');
          return true;
        } else {
          return $db->error;
        }
      }
    }
  }

  /**
   * @param $email
   */
  public function forgotPassword($email) {
    global $db, $root;
    $result = $db->query("SELECT * FROM `account` WHERE EmailAddress='$email'");
    $row    = $result->fetch_assoc();

    if ($result->num_rows > 0) {
      $this->log("sent|forgot.password|$email");
      $data    = "email=$email&token=" . $this->generateForgotToken($email);
      $subject = 'Northwood Hotel Forgot Password';
      $body    = "Please proceed to this link to reset your password:<br/>Click <a href='http://{$_SERVER['SERVER_NAME']}{$root}?$data'>here</a> to change your password.";

      return $this->sendMail("$email", "$subject", "$body");
    }
  }

  /**
   * @param $email
   * @param $status
   */
  public function updateAccountStatus($email, $status) {
    global $db;
    $db->query("UPDATE account SET Status=$status WHERE EmailAddress='$email'");

    if ($db->affected_rows > 0) {
      $this->log("update|account.status|$email|$status");
      echo true;
    } else {
      echo ERROR_OCCURED;
    }
  }

  /**
   * @param $email
   * @return mixed
   */
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

  /**
   * @param $email
   * @param $token
   * @return mixed
   */
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

  /**
   * @param $email
   * @param $token
   * @return mixed
   */
  public function expireToken($email, $token) {
    global $db;
    $db->query("UPDATE forgot_password SET Used=1 WHERE EmailAddress='$email' AND Token='$token'");
    if ($db->affected_rows > 0) {
      return true;
    } else {
      return $db->error;
    }
  }

  /**
   * @param $credentials
   * @param $admin
   * @return mixed
   */
  public function editProfile($credentials, $admin = false) {
    global $db, $root;
    $output = NOTHING_CHANGED;
    if ($admin) {
      $email       = $credentials['email'];
      $accountType = $credentials['accountType'];

      $result = $db->query("UPDATE `account` SET AccountType='$accountType' WHERE EmailAddress='$email'");
      if ($db->affected_rows > 0) {
        $this->log("update|account|$email");
        echo true;
      } else {
        echo $output;
      }
    } else {
      $email         = $this->filter_input($this->email);
      $fname         = $this->filter_input($credentials['fname']);
      $lname         = $this->filter_input($credentials['lname']);
      $birthDate     = date('Y-m-d', strtotime($this->filter_input($credentials['birthDate'])));
      $contactNumber = $this->filter_input($credentials['contactNumber']);
      $nationality   = $this->filter_input($credentials['nationality']);

      if (isset($credentials['image'])) {
        $accountResult = $db->query("SELECT * FROM account WHERE EmailAddress='$email'");
        $accountRow    = $accountResult->fetch_assoc();
        $directory     = $_SERVER['DOCUMENT_ROOT'] . "{$root}images/profilepics/";
        @mkdir($directory);
        if ($accountRow['ProfilePicture'] == 'default') {
          do {
            $randomName = $this->getRandomString(20);
          } while (file_exists($directory . $randomName));
        } else {
          $randomName = $accountRow['ProfilePicture'];
        }
        $filename = basename($randomName);
        $output   = $this->saveImage($credentials['image'], $directory, $filename, 500);
        if ($output == true) {
          $db->query("UPDATE account SET ProfilePicture='$filename' WHERE EmailAddress='{$this->email}'");
          $this->log('update|account.profilepicture');
        } else {
          return $output;
        }
      }

      $db->query("UPDATE account SET FirstName='$fname', LastName='$lname', BirthDate='$birthDate', ContactNumber='$contactNumber', Nationality='$nationality' WHERE EmailAddress='$email'");

      if ($db->affected_rows > 0) {
        $this->log('update|account.profile');
        $output = true;
      }
      return $output;
    }
  }

  public function isLogged() {
    return isset($_SESSION['account']) ? true : false;
  }

  /**
   * @param $reqLevel
   * @param $kick
   */
  public function checkUserLevel($reqLevel, $kick = false) {
    global $root, $levels;
    if ($this->isLogged()) {
      $currentLevel = array_search($this->accountType, $levels);
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

  /**
   * @return mixed
   */
  public function checkFeedback() {
    global $db;
    return $db->query("SELECT * FROM account WHERE EmailAddress='{$this->email}'")->fetch_assoc()['Feedback'];
  }

  /**
   * @param $star
   * @param $comment
   */
  public function addFeedback($star, $comment) {
    global $db;
    $db->query("UPDATE account SET Feedback=0 WHERE EmailAddress='{$this->email}'");
    $db->query("INSERT INTO feedback VALUES(NULL,'$star','$comment')");
    if ($db->affected_rows > 0) {
      $this->log("add|feedback|$star|$comment");
      return true;
    } else {
      return false;
    }
  }
}

/*----------------------------------------*/
/*----------------Room Class--------------*/
/*----------------------------------------*/
class Room extends System {

  /**
   * @param $roomID
   * @param $roomType
   */
  public function addRoomID($roomID, $roomType) {
    global $db;
    $result = $db->query("SELECT * FROM room_type WHERE RoomType='$roomType'");
    $row    = $result->fetch_assoc();
    $db->query("INSERT INTO room VALUES($roomID,{$row['RoomTypeID']},1,0,0)");

    if ($db->affected_rows > 0) {
      $this->log("add|room|$roomType|$roomID");
      return true;
    } else {
      return NOTHING_CHANGED;
    }
  }

  /**
   * @param $roomDetails
   */
  public function addRoomType($roomDetails) {
    global $db;
    $db->query("INSERT INTO room_type VALUES(NULL,'" . str_replace(' ', '_', $roomDetails[0]) . "','{$roomDetails[1]}','{$roomDetails[2]}','{$roomDetails[3]}',{$roomDetails[4]},{$roomDetails[5]},{$roomDetails[6]},{$roomDetails[7]})");

    if ($db->affected_rows > 0) {
      $this->log("add|room_type|{$roomDetails[0]}");
      return true;
    } else {
      return NOTHING_CHANGED;
    }
  }

  /**
   * @param $roomID
   */
  public function deleteRoomID($roomID) {
    global $db;
    $db->query("DELETE FROM room WHERE RoomID=$roomID");

    if ($db->affected_rows > 0) {
      $this->log("delete|room|$roomID");
      return true;
    } else {
      return NOTHING_CHANGED;
    }
  }

  /**
   * @param $roomType
   */
  public function deleteRoomType($roomType) {
    global $db;
    $db->query("DELETE FROM room_type WHERE RoomType='$roomType'");

    if ($db->affected_rows > 0) {
      $this->log("delete|room|$roomType");
      return true;
    } else {
      return NOTHING_CHANGED;
    }
  }

  /**
   * @param $roomID
   * @param $roomType
   */
  public function editRoomID($roomID, $roomType) {
    global $db;
    $result = $db->query("SELECT * FROM room_type WHERE RoomType='$roomType'");
    $row    = $result->fetch_assoc();
    $db->query("UPDATE room SET RoomTypeID={$row['RoomTypeID']} WHERE RoomID=$roomID");
    if ($db->affected_rows > 0) {
      $this->log("update|room|$roomID|$roomType");
      return true;
    } else {
      return NOTHING_CHANGED;
    }
  }

  /**
   * @param $roomDetails
   */
  public function editRoomType($roomDetails) {
    global $db;
    $db->query("UPDATE room_type SET RoomDescription='{$roomDetails[1]}', RoomSimplifiedDescription='{$roomDetails[2]}', Icons='{$roomDetails[3]}', Capacity={$roomDetails[4]}, RegularRate={$roomDetails[5]}, SeasonRate={$roomDetails[6]}, HolidayRate={$roomDetails[7]} WHERE RoomType='{$roomDetails[0]}'");

    if ($db->affected_rows > 0) {
      $this->log("update|room_type|{$roomDetails[0]}");
      return true;
    } else {
      return NOTHING_CHANGED;
    }
  }

  /**
   * @param $roomID
   * @param $status
   * @param $type
   */
  public function updateRoomStatus($roomID, $status, $type) {
    global $db;
    $db->query("UPDATE room SET $type = $status WHERE RoomID = $roomID");

    if ($db->affected_rows > 0) {
      $this->log("update|room.status|$roomID|$status");
      echo true;
    } else {
      echo ERROR_OCCURED;
    }
  }

  /**
   * @param $roomID
   */
  public function cleanRoom($roomID) {
    global $db;
    $db->query("UPDATE room SET Cleaning=0 WHERE RoomID=$roomID");

    if ($db->affected_rows > 0) {
      $this->log("update|room.cleaning|$roomID|cleaned");
      echo true;
    } else {
      echo ERROR_OCCURED;
    }
  }

  /**
   * @param $roomID
   */
  public function isOccupied($roomID) {
    global $db;
    $rooms  = [];
    $result = $db->query('SELECT booking_room.RoomID FROM booking JOIN booking_room ON booking.BookingID=booking_room.BookingID LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID WHERE CheckIn IS NOT NULL AND CheckOut IS NULL');
    while ($row = $result->fetch_assoc()) {
      $rooms[] = $row['RoomID'];
    }
    return in_array($roomID, $rooms);
  }

  /**
   * @param $bookingID
   * @param $roomID
   * @param $startDate
   * @param $endDate
   */
  public function isBookedInDate($bookingID, $roomID, $startDate, $endDate) {
    global $db;
    $row   = $db->query("SELECT * FROM booking WHERE BookingID=$bookingID")->fetch_assoc();
    $dates = array_diff($this->getDatesFromRange($startDate, $endDate), $this->getDatesFromRange($row['CheckInDate'], $row['CheckOutDate']));
    $rooms = $this->generateRoomID(null, null, $dates[0], $dates[count($dates) - 1]);
    if (in_array($roomID, $rooms)) {
      return false;
    } else {
      return true;
    }
  }

  /**
   * @param $roomID
   */
  public function getRoomInfo($roomID) {
    global $db;
    $result = $db->query("SELECT * FROM account JOIN booking ON account.EmailAddress=booking.EmailAddress JOIN booking_room ON booking.BookingID=booking_room.BookingID JOIN booking_check ON booking.BookingID=booking_check.BookingID WHERE RoomID=$roomID AND CheckIn IS NOT NULL AND CheckOut IS NULL ORDER BY CheckIn DESC LIMIT 1");
    $row    = $result->fetch_assoc();
    $infos  = [
      'bookingID'    => $this->formatBookingID($row['BookingID']),
      'name'         => $row['FirstName'] . ' ' . $row['LastName'],
      'email'        => $row['EmailAddress'],
      'checkInDate'  => $row['CheckInDate'],
      'checkOutDate' => $row['CheckOutDate']
    ];
    $rooms  = [];
    $result = $db->query("SELECT * FROM booking JOIN booking_room ON booking.BookingID=booking_room.BookingID WHERE booking.BookingID={$row['BookingID']}");
    while ($row = $result->fetch_assoc()) {
      $rooms[] = $row['RoomID'];
    }
    $infos['rooms'] = join($rooms, ', ');
    return $infos;
  }

  /**
   * @param $bookingID
   * @return mixed
   */
  public function getRoomIDList($bookingID = null) {
    global $db;
    $rooms = [];
    if ($bookingID != null) {
      $result = $db->query("SELECT * FROM booking_room WHERE BookingID=$bookingID");
    } else {
      $result = $db->query('SELECT * FROM room');
    }
    while ($row = $result->fetch_assoc()) {
      $rooms[] = $row['RoomID'];
    }
    sort($rooms);
    return $rooms;
  }

  /**
   * @return mixed
   */
  public function getRoomTypeList() {
    global $db;
    $roomType = [];
    $result   = $db->query('SELECT * FROM room_type');
    while ($row = $result->fetch_assoc()) {
      $roomType[] = $row['RoomType'];
    }
    return $roomType;
  }

  /**
   * @param $roomID
   * @return mixed
   */
  public function getRoomType($roomID) {
    global $db;
    $result = $db->query("SELECT * FROM room JOIN room_type ON room.RoomTypeID=room_type.RoomTypeID WHERE RoomID=$roomID");
    $row    = $result->fetch_assoc();
    return $row['RoomType'];
  }

  /**
   * @param $room
   * @param $regular
   * @return mixed
   */
  public function getRoomPrice($room, $regular = false) {
    global $db, $date;
    $room             = str_replace(' ', '_', $room);
    $result           = $db->query("SELECT * FROM room_type WHERE RoomType='$room'");
    $row              = $result->fetch_assoc();
    $checkPromoResult = $db->query("SELECT * FROM promo_dates WHERE StartDate<='$date'");
    while ($checkPromoRow = $checkPromoResult->fetch_assoc()) {
      if (in_array($date, $this->getDatesFromRange($checkPromoRow['StartDate'], $checkPromoRow['EndDate'])) && !$regular) {
        return $row["{$checkPromoRow['PromoType']}Rate"];
      }
    }
    return $row['RegularRate'];
  }

  /**
   * @return mixed
   */
  public function getUsingRoomList() {
    global $db;
    $rooms  = [];
    $result = $db->query('SELECT RoomID FROM booking JOIN booking_room ON booking.BookingID=booking_room.BookingID JOIN booking_check ON booking.BookingID=booking_check.BookingID WHERE CheckIn IS NOT NULL AND CheckOut IS NULL');
    while ($row = $result->fetch_assoc()) {
      $rooms[] = $row['RoomID'];
    }
    return $rooms;
  }

  /**
   * @param $room
   * @param null $quantity
   * @param null $checkInDate
   * @param $checkOutDate
   * @param $includeDisabled
   */
  public function generateRoomID($room = null, $quantity = null, $checkInDate, $checkOutDate, $includeDisabled = false) {
    global $db, $date;
    $room   = $room != null ? "RoomType = '$room'" : 1;
    $rooms  = [];
    $result = $db->query("SELECT RoomID, RoomType, Status, Maintenance FROM room JOIN room_type ON room.RoomTypeID = room_type.RoomTypeID WHERE $room");
    while ($row = $result->fetch_assoc()) {
      $roomResult = $db->query("SELECT booking.BookingID, CheckInDate, CheckOutDate, CheckIn, CheckOut FROM room JOIN booking_room ON room.RoomID=booking_room.RoomID JOIN booking ON booking_room.BookingID=booking.BookingID LEFT JOIN booking_cancelled ON booking.BookingID=booking_cancelled.BookingID LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID WHERE room.RoomID = '{$row['RoomID']}' AND DateCancelled IS NULL");
      if ($roomResult->num_rows > 0) {
        while ($roomRow = $roomResult->fetch_assoc()) {
          if (($this->isBetweenDate($checkInDate, $checkOutDate, $roomRow['CheckInDate'], $roomRow['CheckOutDate']) || $this->checkExpiredBooking($roomRow['BookingID'])) && ($roomRow['CheckIn'] == null && $roomRow['CheckOut'] == null)) {
            $roomAvailable = false;
            break;
          }
          $roomAvailable = true;
        }
      } else {
        $roomAvailable = true;
      }
      if (($row['Status'] != 0 || $includeDisabled) && $roomAvailable && !in_array($row['RoomID'], $rooms) && $row['Maintenance'] == 0) {
        $rooms[] = $row['RoomID'];
      }
    }
    shuffle($rooms);
    return count($rooms) > 0 ? array_slice($rooms, 0, $quantity) : $rooms;
  }

}

/*----------------------------------------*/
/*---------------View Class---------------*/
/*----------------------------------------*/
class View extends Room {
  public function promoPictures() {
    foreach (glob('images/promos/*.{jpg,gif,png,JPG,GIF,PNG}', GLOB_BRACE) as $image) {
      $filename = str_replace('images/promos/', '', $image);
      echo '      ';
      echo "<div>
        <img data-u='image' src='$image?v=" . filemtime("$image") . "' alt='$filename'>
        <div u='thumb'>Slide Description 001</div>
      </div>\n";
    }
  }
  public function homeJssor() {
    foreach (glob('images/carousel/*.{jpg,gif,png,JPG,GIF,PNG}', GLOB_BRACE) as $image) {
      $filename = str_replace('images/carousel/', '', $image);
      echo '      ';
      echo "<div data-b='0' data-p='112.50' style='display: none;'>
        <img data-u='image' src='$image?v=" . filemtime("$image") . "' alt='$filename'>
      </div>\n";
    }
  }

  public function homeRooms() {
    global $db;
    $result = $db->query('SELECT * FROM room_type');
    while ($row = $result->fetch_assoc()) {
      echo '      ';
      echo "<div class='wow slideInUp center-block text-center col-md-4' style='margin-bottom:40px'>
        <figure class='imghvr-fade-in'>
          <img src='gallery/images/rooms/{$row['RoomType']}.jpg?v=" . @filemtime("gallery/images/rooms/{$row['RoomType']}.jpg") . "'>
          <figcaption style='background: url(\"gallery/images/rooms/{$row['RoomType']}.jpg\") center;text-align:center;color:black;padding:0px'>
            <div style='background-color:rgba(255,255,255,0.8);position:relative;height:100%;width:100%;'>
              <div style='text-align:center;color:black;font-size:22px;padding-top:10px;font-weight:bold'>" . str_replace('_', ' ', $row['RoomType']) . "<br/><div style='font-size:15px'>Price: <i>₱" . number_format($this->getRoomPrice($row['RoomType'])) . '</i></div></div>
              <br/>' . str_replace('<li>', "<li style='text-align:left;margin-left:15%'>", nl2br($row['RoomDescription'])) . "
            </div>
          </figcaption>
          <div style='text-align:center;color:black;font-size:22px;font-weight:bold'>" . str_replace('_', ' ', $row['RoomType']) . "<br/><div style='font-size:15px'>Price: <i>₱" . number_format($this->getRoomPrice($row['RoomType'])) . "</i></div></div>
        </figure>
        <div style='position:relative;height:20px;margin-top:-6px'>
          <button id='{$row['RoomType']}' class='btn btn-info btnMoreInfo' style='width:50%;position:absolute;left:0' data-toggle='modal' data-target='#modalRoom'>More Info</button>
          <button onclick='location.href=\"reservation\"' class='btn btn-primary' style='width:50%;position:absolute;right:0'>Book Now</button>
        </div>
      </div>\n";
    }
  }

  public function transactionHistory() {
    global $db, $root;
    $result = $db->query("SELECT booking.BookingID, EmailAddress, CheckIn, CheckOut, Adults, Children, AmountPaid, TotalAmount, PaymentMethod FROM booking LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID JOIN booking_transaction ON booking.BookingID=booking_transaction.BookingID WHERE EmailAddress='{$this->email}'");
    while ($row = $result->fetch_assoc()) {
      echo '<tr>';
      echo "<td>{$this->formatBookingID($row['BookingID'])}</td>";
      echo '<td>' . ($row['CheckIn'] == null ? 'N/A' : $row['CheckIn']) . '</td>';
      echo '<td>' . ($row['CheckOut'] == null ? 'N/A' : $row['CheckOut']) . '</td>';
      echo "<td>{$row['Adults']}</td>";
      echo "<td>{$row['Children']}</td>";
      if ($row['PaymentMethod'] == 'PayPal') {
        $paypalResult = $db->query("SELECT * FROM booking_paypal WHERE BookingID={$row['BookingID']}");
        $paypalRow    = $paypalResult->fetch_assoc();
        $amountPaid   = $row['AmountPaid'] + $paypalRow['PaymentAmount'];
      } else {
        $amountPaid = $row['AmountPaid'];
      }
      echo '<td>₱&nbsp;' . number_format($amountPaid, 2, '.', ',') . '</td>';
      echo '<td>₱&nbsp;' . number_format($row['TotalAmount'], 2, '.', ',') . '</td>';
      $cancelledBook = $db->query("SELECT * FROM booking_cancelled WHERE BookingID={$row['BookingID']}")->num_rows;
      if ($row['CheckIn'] == null && $row['CheckOut'] == null) {
        $status = $cancelledBook > 0 ? 'Cancelled' : 'Not yet check';
      } else if ($row['CheckIn'] != null && $row['CheckOut'] == null) {
        $status = 'Checked In';
      } else {
        $status = $row['AmountPaid'] == $row['TotalAmount'] ? 'Paid' : 'Checked Out';
      }
      echo "<td>$status</td>";
      echo "<td><a href='{$root}files/generateReservationConfirmation/?BookingID={$this->formatBookingID($row['BookingID'])}' data-tooltip='tooltip' data-placement='bottom' title='Print Reservation'><i class='fa fa-print fa-2x'></i></a>";
      echo $cancelledBook == 0 && $row['CheckIn'] != null && $row['CheckOut'] != null ? "&nbsp;<a href='{$root}files/generateReceipt/?BookingID={$this->formatBookingID($row['BookingID'])}' data-tooltip='tooltip' data-placement='bottom' title='Print Receipt'><i class='fa fa-print fa-2x'></i></a>" : '';
      echo '</td>';
      echo '</tr>';
    }
  }

  /**
   * @param $category
   */
  public function gallery($category) {
    foreach (glob("images/{$category}/*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
      $filename  = str_replace('_', ' ', str_replace(["images/{$category}/", '.jpg', '.gif', '.png', '.JPG', '.GIF', '.PNG'], '', $image));
      $thumbnail = str_replace("images/{$category}/", "images/{$category}/thumbnail/", $image);
      if (!file_exists($thumbnail)) {
        $thumbnail = $image;
      }
      echo "<a href='$image' data-caption='$filename'><img src='$thumbnail?v=" . filemtime("$thumbnail") . "' alt='$filename' class='zoom'></a>\n";
    }
  }

  public function roomandrates() {
    global $db;
    $result = $db->query('SELECT * FROM room_type');
    while ($row = $result->fetch_assoc()) {
      echo '<tr>';
      echo "<td style='width:40%' class='img-baguette'>";
      $first = true;
      foreach (glob("../gallery/images/rooms/{$row['RoomType']}*.{jpg,gif,png,JPG,GIF,PNG}", GLOB_BRACE) as $image) {
        $filename = str_replace('../gallery/images/rooms/', '', $image);
        $caption  = str_replace(['.jpg', '.bmp', '.jpeg', '.png'], '', $filename);
        echo "<a href='$image' data-caption='$caption' style='";
        echo $first == true ? '' : 'display:none';
        echo "'><img src='$image?v=" . filemtime("$image") . "' alt='$filename' data-tooltip='tooltip' data-placement='bottom' title='Click to view images' style='width:100%'></a>\n";
        $first = false;
      }
      echo '</td>';
      echo "<td style='vertical-align:top'>
          <h3><b>" . str_replace('_', ' ', $row['RoomType']) . '</b></h3><br/>
          ' . str_replace("\n", '<br/>', $row['RoomDescription']);
      echo "<div style='padding: 10px 10px'>";
      $icons = explode("\n", $row['Icons']);
      foreach ($icons as $key => $value) {
        $iconArr = explode('=', $value);
        $icon    = $iconArr[0] ?? '';
        $title   = $iconArr[1] ?? '';
        echo "<i class='fa fa-$icon fa-2x' data-tooltip='tooltip' data-placement='bottom' title='$title' style='margin-right:20px'></i>";
      }
      echo '</div>';
      echo '</td>';
      echo "<td><center>From<br/><br/><span style='font-size:20px;'><b>₱&nbsp;" . number_format($this->getRoomPrice($row['RoomType'])) . '</b></span></center></td>';
      echo '</tr>';
    }
  }

  public function booking() {
    global $db, $root, $date;
    $result = $db->query('SELECT booking.BookingID, EmailAddress, CheckInDate, CheckOutDate, CheckIn, CheckOut, Adults, Children, AmountPaid, TotalAmount,PaymentMethod, DateCreated, DateCancelled, Filename FROM booking LEFT JOIN booking_cancelled ON booking.BookingID=booking_cancelled.BookingID LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID LEFT JOIN booking_bank ON booking.BookingID=booking_bank.BookingID JOIN booking_transaction ON booking.BookingID=booking_transaction.BookingID WHERE DateCancelled IS NULL');
    while ($row = $result->fetch_assoc()) {
      $rooms      = [];
      $roomResult = $db->query("SELECT * FROM booking_room WHERE BookingID={$row['BookingID']}");
      while ($roomRow = $roomResult->fetch_assoc()) {
        $rooms[] = $roomRow['RoomID'];
      }
      sort($rooms);
      $cancelled  = $row['DateCancelled'] == null ? false : true;
      $checkedIn  = !($row['CheckIn'] != null && $row['CheckOut'] == null);
      $checkedOut = $row['CheckIn'] != null && $row['CheckOut'] != null;
      if (!$cancelled && !$checkedOut) {
        echo "<td id='txtBookingID'>{$this->formatBookingID($row['BookingID'])}</td>";
        echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
        echo "<td id='txtRooms'>";
        foreach ($rooms as $roomID) {
          if ($checkedIn) {
            echo "<span style='margin-right:5px'>$roomID</span><a id='$roomID' class='btnEditRoom' style='cursor:pointer'><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a id='$roomID' class='btnDeleteRoom' style='cursor:pointer'><i class='fa fa-trash'></i></a><br/>";
          }
        }
        echo !$checkedIn ? join($rooms, ', ') : '';
        echo "<button class='btnAddRoom btn btn-xs btn-block' style='cursor:pointer;background:transparent;box-shadow:none;color:#337ab7;border:1px dashed #337ab7'><i class='fa fa-plus'></i></button>";
        echo '</td>';
        echo "<td id='txtCheckInDate'>" . date('m/d/Y', strtotime($row['CheckInDate'])) . '</td>';
        echo "<td id='txtCheckOutDate'>" . date('m/d/Y', strtotime($row['CheckOutDate'])) . '</td>';
        echo "<td id='txtAdults'>{$row['Adults']}</td>";
        echo "<td id='txtChildren'>{$row['Children']}</td>";
        echo "<td id='txtAmountPaid'>₱&nbsp;" . number_format($row['AmountPaid']);
        echo "<div class='pull-right'><a class='btnAddPayment col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0' data-toggle='modal' data-target='#modalAddPayment' data-tooltip='tooltip' data-placement='bottom' title='Add Payment'><i class='fa fa-plus' style='color:red'></i></a></div>";
        echo '</td>';
        echo "<td id='txtBalance'>₱&nbsp;" . number_format(($row['TotalAmount'] - $row['AmountPaid'])) . '</td>';
        echo "<td id='txtTotalAmount'>₱&nbsp;" . number_format($row['TotalAmount']) . '</td>';
        echo '<td>';
        echo $checkedIn ? "<a class='btnEditReservation col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0' data-toggle='modal' data-target='#modalEditReservation' data-tooltip='tooltip' data-placement='bottom' title='Edit'><i class='fa fa-pencil fa-2x'></i></a>" : '';
        echo $checkedIn && ($this->checkUserLevel(2) || ($this->checkUserLevel(1) && ALLOW_RECEPTIONIST_CANCEL)) ? "<a class='btnCancel col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0' data-tooltip='tooltip' data-placement='bottom' title='Cancel'><i class='fa fa-ban fa-2x' style='color:red'></i></a>" : '';
        echo "<a class='col-md-6' onclick='window.open(\"{$root}files/generateReservationConfirmation?BookingID=" . $this->formatBookingID($row['BookingID']) . "\",\"_blank\",\"height=650,width=1000\")' style='padding:0;cursor:pointer' data-tooltip='tooltip' data-placement='bottom' title='Print'><i class='fa fa-print fa-2x'></i></a>";
        echo $row['PaymentMethod'] == 'Bank' && $db->query("SELECT * FROM booking_bank WHERE BookingID={$row['BookingID']}")->fetch_assoc()['Filename'] != null ? "<a class='col-md-6' onclick='window.open(\"{$root}images/bankreferences/?id={$this->formatBookingID($row['BookingID'])}\",\"_blank\",\"height=650,width=1000\")' style='padding:0;cursor:pointer' data-tooltip='tooltip' data-placement='bottom' title='View Bank Reference'><i class='fa fa-image fa-2x' style='color:green'></i></a>" : '';
        echo '</td>';
        echo '</tr>';
      }
    }
  }

  public function check() {
    global $db, $date;
    $result = $db->query('SELECT booking.BookingID, EmailAddress, CheckInDate, CheckOutDate, CheckIn, CheckOut, Adults, Children, TotalAmount FROM booking LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID LEFT JOIN booking_cancelled ON booking.BookingID=booking_cancelled.BookingID JOIN booking_transaction ON booking.BookingID=booking_transaction.BookingID WHERE DateCancelled IS NULL');
    while ($row = $result->fetch_assoc()) {
      $roomResult = $db->query("SELECT * FROM booking_room WHERE BookingID={$row['BookingID']}");
      $rooms      = [];
      while ($roomRow = $roomResult->fetch_assoc()) {
        $rooms[] = $roomRow['RoomID'];
      }
      $checkInStatus  = $row['CheckIn'] == '' ? false : true;
      $checkOutStatus = $row['CheckOut'] == '' ? false : true;
      $checkIn        = $row['CheckIn'] != null ? date('m/d/Y h:i:s A', strtotime($row['CheckIn'])) : '';
      $checkOut       = $row['CheckOut'] != null ? date('m/d/Y h:i:s A', strtotime($row['CheckOut'])) : '';
      $dates          = $this->getDatesFromRange($row['CheckInDate'], date('Y-m-d', strtotime($row['CheckOutDate']) - 86400));
      if (in_array($date, $dates) || ($checkIn != '' && $checkOut == '')) {
        echo '<tr>';
        echo "<td id='txtBookingID'>{$this->formatBookingID($row['BookingID'])}</td>";
        echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
        echo "<td id='txtRoomID'>" . join(', ', $rooms) . '</td>';
        echo "<td id='txtGuests'>Adults: {$row['Adults']}<br/>Children: {$row['Children']}</td>";
        echo "<td id='txtCheckDate' width='15%'>{$row['CheckInDate']} - {$row['CheckOutDate']}</td>";
        echo "<td id='txtCheckIn'>$checkIn</td>";
        echo "<td id='txtCheckOut'>$checkOut</td>";
        echo "<td id='txtExtraCharges'>";
        $expenses       = 0;
        $expensesResult = $db->query("SELECT Name, Quantity, expenses.Amount as Amount, booking_expenses.Amount as oAmount, Remark FROM expenses LEFT JOIN booking_expenses ON expenses.ExpensesID=booking_expenses.ExpensesID WHERE BookingID={$row['BookingID']}");
        while ($expensesRow = $expensesResult->fetch_assoc()) {
          if ($expensesRow['Name'] == 'Others') {
            echo "{$expensesRow['Name']}({$expensesRow['Quantity']})" . ($expensesRow['Remark'] != '' ? "({$expensesRow['Remark']})" : '') . ': ₱&nbsp;' . number_format($expensesRow['oAmount'] * $expensesRow['Quantity'], 2, '.', ',') . '<br/>';
            $expenses += $expensesRow['oAmount'] * $expensesRow['Quantity'];
          } else {
            echo "{$expensesRow['Name']}({$expensesRow['Quantity']})" . ($expensesRow['Remark'] != '' ? "({$expensesRow['Remark']})" : '') . ': ₱&nbsp;' . number_format($expensesRow['Amount'] * $expensesRow['Quantity'], 2, '.', ',') . '<br/>';
            $expenses += $expensesRow['Amount'] * $expensesRow['Quantity'];
          }
        }
        echo '</td>';
        echo "<td id='txtDiscount'>";
        $discountResult = $db->query("SELECT Name, discount.Amount as Amount, booking_discount.Amount as oAmount FROM discount LEFT JOIN booking_discount ON discount.DiscountID=booking_discount.DiscountID WHERE BookingID={$row['BookingID']}");
        while ($discountRow = $discountResult->fetch_assoc()) {
          if ($discountRow['Name'] == 'Others') {
            echo "{$discountRow['Name']}: " . (strpos($discountRow['oAmount'], '%') ? $discountRow['oAmount'] : '₱&nbsp;' . number_format($discountRow['Amount'], 2, '.', ',')) . '<br/>';
          } else {
            echo "{$discountRow['Name']}: " . (strpos($discountRow['Amount'], '%') ? $discountRow['Amount'] : '₱&nbsp;' . number_format($discountRow['Amount'], 2, '.', ',')) . '<br/>';
          }
        }
        echo '</td>';
        echo "<td id='txtTotalAmount'>₱&nbsp;" . number_format($row['TotalAmount'], 2, '.', ',') . '</td>';
        echo '<td>';
        echo "<a data-tooltip='tooltip' data-placement='bottom' title='Check In' class='btnCheckIn col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0'" . ($checkInStatus ? ' disabled' : '') . "><i class='fa fa-sign-in fa-2x'></i></a>";
        echo "<a data-tooltip='tooltip' data-placement='bottom' title='Check Out' class='btnCheckOut col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0'" . ($checkOutStatus || !$checkInStatus ? ' disabled' : '') . "><i class='fa fa-sign-out fa-2x'></i></a>";
        echo !$checkOutStatus && $checkInStatus ? "<a class='btnAddExpenses col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0' data-toggle='modal' data-target='#modalAddExpenses' data-tooltip='tooltip' data-placement='bottom' title='Add Expenses'><i class='fa fa-money fa-2x' style='color:green'></i></a>" : '';
        echo !$checkOutStatus && $checkInStatus ? "<a class='btnAddDiscount col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0' data-toggle='modal' data-target='#modalAddDiscount' data-tooltip='tooltip' data-placement='bottom' title='Add Discount'><i class='fa fa-gift fa-2x' style='color:red'></i></a>" : '';
        echo $checkOutStatus && $checkInStatus ? "<a class='btnShowBill col-md-6' id='{$row['BookingID']}' style='cursor:pointer;padding:0' data-tooltip='tooltip' data-placement='bottom' title='Show Bill'><i class='fa fa-money fa-2x' style='color:red'></i></a>" : '';
        echo '</td>';
        echo '</tr>';
      }
    }
  }

  public function notification() {
    global $db, $date;
    $result = $db->query('SELECT * FROM notification');
    while ($row = $result->fetch_assoc()) {
      echo '<tr>';
      echo "<td>{$row['ID']}</td>";
      echo "<td>{$row['Message']}</td>";
      echo "<td>{$row['TimeStamp']}</td>";
      echo '</tr>';
    }
  }

  public function listOfReservation() {
    global $db;
    $result = $db->query('SELECT booking.BookingID, EmailAddress, CheckInDate, CheckOutDate, CheckIn, CheckOut, Adults, Children, TotalAmount FROM booking LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID JOIN booking_transaction ON booking.BookingID=booking_transaction.BookingID WHERE CheckOut IS NOT NULL');
    while ($row = $result->fetch_assoc()) {
      $roomResult = $db->query("SELECT * FROM booking_room WHERE BookingID={$row['BookingID']}");
      $rooms      = [];
      while ($roomRow = $roomResult->fetch_assoc()) {
        $rooms[] = $roomRow['RoomID'];
      }
      $checkIn  = $row['CheckIn'] != null ? date('m/d/Y h:i:s A', strtotime($row['CheckIn'])) : '';
      $checkOut = $row['CheckOut'] != null ? date('m/d/Y h:i:s A', strtotime($row['CheckOut'])) : '';
      echo '<tr>';
      echo "<td>{$this->formatBookingID($row['BookingID'])}</td>";
      echo "<td>{$row['EmailAddress']}</td>";
      echo '<td>' . join(', ', $rooms) . '</td>';
      echo '<td>' . date('m/d/Y', strtotime($row['CheckInDate'])) . '</td>';
      echo '<td>' . date('m/d/Y', strtotime($row['CheckOutDate'])) . '</td>';
      echo "<td>$checkIn</td>";
      echo "<td>$checkOut</td>";
      echo "<td>{$row['Adults']}</td>";
      echo "<td>{$row['Children']}</td>";
      echo '<td>₱&nbsp;' . number_format($this->computeTotalAmount($row['BookingID']), 2, '.', ',') . '</td>';
      echo '</tr>';
    }
  }

  public function listOfCancelledBooking() {
    global $db;
    $result = $db->query('SELECT booking.BookingID, EmailAddress, CheckInDate, CheckOutDate, Adults, Children, DateCancelled, Reason FROM booking JOIN booking_cancelled ON booking.BookingID=booking_cancelled.BookingID');
    while ($row = $result->fetch_assoc()) {
      $roomResult = $db->query("SELECT * FROM booking_room WHERE BookingID={$row['BookingID']}");
      $rooms      = [];
      while ($roomRow = $roomResult->fetch_assoc()) {
        $rooms[] = $roomRow['RoomID'];
      }
      echo '<tr>';
      echo "<td>{$this->formatBookingID($row['BookingID'])}</td>";
      echo "<td>{$row['EmailAddress']}</td>";
      echo '<td>' . join(', ', $rooms) . '</td>';
      echo '<td>' . date('m/d/Y', strtotime($row['CheckInDate'])) . '</td>';
      echo '<td>' . date('m/d/Y', strtotime($row['CheckOutDate'])) . '</td>';
      echo "<td>{$row['Adults']}</td>";
      echo "<td>{$row['Children']}</td>";
      echo "<td>{$row['DateCancelled']}</td>";
      echo "<td>{$row['Reason']}</td>";
      echo '</tr>';
    }
  }

  public function listOfPaypalPayment() {
    global $db;
    $result = $db->query('SELECT * FROM account JOIN booking ON account.EmailAddress=booking.EmailAddress JOIN booking_paypal ON booking.BookingID=booking_paypal.BookingID');
    while ($row = $result->fetch_assoc()) {
      echo '<tr>';
      echo "<td>{$this->formatBookingID($row['BookingID'])}</td>";
      echo "<td>{$row['EmailAddress']}</td>";
      echo "<td>{$row['PayerID']}</td>";
      echo "<td>{$row['PaymentID']}</td>";
      echo "<td>{$row['InvoiceNumber']}</td>";
      echo '<td>₱&nbsp;' . number_format($row['PaymentAmount'], 2, '.', ',') . '</td>';
      echo '<td>' . date('m/d/Y h:i:s A', strtotime($row['TimeStamp'])) . '</td>';
      echo '</tr>';
    }
  }

  public function listOfFeedback() {
    global $db;
    $result = $db->query('SELECT * FROM feedback');
    while ($row = $result->fetch_assoc()) {
      echo '<tr>';
      echo "<td>{$row['ID']}</td>";
      echo "<td>{$row['Star']}</td>";
      echo '<td>' . ($row['Comment'] ?? 'N/A') . '</td>';
      echo '</tr>';
    }
  }

  public function accounts() {
    global $db;
    $result = $db->query('SELECT * FROM account');
    while ($row = $result->fetch_assoc()) {
      echo '<tr>';
      echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
      echo "<td id='txtFirstName'>{$row['FirstName']}</td>";
      echo "<td id='txtLastName'>{$row['LastName']}</td>";
      echo "<td id='txtBirthDate'>" . date('m/d/Y', strtotime($row['BirthDate'])) . '</td>';
      echo "<td id='txtContactNumber'>{$row['ContactNumber']}</td>";
      echo "<td id='txtAccountType'>{$row['AccountType']}</td>";
      $checked = $row['Status'] == 1 ? 'checked' : '';
      if ($this->checkUserLevel(2)) {
        echo '<td>';
        echo (($row['AccountType'] != 'Admin' && $row['AccountType'] != 'Creator') || $this->checkUserLevel(3)) && $row['EmailAddress'] != $this->email ? "<input type='checkbox' id='{$row['EmailAddress']}' class='cbxStatus' data-toggle='toggle' data-on='Activated' data-off='Deactivated' data-width='105' $checked/>" : '';
        echo '</td>';
        echo '<td>';
        echo (($row['AccountType'] != 'Admin' && $row['AccountType'] != 'Creator') || $this->checkUserLevel(3)) && $row['EmailAddress'] != $this->email ? "<a class='btnEditAccount' data-tooltip='tooltip' data-placement='bottom' title='Edit' id='{$row['EmailAddress']}' style='cursor:pointer' data-toggle='modal' data-target='#modalEditAccount'><i class='fa fa-pencil fa-2x' aria-hidden='true'></i></a>" : '';
        echo '</td>';
      }
      echo '</tr>';
    }
  }

  public function eventLogs() {
    global $db;
    $result = $db->query('SELECT * FROM log');
    while ($row = $result->fetch_assoc()) {
      echo '<tr>';
      echo "<td>{$row['ID']}</td>";
      echo "<td>{$row['EmailAddress']}</td>";
      echo '<td>' . str_replace('|', ' | ', $row['Action']) . '</td>';
      echo '<td>' . date('m/d/Y h:i:s A', strtotime($row['TimeStamp'])) . '</td>';
      echo '</tr>';
    }
  }

  /**
   * @param $type
   */
  public function listBookingID($type = 'get') {
    global $db;
    $email      = $this->filter_input($this->email);
    $result     = $db->query("SELECT * FROM booking WHERE EmailAddress = '$email'");
    $first      = true;
    $bookingIDs = [];
    while ($row = $result->fetch_assoc()) {
      $tomorrow = strtotime(date('Y-m-d')) + 86400 * EDIT_RESERVATION_DAYS;
      if ($tomorrow <= strtotime($row['CheckInDate'])) {
        if ($type == 'combobox') {
          if ($first) {
            $adults   = $row['Adults'];
            $children = $row['Children'];
            $first    = false;
          }
          echo '                ';
          echo "<option value='" . $row['BookingID'] . "'>" . $this->formatBookingID($row['BookingID']) . "</option>\n";
        } else {
          $bookingIDs[] = $row['BookingID'];
        }
      }
    }
    if ($type == 'get') {
      return count($bookingIDs) > 0 ? $bookingIDs : false;
    }
  }

  /**
   * @param $category
   */
  public function rooms($category) {
    global $db;
    if ($category == 'statuses') {
      $query  = 'SELECT RoomID, RoomType, RoomDescription, Status, Maintenance FROM room JOIN room_type ON room.RoomTypeID = room_type.RoomTypeID ORDER BY RoomID';
      $result = mysqli_query($db, $query);
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo "<td id='txtRoomID'>{$row['RoomID']}</td>";
        echo "<td id='txtRoomType'>" . str_replace('_', ' ', $row['RoomType']) . '</td>';
        $checked = $row['Status'] == 1 ? 'checked' : '';
        echo "<td><input type='checkbox' data-toggle='toggle' data-on='Enabled' data-off='Disabled' class='cbxRoom' id='{$row['RoomID']}' data-type='Status' $checked/></td>";
        $checked  = $row['Maintenance'] == 1 ? 'checked' : '';
        $disabled = $this->isOccupied($row['RoomID']) ? "data-onstyle='danger' disabled" : '';
        echo "<td><input type='checkbox' data-toggle='toggle' data-on='" . ($disabled == '' ? 'Enabled' : 'Occupied') . "' data-off='" . ($disabled == '' ? 'Disabled' : 'Occupied') . "' class='cbxRoom' id='{$row['RoomID']}' data-type='Maintenance' $checked $disabled/></td>";
        echo "<td style='width:7%'>";
        echo "<a class='btnEditRoomID col-md-6' style='cursor:pointer;padding:0;' id='{$row['RoomID']}' data-toggle='modal' data-target='#modalEditRoomID' data-tooltip='tooltip' data-placement='bottom' title='Edit'><i class='fa fa-pencil fa-2x' aria-hidden='true'></i></a>";
        echo "<a class='btnDeleteRoomID col-md-6' style='cursor:pointer;padding:0;padding-left:2px' id='{$row['RoomID']}' data-tooltip='tooltip' data-placement='bottom' title='Delete'><i class='fa fa-trash fa-2x' aria-hidden='true'></i></a>";
        echo '</td>';
        echo '</tr>';
      }
    } else if ($category == 'descriptions') {
      $result = $db->query('SELECT * FROM room_type');
      while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . str_replace('_', ' ', $row['RoomType']) . '</td>';
        echo "<td style='width:20%' id='txtRoomDescription'>" . str_replace("\n", '<br/>', $row['RoomDescription']) . '</td>';
        echo "<td id='txtRoomSimpDesc'>" . nl2br($row['RoomSimplifiedDescription']) . '</td>';
        echo "<td id='txtIcon'>" . nl2br($row['Icons']) . '</td>';
        echo "<td id='txtCapacity'>{$row['Capacity']}</td>";
        echo "<td id='txtRegularRate'>₱&nbsp;" . number_format($row['RegularRate']) . '</td>';
        echo "<td id='txtSeasonRate'>₱&nbsp;" . number_format($row['SeasonRate']) . '</td>';
        echo "<td id='txtHolidayRate'>₱&nbsp;" . number_format($row['HolidayRate']) . '</td>';
        echo "<td style='width:7%'>";
        echo "<a class='btnEditRoomType col-md-6' style='cursor:pointer;padding:0' data-toggle='modal' data-target='#modalEditRoomType' id='{$row['RoomType']}' data-tooltip='tooltip' data-placement='bottom' title='Edit'><i class='fa fa-pencil fa-2x' aria-hidden='true'></i></a>";
        echo "<a class='btnDeleteRoomType col-md-6' style='cursor:pointer;padding:0;padding-left:2px' id='{$row['RoomType']}' data-tooltip='tooltip' data-placement='bottom' title='Delete'><i class='fa fa-trash fa-2x' aria-hidden='true'></i></a>";
        echo '</td>';
        echo '</tr>';
      }
    }

  }

}

/*----------------------------------------*/
/*--------------System Class--------------*/
/*----------------------------------------*/
class System {
  /**
   * @var mixed
   */
  public $email, $firstName, $lastName, $profilePicture, $accountType, $birthDate, $contactNumber;

  public function __construct() {
    global $db;
    if (isset($_SESSION['account']) && !$db->connect_error && $db->select_db('cp018101_nwh')) {
      $this->email          = $this->decrypt($_SESSION['account']);
      $result               = $db->query("SELECT * FROM account WHERE EmailAddress='{$this->email}'");
      $row                  = $result->fetch_assoc();
      $this->firstName      = $row['FirstName'];
      $this->lastName       = $row['LastName'];
      $this->profilePicture = $row['ProfilePicture'];
      $this->accountType    = $row['AccountType'];
      $this->birthDate      = $row['BirthDate'];
      $this->contactNumber  = $row['ContactNumber'];
      $this->nationality    = $row['Nationality'];
    }
  }

  /**
   * @param $name
   * @param $price
   */
  public function addExpenses($name, $price) {
    global $db;
    $db->query("INSERT INTO expenses VALUES(NULL,'$name',$price)");
    if ($db->affected_rows > 0) {
      $this->log("insert|expenses|$name|$price");
      return true;
    } else {
      return false;
    }
  }

  /**
   * @param $name
   * @param $price
   */
  public function addDiscount($name, $price, $taxFree) {
    global $db;
    $db->query("INSERT INTO discount VALUES(NULL,'$name','" . ($taxFree != null ? 1 : 0) . "',$price)");
    if ($db->affected_rows > 0) {
      $this->log("insert|discount|$name|$price");
      return true;
    } else {
      return false;
    }
  }

  /**
   * @param $name
   * @param $price
   * @return mixed
   */
  public function editExpenses($name, $price) {
    global $db;
    $db->query("UPDATE expenses SET Amount=$price WHERE Name='$name'");
    if ($db->affected_rows > 0) {
      $this->log("update|expenses|$name|$price");
      return true;
    } else {
      return $db->error;
    }
  }

  /**
   * @param $name
   * @param $price
   * @return mixed
   */
  public function editDiscount($name, $price, $taxFree) {
    global $db;
    $db->query("UPDATE discount SET Amount='$price', TaxFree='" . ($taxFree != null ? 1 : 0) . "' WHERE Name='$name'");
    if ($db->affected_rows > 0) {
      $this->log("update|discount|$name|$price");
      return true;
    } else {
      return $db->error;
    }
  }

  /**
   * @param $name
   * @return mixed
   */
  public function deleteExpenses($name) {
    global $db;
    $db->query("DELETE FROM expenses WHERE Name='$name'");
    if ($db->affected_rows > 0) {
      $this->log("delete|expenses|$name");
      return true;
    } else {
      return $db->error;
    }
  }

  /**
   * @param $name
   * @return mixed
   */
  public function deleteDiscount($name) {
    global $db;
    $db->query("DELETE FROM discount WHERE Name='$name'");
    if ($db->affected_rows > 0) {
      $this->log("delete|discount|$name");
      return true;
    } else {
      return $db->error;
    }
  }

  /**
   * @param $type
   * @param $startDate
   * @param $endDate
   */
  public function markEvent($type = '', $startDate, $endDate) {
    global $db, $date;
    $startDate = $this->formatDate($startDate, 'Y-m-d');
    $endDate   = $this->formatDate($endDate, 'Y-m-d');
    $db->query("INSERT INTO promo_dates VALUES('" . ucfirst($type) . "','$startDate','$endDate')");
    if ($db->affected_rows > 0) {
      $this->log("add|promo_dates|$type");
      return true;
    } else {
      return NOTHING_CHANGED;
    }
  }

  public function addVisitorCount() {
    global $db, $date;
    $result = $db->query("SELECT * FROM `visitor_count` WHERE Date='$date'");
    if ($result->num_rows == 0) {
      $db->query("INSERT INTO `visitor_count` VALUES('$date','1')");
    } else {
      $db->query("UPDATE `visitor_count` SET Count=Count+1 WHERE Date='$date'");
    }
  }

  /**
   * @return mixed
   */
  public function getAllEmailAddress() {
    global $db;
    $result = $db->query('SELECT * FROM account');
    $list   = [];
    while ($row = $result->fetch_assoc()) {
      $list[] = $row['EmailAddress'];
    }
    return $list;
  }

  /**
   * @return mixed
   */
  public function getNextBookingID() {
    global $db;
    $result = $db->query("SHOW TABLE STATUS LIKE 'booking'");
    $row    = $result->fetch_assoc();
    return $row['Auto_increment'];
  }

  /**
   * @param $bookingID
   * @param $type
   * @return mixed
   */
  public function revertCheck($bookingID, $type) {
    global $db;
    if ($type == 'checkIn') {
      $db->query("DELETE FROM booking_check WHERE BookingID=$bookingID");
    } else if ($type == 'checkOut') {
      $result = $db->query("SELECT * FROM booking_check WHERE BookingID=$bookingID");
      if ($result->num_rows > 0) {
        $db->query("UPDATE booking_check SET CheckOut=NULL WHERE BookingID=$bookingID");
      } else {
        return false;
      }
    }
    $this->log("delete|$type|$bookingID");
    return $db->affected_rows > 0;
  }

  /**
   * @param $bookingID
   */
  public function computeTotalAmount($bookingID) {
    global $db;
    $result         = $db->query("SELECT * FROM booking LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID LEFT JOIN booking_paypal ON booking.BookingID=booking_paypal.BookingID JOIN booking_transaction ON booking.BookingID=booking_transaction.BookingID WHERE booking.BookingID=$bookingID");
    $row            = $result->fetch_assoc();
    $expenses       = 0;
    $expensesResult = $db->query("SELECT Name, Quantity, expenses.Amount as Amount, booking_expenses.Amount as oAmount FROM expenses LEFT JOIN booking_expenses ON expenses.ExpensesID=booking_expenses.ExpensesID WHERE BookingID=$bookingID");
    while ($expensesRow = $expensesResult->fetch_assoc()) {
      if ($expensesRow['Name'] == 'Others') {
        $expenses += $expensesRow['oAmount'] * $expensesRow['Quantity'];
      } else {
        $expenses += $expensesRow['Amount'] * $expensesRow['Quantity'];
      }
    }
    $discountResult = $db->query("SELECT Name, discount.Amount as Amount, booking_discount.Amount as oAmount FROM discount LEFT JOIN booking_discount ON discount.DiscountID=booking_discount.DiscountID WHERE BookingID=$bookingID");
    $discountRow    = $discountResult->fetch_assoc();
    if ($discountRow['Name'] == 'Others') {
      $discount = strpos($discountRow['oAmount'], '%') !== false ? $this->percentToDecimal($discountRow['oAmount']) : $discountRow['oAmount'];
    } else {
      $discount = strpos($discountRow['Amount'], '%') !== false ? $this->percentToDecimal($discountRow['Amount']) : $discountRow['Amount'];
    }
    return ($row['TotalAmount'] + $expenses) - (($row['TotalAmount'] + $expenses) * $discount);
  }

  /**
   * @param $bookingID
   */
  public function computeBill($bookingID) {
    global $db;
    $result         = $db->query("SELECT * FROM booking LEFT JOIN booking_check ON booking.BookingID=booking_check.BookingID LEFT JOIN booking_paypal ON booking.BookingID=booking_paypal.BookingID JOIN booking_transaction ON booking.BookingID=booking_transaction.BookingID WHERE booking.BookingID=$bookingID");
    $row            = $result->fetch_assoc();
    $expenses       = 0;
    $expensesResult = $db->query("SELECT Name, Quantity, expenses.Amount as Amount, booking_expenses.Amount as oAmount FROM expenses LEFT JOIN booking_expenses ON expenses.ExpensesID=booking_expenses.ExpensesID WHERE BookingID=$bookingID");
    while ($expensesRow = $expensesResult->fetch_assoc()) {
      if ($expensesRow['Name'] == 'Others') {
        $expenses += $expensesRow['oAmount'] * $expensesRow['Quantity'];
      } else {
        $expenses += $expensesRow['Amount'] * $expensesRow['Quantity'];
      }
    }
    $discountResult = $db->query("SELECT Name, discount.Amount as Amount, booking_discount.Amount as oAmount FROM discount LEFT JOIN booking_discount ON discount.DiscountID=booking_discount.DiscountID WHERE BookingID=$bookingID");
    $discountRow    = $discountResult->fetch_assoc();
    if ($discountRow['Name'] == 'Others') {
      $discount = strpos($discountRow['oAmount'], '%') !== false ? $this->percentToDecimal($discountRow['oAmount']) : $discountRow['oAmount'];
    } else {
      $discount = strpos($discountRow['Amount'], '%') !== false ? $this->percentToDecimal($discountRow['Amount']) : $discountRow['Amount'];
    }
    return ($row['TotalAmount'] + $expenses) - (($row['TotalAmount'] + $expenses) * $discount) - $row['AmountPaid'];
  }

  /**
   * @param $bookingID
   * @param $payment
   * @return mixed
   */
  public function payBill($bookingID, $payment) {
    global $db, $dateandtime;
    $totalAmount = $this->computeBill($bookingID);
    $row         = $db->query("SELECT * FROM booking_transaction WHERE BookingID=$bookingID")->fetch_assoc();
    $amountPaid  = $row['AmountPaid'] + $payment;
    $change      = $payment - $totalAmount;
    $db->query("UPDATE booking_transaction SET AmountPaid=$amountPaid,PaymentChange=$change WHERE BookingID=$bookingID");
    if ($db->affected_rows > 0) {
      return $change;
    } else {
      return ERROR_OCCURED;
    }
  }

  public function redirectLogin() {
    global $root;
    if (!strpos($_SERVER['QUERY_STRING'], $_SERVER['SERVER_NAME']) && !$this->isLogged()) {
      $referrer = '//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
      $url      = rawurlencode($referrer);
      echo "<script>location.replace('//{$_SERVER['SERVER_NAME']}{$root}account/login.php?redirect=$url')</script>";
    }
  }

  /**
   * @param $name
   * @param $email
   * @param $contactNumber
   * @param $message
   * @return mixed
   */
  public function sendContactForm($name, $email, $contactNumber, $message) {
    $subject = "Message from $email";
    $body    = "Name: $name<br/>Email: $email<br/>Contact Number: $contactNumber<br/>Message: $message";
    return $this->sendMail(SUPPORT_EMAIL, $subject, $body, 'Northwood Hotel Support');
  }

  /**
   * @param $email
   * @param $subject
   * @param $body
   * @param $title
   */
  public function sendMail($email, $subject, $body, $title = '') {
    try {
      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Timeout  = 10;
      $mail->Host     = 'ssl://cpanel02wh.sin1.cloud.z.com:465';
      $mail->SMTPAuth = true;
      $mail->Username = NOREPLY_EMAIL;
      $mail->Password = PASSWORD;

      $mail->setFrom(NOREPLY_EMAIL, 'Northwood Hotel');
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

  /**
   * @param $image
   * @param $directory
   * @param $filename
   * @param $size
   */
  public function saveImage($image, $directory, $filename, $size = 720) {
    if (file_exists($directory . $filename)) {
      unlink($directory . $filename);
    }
    if (move_uploaded_file($image['tmp_name'], $directory . $filename)) {
      $image = new \Gumlet\ImageResize($directory . $filename);
      $image->resizeToHeight($size);
      $image->save($directory . $filename);
      return true;
    } else {
      return UPLOAD_ERROR;
    }
  }

  /**
   * @param $token
   * @return mixed
   */
  public function validateToken($token = null) {
    return isset($_SERVER['HTTP_X_CSRF_TOKEN']) && $_SESSION['csrf_token'] === $this->decrypt($token ?? $_SERVER['HTTP_X_CSRF_TOKEN']);
  }

  /**
   * @param $action
   * @param $email
   */
  public function log($action, $email = null) {
    global $db;
    $email = $email ?? $this->email;
    $date  = date('Y-m-d H:i:s');
    $db->query("INSERT INTO log VALUES(NULL, '$email', '$action', '$date')");
  }

  /**
   * @param $id
   * @param $revert
   */
  public function formatBookingID($id, $revert = false) {
    global $db;
    if ($revert == false) {
      $dateCreated = $this->formatDate($db->query("SELECT DateCreated FROM booking WHERE BookingID=$id")->fetch_assoc()['DateCreated'], 'Y-m-d');
      $result      = $db->query("SELECT * FROM booking WHERE DateCreated>='{$dateCreated} 00:00:00' AND DateCreated<='{$dateCreated} 23:59:59'");
      $number      = 1;
      for (; $row = $result->fetch_assoc(); $number++) {
        if ($id == $row['BookingID']) {
          break;
        }
      }
      return 'NWH' . date('mdy', strtotime($row['DateCreated'])) . '-' . sprintf("% '04d", $number);
    } else {
      $dateCreated = DateTime::createFromFormat('mdy', substr($id, 3, 6));
      $dateCreated = $dateCreated->format('Y-m-d');
      $bookingID   = (int) substr(strrchr($id, '-'), 1) - 1;
      $result      = $db->query("SELECT * FROM booking WHERE DateCreated>='{$dateCreated} 00:00:00' AND DateCreated<='{$dateCreated} 23:59:59'");
      $result->data_seek($bookingID);
      $row = $result->fetch_assoc();

      return (int) $row['BookingID'];
    }
  }

  /**
   * @param $bookingID
   */
  public function checkExpiredBooking($bookingID = null) {
    global $db, $date, $dateandtime;
    if (!$db->connect_error) {
      if ($bookingID == null) {
        $result = $db->query('SELECT booking.BookingID,AmountPaid,DateCreated FROM booking LEFT JOIN booking_cancelled ON booking.BookingID=booking_cancelled.BookingID JOIN booking_transaction ON booking.BookingID=booking_transaction.BookingID WHERE DateCancelled IS NULL');
      } else {
        $result = $db->query("SELECT booking.BookingID,AmountPaid,DateCreated FROM booking LEFT JOIN booking_cancelled ON booking.BookingID=booking_cancelled.BookingID JOIN booking_transaction ON booking.BookingID=booking_transaction.BookingID WHERE DateCancelled IS NULL AND booking.BookingID=$bookingID");
      }
      while ($row = $result->fetch_assoc()) {
        if (strtotime($row['DateCreated']) + 86400 < strtotime($dateandtime) && $row['AmountPaid'] == 0 && $db->query("SELECT * FROM booking_paypal WHERE BookingID=$bookingID")->num_rows == 0) {
          $db->query("INSERT INTO booking_cancelled VALUES({$row['BookingID']},'$date','Auto expired')");
          $this->log("insert|{$this->formatBookingID($row['BookingID'])}|autocancel");
        }
      }
    }
  }

  /**
   * @param $captcha
   */
  public function verifyCaptcha($captcha) {
    if (!$captcha) {
      return 'Please check the the captcha form.';
    }
    $secretKey    = '6Ler0DUUAAAAABE_r5gAH7LhkRPAavkyNkUOOQZd';
    $ip           = $_SERVER['REMOTE_ADDR'];
    $response     = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $captcha . '&remoteip=' . $ip);
    $responseKeys = json_decode($response, true);
    if (intval($responseKeys['success']) !== 1) {
      return 'Get out loser!';
    }
    return true;
  }

  /**
   * @param $date
   * @param $time
   */
  public function isExpired($date, $time) {
    $seconds = $time * 60;
    return strtotime($date) + $seconds < strtotime('now');
  }

  /**
   * @param $checkDate1
   * @param $checkDate2
   * @param $date1
   * @param $date2
   */
  public function isBetweenDate($checkDate1, $checkDate2, $date1, $date2) {
    $checkDate = $this->getDatesFromRange($checkDate1, date('Y-m-d', strtotime($checkDate2) - 86400));
    $date      = $this->getDatesFromRange($date1, date('Y-m-d', strtotime($date2) - 86400));

    foreach ($checkDate as $key => $value) {
      if (in_array($value, $date)) {
        return true;
      }
    }
    return false;
  }

  /**
   * @param $start
   * @param $end
   * @return mixed
   */
  public function getDatesFromRange($start, $end) {
    $dates = [];
    if ($start != $end) {
      $end = new DateTime($end);
      $end->add(new DateInterval('P1D'));

      $period = new DatePeriod(new DateTime($start), new DateInterval('P1D'), $end);

      foreach ($period as $date) {
        $dates[] = $date->format('Y-m-d');
      }
    } else {
      $dates[] = date('Y-m-d', strtotime($start));
    }
    return $dates;
  }

  /**
   * @param $file
   */
  public function importdb($file) {
    global $db;
    $contents         = file_get_contents($file);
    $comment_patterns = ['/\/\*.*(\n)*.*(\*\/)?/',
      '/\s*--.*\n/',
      '/\s*#.*\n/'
    ];
    $contents = preg_replace($comment_patterns, "\n", $contents);

    $statements = explode(';', $contents);
    $statements = preg_replace("/\s/", ' ', $statements);
    foreach ($statements as $query) {
      if (trim($query) != '') {
        $res = $db->query($query);
      }
    }
  }

  /**
   * @param $tables
   * @param $type
   */
  public function backupdb($tables, $type) {
    global $db;
    $hasData = false;
    @mkdir('../files/backup');
    @mkdir('../files/backup/sql');
    @mkdir('../files/backup/excel');
    $filename = date('Y-m-d h-i-s A') . ' [' . join($tables, '][') . ']';
    if ($type == 'sql' || $type == 'all') {
      $filedir  = "../files/backup/sql/$filename.sql";
      $filedata = '';
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
          $query = "INSERT INTO $table (" . join($columns, ',') . ") VALUES('" . join($data, "','") . "');";
          $filedata .= $query . PHP_EOL;
        }
      }
      if (trim($filedata) != '') {
        $file = fopen($filedir, 'w');
        fwrite($file, $filedata);
        fclose($file);
      }
    }
    if ($type == 'excel' || $type == 'all') {
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

  /**
   * @param $type
   * @param $message
   */
  public function addNotif($type, $message) {
    global $db, $dateandtime;
    $db->query("INSERT INTO notification VALUES(NULL,'$type','$message',0,'$dateandtime')");
  }

  /**
   * @param $id
   */
  public function readNotif($id) {
    global $db, $dateandtime;
    $db->query("UPDATE notification SET MarkedAsRead=1 WHERE ID=$id");
  }

  public function isLogged() {
    return isset($_SESSION['account']) ? true : false;
  }

  /**
   * @param $reqLevel
   * @param $kick
   */
  public function checkUserLevel($reqLevel, $kick = false) {
    global $root, $levels;
    if ($this->isLogged()) {
      $currentLevel = array_search($this->accountType, $levels);
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

  /**
   * @param $date
   * @param $format
   */
  public function formatDate($date, $format) {
    return date($format, strtotime($date));
  }

  /**
   * @param $percent
   * @return mixed
   */
  public function percentToDecimal($percent) {
    $percent = str_replace('%', '', $percent);
    return $percent / 100;
  }

  /**
   * @param $var1
   * @param $var2
   * @param $pool
   */
  public function getBetweenString($var1 = '', $var2 = '', $pool) {
    $temp1  = strpos($pool, $var1) + strlen($var1);
    $result = substr($pool, $temp1, strlen($pool));
    $dd     = strpos($result, $var2);
    if ($dd == 0) {
      $dd = strlen($result);
    }

    return substr($result, 0, $dd);
  }

  /**
   * @param $length
   * @return mixed
   */
  public function getRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string     = '';

    for ($i = 0; $i < $length; $i++) {
      $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
  }

  /**
   * @param $string
   * @param $isPassword
   * @return mixed
   */
  public function filter_input($string, $isPassword = false) {
    global $db;
    $output = $db->real_escape_string($string);
    return $isPassword == false ? filter_var($output, FILTER_SANITIZE_STRING) : $output;
  }

  /**
   * @param $string
   */
  public function encrypt($string) {
    return openssl_encrypt($string, 'AES-256-CTR', ENCRYPT_KEYWORD, OPENSSL_ZERO_PADDING, INITIALIZATION_VECTOR);
  }

  /**
   * @param $string
   */
  public function decrypt($string) {
    return openssl_decrypt(str_replace(' ', '+', $string), 'AES-256-CTR', ENCRYPT_KEYWORD, OPENSSL_ZERO_PADDING, INITIALIZATION_VECTOR);
  }

};
$account = new Account();
$room    = new Room();
$view    = new View();
$system  = new System();
?>
