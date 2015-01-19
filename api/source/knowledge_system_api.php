<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

switch($action){
	case 'version_list':

		$subject_id = $_GET['subject'];
		$section_id = $_GET['section'];


// 		$result = factory::getModel('setin_exam')->get_exam_names($subject_id , $section_id);


		break;
		
	case 'tree_data':
		
		$subject_id = $_GET['subject'];
		$section_id = $_GET['section'];
		$version_id = $_GET['version'];
		
		$result = factory::getModel('edu_knowledge')->get_knowledges($subject_id , $section_id , $version_id);
		
		break;
		
	
}

echo $callback.'('.json_encode($result).')';