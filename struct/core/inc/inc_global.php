<?php
/*全局加载文件
 * 
 * @version 
 * @copyright 
 * @package 
 * @author Tony<yanglin21@yeah.net>
 */
//加载基本信息文件
include_once 'core'.DIRECTORY_SEPARATOR.'conf'.DIRECTORY_SEPARATOR.'cfg_main.php';
//加载文件夹路径文件
include_once 'core'.DIRECTORY_SEPARATOR.'conf'.DIRECTORY_SEPARATOR.'cfg_path.php';

include_once $CFG['path']['core']['conf'].DIRECTORY_SEPARATOR.'cfg_db.php';


include_once $CFG['path']['core']['inc'].DIRECTORY_SEPARATOR.'inc_lib.php';

include_once $CFG['path']['core']['inc'].DIRECTORY_SEPARATOR.'inc_mdl.php';

include_once $CFG['path']['core']['inc'].DIRECTORY_SEPARATOR.'inc_lgc.php';

include_once $CFG['path']['core']['conf'].DIRECTORY_SEPARATOR.'cfg_data.php';

include_once $CFG['path']['core']['conf'].DIRECTORY_SEPARATOR.'cfg_history.php';


