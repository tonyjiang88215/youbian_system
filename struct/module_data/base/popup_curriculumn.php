<?php
$userInfo = json_decode($_SESSION['user_info'] , true);

$Views = array();

$Views['popPanels'] = array();

$Views['popPanels'] ['addCurriculumn'] = array( 'show' => true );

$Views['popPanels'] ['addCurriculumn'] ['data'] = factory::getModel('edu_curriculumn_version')->get_curriculumn_versions();


//添加条件选择框
$searchBarModule = new lib_module('module/source/search_bar.module.php');

$moduleView= array();

$moduleView ['search'] = array ();

$moduleView ['search'] ['section'] = array (
		'show' => true,
		'data' => factory::getModel('edu_section')->get_sections()
);


$moduleView ['search'] ['subject'] = array (
		'show'=>true,
		'data'=>factory::getModel('edu_subject')->get_subjects_by_control($userInfo['id'])
);



$moduleView ['search'] ['publisher'] = array (
		'show'=>true,
		'data'=>factory::getModel('edu_publisher')->get_publishers()
 );

$moduleView ['search'] ['grade'] = array(
		'data'=>factory::getModel('edu_grade')->get_grades()
);

$moduleView ['search'] ['book'] = array ('show'=>false );

$moduleView ['search'] ['curriculumn_version'] = array(
	'show'=>false,
	'data'=>factory::getModel('edu_curriculumn_version')->get_curriculumn_versions_with_subject_by_control($userInfo['id'])
);

$moduleView['search'] ['group'] = 'first';

$searchBarModule->setView($moduleView);

$Views['popPanels'] ['searchBarFirst'] = $searchBarModule->render();

$moduleView['search'] ['group'] = 'second';

$searchBarModule->setView($moduleView);

$Views['popPanels'] ['searchBarSecond'] = $searchBarModule->render();


$treeHTMLModule = new lib_module('module/source/tree_html.module.php');
$treeHTMLModule->setView(array('type'=>'js' , 'treeClass'=>'treeClass'));


$Views['popPanels'] ['treeHTML'] = $treeHTMLModule->render();

