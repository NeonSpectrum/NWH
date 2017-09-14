<?php
    $msg="";
    if($logged){
        $msg = "Login Successfully!";
    }
    else
    {
        $msg = "Invalid Username or Password!";
    }
    echo '<script>alert($msg);</script>';
?>