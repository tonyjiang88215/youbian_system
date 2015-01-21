<?php
//数据库处理类
require_once $CFG['path']['core']['database'].DIRECTORY_SEPARATOR.'database.php';
//数据库处理抽象层
require_once $CFG['path']['core']['database'].DIRECTORY_SEPARATOR.'db_abstract.php';
//基本类库加载
require_once $CFG['path']['core']['util'] .DIRECTORY_SEPARATOR.'lib_factory.php';

//模版应用类
require_once $CFG['path']['core']['display'].DIRECTORY_SEPARATOR.'interface'.DIRECTORY_SEPARATOR.'i_display.php';
require_once $CFG['path']['core']['display'].DIRECTORY_SEPARATOR.'lib_template.php';
require_once $CFG['path']['core']['display'].DIRECTORY_SEPARATOR.'lib_display_setting.php';
require_once $CFG['path']['core']['display'].DIRECTORY_SEPARATOR.'lib_header.php';
require_once $CFG['path']['core']['display'].DIRECTORY_SEPARATOR.'lib_footer.php';
require_once $CFG['path']['core']['display'].DIRECTORY_SEPARATOR.'lib_body.php';
require_once $CFG['path']['core']['display'].DIRECTORY_SEPARATOR.'lib_display.php';
//3DES加密
include_once $CFG['path']['core']['lib']. DIRECTORY_SEPARATOR .'3des'.DIRECTORY_SEPARATOR.'Encrypt3des.php';


//引入OFC类库
include_once $CFG['path']['core']['lib'] .DIRECTORY_SEPARATOR.'ofc'.DIRECTORY_SEPARATOR.'chart_maker.php';

require_once $CFG['path']['core']['lib'].DIRECTORY_SEPARATOR.'entity'.DIRECTORY_SEPARATOR.'tree.php';

//数据库处理类
//数据库处理抽象层
//模版应用类

//文件上传
//require_once $CFG['path']['core']['lib'] .DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'Upload.php';
//require_once $CFG['path']['core']['util'].DIRECTORY_SEPARATOR.'lib_s8s_header.php';//s8s文件上传
//基本类库加载
require_once $CFG['path']['core']['util'] .DIRECTORY_SEPARATOR.'lib_init.php';
require_once $CFG['path']['core']['util'] .DIRECTORY_SEPARATOR.'lib_page_tool_bar.php';
require_once $CFG['path']['core']['util'] .DIRECTORY_SEPARATOR.'lib_pager.php';
require_once $CFG['path']['core']['util'] .DIRECTORY_SEPARATOR.'lib_tree_handler.php';
//缓存
require_once $CFG['path']['core']['lib'] .DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'file_cache.php';

//对象数据类型库加载
require_once $CFG['path']['core']['entity'] .DIRECTORY_SEPARATOR.'tree.php';
//加载html解析器
require_once $CFG['path']['core']['htmlParser'] .DIRECTORY_SEPARATOR.'simple_html_dom.php';

require_once $CFG['path']['core']['lib'] .DIRECTORY_SEPARATOR.'opensource'.DIRECTORY_SEPARATOR.'xml2json.php';
