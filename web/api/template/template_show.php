<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$display = new lib_display();
$display->header->setHeader('head.tpl.php');


$display->setBody('struct/manage_system.tpl.php');

$contentModule = new lib_module('module/source/question_list.module.php');

$JSCode = <<<JSCODE
$(document).ready(function(){
	$('.top , .nav').hide();

	$('#question_template').show();
});
JSCODE;

$contentModule->addJavaScriptCode($JSCode);

$display->addModuleObject('content',$contentModule);



$display->footer->setFooter('foot.tpl.php');

$display->render();
