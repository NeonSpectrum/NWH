<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

class Account extends System {

  public function login($credentials) {
    global $db;
    $email    = $db->real_escape_string($credentials['email']);
    $password = $db->real_escape_string($credentials['password']);

    $result = $db->query("SELECT * FROM `account` WHERE EmailAddress='$email'");
    $row    = $result->fetch_assoc();

    if ($result->num_rows == 1 && password_verify($password, $row['Password'])) {
      $_SESSION['email']         = $row['EmailAddress'];
      $_SESSION['fname']         = $row['FirstName'];
      $_SESSION['lname']         = $row['LastName'];
      $_SESSION['picture']       = $row['ProfilePicture'];
      $_SESSION['accountType']   = $row['AccountType'];
      $_SESSION['birthDate']     = $row['BirthDate'];
      $_SESSION['contactNumber'] = $row['ContactNumber'];

      $db->query("UPDATE account SET SessionID='" . session_id() . "' WHERE EmailAddress='$email");
      $this->createLog("login|account", $email);
      return true;
    } else {
      return false;
    }
  }

  public function logout() {
    if (isSet($_COOKIE['nwhAuth'])) {
      setcookie('nwhAuth', '', time() - (60 * 60 * 24 * 7), '/');
      unset($_COOKIE['nwhAuth']);
    }
    if (session_destroy()) {
      if (strpos($_SERVER['HTTP_REFERER'], "/reservation")) {
        header("location: ../");
      } else {
        header("location:" . $_SERVER['HTTP_REFERER']);
      }
      return true;
    }
    return false;
  }

  public function verifyRegistration($credentials) {
    global $db, $date, $root;
    $fname         = ucwords(strtolower($db->real_escape_string($credentials['txtFirstName'])));
    $lname         = ucwords(strtolower($db->real_escape_string($credentials['txtLastName'])));
    $email         = $db->real_escape_string($credentials['txtEmail']);
    $password      = password_hash($db->real_escape_string($credentials['txtPassword']), PASSWORD_DEFAULT);
    $contactNumber = $db->real_escape_string($credentials['txtContactNumber']);
    $birthDate     = $db->real_escape_string($credentials['txtBirthDate']);

    $result = $db->query("SELECT * FROM account WHERE EmailAddress='$email'");

    if ($result->num_rows == 0) {
      $data    = $this->nwh_encrypt("txtFirstName=$fname&txtLastName=$lname&txtEmail=$email&txtPassword=$password&txtContactNumber=$contactNumber&txtBirthDate=$birthDate&expirydate=" . (strtotime("now") + (60 * 10)));
      $subject = "Northwood Hotel Account Creation";
      $body    = "Please proceed to this link to register your account:<br/>http://{$_SERVER['SERVER_NAME']}{$root}account/register.php?$data";
      if ($this->sendMail("$email", "$subject", "$body") == true) {
        $this->createLog("sent|registration|$email");
        echo true;
      }
    } else {
      echo ALREADY_REGISTERED;
    }
  }

  public function register($credentials, $verify = true) {
    global $db, $date, $root;
    $fname         = ucwords(strtolower($db->real_escape_string($credentials['txtFirstName'])));
    $lname         = ucwords(strtolower($db->real_escape_string($credentials['txtLastName'])));
    $email         = $db->real_escape_string($credentials['txtEmail']);
    $password      = password_hash($db->real_escape_string($credentials['txtPassword']), PASSWORD_DEFAULT);
    $contactNumber = $db->real_escape_string($credentials['txtContactNumber']);
    $birthDate     = $db->real_escape_string($credentials['txtBirthDate']);

    if (isset($credentials['expirydate']) && $this->isExpired($credentials['expirydate'])) {
      return "<script>alert('Link Expired. Please register again.');location.href='$root';</script>";
    }

    $db->query("INSERT INTO `account`(EmailAddress,Password,FirstName,LastName,ContactNumber,BirthDate,DateRegistered) VALUES ('$email', '$password', '$fname', '$lname','$contactNumber','$birthDate','$date')");

    if (!$verify) {
      if ($db->affected_rows > 0) {
        $this->createLog("insert|account.register|$email']}", $_SESSION['email']);
        return true;
      } else {
        return ALREADY_REGISTERED;
      }
    } else {
      if ($db->affected_rows > 0) {
        $this->createLog("registered|account|$email");
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
        $this->createLog("update|user.password|$email");
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
          $this->createLog("update|user.password");
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
      $this->createLog("sent|forgot.password|$email");
      $data    = "email=$email&token=" . $this->generateForgotToken($email);
      $subject = "Northwood Hotel Forgot Password";
      $body    = "Please proceed to this link to reset your password:<br/>http://{$_SERVER['SERVER_NAME']}{$root}?$data";

      return $this->sendMail("$email", "$subject", "$body");
    }
  }

  private function generateForgotToken($email) {
    global $db, $dateandtime;
    $token = $this->getRandomString(50);
    $db->query("INSERT INTO forgot_password VALUES(NULL, '$email', '$token', 0, '$dateandtime')");
    if ($db->affected_rows > 0) {
      $this->createLog("insert|account.generate.token|$email");
      return $token;
    } else {
      return $db->error;
    }
  }

  public function verifyForgotToken($email, $token) {
    global $db;
    $result = $db->query("SELECT * FROM forgot_password WHERE EmailAddress='$email' AND token='$token'");
    $row    = $result->fetch_assoc();
    if ($result->num_rows > 0 && !$row['used'] && !$this->isExpired($row['timestamp'], FORGOT_PASSWORD_EXPIRATION)) {
      return true;
    } else {
      return $db->error;
    }
  }

  public function expireToken($email, $token) {
    global $db;
    $db->query("UPDATE forgot_password SET used=1 WHERE EmailAddress='$email' AND token='$token'");
    if ($db->affected_rows > 0) {
      return true;
    } else {
      return $db->error;
    }
  }

  public function editProfile($credentials, $basic = false) {
    global $db, $root;
    if ($basic) {
      $email       = $credentials['email'];
      $accountType = $credentials['accountType'];
      $firstName   = $credentials['firstName'];
      $lastName    = $credentials['lastName'];

      $result = $db->query("UPDATE `account` SET AccountType='$accountType',FirstName='$firstName',LastName='$lastName' WHERE EmailAddress='$email'");
      if ($db->affected_rows > 0) {
        $this->createLog("update|account|$email");
        echo true;
      } else {
        echo $db->error;
      }
    } else {
      $output = NOTHING_CHANGED;
      if (isset($credentials['image'])) {
        $directory = $_SERVER['DOCUMENT_ROOT'] . "{$root}images/profilepics/";
        $filename  = basename($_SESSION['fname'] . $_SESSION['lname']) . "." . pathinfo($directory . basename($credentials['image']["name"]), PATHINFO_EXTENSION);
        $output    = $this->saveImage($credentials['image'], $directory, $filename);
        if ($output == true) {
          $db->query("UPDATE account SET ProfilePicture='$filename' WHERE EmailAddress='{$_SESSION['email']}'");
          $this->createLog("update|account.profilepicture");
          $_SESSION["picture"] = $filename;
        } else {
          return $output;
        }
      }

      $email         = $db->real_escape_string($_SESSION['email']);
      $fname         = $db->real_escape_string($credentials['fname']);
      $lname         = $db->real_escape_string($credentials['lname']);
      $birthDate     = $db->real_escape_string($credentials['birthDate']);
      $contactNumber = $db->real_escape_string($credentials['contactNumber']);

      $db->query("UPDATE account SET FirstName='$fname', LastName='$lname', BirthDate='$birthDate', ContactNumber='$contactNumber' WHERE EmailAddress='$email'");

      if ($db->affected_rows > 0) {
        $_SESSION['fname']         = $fname;
        $_SESSION['lname']         = $lname;
        $_SESSION['birthDate']     = $birthDate;
        $_SESSION['contactNumber'] = $contactNumber;
        $this->createLog("update|account.profile");
        $output = true;
      }
      return $output;
    }
  }

  public function deleteAccount($email) {
    global $db;
    if ($_SESSION['accountType'] == "Owner") {
      $result = $db->query("DELETE FROM account WHERE EmailAddress='$email'");

      if ($db->affected_rows > 0) {
        $this->createLog("delete|account|$email");
        echo true;
      } else {
        echo $db->error;
      }
    }
    return ERROR_OCCURED;
  }

}

class Room extends System {

  public function editRoomDescription($roomType, $description) {
    global $db;
    $db->query("UPDATE room_type SET RoomDescription='$description' WHERE RoomType='$roomType'");

    if ($db->affected_rows > 0) {
      $this->createLog("update|room_type|$roomType");
      return true;
    } else {
      return NOTHING_CHANGED;
    }
  }

  public function updateRoomStatus($roomID, $status) {
    global $db;
    $result = $db->query("UPDATE room SET Status = '$status' WHERE RoomID = $roomID");

    if ($db->affected_rows > 0) {
      $this->createLog("update|room.status|$roomID|$status");
      echo true;
    } else {
      echo ERROR_OCCURED;
    }
  }

  public function getRoomPrice($room) {
    global $db;
    $result = $db->query("SELECT * FROM room_type WHERE RoomType='$room'");
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

  public function generateRoomID($room) {
    global $db;
    $rooms  = array();
    $result = $db->query("SELECT RoomID, RoomType, Status FROM room JOIN room_type ON room.RoomTypeID = room_type.RoomTypeID WHERE RoomType = '$room'");

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

}
class Book {
  public function showBookingInfo($bookingID) {
    global $db;
    $result = $db->query("SELECT * FROM booking JOIN room ON booking.RoomID = room.RoomID JOIN room_type ON room_type.RoomTypeID = room.RoomTypeID WHERE BookingID = $bookingID");
    $row    = $result->fetch_assoc();

    if ($result->num_rows == 1) {
      $arr    = [];
      $arr[0] = $row['RoomType'];
      $arr[1] = $row['CheckInDate'];
      $arr[2] = $row['CheckOutDate'];
      $arr[3] = $row['Adults'];
      $arr[4] = $row['Childrens'];

      return json_encode($arr);
    }
  }
}
class View extends Room {

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
      echo "<div class='wow slideInUp col-md-4' style='margin-bottom:40px'>
        <figure class='imghvr-hinge-up'>
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
      $filename = str_replace("images/{$category}/", "", $image);
      echo "<a href='$image' data-caption='$filename'><img src='$image?v=" . filemtime("$image") . "' alt='$filename' class='zoom'></a>\n";
    }
  }

  public function roomandrates() {
    global $db;
    $result = $db->query("SELECT * FROM room_type");
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td class='img-baguette'>";
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
          <h3>" . str_replace("_", " ", $row['RoomType']) . "</h3><br/>
          {$row['RoomDescription']}
        </td>";
      echo "<td><center>From<br/><br/><span style='text-style:bold;font-size:20px;'>₱&nbsp;" . number_format($this->getRoomPrice($row['RoomType'])) . "</span></center></td>";
      echo "</tr>";
    }
  }

  public function booking() {
    global $db, $root;
    $result = $db->query("SELECT * FROM booking");
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>{$row['BookingID']}</td>";
      echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
      echo "<td id='txtRoomID'>{$row['RoomID']}</td>";
      echo "<td id='txtCheckInDate'>{$row['CheckInDate']}</td>";
      echo "<td id='txtCheckOutDate'>{$row['CheckOutDate']}</td>";
      echo "<td id='txtAdults'>{$row['Adults']}</td>";
      echo "<td id='txtChildren'>{$row['Children']}</td>";
      echo "<td>";
      echo "<a class='btnEditReservation' id='{$row['BookingID']}' style='cursor:pointer' data-toggle='modal' data-target='#modalEditReservation' title='Edit'><i class='fa fa-pencil'></i></a>";
      echo "&nbsp;&nbsp;<a href='{$root}files/generateReservationConfirmation?BookingID={$row['BookingID']}' title='Print'><i class='fa fa-print'></i></a>";
      echo "</td>";
      echo "</tr>";
    }
  }

  public function check($category) {
    global $db;
    if ($category == "walk_in") {
      $result = $db->query("SELECT walk_in.WalkInID, EmailAddress, RoomID, CheckInDate, CheckOutDate, CheckIn, CheckOut, Adults, Children FROM walk_in LEFT JOIN reservation ON walk_in.WalkInID=reservation.WalkInID");
      while ($row = $result->fetch_assoc()) {
        $checkInStatus  = $row['CheckIn'] == '' ? false : true;
        $checkOutStatus = $row['CheckOut'] == '' ? false : true;
        if (strtotime(date('Y-m-d')) == strtotime($row['CheckInDate']) && !($checkInStatus && $checkOutStatus)) {
          echo "<tr>";
          echo "<td>{$row['WalkInID']}</td>";
          echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
          echo "<td id='txtRoomID'>{$row['RoomID']}</td>";
          echo "<td id='txtCheckIn'>{$row['CheckIn']}</td>";
          echo "<td id='txtCheckOut'>{$row['CheckOut']}</td>";
          echo "<td id='txtAdults'>{$row['Adults']}</td>";
          echo "<td id='txtChildren'>{$row['Children']}</td>";
          echo "<td>";
          echo "<a title='Check In' class='btnCheckIn' id='{$row['WalkInID']}' style='cursor:pointer'";
          echo $checkInStatus ? ' disabled' : '';
          echo "><i class='fa fa-calendar-plus-o'></i></a>";
          echo "&nbsp;&nbsp;<a title='Check Out' class='btnCheckOut' id='{$row['WalkInID']}' style='cursor:pointer'";
          echo $checkOutStatus ? ' disabled' : '';
          echo "><i class='fa fa-calendar-minus-o'></i></a>";
          echo "</td>";
          echo "</tr>";
        }
      }
    } else if ($category == "book") {
      $result = $db->query("SELECT booking.BookingID, EmailAddress, RoomID, CheckInDate, CheckOutDate, CheckIn, CheckOut, Adults, Children FROM booking LEFT JOIN reservation ON booking.BookingID=reservation.BookingID");
      while ($row = $result->fetch_assoc()) {
        $checkInStatus  = $row['CheckIn'] == '' ? false : true;
        $checkOutStatus = $row['CheckOut'] == '' ? false : true;
        if (strtotime(date('Y-m-d')) == strtotime($row['CheckInDate']) && !($checkInStatus && $checkOutStatus)) {
          echo "<tr>";
          echo "<td>{$row['BookingID']}</td>";
          echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
          echo "<td id='txtRoomID'>{$row['RoomID']}</td>";
          echo "<td id='txtCheckIn'>{$row['CheckIn']}</td>";
          echo "<td id='txtCheckOut'>{$row['CheckOut']}</td>";
          echo "<td id='txtAdults'>{$row['Adults']}</td>";
          echo "<td id='txtChildren'>{$row['Children']}</td>";
          echo "<td>";
          echo "<a title='Check In' class='btnCheckIn' id='{$row['BookingID']}' style='cursor:pointer'";
          echo $checkInStatus ? ' disabled' : '';
          echo "><i class='fa fa-calendar-plus-o'></i></a>";
          echo "&nbsp;&nbsp;<a title='Check Out' class='btnCheckOut' id='{$row['BookingID']}' style='cursor:pointer'";
          echo $checkOutStatus ? ' disabled' : '';
          echo "><i class='fa fa-calendar-minus-o'></i></a>";
          echo "</td>";
          echo "</tr>";
        }
      }
    }
  }

  public function listOfReservation($category) {
    global $db;
    if ($category == "walk_in") {
      $result = $db->query("SELECT walk_in.WalkInID, EmailAddress, RoomID, CheckInDate, CheckOutDate, CheckIn, CheckOut, Adults, Children FROM walk_in LEFT JOIN reservation ON walk_in.WalkInID=reservation.WalkInID");
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['WalkInID']}</td>";
        echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
        echo "<td id='txtRoomID'>{$row['RoomID']}</td>";
        echo "<td id='txtCheckIn'>{$row['CheckIn']}</td>";
        echo "<td id='txtCheckOut'>{$row['CheckOut']}</td>";
        echo "<td id='txtAdults'>{$row['Adults']}</td>";
        echo "<td id='txtChildren'>{$row['Children']}</td>";
        echo "</tr>";
      }
    } else if ($category == "book") {
      $result = $db->query("SELECT booking.BookingID, EmailAddress, RoomID, CheckInDate, CheckOutDate, CheckIn, CheckOut, Adults, Children FROM booking LEFT JOIN reservation ON booking.BookingID=reservation.BookingID");
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['BookingID']}</td>";
        echo "<td id='txtEmail'>{$row['EmailAddress']}</td>";
        echo "<td id='txtRoomID'>{$row['RoomID']}</td>";
        echo "<td id='txtCheckIn'>{$row['CheckIn']}</td>";
        echo "<td id='txtCheckOut'>{$row['CheckOut']}</td>";
        echo "<td id='txtAdults'>{$row['Adults']}</td>";
        echo "<td id='txtChildren'>{$row['Children']}</td>";
        echo "</tr>";
      }
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
      echo "<td id='txtAccountType'>{$row['AccountType']}</td>";
      echo "<td>";
      if ($row['AccountType'] != "Owner" || $this->checkUserLevel(2)) {
        echo "<a class='btnEditAccount' title='Edit' id='{$row['EmailAddress']}' style='cursor:pointer' data-toggle='modal' data-target='#modalEditAccount'><i class='fa fa-pencil' aria-hidden='true'></i></a>";
        echo "&nbsp;&nbsp;";
      }
      if ($_SESSION['email'] != $row['EmailAddress'] && $this->checkUserLevel(2)) {
        echo "<a class='btnDeleteAccount' title='Delete' id='{$row['EmailAddress']}' style='cursor:pointer'><i class='fa fa-trash' aria-hidden='true'></i></a>";
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
      echo "<td>{$row['id']}</td>";
      echo "<td>{$row['user']}</td>";
      echo "<td>" . str_replace("|", " | ", $row['action']) . "</td>";
      echo "<td>{$row['timestamp']}</td>";
      echo "</tr>";
    }
  }

  public function listBookingID() {
    global $db;
    $email  = $db->real_escape_string($_SESSION['email']);
    $result = $db->query("SELECT * FROM booking WHERE EmailAddress = '$email'");
    while ($row = $result->fetch_assoc()) {
      $tomorrow = time() + 86400 * EDIT_RESERVATION_DAYS;
      if ($tomorrow < strtotime($row['CheckInDate'])) {
        echo "                ";
        echo "<option value='" . $row['BookingID'] . "'>" . $row['BookingID'] . "</option>\n";
      }
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
      $result = $db->query("SELECT RoomType, RoomDescription FROM room_type");
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . str_replace("_", " ", $row['RoomType']) . "</td>";
        echo "<td style='width:60%' id='txtRoomDescription'>{$row['RoomDescription']}</td>";
        echo "<td style='width:20%'><a class='btnEditRoom' style='cursor:pointer' data-toggle='modal' data-target='#modalEditRoom' id='{$row['RoomType']}'><i class='fa fa-pencil' aria-hidden='true'></i></a></td>";
        echo "</tr>";
      }
    }

  }

}

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class System {

  public function isLogged() {
    if (isset($_SESSION['email'])) {
      return true;
    } else {
      return false;
    }
  }

  public function checkUserLevel($reqLevel, $kick = false) {
    global $root;
    if ($this->isLogged()) {
      $currentLevel = 0;
      switch ($_SESSION['accountType']) {
      case "User":{
          $currentLevel = 0;
          break;
        }
      case "Admin":{
          $currentLevel = 1;
          break;
        }
      case "Owner":{
          $currentLevel = 2;
          break;
        }
      }
      if ($currentLevel < $reqLevel && !($currentLevel == 1 && ALLOW_OWNER_PRIVILEGES)) {
        if ($kick) {
          header("location: http://{$_SERVER['SERVER_NAME']}{$root}");
          exit();
        } else {
          return false;
        }
      } else {
        return true;
      }
    }
  }

  public function sendContactForm($name, $email, $message) {
    $subject = "Message from $email";
    $body    = "Name: $name<br/>Email: $email<br/>Message: $message";
    return $this->sendMail("Northwood Hotel Support", SUPPORT_EMAIL, $subject, $body);
  }

  public function sendMail($email, $subject, $body) {
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

  public function saveImage($image, $directory, $filename) {
    if (move_uploaded_file($image["tmp_name"], $directory . $filename)) {
      return true;
    } else {
      return UPLOAD_ERROR;
    }
  }

  public function createLog($action, $email = "") {
    global $db;
    $email = $email == "" && isset($_SESSION['email']) ? $_SESSION['email'] : $email;
    $date  = date("Y-m-d H:i:s");
    $db->query("INSERT INTO log VALUES(NULL, '$email', '$action', '$date')");
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
    if (strtotime($date) + $seconds < strtotime("now")) {
      return true;
    } else {
      return false;
    }
  }

  public function getBetween($var1 = "", $var2 = "", $pool) {
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

  public function nwh_encrypt($string) {
    return openssl_encrypt($string, "AES-128-ECB", ENCRYPT_KEYWORD);
  }

  public function nwh_decrypt($string) {
    return openssl_decrypt($string, "AES-128-ECB", ENCRYPT_KEYWORD);
  }

}

$account = new Account();
$room    = new Room();
$view    = new View();
$system  = new System();
?>