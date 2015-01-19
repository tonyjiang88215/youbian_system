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
	case 'book_data':

		$subject_id = $_GET['subject'];
		$section_id = $_GET['section'];
		$publisher_id = $_GET['publisher'];
		
		$result = factory::getModel('edu_book')->get_books_with_ssp($subject_id , $section_id , $publisher_id);


// 		$result = factory::getModel('setin_exam')->get_exam_names($subject_id , $section_id);


		break;
		
	case 'tree_data':
		
		$subject_id = $_GET['subject'];
		$book_id = $_GET['book'];
		
		$units = factory::getModel('edu_unit')->get_units_by_bookid($subject_id , $book_id);
		
		$chapters = factory::getModel('edu_chapter')->get_chapters_by_bookid($subject_id , $book_id);
		
		$result = array('unit'=>$units , 'chapter'=>$chapters);
		
		break;
		
	case 'modify':
		
		$id = $_POST['id'];
		$type = $_POST['type'];
		$subject = $_POST['subject'];
		$name = str_replace('\'', '\'\'', $_POST['name']);
		$oldname = str_replace('\'' , '\'\'' , $_POST['oldname']);
		
		if($type == 'unit'){
			$result = factory::getModel('edu_unit')->modify_unit($subject , array('id'=>$id , 'unit_name'=>$name));
			
			//添加操作记录
			factory::getModel('base_version_history')->insert_history(
				$History ['type'] ['tongbu'] , $History['entity']['unit'] , $subject , 0 , $History['action']['modify'] , 
				$id , $userInfo['id'] , $oldname , $name , ''
			);
		}else if($type == 'chapter'){
			$result = factory::getModel('edu_chapter')->modify_chapter($subject , array('id'=>$id , 'chapter_name'=>$name));
			
			//添加操作记录
			factory::getModel('base_version_history')->insert_history(
				$History ['type'] ['tongbu'] , $History['entity']['chapter'] , $subject , 0 , $History['action']['modify'] , 
				$id , $userInfo['id'] , $oldname , $name , ''
			);

		}
		
		
		
		break;
		
	case 'insert_unit':
		$data = $_POST['new_data'];
		
		$result = factory::getModel('edu_unit')->insert_unit($data);

		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['tongbu'] , $History['entity']['unit'] , $data['subject_id'] , 0 , $History['action']['insert'] ,
			$data['id'] , $userInfo['id'] , '' , $data['unit_name'] , 
			json_encode(array('book_id'=>$data['book_id']))
		);
		
		
		break;
		
	case 'insert_chapter':
		
		$data = $_POST['new_data'];
		
		$result = factory::getModel('edu_chapter')->insert_chapter($data);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['tongbu'] , $History['entity']['chapter'] , $data['subject_id'] , 0 , $History['action']['insert'] ,
			$data['id'] , $userInfo['id'] , '' , $data['chapter_name'] ,
			json_encode(array('book_id'=>$data['book_id']))
		);
		
		
		break;
		
	case 'remove_unit':
		
		$id = $_POST['id'];
		$subject_id = $_POST['subject'];
		$oldname = $_POST['oldname'];
		
		$result = factory::getModel('edu_unit')->remove_unit($subject_id , $id);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['tongbu'] , $History['entity']['unit'] , $subject , 0 , $History['action']['delete'] ,
			$id , $userInfo['id']	, $oldname	
		);
		
		
		break;
		
	case 'remove_chapter':
		
		$id = $_POST['id'];
		$subject_id = $_POST['subject'];
		$oldname = $_POST['oldname'];
		
		$result = factory::getModel('edu_chapter')->remove_chapter($subject_id , $id);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['tongbu'] , $History['entity']['chapter'] , $subject , 0 , $History['action']['delete'] ,
			$id , $userInfo['id'] , $oldname
		);
		
		break;
		
	case 'move_up':
		
		$id = $_POST['id'];
		$type = $_POST['type'];
		$subject = $_POST['subject'];
		$oldname = $_POST['oldname'];
		
		if($type == 'unit'){
			$result = factory::getModel('edu_unit')->move_up($subject , $id);
			
			//添加操作记录
			factory::getModel('base_version_history')->insert_history(
				$History ['type'] ['tongbu'] , $History['entity']['unit'] , $subject , 0 , $History['action']['modify'] ,
				$id , $userInfo['id'] , '' , '' , '上移'
			);
			
		}else if($type == 'chapter'){
			$result = factory::getModel('edu_chapter')->move_up($subject , $id);
			
			//添加操作记录
			factory::getModel('base_version_history')->insert_history(
				$History ['type'] ['tongbu'] , $History['entity']['chapter'] , $subject , 0 , $History['action']['modify'] ,
				$id , $userInfo['id'] , $oldname , '' , '上移'
			);
			
		}
		
		break;
		
	case 'move_down':
		
		$id = $_POST['id'];
		$type = $_POST['type'];
		$subject = $_POST['subject'];
		$oldname = $_POST['oldname'];
		
		if($type == 'unit'){
			$result = factory::getModel('edu_unit')->move_down($subject , $id);
			
			//添加操作记录
			factory::getModel('base_version_history')->insert_history(
				$History ['type'] ['tongbu'] , $History['entity']['unit'] , $subject , 0 , $History['action']['modify'] ,
				$id , $userInfo['id'] , $oldname , '' , '下移'
			);
			
		}else if($type == 'chapter'){
			$result = factory::getModel('edu_chapter')->move_down($subject , $id);
			
			//添加操作记录
			factory::getModel('base_version_history')->insert_history(
				$History ['type'] ['tongbu'] , $History['entity']['chapter'] , $subject , 0 , $History['action']['modify'] ,
				$id , $userInfo['id'] , $oldname , '' , '下移'
			);
			
		}
		
		break;
		
	case 'drag':
		
		$chapter = $_POST['chapter'];
		$subject_id = $_POST['subject'];
		$oldname = $_POST['oldname'];
		
		$result = factory::getModel('edu_chapter')->drag_knowledge($subject_id , $chapter);
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['tongbu'] , $History['entity']['chapter'] , $subject , 0 , $History['action']['modify'] ,
			$chapter['id'] , $userInfo['id'] , $oldname , '' , '拖拽'
		);
		
		
		break;
		
		
	case 'setin_data':
		
		
		$toVersion = $_SESSION['select_version']['id'];
		$toSubject = $_POST['to_subject'];
		$toBook = $_POST['to_book'];
		
		$fromVersion = $_POST['from_version'];
		$fromSubject = $_POST['from_subject'];
		$fromBook = $_POST['from_book'];
		
		//是否导入题目关系
		$relation = $_POST['relation'];
		
		$ref = $_POST['ref'];
		
		try{
				
			//先导入单元数据
			$resultUnit = factory::getModel('edu_unit')->copyData($toVersion , $toSubject , $toBook , $fromVersion , $fromSubject , $fromBook);

			//再导入章节数据
			$resultChapter = factory::getModel('edu_chapter')->copyData($toVersion , $toSubject , $toBook , $fromVersion , $fromSubject , $fromBook);
		
			if($relation){
				//最后导入章节对应题目关系表数据
				$resultChapterRelation = factory::getModel('edu_chapter_to_question')->copyData($toVersion , $toSubject , $toBook , $fromVersion , $fromSubject , $fromBook);
			}else{
				$resultChapterRelation = true;
			}
		
			$result = $resultUnit && $resultChapter && $resultChapterRelation;
			
			//添加操作记录
			factory::getModel('base_version_history')->insert_history(
				$History ['type'] ['tongbu'] , $History['entity']['book'] , $toSubject , 0 , $History['action']['setin'] ,
				$toBook , $userInfo['id'] , '' , ''  , 
				str_replace('\\', '\\\\', json_encode(array('version'=>$fromVersion , 'id'=>$fromBook , 'note'=>($relation ? '结构及题目' : '结构'))))
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
		$book = $_POST['book'];
	
		//先删除章节对应题目关系表数据
		$resultChapterRelation = factory::getModel('edu_chapter_to_question')->clearData($subject , $book);
	
		//在删除章节数据
		$resultChapter = factory::getModel('edu_chapter')->clearData($subject , $book);
	
		//最后删除单元数据
		$resultUnit = factory::getModel('edu_unit')->clearData($subject , $book);
		
// 		var_dump($resultChapterRelation , $resultChapter , $resultUnit);
	
		$result = $resultUnit && $resultChapter && $resultChapterRelation;
		
		//添加操作记录
		factory::getModel('base_version_history')->insert_history(
			$History ['type'] ['tongbu'] , $History['entity']['book'] , $subject , 0 , $History['action']['clear'] ,
			$book , $userInfo['id'] , '' , '' , ''
		);
	
		// 		if($result){
// 		$result = factory::getModel('edu_curriculumn_version_detail')->post_clear_success($detail_id);
		// 		}
	
	
		break;
		
		
	
}

echo $callback.'('.json_encode($result).')';