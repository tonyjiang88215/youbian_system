<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

switch($action){

	case 'list'://查询试卷

		// 		$exam_name = $_GET['exam_name'];
		// 		$source = $_GET['source'];
		$type = $_GET['type'];
		$subject_id = $_GET['subject'];
		$section_id = $_GET['section'];

		$setin_id = $_GET['setin_id'];
		$element_id = $_GET['element_id'];

		$offset = $_GET['offset'];
		$step = $_GET['step'];
		
		$result = factory::getModel('stat_source_handler')->get_list_count_by_type($subject_id , $section_id ,$type , $offset , $step);
		
}

echo $callback.'('.json_encode($result).')';