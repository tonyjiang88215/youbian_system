<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

$userInfo = json_decode($_SESSION['user_info'] , true);

switch($action){
	case 'curriculumn_list':
		$offset = $_GET['offset'];
		$step = $_GET['step'];
		
		$result = factory::getModel('edu_curriculumn_version')->get_curriculumn_versions_by_control_list($userInfo['id'] , $offset , $step);
		
		break;
		
	case 'list_by_bookid':
		
		$bookid = $_GET['book'];
		
		$result = factory::getModel('edu_curriculumn_version_detail')->get_curriculumn_by_bookid($bookid);
		
		break;
		
	case 'query_active':
		
		$version_id = $_GET['version'];
		
		$result = factory::getModel('edu_curriculumn_version_active')->get_actives($version_id);
		
		break;
	
	case 'add':
		
		$name = $_POST['name'];
		
		$version = $_POST['version'];
		$extend = $_POST['extend'];
		$ref = $_POST['ref'];
		
		$result = factory::getModel('edu_curriculumn_version')->post_new_curriculumn($name , $version , $extend , $ref , $userInfo['workset_id']);
		
		if($result['result'] !== false){
			
			
			
			factory::getModel('hx_workset_version')->add_workset_versions(1 , $result['lastid']);
		}
		
		break;
		
	case 'active':
		
		$version = $_POST['version'];
		$activeList = $_POST['active'];
		
		foreach($activeList as $k => $v){
			$activeList[$k]['version_id'] = $version;
		}
		
		$result = factory::getModel('edu_curriculumn_version_active')->post_active($version , $activeList);
		
		break;
		
	case 'active_knowledge':
		
		$version = $_POST['version'];
		
		$result = factory::getModel('edu_curriculumn_version')->post_active_knowledge($version);
		
		break;
		
	case 'active_zhuanti':
		
		$version = $_POST['version'];
		
		$result = factory::getModel('edu_curriculumn_version')->post_active_zhuanti($version);
		
		break;
		
	
		
	
}

echo $callback.'('.json_encode($result).')';