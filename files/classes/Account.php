<?php

/**
 * Account Class
 */
class Account extends System {

  /**
   * @param String $email
   */
  public function getInfo($email) {
    global $db;

    $row = $db->query("SELECT * FROM account WHERE EmailAddress='{$email}'")->fetch_assoc();

    return $row;
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

  public function isLogged() {
    return isset($_SESSION['account']);
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
}

?>