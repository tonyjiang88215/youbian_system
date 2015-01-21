<?php
include_once dirname(dirname(__FILE__)).'/global_inc.php';

$display = new lib_display();
$display->header->setHeader('head.tpl.php');
$display->header->setTitle('用户管理');

$display->setBody('struct/manage_system.tpl.php');
$display->addModule('top','module/top.module.php','manage_system_top.php');
$display->addModule('left','module/left.module.php','manage_system_left.php');
//主页面
$contentModule = new lib_module('user/manage_user.module.php');

//加载当前页JS数据处理
$contentModule->addJavaScript('/manage_system/js/md5.js');
$contentModule->addJavaScript('/manage_system/js/user/manage_user_handler.js');

$contentModule->setView( $content_views );
$contentModule->addModule('searchBar', 'module/source/search_bar.module.php' , 'searchbar/user_list.php');
// $contentModule->addModule('treeSetting' , 'module/source/tree_setting.module.php' , 'source/tree_setting.php');
// $contentModule->addModule('treeHTML' , 'module/source/tree_html.module.php' , 'source/tree_data.php');
$contentModule->addModule('pagerHTML' , 'module/source/pager_html.module.php' , array('pager'=>array('type'=>'js','totalcount'=>0,'offset'=>0,'step'=>10,'linkMax'=>2)));
// $contentModule->addModule('questionListSetting' , 'module/source/question_list_setting.module.php' , 'source/question_list_setting.php');
// $contentModule->addModule('questionList' , 'module/source/question_duplicate.module.php');
$contentModule->addModule('popPanels' , 'popup/user/popup_user_member.php' , 'popup/popup_user_member.php');
// $contentModule->addModule('floatPanels' , 'module/source/float_source_duplicate.php' , '');
$display->addModuleObject('content',$contentModule);

$display->footer->setFooter('foot.tpl.php');
$display->render();