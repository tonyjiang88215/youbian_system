<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

$version_id = $_REQUEST['version'];

$userInfo = json_decode($_SESSION['user_info'] , true);

if($version_id != 0){
	foreach($CFG['data']['curriculumn'] as $curriculumn){
		if($curriculumn['id'] == $version_id){
			$dbname = db_config::$sourcename .'_'. $curriculumn['extends'];
			break;
		}
	}
}else{
	$dbname = db_config::$sourcename .'_'. $_SESSION['select_version']['extends'];
}

db_config::$dbname = $dbname;

switch($action){
	
	case 'tree_data':
	
		$subject_id = $_GET['subject'];
		$section_id = $_GET['section'];
		
		$result = factory::getModel('edu_knowledge')->get_knowledges($subject_id , $section_id);
	
		break;
	
	case 'insert':
		
		$newData = $_POST['new_data'];
		
		$result = factory::getModel('edu_knowledge')->insert_knowledge($newData);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['knowledge'] , $History['entity']['knowledge'] , $newData['subject_id'] , $newData['section_id'] , $History['action']['insert'] ,
			0 , $userInfo['id'] , '' , $newData['name'] 
		);
		
		break;
		
	case 'modify':
		
		$knowledge = $_POST['knowledge'];
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$oldname = $_POST['oldname'];
		
		$result = factory::getModel('edu_knowledge')->modify_knowledge($subject_id , $knowledge);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['knowledge'] , $History['entity']['knowledge'] , $subject_id , $section_id , $History['action']['modify'] ,
			$knowledge['id'] , $userInfo['id'] , $oldname , $knowledge['name'] 
		);
		
		break;
		
	case 'drag':
		
		$knowledge = $_POST['knowledge'];
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$childs = $_POST['childs'];
		$levelDiff = $_POST['levelDiff'];
		$oldname = $_POST['oldname'];
		
		$result = factory::getModel('edu_knowledge')->drag_knowledge($subject_id , $knowledge , $levelDiff , $childs);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['knowledge'] , $History['entity']['knowledge'] , $subject_id , $section_id , $History['action']['modify'] ,
			$knowledge['id'] , $userInfo['id'] , $oldname , '' , '拖拽'
		);
		
		break;
		
	case 'delete':
		
		$knowledge_id = $_POST['knowledge_id'];
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$oldname = $_POST['oldname'];
		
		$result = factory::getModel('edu_knowledge')->delete_knowledge($subject_id , $knowledge_id);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['knowledge'] , $History['entity']['knowledge'] , $subject_id , $section_id , $History['action']['delete'] ,
			$knowledge_id , $userInfo['id'] , $oldname 
		);
		
		break;
		
	case 'move_up':
		
		$id = $_POST['knowledge_id'];
		$id2 = $_POST['target_id'];
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$oldname = $_POST['oldname'];
		
		$result = factory::getModel('edu_knowledge')->move_up_knowledge($subject_id , $id , $id2);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['knowledge'] , $History['entity']['knowledge'] , $subject_id , $section_id , $History['action']['modify'] ,
			$id , $userInfo['id'] , $oldname ,  '' , '上移'
		);
		
		break;
		
	case 'move_down':
		
		$id = $_POST['knowledge_id'];
		$id2 =$_POST['target_id'];
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$oldname = $_POST['oldname'];
		
		$result = factory::getModel('edu_knowledge')->move_down_knowledge($subject_id , $id , $id2);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['knowledge'] , $History['entity']['knowledge'] , $subject_id , $section_id , $History['action']['modify'] ,
			$id , $userInfo['id'] , $oldname , '' , '下移'
		);
		
		break;
		
	case 'setin_data':
		
	
		$toVersion = $_SESSION['select_version']['id'];
		$toSubject = $_POST['to_subject'];
		$toSection = $_POST['to_section'];
	
		$fromVersion = $_POST['from_version'];
		$fromSubject = $_POST['from_subject'];
		$fromSection = $_POST['from_section'];
	
		$ref = $_POST['ref'];
		
		//是否导入题目关系
		$relation = $_POST['relation'];
		
		try{
			//先导入知识点数据
			$resultKnowledge = factory::getModel('edu_knowledge')->copyData($toVersion , $toSubject , $toSection , $fromVersion , $fromSubject , $fromSection);
	
			if($relation){
				//最后导入知识点对应题目关系表数据
				$resultKnowledgeRelation = factory::getModel('edu_knowledge_to_question')->copyData($toVersion , $toSubject , $toSection , $fromVersion , $fromSubject , $fromSection);
			}else{
				$resultKnowledgeRelation = true;
			}
	
			$result = $resultKnowledge && $resultKnowledgeRelation;
	
			//添加操作记录
			factory::getModel('base_version_history')->insert_history(
				$History ['type'] ['knowledge'] , $History['entity']['knowledge'] , $toSubject , $toSection , $History['action']['setin'] ,
				0 , $userInfo['id'] , '' , '' , 
				str_replace('\\', '\\\\', json_encode(array('version'=>$fromVersion , 'subject'=>$fromSubject , 'section'=>$fromSection , 'note'=>($relation ? '结构及题目' : '结构'))))
				
			);
			
			if($result){
// 				$result = factory::getModel('edu_curriculumn_version_detail')->post_setin_success($detail_id , $ref);
			}
	
		}catch(Exception $e){
			$result = false;
		}
	
		break;
		
	case 'clear_data':
	
		$subject = $_POST['subject'];
		$section = $_POST['section'];
	
		//先删除知识点对应题目关系表数据
		$resultKnowledgeRelation = factory::getModel('edu_knowledge_to_question')->clearData($subject , $section);
	
		//在删除知识点数据
		$resultKnowledge = factory::getModel('edu_knowledge')->clearData($subject , $section);
	
	
		$result = $resultKnowledgeRelation && $resultKnowledge;
	
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['knowledge'] , $History['entity']['knowledge'] , $subject , $section , $History['action']['clear'] ,
			0 , $userInfo['id'] , '' , '' , ''
		);
		
		// 		if($result){
// 		$result = factory::getModel('edu_curriculumn_version_detail')->post_clear_success($detail_id);
		// 		}
	
	
		break;
		
}


echo $callback.'('.json_encode($result).')';