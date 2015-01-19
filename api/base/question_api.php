<?php

include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

$version_id = $_REQUEST['version'];

$userInfo = json_decode($_SESSION['user_info'] , true);

db_config::$dbname = db_config::$sourcename .'_'. $_SESSION['select_version']['extends'];

switch($action){
	
	case 'list'://查询试卷
		//右侧条件,查询条件
		$type = $_GET['type'];
		$subject_id = $_GET['subject'];
		$version_id = $_GET['version'];
		$element_id = $_GET['element_id'];
		
		
		//左侧条件，过滤条件
		$filter_subject_id = $_GET['filter_subject'];
		$filter_version_id = $_SESSION['select_version']['id'];
		$filter_id = $_GET['filter_id'];
		
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
// 				ini_set('display_errors' , 'On');

				if($filter_id){ 
					$qid = factory::getModel('exam_question_index')->get_question_id_by_chapter_id_instore($filter_subject_id , $filter_id);
				}else{
					$qid = array();
				}
				
				foreach($CFG['data']['curriculumn'] as $curriculumn){
					if($curriculumn['id'] == $version_id){
						db_config::$dbname  = db_config::$sourcename .'_'. $curriculumn['extends'];
						break;
					}
				}

				$result = factory::getModel('exam_question_index_0911')->get_question_by_chapter_not_in_id($subject_id , $qid , $element_id , $offset , $step);
// 				}else{
// 					$result = factory::getModel('exam_question_index_0911')->get_question_for_chapter($subject_id , $setin_id , $offset , $step);
// 				}
				
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
	
		$question = $_POST['question'];
		
//		print_r($question);
//		exit;
		
		$result = factory::getModel('exam_question_index')->post_modify_question($question);
	
		break;
		

	case 'remove'://删除题目
	
		$question_id = $_POST['question_id'];
	
		$result = factory::getModel('exam_question_index')->post_remove_question($question_id);
	
		break;
		
		
	case 'setin_exam'://题目入库试卷
		
		$insertArray = $_POST['inserts'];
		$element_id = $_POST['element'];
		
		$result = factory::getModel('exam_examination_to_question')->insert_relations($insertArray , $element_id);
		
		break;
		
	case 'setout_exam'://题目出库试卷
		
		$removeArray = $_POST['removes'];
		$element_id = $_POST['element'];
		
		$result = factory::getModel('exam_examination_to_question')->remove_relations($removeArray , $element_id);
		
		break;
		
		
	case 'setin_chapter'://题目入库章节
	
		$subject_id = $_POST['subject'];
		$insertArray = $_POST['inserts'];
		$element_id = $_POST['element'];
	
		$result = factory::getModel('edu_chapter_to_question')->insert_relations_version($subject_id , $insertArray , $element_id);
	
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
		
		
			break;
		
	case 'setout_zhuanti':
		
			$subject_id = $_POST['subject'];
			$removeArray = $_POST['removes'];
			$element_id = $_POST['element'];
		
			$result = factory::getModel('edu_zhuanti_to_question')->remove_relations($subject_id , $removeArray , $element_id);
		
		
		break;
		
}

echo $callback.'('.json_encode($result).')';


