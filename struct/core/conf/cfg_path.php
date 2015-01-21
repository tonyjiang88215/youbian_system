<?php //$id cfg_path.php
	$CFG['path']['core']['conf']       				= $CFG['docRoot']['core'].'/'.'conf';
	$CFG['path']['core']['inc']       					= $CFG['docRoot']['core'].'/'.'inc';
	$CFG['path']['core']['lib']       					= $CFG['docRoot']['core'].'/'.'lib';
	
	$CFG['path']['core']['database']  			= $CFG['path']['core']['lib'].'/'.'database';
	$CFG['path']['core']['util']   						= $CFG['path']['core']['lib'].'/'.'util';
	
	$CFG['path']['core']['database']  			= $CFG['path']['core']['lib'].'/'.'database';
	$CFG['path']['core']['display']      			= $CFG['path']['core']['lib'].'/'.'display';
	$CFG['path']['core']['upload']       			= $CFG['path']['core']['lib'].'/'.'upload';
	$CFG['path']['core']['util']   						= $CFG['path']['core']['lib'].'/'.'util';
	$CFG['path']['core']['entity']   				= $CFG['path']['core']['lib'].'/'.'entity';
	$CFG['path']['core']['htmlParser']   		= $CFG['path']['core']['lib'].'/'.'htmlParser';
	
	$CFG['path']['core']['logic']       				= $CFG['docRoot']['core'].'/'.'logic';
	$CFG['path']['core']['model']       			= $CFG['docRoot']['core'].'/'.'model';
	$CFG['path']['core']['template']       		= $CFG['docRoot']['core'].'/'.'template';
	$CFG['path']['errors']    							= $CFG['docRoot_path'].'/'.'errors';
	$CFG['path']['install']     							= $CFG['docRoot_path'].'/'.'install';
	
	if(PATH_SEPARATOR==':'){
		$CFG['path']['www']								= $CFG['docRoot_path'].'/'.'html';
		$CFG['path']['core']['cache']   				= $CFG['docRoot_path'].'/'.'cache';
	}else{
		$CFG['path']['www']								= $CFG['docRoot_path'].'/'.'www';
		$CFG['path']['core']['cache']   				= $CFG['docRoot_path'].'/'.'cache';
	}
	$CFG['path']['template']							= $CFG['docRoot']['core'].'/'.'template';
	$CFG['path']['sql']										=$CFG['docRoot_path'].'/'.'sql';
?>