<?php
include_once dirname(dirname(__FILE__)).'/global_inc.php';

$display = new lib_display();
$display->header->setHeader('head.tpl.php');
$display->header->setTitle('导出批次管理');

$display->setBody('struct/manage_system.tpl.php');
$display->addModule('top','module/top.module.php','manage_system_top.php');
$display->addModule('left','module/left.module.php','manage_system_left.php');
//主页面
$contentModule = new lib_module('setout/setout_batch.module.php');

//加载当前页JS数据处理
$contentModule->addJavaScript('/manage_system/js/setout/setout_batch_handler.js');

$contentModule->setView( $content_views );
// $contentModule->addModule('searchBar', 'module/source/search_bar.module.php' , 'source/search_bar_for_duplicate.php');
// $contentModule->addModule('treeSetting' , 'module/source/tree_setting.module.php' , 'source/tree_setting.php');
// $contentModule->addModule('treeHTML' , 'module/source/tree_html.module.php' , 'source/tree_data.php');
$contentModule->addModule('pagerHTML' , 'module/source/pager_html.module.php' , array('pager'=>array('type'=>'js','totalcount'=>0,'offset'=>0,'step'=>10,'linkMax'=>2)));
// $contentModule->addModule('questionListSetting' , 'module/source/question_list_setting.module.php' , 'source/question_list_setting.php');
// $contentModule->addModule('questionList' , 'module/source/question_duplicate.module.php');
$contentModule->addModule('popPanels' , 'module/setout/popup_setout_batch.php' , '');
// $contentModule->addModule('floatPanels' , 'module/source/float_source_duplicate.php' , '');
$display->addModuleObject('content',$contentModule);

$display->footer->setFooter('foot.tpl.php');
$display->render();