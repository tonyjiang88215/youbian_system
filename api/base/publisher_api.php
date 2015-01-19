<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

switch($action){
	
	case 'publisher_list':
		
		$result = factory::getModel('edu_publisher')->get_publishers();
		break;
	
	case 'book_list':
		
		$subject = $_GET['subject'];
		$section = $_GET['section'];
		$publisher = $_GET['publisher'];
		$result = factory::getModel('edu_book')->get_books_with_ssp2($subject , $section , $publisher);
		
		break;
		
	case 'add_publisher':
		
		$publisher_name = $_POST['publisher_name'];
		
		$result = factory::getModel('edu_publisher')->add_publisher($publisher_name);
		
		break;
		
	case 'modify_publisher':
		
		$publisher_id = $_POST['publisher_id'];
		$publisher_name = $_POST['publisher_name'];
		
		$result = factory::getModel('edu_publisher')->modify_publisher($publisher_id , $publisher_name);
		
		
		
		break;
		
	case 'delete_publisher':
		
		$publisher_id = $_POST['publisher'];
		
		$result = factory::getModel('edu_publisher')->remove_publisher($publisher_id);
		
		break;
}

echo $callback.'('.json_encode($result).')';
	
	
