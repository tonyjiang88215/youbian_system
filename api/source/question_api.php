<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

$userInfo = json_decode($_SESSION['user_info'] , true);

db_config::$dbname = db_config::$sourcename .'_'. $_SESSION['select_version']['extends'];


switch($action){
	
	case 'list'://查询试卷
// 		$exam_name = $_GET['exam_name'];
// 		$source = $_GET['source'];
		$type = $_GET['type'];
		$subject_id = $_GET['subject'];
		
		$setin_id = $_GET['setin_id'];
		$element_id = $_GET['element_id'];
		
		$offset = $_GET['offset'];
		$step = $_GET['step'];
		
		switch($type){
			case 1:	//试卷过滤方法
				if($element_id){
					$result = factory::getModel('exam_question_index')->get_question_by_exam_id($element_id , $offset , $step);
				}else{
					$result = factory::getModel('exam_question_index')->get_question_for_exam($setin_id , $offset , $step);
				}
				
				break;
				
			case 2://章节过滤方法
				if($element_id){
					$result = factory::getModel('exam_question_index')->get_question_by_chapter_id($userInfo['id'] ,  $subject_id , $element_id , $offset , $step);
				}else{
					$result = factory::getModel('exam_question_index')->get_question_for_chapter($subject_id , $setin_id , $offset , $step);
				}
				
				break;
				
			case 3://专题过滤方法
				
				if($element_id){
					$result = factory::getModel('exam_question_index')->get_question_by_zhuanti_id($subject_id , $element_id , $offset , $step);
				}else{
					$result = factory::getModel('exam_question_index')->get_question_for_zhuanti($subject_id , $setin_id , $offset , $step);
						
				}
				
				break;
				
			case 4://根据知识点查
				
				$result = factory::getModel('exam_question_index')->get_question_by_knowledge_id($subject_id , $element_id , $offset , $step);
		}
		
		
		
		
		break;
		
	case 'modify';//修改题目信息
	
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$question = $_POST['question'];
		
// 		print_r($question);
// 		exit;
		
		$result = factory::getModel('exam_question_index')->post_modify_question($question);
		
		$gidArray = array();
		foreach($question as $q){
			$gidArray[] = $q['gid'];
		}
		
		$result2 = factory::getModel('stat_source_handler')->add_record($subject_id , $section_id ,  $gidArray , '2' , 11);
	
		break;
		

	case 'remove'://删除题目
	
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$question_id = $_POST['question_id'];
		$type = $_POST['type'];
		
		$result = factory::getModel('exam_question_index')->post_remove_question($question_id , $type);
		
		$gidArray = array($question_id);
		
		$result2 = factory::getModel('stat_source_handler')->add_record($subject_id , $section_id ,  $gidArray , '2' , 2);
	
		break;
		
		
	case 'setin_exam'://题目入库试卷
		
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$insertArray = $_POST['inserts'];
		$element_id = $_POST['element'];
		
		$result = factory::getModel('exam_examination_to_question')->insert_relations($insertArray , $element_id);
		
		$gidArray = array();
		foreach($insertArray as $q){
			$gidArray[] = $q['gid'];
		}
		
		$result2 = factory::getModel('stat_source_handler')->add_record($subject_id , $section_id ,  $gidArray , '2' , 10);
		
		break;
		
	case 'setout_exam'://题目出库试卷
		
		$removeArray = $_POST['removes'];
		$element_id = $_POST['element'];
		
		$result = factory::getModel('exam_examination_to_question')->remove_relations($removeArray , $element_id);
		
		break;
		
		
	case 'setin_chapter'://题目入库章节
	
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$insertArray = $_POST['inserts'];
		$element_id = $_POST['element'];
	
		$result = factory::getModel('edu_chapter_to_question')->insert_relations($subject_id , $insertArray , $element_id);
		
		$gidArray = array();
		foreach($insertArray as $q){
			$gidArray[] = $q;
		}
		
		$result2 = factory::getModel('stat_source_handler')->add_record($subject_id , $section_id ,  $gidArray , '2' , 10);
	
		break;
	
	case 'setout_chapter'://试卷出库
	
		$subject_id = $_POST['subject'];
		$removeArray = $_POST['removes'];
		$element_id = $_POST['element'];
	
		$result = factory::getModel('edu_chapter_to_question')->remove_relations($subject_id , $removeArray , $element_id);
	
		break;
		
	case 'setin_knowledge':
		
		$subject_id = $_POST['subject'];
		$insertArray = $_POST['inserts'];
		$element_id = $_POST['element'];
		
		$result = factory::getModel('edu_knowledge_to_question')->insert_relations($subject_id , $insertArray , $element_id);
		
		$gidArray = array();
		foreach($insertArray as $q){
			$gidArray[] = $q['gid'];
		}
		
		$result2 = factory::getModel('stat_source_handler')->add_record($subject_id , $section_id ,  $gidArray , '2' , 10);
		
		
		break;
		
	case 'setout_knowledge':
		
		$subject_id = $_POST['subject'];
		$removeArray = $_POST['removes'];
		$element_id = $_POST['element'];
		
		$result = factory::getModel('edu_knowledge_to_question')->remove_relations($subject_id , $removeArray , $element_id);
		
		
	case 'setin_zhuanti':
		
			$subject_id = $_POST['subject'];
			$insertArray = $_POST['inserts'];
			$element_id = $_POST['element'];
		
			$result = factory::getModel('edu_zhuanti_to_question')->insert_relations($subject_id , $insertArray , $element_id);
		
			$gidArray = array();
			foreach($insertArray as $q){
				$gidArray[] = $q['gid'];
			}
			
			$result2 = factory::getModel('stat_source_handler')->add_record($subject_id , $section_id ,  $gidArray , '2' , 10);
				
		
			break;
		
	case 'setout_zhuanti':
			
			$subject_id = $_POST['subject'];
			$removeArray = $_POST['removes'];
			$element_id = $_POST['element'];
		
			$result = factory::getModel('edu_zhuanti_to_question')->remove_relations($subject_id , $removeArray , $element_id);
		
		
		break;
		
	case 'insert_word_data':
// 		ini_set('display_errors' , 'On');
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$version_id = $_POST['version'];
		$content = $_POST['content'];
		
		$result = factory::getModel('setin_exam')->post_insert_word($subject_id , $section_id , $version_id , $content);
		
		break;
		
}

echo $callback.'('.json_encode($result).')';


