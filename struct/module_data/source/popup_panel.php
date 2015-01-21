<?php
$Views = array();

$Views['popPanels'] = array();

$Views['popPanels'] ['knowledgeList'] = array( 'show' => true );

$Views['popPanels'] ['addExam'] = array( 'show' => true );

$Views['popPanels'] ['modifyExam'] = array( 'show' => true );

$Views['popPanels'] ['uploadImg'] = array( 'show' => true );

$Views['popPanels'] ['uploadWord'] = array( 'show' => true );

$section = array(
		array('id'=>1 , 'name'=>'小学'),
		array('id'=>2 , 'name'=>'初中'),
		array('id'=>3 , 'name'=>'高中')
);
$subject =factory::getModel('edu_subject')->get_subjects();
$year = factory::getModel('edu_year')->get_years();
$area = factory::getModel('area_province')->get_provinces();


if($Views['popPanels'] ['addExam'] ['show']){
	
	$Views['popPanels'] ['addExam'] ['data'] = array(
		'section'	=>$section,
		'subject'	=> $subject, 
		'year'		=>	$year,
		'area'		=> $area
	);
}

if($Views['popPanels'] ['modifyExam'] ['show']){
	
	$Views['popPanels'] ['modifyExam'] ['data'] = array(
		'section'	=>$section,
		'subject'	=> $subject, 
		'year'		=>	$year,
		'area'		=> $area
	);
}

if($Views['popPanels'] ['uploadImg'] ['show']){
	
	$Views['popPanels'] ['uploadImg'] ['data'] = array(
		'uploadPath' =>'/manage_system/api/source/upload_image_api.php'
	);
	
}

if($Views['popPanels'] ['uploadWord'] ['show']){

	$Views['popPanels'] ['uploadWord'] ['data'] = array(
			'uploadPath' =>'/manage_system/api/source/upload_word_api.php'
	);

}


$Views['subject'] = factory::getModel('edu_subject')->get_subjects();

$Views ['year'] = factory::getModel('exam_examination')->get_years();

$Views ['area'] = factory::getModel('area_province')->get_provinces();
