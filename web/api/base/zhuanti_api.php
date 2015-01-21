<?php
// ini_set('display_errors' , 'On');
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
	
		$result = factory::getModel('edu_zhuanti')->get_zhuantis($subject_id , $section_id);
	
		break;
	
	case 'insert':
		
		$newData = $_POST['new_data'];
		
		$result = factory::getModel('edu_zhuanti')->insert_zhuanti($newData);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
		$History ['type'] ['zhuanti'] , $History['entity']['zhuanti'] , $newData['subject_id'] , $newData['section_id'] , $History['action']['insert'] ,
		0 , $userInfo['id'] , '' , $newData['name']
		);
		
		break;
		
	case 'modify':
		
		$zhuanti = $_POST['zhuanti'];
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$oldname = $_POST['oldname'];
		
		$result = factory::getModel('edu_zhuanti')->modify_zhuanti($subject_id , $zhuanti);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['zhuanti'] , $History['entity']['zhuanti'] , $subject_id , $section_id , $History['action']['modify'] ,
			$zhuanti['id'] , $userInfo['id'] , $oldname , $zhuanti['name']
		);
		
		break;
		
	case 'drag':
		
		$zhuanti = $_POST['zhuanti'];
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$childs = $_POST['childs'];
		$levelDiff = $_POST['levelDiff'];
		$oldname = $_POST['oldname'];
		
		$result = factory::getModel('edu_zhuanti')->drag_zhuanti($subject_id , $zhuanti , $levelDiff , $childs);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['zhuanti'] , $History['entity']['zhuanti'] , $subject_id , $section_id , $History['action']['modify'] ,
			$zhuanti['id'] , $userInfo['id'] , $oldname , '' , '拖拽'
		);
		
		break;
		
	case 'delete':
		
		$zhuanti_id = $_POST['zhuanti_id'];
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$oldname = $_POST['oldname'];
		
		$result = factory::getModel('edu_zhuanti')->delete_zhuanti($subject_id , $zhuanti_id);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['zhuanti'] , $History['entity']['zhuanti'] , $subject_id , $section_id , $History['action']['delete'] ,
			$zhuanti_id , $userInfo['id'] , $oldname
		);
		
		break;
		
	case 'move_up':
		
		$id = $_POST['zhuanti_id'];
		$id2 = $_POST['target_id'];
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$oldname = $_POST['oldname'];
		
		$result = factory::getModel('edu_zhuanti')->move_up_zhuanti($subject_id , $id , $id2);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['zhuanti'] , $History['entity']['zhuanti'] , $subject_id , $section_id , $History['action']['modify'] ,
			$id , $userInfo['id'] , $oldname ,  '' , '上移'
		);
		
		break;
		
	case 'move_down':
		
		$id = $_POST['zhuanti_id'];
		$id2 = $_POST['target_id'];
		$subject_id = $_POST['subject'];
		$section_id = $_POST['section'];
		$oldname = $_POST['oldname'];
		
		$result = factory::getModel('edu_zhuanti')->move_down_zhuanti($subject_id , $id , $id2);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['zhuanti'] , $History['entity']['zhuanti'] , $subject_id , $section_id , $History['action']['modify'] ,
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
			$resultZhuanti = factory::getModel('edu_zhuanti')->copyData($toVersion , $toSubject , $toSection , $fromVersion , $fromSubject , $fromSection);
	
			if($relation){
				//最后导入知识点对应题目关系表数据
				$resultZhuantiRelation = factory::getModel('edu_zhuanti_to_question')->copyData($toVersion , $toSubject , $toSection , $fromVersion , $fromSubject , $fromSection);
			}else{
				$resultZhuantiRelation = true;
			}
	
			$result = $resultZhuanti && $resultZhuantiRelation;
	
			//添加操作记录
			factory::getModel('base_version_history')->insert_history(
				$History ['type'] ['zhuanti'] , $History['entity']['zhuanti'] , $toSubject , $toSection , $History['action']['setin'] ,
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
		$resultZhuantiRelation = factory::getModel('edu_zhuanti_to_question')->clearData($subject , $section);
	
		//在删除知识点数据
		$resultZhuanti = factory::getModel('edu_zhuanti')->clearData($subject , $section);
	
	
		$result = $resultZhuantiRelation && $resultZhuanti;
	
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['zhuanti'] , $History['entity']['zhuanti'] , $subject , $section , $History['action']['clear'] ,
			0 , $userInfo['id'] , '' , '' , ''
		);
		// 		if($result){
		// 		$result = factory::getModel('edu_curriculumn_version_detail')->post_clear_success($detail_id);
		// 		}
	
	
		break;
		
}


echo $callback.'('.json_encode($result).')';