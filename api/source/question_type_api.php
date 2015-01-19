<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

switch($action){
	case 'list':
		
		$subject_id = $_GET['subject'];
		$section_id = $_GET['section'];
		
		$result = factory::getModel('edu_question_type')->get_question_types($subject_id , $section_id);
		
		break;
}
echo $callback.'('.json_encode($result).')';