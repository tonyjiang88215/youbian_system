<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

$userInfo = json_decode($_SESSION['user_info'] , true);

db_config::$dbname = db_config::$sourcename .'_'. $_SESSION['select_version']['extends'];


switch($action){

	case 'temp1'://查询没有知识点的题目
		
		$subject_id = $_GET['subject'];
		$section_id = $_GET['section'];
		$offset = $_GET['offset'];
		$step = $_GET['step'];
		
		$modify_only = $_GET['modify_only'];
		
		if($modify_only){
			$data_origin = factory::getModel('temp_exam_question_index_0911')->get_question_without_knowledge_filter($subject_id , $section_id , $offset , $step);
		}else{
			$data_origin = factory::getModel('temp_exam_question_index_0911')->get_question_without_knowledge($subject_id , $section_id , $offset , $step);
		}
		
		
		$ids = array();
		
		foreach( $data_origin['data'] as $question ){
			$ids[] = $question['gid'];
		}
		
		$data_modify = factory::getModel('temp_exam_question_index')->get_question_by_id($ids);
		
		
		foreach($data_modify['data'] as $k1 => $question){
			foreach($data_origin['data'] as $k2 => $q2){
				if($question['gid'] == $q2['gid'] ){
					$data_origin['data'][$k2]['knowledge_id'] = $question['knowledge_id'];
					$data_origin['data'][$k2]['knowledge_text'] = $question['knowledge_text'];
				}
			}
			
		}
		
		
		$modify_count = factory::getModel('temp_exam_question_index')->get_question_count($subject_id , $section_id);
		
			
		$result = array(
				'data'=>$data_origin['data'],
				'children'=>array(),
				'count'=>$data_origin['count'],
				'modify_count'=>$modify_count[0]['count']
		);
		
		
		
		break;
	
	case 'modify';//修改题目信息
		
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$question = $_POST['question'];
		
		$result = factory::getModel('temp_exam_question_index')->post_modify_question_knowledge($question);
		
		$gidArray = array();
		foreach($question as $q){
			$gidArray[] = $q['gid'];
		}
		
		$result2 = factory::getModel('stat_source_handler')->add_record($subject_id , $section_id ,  $gidArray , '2' , 14);
		
		break;
		
}

echo $callback.'('.json_encode($result).')';