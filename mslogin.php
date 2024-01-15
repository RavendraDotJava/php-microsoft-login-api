<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require "vendor/autoload.php";

use myPHPnotes\Microsoft\Auth;

$tenant = "common";
$client_id = "1e6d4bd0-520a-4e7c-ae1d-5f40f8abd0e6";
$client_secret = "CJA8Q~0NQaSlVLu6bUBZR8vxdjd7kxyuRt5p3aG-";
$callback = "https://resolvegroup.in/projects/rust-consolecommunity/callback.php";
$scopes = [
    'User.Read'
];


$microsoft = new Auth($tenant, $client_id,  $client_secret, $callback, $scopes);
header("location: ". $microsoft->getAuthUrl());