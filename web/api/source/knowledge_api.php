<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

switch($action){
	
	case 'tree_data':
	
		$subject_id = $_GET['subject'];
		$section_id = $_GET['section'];
		$version_id = $_GET['version'];
		
		$result = factory::getModel('edu_knowledge')->get_knowledges($version_id , $subject_id , $section_id);
	
		break;
	
	case 'insert':
		
		$newData = $_POST['new_data'];
		$version_id = $_POST['version'];
		
		$result = factory::getModel('edu_knowledge')->insert_knowledge($version_id , $newData);
		
		break;
		
	case 'modify':
		
		$knowledge = $_POST['knowledge'];
		$subject_id = $_POST['subject'];
		$version_id = $_POST['version'];
		
		$result = factory::getModel('edu_knowledge')->modify_knowledge($version_id , $subject_id , $knowledge);
		
		break;
		
	case 'drag':
		
		$version_id = $_POST['version'];
		$knowledge = $_POST['knowledge'];
		$subject_id = $_POST['subject'];
		$childs = $_POST['childs'];
		$levelDiff = $_POST['levelDiff'];
		
		$result = factory::getModel('edu_knowledge')->drag_knowledge($version_id , $subject_id , $knowledge , $levelDiff , $childs);
		
		break;
		
	case 'delete':
		
		$knowledge_id = $_POST['knowledge_id'];
		$subject_id = $_POST['subject'];
		$version_id = $_POST['version'];
		
		$result = factory::getModel('edu_knowledge')->delete_knowledge($version_id , $subject_id , $knowledge_id);
		
		
		break;
		
	case 'move_up':
		
		$version_id = $_POST['version'];
		$id = $_POST['knowledge_id'];
		$id2 = $_POST['target_id'];
		$subject_id = $_POST['subject'];
		
		$result = factory::getModel('edu_knowledge')->move_up_knowledge($version_id , $subject_id , $id , $id2);
		
		break;
		
	case 'move_down':
		
		$version_id = $_POST['version'];
		$id = $_POST['knowledge_id'];
		$id2 =$_POST['target_id'];
		$subject_id = $_POST['subject'];
		
		$result = factory::getModel('edu_knowledge')->move_down_knowledge($version_id , $subject_id , $id , $id2);
		
		break;
		
}


echo $callback.'('.json_encode($result).')';