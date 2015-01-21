<?php
include_once dirname(dirname(dirname(dirname(__FILE__)))).'/struct/global_inc.php';

if($_SESSION['login'] !== true){
	header('Location: /manage_system/login.php');
	exit;
}

$userInfo = json_decode($_SESSION['user_info'] , true);