<?php
// require adnanhussainturki/microsoft-api-php this library using composer before using
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require "vendor/autoload.php";

use myPHPnotes\Microsoft\Auth;

$tenant = "common";
$client_id = "Client Id";
$client_secret = "Client secret";
$callback = "Your Callback Url";
$scopes = [
    'User.Read'
];


$microsoft = new Auth($tenant, $client_id,  $client_secret, $callback, $scopes);
header("location: ". $microsoft->getAuthUrl());
