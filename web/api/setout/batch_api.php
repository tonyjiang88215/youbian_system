<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

switch($action){
		
	case 'list':

		$result = factory::getModel('setout_batch')->get_batchs();
		
		foreach($result as $k =>$v){
			$result[$k]['time'] = date('Y-m-d H:i' , $v['time']);
		}
		
		break;
	
	case 'detail':
		
		$batch_id = $_GET['batch_id'];
		
		$result = array();
		$result['question'] = factory::getModel('setout_batch2question')->getQuestionsTotal($batch_id);
		$result['detail'] = factory::getModel('setout_batch_detail')->get_detail($batch_id);
		
		break;
	
	case 'insert':
		
		$name = $_POST['name'];
		
		$result = factory::getModel('setout_batch')->post_add_batch($name);
		
		
		break;
		
	case 'add_question':
		
		$type = $_POST['type'];
		$add_type = $_POST['add_type'];
		$batch_id = $_POST['batch_id'];
		$subject = $_POST['subject'];
		$section = $_POST['section'];
		$qid = $_POST['qid'];
		
		switch($add_type){
			case 'all':
				
				$gids = factory::getModel('stat_source_handler')->get_gid_by_action($type);
				
				$result = factory::getModel('setout_batch2question')->addQuestions($batch_id , $type , $gids);
				
				break;
				
			case 'condition':
				
				$gids = factory::getModel('stat_source_handler')->get_gid_by_subjectSection($type , $subject , $section);
				
				$result = factory::getModel('setout_batch2question')->addQuestions($batch_id , $type , $gids);
				
				break;
				
			case 'check':
				
				$gids = array();
				foreach($qid as $v){
					$gids[] = array('gid'=>$v);
				}
				
				$result = factory::getModel('setout_batch2question')->addQuestions($batch_id , $type , $gids);
				
				break;
		}
		
		break;
		
	case 'add_detail':
		$batch_id = $_POST['batch_id'];
		$detail_ids = $_POST['detail'];
		
		$result = factory::getModel('setout_batch_detail')->post_add_detail($batch_id , $detail_ids);
		
		
		break;
		
	case 'remove_detail':
		$batch_id = $_POST['batch_id'];
		$detail_id = $_POST['detail_id'];
		
		$result = factory::getModel('setout_batch_detail')->post_remove_detail($batch_id , $detail_id);
		
		break;
}

echo $callback.'('.json_encode($result).')';