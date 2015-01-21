<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

$userInfo = json_decode($_SESSION['user_info'] , true);

switch($action){
	case 'list':
		
// 		$batch_data = factory::getModel('edu_source')->get_batchs($subject_id , $section_id);
// 		$exam_name = factory::getModel('exam_question_index')->get_exam_names($subject_id , $section_id);

// 		$offset = $_GET['offset'];
// 		$step = $_GET['step'];
		
// 		$result = factory::getModel('hx_workset')->get_worksets();
		$result = factory::getModel('hx_workset')->get_worksets_by_control($userInfo['id']);
//		print_r($batch_data);
//		echo '<br/>';
//		print_r($exam_name);
//		echo '<br/>';
		
		break;
		
		
	case 'source':
		
		//先查询当前工作组的父工作组的ID，来确定资源范围
		
		$workset_id = intval($_GET['workset']);
		$parent_id = intval($_GET['parent']);
		
		$result = array();
		
		//如果parent_id=0 说明是顶级工作组，查询所有选项
		if($parent_id == 0){
			
			$result['data'] = factory::getModel('edu_subject')->get_subjects_with_section();
			
		}else{
			
			$result['data'] = factory::getModel('hx_workset_source')->get_workset_sources($parent_id);
			
		}
		
		$result['select'] = factory::getModel('hx_workset_source')->get_workset_sources($workset_id);
		
	
		break;
		
	case 'version':
		
		$workset_id = intval($_GET['workset']);
		$result = factory::getModel('hx_workset_version')->get_workset_versions($workset_id);
		break;
		
		
	
		
	case 'add_workspace':
		$work_name = $_POST['work_name'];
		
// 		$result = factory::getModel('hx_workset')->add_workset($work_name , 1 , 0);
		$result = factory::getModel('hx_workset')->add_workset_by_control($work_name , $userInfo['id']);
		
		break;
		
	case 'update_workspace_source':
		
		$workset_id = $_POST['workset'];
		$sourceArray = $_POST['source'];
		
		$result = factory::getModel('hx_workset_source')->update_workset_sources($workset_id , $sourceArray);
		
		break;
		
		
	case 'update_workspace_version':
		
		$workset_id = $_POST['workset'];
		$versionArray = $_POST['version'];
		
		$result = factory::getModel('hx_workset_version')->update_workset_versions($workset_id , $versionArray);
		
		
		break;
}

echo $callback.'('.json_encode($result).')';