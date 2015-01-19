<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_REQUEST['action'];

$callback = $_GET['callback'];

switch($action){
	case 'list':
		$subject_id = $_GET['subject'];
		$offset = $_GET['offset'];
		$step = $_GET['step'];
		
		$result = factory::getModel('exam_question_index_0911')->get_question_for_subject($subject_id , $offset , $step);

		break;

	case 'duplicate':
		
		$subject_id = $_POST['subject'];
		$gid = $_POST['gid'];
		$gidArray = $_POST['gidArray'];
		
		$result = factory::getModel('exam_question_index_0911')->duplicate_questions($subject_id , $gid , $gidArray);
		
		if($result){
			factory::getModel('stat_source_duplicate')->add_record($subject_id , $gidArray);
		}
		
		break;
		
}

echo $callback.'('.json_encode($result).')';