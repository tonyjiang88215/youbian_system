<?php


$Views ['search'] ['section'] ['show'] = true;
$Views ['search'] ['grade'] ['show'] = true;
$Views ['search'] ['subject'] ['show'] = true;
$Views ['search'] ['publisher'] ['show'] = true;
$Views ['search'] ['book'] ['show'] = true;



// $mod = $_GET['mod'] ? $_GET['mod'] : 1;
// $type = $_GET['type'] ? $_GET['type'] : 2;

// $userInfo = json_decode($_SESSION['user_info'] , true);

// $Views = array();

// $Views ['search'] = array ();

// $Views ['search'] ['group'] = 'setin';

// $Views ['search'] ['section'] = array ('show'=>false );

// $Views ['search'] ['grade'] = array ('show' => false);

// $Views ['search'] ['subject'] = array ('show'=>false );

// $Views ['search'] ['year'] = array ('show'=>false );

// $Views ['search'] ['area'] = array ('show'=>false );

// $Views ['search'] ['zhenti_flag'] = array ('show'=>false );

// $Views ['search'] ['publisher'] = array ('show'=>false );

// $Views ['search'] ['book'] = array ('show'=>false );

// $Views ['search'] ['curriculumn_version'] = array ('show' => false);

// $Views ['search'] ['section'] ['data'] = array(
// 	array('id'=>1 , 'name'=>'小学'),
// 	array('id'=>2 , 'name'=>'初中'),
// 	array('id'=>3 , 'name'=>'高中')
// );

// $Views ['search'] ['subject'] ['data'] = factory::getModel('edu_subject')->get_subjects_by_control($userInfo['id']);

// $Views ['search'] ['year'] ['data'] = factory::getModel('edu_year')->get_years();

// $Views['search'] ['grade'] ['data'] = factory::getModel('edu_grade')->get_grades();

// $Views ['search'] ['area'] ['data'] = factory::getModel('area_province')->get_provinces();

// $Views ['search'] ['curriculumn_version'] ['data'] = factory::getModel('edu_curriculumn_version')->get_curriculumn_versions_with_subject_by_control($userInfo['id']);

// 	if($type == 1){//试卷
		
// 		//设置显示内容
// 		$Views ['search'] ['section'] ['show'] = true;
// 		$Views ['search'] ['subject'] ['show'] = true;
// 		$Views ['search'] ['year'] ['show'] = true;
// 		$Views ['search'] ['area'] ['show'] = true;
// 		$Views ['search'] ['zhenti_flag'] ['show'] = true;
// 		$Views ['search'] ['curriculumn_version'] ['show'] = true;
		

// 	}else if($type == 2){//同步
		
// 		$Views ['search'] ['section'] ['show'] = true;
// 		$Views ['search'] ['grade'] ['show'] = true;
// 		$Views ['search'] ['subject'] ['show'] = true;
// 		$Views ['search'] ['publisher'] ['show'] = true;
// 		$Views ['search'] ['book'] ['show'] = true;
// 		$Views ['search'] ['curriculumn_version'] ['show'] = true;
		
// 	}else if($type == 3){//专题
		
// 		$Views ['search'] ['section'] ['show'] = true;
// 		$Views ['search'] ['subject'] ['show'] = true;
// 		$Views ['search'] ['curriculumn_version'] ['show'] = true;
		
		
// 	}else if($type == 4){
// 		$Views ['search'] ['section'] ['show'] = true;
// 		$Views ['search'] ['subject'] ['show'] = true;
// 		$Views ['search'] ['curriculumn_version'] ['show'] = true;
		
// 	}

