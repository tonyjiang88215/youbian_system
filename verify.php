<?php
include_once dirname(__FILE__).'/global_inc.php';

$action = $_GET['action'];

if($action == 'login'){
	
	$tokenInfo = json_decode(base64_decode($_GET['AuthToken']),TRUE);
	
	$result = factory::getModel('user_verify')->tokenVerify($tokenInfo);
	
	if(isset($result['id'])){
		
		$level = factory::getModel('user_verify')->queryLevel($result['id']);
		
		if($level['level'] == 8){
			
			$_SESSION['login'] = true;
			$_SESSION['user_id'] = $result['id'];
			
			$check = true;
		}else{
			$check = false;
		}
	}else{
		$check = false;
	}
	
	if($check){
		header('Location:nsource/manage_nsource_setin.php?type=1');
	}else{
		echo <<<SCRIPT
		 <script type="text/javascript">
				alert("没有权限");
	// 			history.go(-1);
		</script>;
		 
SCRIPT;
		
	}
	
}else if($action == 'logout'){
	$_SESSION['login'] = false;
	$_SESSION['user_id'] = 0;
	header('Location:/hx_manages/Login.html');
}
