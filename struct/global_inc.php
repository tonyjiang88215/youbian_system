<?php

if(PATH_SEPARATOR==':')
{
    ini_set('include_path' , ini_get('include_path') . dirname(__FILE__));
//	ini_set('include_path','.:/var/www/phplib/share/pear:/data/nginx/struct');//linux
}
else
{
//	ini_set('include_path','.;c:\php\includes;d:\\appserv\\s8sserver');//windows下文件夹路径
}
include_once 'core'.DIRECTORY_SEPARATOR.'inc'.DIRECTORY_SEPARATOR.'inc_global.php';

session_start();

?>