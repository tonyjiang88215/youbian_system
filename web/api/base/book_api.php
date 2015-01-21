<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

switch($action){
		
		
	case 'book':
		
		$subject_id = $_GET['subject'];
		$section_id = $_GET['section'];
		$publisher_id = $_GET['publisher'];
		
		$result = factory::getModel('edu_book')->get_books_with_ssp($subject_id , $section_id , $publisher_id);
		
		
		break;
		
	case 'insert_book':
		
		$name = $_POST['name'];
		$subject = $_POST['subject'];
		$section = $_POST['section'];
		$grade = $_POST['grade'];
		$publisher = $_POST['publisher'];
		
		$result = factory::getModel('edu_book')->insert_book($subject , $section , $grade , $publisher , $name);
		break;
		
	case 'modify_book':
		
		$bookInfo = array();
		$bookInfo['id'] = $_POST['id'];
		$bookInfo['book_name'] = $_POST['name'];
		$bookInfo['subject_id'] = $_POST['subject'];
	
		$result = factory::getModel('edu_book')->modify_book($bookInfo);
	
		break;
		
	case 'delete_book':
		
		$book_id = $_POST['book'];
		$subject_id = intval($_POST['subject']);
		
		$result = factory::getModel('edu_book')->delete_book($book_id , $subject_id);
		
		break;
		
}

echo $callback.'('.json_encode($result).')';