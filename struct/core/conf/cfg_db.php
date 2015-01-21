<?php
/**
 * 数据库连接配置类
 * @author Tony
 *
 */
class db_config{
	
    static $host = '192.168.1.61';
    static $user = 'huhu';
    static $password = '123456';
    static $dbname = 'hx_curriculumn';
    static $sourcename = 'curriculumn_source';
    static $driver = 'mysql';
    static $charset = 'utf8'; 
    static $debug = true;
    static $logerror = true; 
    
    static function logfile()
    {
    	global $CFG;
    	$logfile_path = $CFG['docRoot']['errors'] .'/'.'sqlError.txt';
    	return $logfile_path;
    }
}
?>