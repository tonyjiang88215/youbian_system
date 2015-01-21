<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

switch($action){
	case 'publisher':
		
		$subject_id = $_GET['subject'];
		$grade_id = $_GET['grade'];
		
		$result = factory::getModel('edu_book')->get_publisher($subject_id , $grade_id);
		
		break;
		
		
	case 'book':
		
		$subject_id = $_GET['subject'];
		$grade_id = $_GET['grade'];
		$publisher_id = $_GET['publisher'];
		
		$result = factory::getModel('edu_book')->get_books($subject_id , $grade_id , $publisher_id);
		
		
		break;
		
}

echo $callback.'('.json_encode($result).')';