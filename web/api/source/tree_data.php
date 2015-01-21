<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$type = $_GET['type'] ? $_GET['type'] : 1;

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

switch($type){
	case 1://查询试卷
		
		$section_id = $_GET['section'];
		$subject_id = $_GET['subject'];
		$year = $_GET['year'];
		$area = $_GET['area'];
		$zhentiFlag = $_GET['zhenti'];
		
		$result = factory::getModel('exam_examination')->get_examinations($section_id , $subject_id , $year , $area , $zhentiFlag);
		
		$idArray = array();
		
		foreach($result as $v){
			$idArray[] = $v['id'];
		}
		
		if(count($result)>0){
			
			$questionCount = factory::getModel('exam_examination_to_question')->get_count_by_examid($idArray);
			
			foreach($result as $k =>$v){
				$result[$k]['children'] = array();
				foreach($questionCount as $count){
					if($v['id'] = $count['exam_id']){
						$result[$k]['attributes'] = array(
							'count' => $count['count']
						);
						$result[$k]['name'] = $result[$k]['name'].'['.$count['count'].']';
					}
				}
			}
		}
		
		
		break;
		
	case 2://查询章节单元
		
		$section_id = $_GET['section'];
		$subject_id = $_GET['subject'];
		$publisher_id = $_GET['publisher'];
		$book_id = $_GET['book'];
		
		$units = factory::getModel('edu_unit')->get_units_by_bookid($subject_id , $book_id);
		$chapters = factory::getModel('edu_chapter')->get_chapters_by_bookid($subject_id , $book_id);
		
		$chapterQuestionCount = factory::getModel('edu_chapter_to_question')->get_question_count_by_bookid($subject_id , $book_id);
		
		foreach($chapters as $k=>$chapter){
			$chapters[$k]['count'] = 0;
			foreach($chapterQuestionCount as $c){
				if($chapter['id'] == $c['id']){
					$chapters[$k]['count'] = intval($c['count']);
					break;
				}
			}
		} 
		
		$result = array();
		
		foreach($units as $unit){
			$tmp = array('id'=>$unit['id'],'name'=>$unit['unit_name'],'children'=>array());
			
			foreach($chapters as $chapter){
				if($chapter['unit_id'] == $unit['id']){
					$tmp['children'][] = array('id'=>$chapter['id'],'name'=>$chapter['chapter_name'].'['.$chapter['count'].']','attributes'=>array('count'=>$chapter['count']),'children'=>array());
				}
			}
			
			$result[] = $tmp;
			
		}
		
		break;
		
	case 3://查询专题
		
		$section_id = $_GET['section'];
		$subject_id = $_GET['subject'];
		
		$result = factory::getModel('edu_zhuanti')->get_zhuantis($subject_id , $section_id );
		
		break;
		
	case 4://查询知识体系
		
		$section_id = $_GET['section'];
		$subject_id = $_GET['subject'];
		
		$result = factory::getModel('edu_knowledge')->get_knowledges($section_id , $curriculumn_version );
		
		
		
		break;
}

echo $callback.'('.json_encode($result).')';


