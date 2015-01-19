<?php
include_once dirname(dirname(__FILE__)).'/inc.php';

$action = $_GET['action'];

$callback = $_GET['callback'];

$userInfo = json_decode($_SESSION['user_info'] , true);

$dbname = db_config::$sourcename .'_'. $_SESSION['select_version']['extends'];

db_config::$dbname = $dbname;

switch($action){
	
	case 'detail_list':
		
		$source_type = $_GET['source_type'];
		
		switch($source_type){
			case $History['type']['tongbu']:
				
				$result = factory::getModel('base_version_history')->get_history_list_tongbu();
				
				break;
				
			case $History['type']['knowledge']:
			
				$result = factory::getModel('base_version_history')->get_history_list_knowledge();
				break;
				
			case $History['type']['zhuanti']:
				$result = factory::getModel('base_version_history')->get_history_list_zhuanti();
				break;
				
			case $History['type']['exam']:
			
				break;
		}
		
		
		
		
		break;
	
} 

echo $callback.'('.json_encode($result).')';