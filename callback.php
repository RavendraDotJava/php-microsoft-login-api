<?php
include("./config.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$tenant = "common";
$client_id = "1e6d4bd0-520a-4e7c-ae1d-5f40f8abd0e6";
$client_secret = "CJA8Q~0NQaSlVLu6bUBZR8vxdjd7kxyuRt5p3aG-";//client secret value 
$callback = "https://resolvegroup.in/projects/rust-consolecommunity/callback.php";
$scopes = [
    'User.Read'
];

use myPHPnotes\Microsoft\Auth;
use myPHPnotes\Microsoft\Handlers\Session;
use myPHPnotes\Microsoft\Models\User;

//echo $_GET['code'];
//exit;
require "vendor/autoload.php";
// ON CALLBACK
$microsoft = new Auth(Session::get("tenant_id"),Session::get("client_id"),  Session::get("client_secret"), Session::get("redirect_uri"), Session::get("scopes"));
$tokens = $microsoft->getToken($_REQUEST['code'], Session::get("state"));

// Setting access token to the wrapper
$microsoft->setAccessToken($tokens->access_token);
$user = (new User); // User get pulled only if access token was generated for scope User.Read


//print_r($user->data);

//Checking if the user with email already registered.
$checkmail=$db->getRow("select * from registers where emailid='{$user->data->getMail()}' ");
//echo json_encode($db->getLastQuery());exit;
             if(isset($checkmail['emailid']) && $checkmail['emailid']!=''){	
			 $userid=$checkmail['id'];
			 $_SESSION['userid']=$userid;
			header("location: my-dashboard.php");exit;
			}else{
//If User not registered then send data to database and redirect to dashboard page.			 

         $arydata=array(
           'token'=> token("registers"),
           'fullname'=> $user->data->getDisplayName(),
           'emailid'=>  $user->data->getMail(),
           'password'=> $user->data->getDisplayName(),
           'playertype'=>3,
           'status'=>1,
           'create_at'=>date("Y-m-d"), 
        );
		$flgIn1=$db->insertAry("registers",$arydata);
		$userid=$flgIn1;
         //echo json_encode($db->getLastQuery());exit;
					
	    $db->update("update registers set username='user{$userid}' where id='{$userid}' ");
        //echo $db->getLastQuery();echo '<br>';
		$arydata1=array(
           'userid'=> $userid,
           'regtype'=> 3,
           'aproovemsg'=>  0,
           'xbox'=> $user->data->getId(),
           'create_at'=>date("Y-m-d"),
        );
		$flg1=$db->insertAry("registers_detail",$arydata1);
        //echo $db->getLastQuery();exit;	
		$_SESSION['userid']=$userid;
        //echo json_encode($db->getLastQuery());exit;
		header("location: my-dashboard.php");
        exit();
		}

  
?>