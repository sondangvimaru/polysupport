<?php

//start session on web page
session_start();

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';
$protocol="http://";
if (isset($_SERVER['HTTPS']) &&
($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
$_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    $protocol= 'https://';
}
else {
    $protocol= 'http://';}
    $url=($protocol=='http://')?$protocol.$_SERVER['HTTP_HOST']."/osticket/login.php": $protocol.$_SERVER['HTTPS_HOST']."/osticket/login.php";
 
$gClient=new Google_Client();
$gClient->setClientId(Google_Client_ID);
$gClient->setClientSecret(Google_Client_SECRET);
$gClient->setRedirectUri($url);

$gClient->addScope('email');

$gClient->addScope('profile');

?>