<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

$userInfo = json_decode($_SESSION['user_info'] , true);

db_config::$dbname = db_config::$sourcename .'_'. $_SESSION['select_version']['extends'];


switch($action){
	case 'list':
		
		$subject_id = $_GET['subject'];
		$section_id = $_GET['section'];
		
// 		$batch_data = factory::getModel('edu_source')->get_batchs($subject_id , $section_id);
// 		$exam_name = factory::getModel('exam_question_index')->get_exam_names($subject_id , $section_id);

		$result = factory::getModel('setin_exam')->get_exam_names($subject_id , $section_id );
		
//		print_r($batch_data);
//		echo '<br/>';
//		print_r($exam_name);
//		echo '<br/>';
		
		break;
}

echo $callback.'('.json_encode($result).')';