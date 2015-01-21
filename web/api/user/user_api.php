<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

$userInfo = json_decode($_SESSION['user_info'] , true);

switch($action){
	
	case 'login':
		
		$account = $_POST['account'];
		$passwd = $_POST['passwd'];
		
		$result = factory::getModel('hx_user')->login($account , $passwd);
		
		if($result){
			$_SESSION['user_info'] = json_encode($result[0]);
			$_SESSION['login'] = true;
			
		}
		
		break;
		
	case 'change_version':
		
		$version_id = $_POST['version'];
		
		foreach($userInfo['version_info'] as $k => $v){
			if($v['id'] == $version_id){
				$_SESSION['select_version'] = $userInfo['version_info'][$k];
			}
		}
		
		$result = true;
		
		break;
	
	case 'list':
		
// 		$batch_data = factory::getModel('edu_source')->get_batchs($subject_id , $section_id);
// 		$exam_name = factory::getModel('exam_question_index')->get_exam_names($subject_id , $section_id);

		$offset = $_GET['offset'];
		$step = $_GET['step'];
		$workset_id = $_GET['workset'];
		$role_id = $_GET['role'];
		
// 		$result = factory::getModel('hx_user')->get_users($offset , $step );
		$result = factory::getModel('hx_user')->get_users_by_control($userInfo['id'] , $role_id , $workset_id , $offset , $step );
		
//		print_r($batch_data);
//		echo '<br/>';
//		print_r($exam_name);
//		echo '<br/>';
		
		break;
		
	case 'add_user':
		$username = $_POST['username'];
		$realname = $_POST['realname'];
		$passwd = $_POST['passwd'];
		$role_id = $_POST['role'];
		$workset_id = $_POST['workset'];
		
		$result = factory::getModel('hx_user')->add_user($username , $realname , $passwd , $role_id , $workset_id , $userInfo['id']);
		
		break;
}

echo $callback.'('.json_encode($result).')';