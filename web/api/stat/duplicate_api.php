<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

switch($action){
	case 'list':
		
		$subject_id = $_GET['subject'];
		
// 		$batch_data = factory::getModel('edu_source')->get_batchs($subject_id , $section_id);
// 		$exam_name = factory::getModel('exam_question_index')->get_exam_names($subject_id , $section_id);

		$result = factory::getModel('stat_source_duplicate')->get_duplicate_list($subject_id);
		
//		print_r($batch_data);
//		echo '<br/>';
//		print_r($exam_name);
//		echo '<br/>';
		
		break;
}

echo $callback.'('.json_encode($result).')';