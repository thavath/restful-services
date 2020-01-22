<?php
    // show error reporting
    error_reporting(E_ALL);
    
    // set your default time-zone
    date_default_timezone_set('Asia/Phnom_Penh'); 
    // variables used for jwt
    $key = "phprestfullservices";
    $iss = "http://php.thavath.com:8080/";
    $aud = "http://php.thavath.com:8080/";
    $iat = 1356999524;
    $nbf = 1357000000;
?>