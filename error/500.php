<?php require_once '../files/autoload.php'?>
<!DOCTYPE html>
<html>
<head>
  <title>Error 500</title>
  <link href='https://fonts.googleapis.com/css?family=Anton|Passion+One|PT+Sans+Caption' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="assets/css/required/1_bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/error.css">
</head>
<body>
  <div class="error">
      <div class="container-floud">
          <div class="col-xs-12 ground-color text-center">
              <div class="container-error-404">
                  <div class="clip"><div class="shadow"><span class="digit thirdDigit">5</span></div></div>
                  <div class="clip"><div class="shadow"><span class="digit secondDigit">0</span></div></div>
                  <div class="clip"><div class="shadow"><span class="digit firstDigit">0</span></div></div>
                  <div class="msg">OH!<span class="triangle"></span></div>
              </div>
              <h2 class="h1">Internal Server Error<br>Please contact the administrator</h2>
              <h2><a href="<?php echo $root ?>" style="color:#102c58">< Go back</a></h2>
          </div>
      </div>
  </div>
</body>
</html>