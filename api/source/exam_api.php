<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

$userInfo = json_decode($_SESSION['user_info'] , true);

db_config::$dbname = db_config::$sourcename .'_'. $_SESSION['select_version']['extends'];


switch($action){
	case 'new':
		
// 		$gradeArray = array('1'=>'66','2'=>'77','3'=>'88');
		
		$examInfo = $_POST['examinfo'];
		
		$insertInfo = array();
		$insertInfo['subject_id'] = $examInfo['subject'];
		$insertInfo['section_id'] = $examInfo['section'];
// 		$insertInfo['grade_id'] = $gradeArray[$examInfo['section']];
		$insertInfo['year'] = $examInfo['year'];
		$insertInfo['province_id'] = $examInfo['area'];
		$insertInfo['exam_type'] = $examInfo['zhenti'];
		$insertInfo['name'] = $examInfo['name'];
		$insertInfo['creat_date'] = date('Y-m-d H:i:s');
		$insertInfo['exam_time'] = $examInfo['time'];
//		$insertInfo['']
		
		$result = factory::getModel('exam_examination')->new_exam($insertInfo);
		
		break;
		
	case 'reset':
		$subject_id = $_POST['subject'];
		$version_id = $_POST['version'];
		$exam_id = $_POST['exam_id'];
		
		$result = factory::getModel('exam_question_index')->post_exam_reset($subject_id , $version_id , $exam_id);
		
		break;
		
	case 'info':
		$exam_id = $_GET['exam_id'];
		
		$result = factory::getModel('exam_examination')->get_exam_info($exam_id);
		
		break;
		
	case 'modify':
		
		$gradeArray = array('1'=>'66','2'=>'77','3'=>'88');
		
		$examInfo = $_POST['examinfo'];
		
		$modifyInfo = array();
		$modifyInfo['id'] = $examInfo['id'];
		$modifyInfo['subject_id'] = $examInfo['subject'];
		$modifyInfo['section_id'] = $examInfo['section'];
		$modifyInfo['grade_id'] = $gradeArray[$examInfo['section']];
		$modifyInfo['year'] = $examInfo['year'];
		$modifyInfo['province_id'] = $examInfo['area'];
		$modifyInfo['exam_type'] = $examInfo['zhenti'];
		$modifyInfo['name'] = $examInfo['name'];
		$modifyInfo['exam_time'] = $examInfo['time'];
		
		$result = factory::getModel('exam_examination')->modify_exam_info($modifyInfo);
		
		break;
		
	case 'complete':
		
		$exam_id = $_POST['exam_id'];
		$type = $_POST['type'];
		
		$result = factory::getModel('setin_exam')->post_finish_exam($exam_id , $type);
		
		break;
		
	case 'setout':
		
		$subject_id = $_POST['subject'];
		$type = $_POST['type'];
		$exam_id = $_POST['exam_id'];
		$version_id = $_POST['cv'];
		
		$result = factory::getModel('setin_exam')->post_setout_exam($version_id , $subject_id , $type , $exam_id);
		
		break;
}

echo $callback.'('.json_encode($result).')';