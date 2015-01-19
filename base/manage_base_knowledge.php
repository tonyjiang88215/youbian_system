<?php
include_once dirname(dirname(__FILE__)).'/global_inc.php';

$userInfo = json_decode($_SESSION['user_info'] , true);

$display = new lib_display();
$display->header->setHeader('head.tpl.php');
$display->header->setTitle('知识体系维护');

$display->setBody('struct/manage_system.tpl.php');
$display->addModule('top','module/top.module.php','manage_system_top.php');
$display->addModule('left','module/left.module.php','manage_system_left.php');
//主页面
$contentModule = new lib_module('base/base_knowledge.module.php');

//加载当前页JS数据处理
$contentModule->addJavaScript('/manage_system/js/base/base_knowledge_handler.js');

$contentModule->addModule('searchBar', 'module/source/search_bar.module.php' , 'searchbar/base_knowledge&zhuanti.php');
$contentModule->addModule('treeHTML' , 'module/source/tree_html.module.php' , 'source/tree_data.php');

$popPanels =  new lib_module('popup/base/popup_knowledge.php');
$popPanels->addModule('search' , 'module/source/search_bar.module.php' , 'searchbar/popup_knowledge&zhuanti.php');
$popPanels->addModule('treeHTML' , 'module/source/tree_html.module.php' , 'source/tree_popup_setin.php');

// $contentModule->addModule('popPanels' , 'popup/base/popup_unit_chapter.php' , 'base/popup_unit_chapter.php');
$contentModule->addModuleObject('popPanels',$popPanels);

$display->addModuleObject('content',$contentModule);

$display->footer->setFooter('foot.tpl.php');
$display->render();