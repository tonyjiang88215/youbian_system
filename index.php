<?php
include_once dirname(__FILE__).'/global_inc.php';

$display = new lib_display();
$display->header->setHeader('head.tpl.php');
$display->header->setTitle('欢迎');

$display->setBody('struct/manage_system.tpl.php');
$display->addModule('top','module/top.module.php','manage_system_top.php');
$display->addModule('left','module/left.module.php','manage_system_left.php');
//主页面
$contentModule = new lib_module('index.tpl.php');
$display->addModuleObject('content',$contentModule);

$display->footer->setFooter('foot.tpl.php');
$display->render();