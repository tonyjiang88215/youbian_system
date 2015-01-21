<?php

$userInfo = json_decode($_SESSION['user_info'] , true);

$Views = array();

$treeHTMLModule = new lib_module('module/source/tree_html.module.php');
$treeHTMLModule->setView(array('type'=>'js' , 'treeClass'=>'treeClass'));

$Views['treeHTML'] = $treeHTMLModule->render();


if($userInfo['workset_id'] == 1){
	$Views['versionList'] = factory::getModel('edu_curriculumn_version')->get_curriculumn_versions();
}else{
	$Views['versionList'] = factory::getModel('edu_curriculumn_version')->get_curriculumn_versions_by_control($userInfo['id']);
}
