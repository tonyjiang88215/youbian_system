<?php
include_once dirname(dirname(__FILE__)).'/global_inc.php';

$display = new lib_display();
$display->header->setHeader('head.tpl.php');
$display->header->setTitle('资源入库');

$display->setBody('struct/manage_system.tpl.php');
$display->addModule('top','module/top.module.php','manage_system_top.php');
$display->addModule('left','module/left.module.php','manage_system_left.php');
//主页面
$contentModule = new lib_module('nsource/source_setin.module.php');

//查询所有题目模版，作为初始化数据
$questionTemplates = factory::getModel('template_question')->get_templates();

$tmp = array();

foreach($questionTemplates as $k => $v){
	$tmp[$v['id']] = $questionTemplates[$k];
}

$questionTemplates = $tmp;

$questionTemplatesJSON = json_encode($questionTemplates);

$JSCode = <<<JSCODE
	TJDataCenter.set('question_templates', $questionTemplatesJSON);
JSCODE;


//加载当前页JS数据处理
$contentModule->addJavaScript('/manage_system/js/nsource/setin_data_handler.js');
$contentModule->addJavascriptCode($JSCode);

$content_views = array();

$contentModule->setView( $content_views );
$contentModule->addModule('searchBar', 'module/source/search_bar.module.php' , 'searchbar/source_common.php');
$contentModule->addModule('treeSetting' , 'module/source/tree_setting.module.php' , 'source/tree_setting.php');
$contentModule->addModule('treeHTML' , 'module/source/tree_html.module.php' , 'source/tree_data.php');
$contentModule->addModule('pagerHTML' , 'module/source/pager_html.module.php' , array('pager'=>array('type'=>'js','totalcount'=>0,'offset'=>0,'step'=>10,'linkMax'=>2)));
$contentModule->addModule('questionListSetting' , 'module/source/question_list_setting.module.php' , 'source/question_list_setting.php');
$contentModule->addModule('questionList' , 'module/source/question_list.module.php' , 'source/question_list.php');
$contentModule->addModule('popPanels' , 'module/source/popup_panel.module.php' , 'source/popup_panel.php');
$display->addModuleObject('content',$contentModule);

$display->footer->setFooter('foot.tpl.php');
$display->render();