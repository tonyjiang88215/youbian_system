<?php
	//网站名称
	global $CFG;
	$CFG['siteName']			= "";
	//网络域名
	$CFG['webRoot']			= "http://hxyoubian.hxpad.com";
	$CFG['ajaxRoot']		= $CFG['webRoot'].'/ajax';
	if(PATH_SEPARATOR==':')
	{
		$CFG['docRoot_path']        = '/data/nginx/struct';//linux下 文件夹路径
	}
	else
	{
		$CFG['docRoot_path']        = '';//windows下文件夹路径
	}
	$CFG['docRoot']['core']       	= $CFG['docRoot_path'].'/core';
	$CFG['docRoot']['errors']    	= $CFG['docRoot_path'].'/errors';
	$CFG['docRoot']['install']     	= $CFG['docRoot_path'].'/install';
	
	
	if(PATH_SEPARATOR==':')
	{
		$CFG['docRoot']['www']			= '/data/nginx/manage_system';
	}
	else
	{
		$CFG['docRoot']['www']			= '';
	}
	
// 	ini_set('display_errors' , 'On');
	
		ini_set('date_default_timezone_set' , 'PRC');
	?>