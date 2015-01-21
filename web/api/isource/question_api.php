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
// 				if($element_id){
					
// 					$result = factory::getModel('exam_question_index')->get_question_by_exam_id($element_id , $offset , $step);
					
// 				}else{
// 					$result = factory::getModel('exam_question_index')->get_question_for_exam($setin_id , $offset , $step);
// 				}
				
				break;
				
			case 2://章节过滤方法
				
				if($element_id){
// 					ini_set('display_errors' ,'On');
// 					$result = factory::getModel('exam_question_index_0911')->get_question_by_chapter_id_instore($version_id , $subject_id , $element_id , null , null ,  $offset , $step);

					$question_id = factory::getModel('edu_chapter_to_question')->get_questions_by_chapter($subject_id , $element_id , $offset , $step);
					if(count($question_id['data']) == 0){
						$result = array('data'=>array() , 'count'=>0);
					}else{
						$idArray = array();
						$idConfirmArray = array();
						foreach($question_id['data'] as $q){
							$idArray[] =$q['question_id'];
							$idConfirmArray[] = $q['question_id'];
						}
						
						//先查询已经修改过的题目
						$data_modify = factory::getModel('exam_question_index')->get_question_by_id($subject_id , $idArray);
						
						foreach( $data_modify['data'] as $question ){
							foreach($idArray as $k => $v){
								if($v == $question['gid']){
									unset( $idArray[$k]);
								}
							}
						}
						
						
						if(count($idArray) > 0){
							$data_origin = factory::getModel('exam_question_index_0911')->get_question_by_id($subject_id , $idArray);
							$data = array_merge($data_modify['data'] , $data_origin['data']);
							$dataChildren = array_merge($data_modify['children'] , $data_origin['children']);
						}else{
							$data = $data_modify['data'];
							$dataChildren = $data_modify['children'];
						}
						$dataOrder = array();
						
						foreach($idConfirmArray as $gid){
							for($i = 0 ; $i < count($data) ; $i ++){
								if($gid == $data[$i]['gid']){
									$dataOrder[] = $data[$i];
									break;
								}
							}
						}
						
					
						$result = array(
								'data'=>$dataOrder,
								'children'=>$dataChildren,
								'count'=>$question_id['count']
						);
					}
					
				}else{
					
					$result = factory::getModel('exam_question_index')->get_question_for_chapter($subject_id , $setin_id , $offset , $step);
				}
				
				break;
				
			case 3://专题过滤方法
				
// 				if($element_id){
// 					$result = factory::getModel('exam_question_index')->get_question_by_zhuanti_id($subject_id , $element_id , $offset , $step);
// 				}else{
// 					$result = factory::getModel('exam_question_index')->get_question_for_zhuanti($subject_id , $setin_id , $offset , $step);
						
// 				}
				
				break;
				
			case 4://根据知识点查
				
// 				$result = factory::getModel('exam_question_index')->get_question_by_knowledge_id($subject_id , $element_id , $offset , $step);
		}
		
		
		
		
		break;
		
	case 'modify';//修改题目信息
	
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$question = $_POST['question'];
		
		$result = factory::getModel('exam_question_index')->post_modify_question($question);
		
		$gidArray = array();
		foreach($question as $q){
			$gidArray[] = $q['gid'];
		}
		
		$result2 = factory::getModel('stat_source_handler')->add_record($subject_id , $section_id ,  $gidArray , '2' , 14);
	
		break;
		

	case 'remove'://删除题目
	
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$question_id = $_POST['question_id'];
	
		$gidArray = array($question_id);
		
		$result2 = factory::getModel('stat_source_handler')->add_record($subject_id , $section_id , $gidArray , '3' , 14);
		
		$result1 = factory::getModel('exam_question_index')->post_remove_question($question_id);
		
		$result = $result1 || $result2;
	
		break;
		
	case 'query_handler':
		
		$question_ids = $_GET['question'];
		
		$result = factory::getModel('stat_source_handler')->get_list_by_question($question_ids);
		
		
		break;
		
	case 'query_by_id':
		
		$subject_id = $_GET['subject'];
		$question_id = $_GET['question'];
		
		$question_id = str_replace('，', ',', $question_id);
		$question_id = explode(',' , $question_id);
		
		$result = factory::getModel('exam_question_index_0911')->get_question_by_id($subject_id ,  $question_id);
		
		break;
		
		
	case 'setin_exam'://题目入库试卷
		
		$insertArray = $_POST['inserts'];
		$element_id = $_POST['element'];
		
		$result = factory::getModel('exam_examination_to_question')->insert_relations($insertArray , $element_id , 12);
		
		break;
		
	case 'setout_exam'://题目出库试卷
		
		$removeArray = $_POST['removes'];
		$element_id = $_POST['element'];
		
		$result = factory::getModel('exam_examination_to_question')->remove_relations($removeArray , $element_id , 13);
		
		break;
		
		
	case 'setin_chapter'://题目入库章节
	
		$subject_id = $_POST['subject'];
		$insertArray = $_POST['inserts'];
		$element_id = $_POST['element'];
	
		$result = factory::getModel('edu_chapter_to_question')->insert_relations($subject_id , $insertArray , $element_id , 12);
	
		break;
	
	case 'setout_chapter'://章节出库
	
		$subject_id = $_POST['subject'];
		$removeArray = $_POST['removes'];
		$element_id = $_POST['element'];
	
		$result = factory::getModel('edu_chapter_to_question')->remove_relations($subject_id , $removeArray , $element_id , 13);
	
		break;
		
	case 'setin_knowledge':
		
		$subject_id = $_POST['subject'];
		$insertArray = $_POST['inserts'];
		$element_id = $_POST['element'];
		
		$result = factory::getModel('edu_knowledge_to_question')->insert_relations($subject_id , $insertArray , $element_id , 12);
		
		
		break;
		
	case 'setout_knowledge':
		
		$subject_id = $_POST['subject'];
		$removeArray = $_POST['removes'];
		$element_id = $_POST['element'];
		
		$result = factory::getModel('edu_knowledge_to_question')->remove_relations($subject_id , $removeArray , $element_id , 13);
		
		
	case 'setin_zhuanti':
		
			$subject_id = $_POST['subject'];
			$insertArray = $_POST['inserts'];
			$element_id = $_POST['element'];
		
			$result = factory::getModel('edu_zhuanti_to_question')->insert_relations($subject_id , $insertArray , $element_id , 12);
		
		
			break;
		
	case 'setout_zhuanti':
		
			$subject_id = $_POST['subject'];
			$removeArray = $_POST['removes'];
			$element_id = $_POST['element'];
		
			$result = factory::getModel('edu_zhuanti_to_question')->remove_relations($subject_id , $removeArray , $element_id , 13);
		
		
		break;
		
}

echo $callback.'('.json_encode($result).')';


