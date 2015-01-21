<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

$userInfo = json_decode($_SESSION['user_info'] , true);

switch($action){
	case 'list':
		
// 		$batch_data = factory::getModel('edu_source')->get_batchs($subject_id , $section_id);
// 		$exam_name = factory::getModel('exam_question_index')->get_exam_names($subject_id , $section_id);

		$offset = $_GET['offset'];
		$step = $_GET['step'];
		
// 		$result = factory::getModel('hx_user_group')->get_groups();
		$result = factory::getModel('hx_user_role')->get_roles($offset , $step);
		
//		print_r($batch_data);
//		echo '<br/>';
//		print_r($exam_name);
//		echo '<br/>';
		
		break;
		
	case 'add_role':
		$group_name = $_POST['role_name'];
		
		$result = factory::getModel('hx_user_role')->add_role($group_name);
		
		break;
		
	case 'privilege_data':
		
		$role_id = $_POST['role'];
		
		$result = array();
		
// 		$result['tree'] = factory::getModel('hx_module')->get_modules();
		//如果group_id=0 说明是顶级用户组，查询所有选项
// 		if($userInfo['group_id'] == 1){
		$result['tree'] = factory::getModel('hx_user_role_privilege')->get_privileges($role_id);
// 		}else{
// 				$result['tree'] = factory::getModel('hx_user_group_privilege')->get_privileges_by_control($group_id , $userInfo['id']);
// 		}
		
		break;
		
	case 'create_privilege_data':
		
		$role_id = $_POST['role'];
		
		$result = factory::getModel('hx_user_role_create_privilege')->get_privileges($role_id);
		
		break;
		
	case 'update_role_privilege':
		
		$role_id = $_POST['role'];
		$modules = $_POST['module'];
		
		$result = factory::getModel('hx_user_role_privilege')->update_privileges($role_id, $modules);
		
		break;
		
	case 'update_role_create_privilege':
		
		$role_id = $_POST['role'];
		$roleArray = $_POST['roleArray'];
		
		$result = factory::getModel('hx_user_role_create_privilege')->update_privileges($role_id, $roleArray);
		
		break;
}

echo $callback.'('.json_encode($result).')';