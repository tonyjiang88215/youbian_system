<?php
/*初始化文件
 * 
 */

/** 错误代码：用户为0*,资源为1*,系统为2*      */
$errorCode = array('0'=>'',);
/**
 * 调试模式
 *
 * @return bool
 */
function s8s_debug(){
	if(defined('S8S_DEBUG_MODE') && S8S_DEBUG_MODE)
	return true;
	return false;
}

/**
 * 获取文件目录
 * @param $pathKey
 */
function s8s_get_path($pathKey){
	global $CFG;
	$pathList = $CFG['path'];
	
	if( array_key_exists($pathKey,$pathList)){
		return $pathList[$pathKey];
	}else{
	}
}
/**
 * 一次引用多个库文件
 */
function require_models(){
	$args = func_get_args();
	
	$includes = s8s_get_path('model') . '/';
	
	foreach($args as $mode){
		if (substr($mode,-4) != '.php'){
			$model .= '.php';
		}
		
		$filePath = $includes . $mode;
		
		if(file_exists($filePath)){
			require_once $filePath;
		}else{
			factory::debug('找不到对应model文件 ' . $filePath);
		}
	}
}

///*
// * 字符过滤
// */
//function addslashes($param)
//{
//	$result = $param;
//	if(!get_magic_quotes_gpc()){
//		if (!is_array($param))
//		{
//			$result = addslashes($param);
//		}
//	}	
//	return $result;
//}

/*
 * 延迟跳转
 * @param $s 延迟时间
 * @param $url 跳转路径
 */
function s8s_jumper($s,$url)
{
	echo '<meta content="text/html;charset=utf-8" http-equiv="content-type">';
	echo "<meta http-equiv=\"refresh\" content=\"$s;url=".$url."\">\n";
	
}

/**
 * 添加分割
 * @param $str
 * @return unknown_type
 */
function string_add_quo($str)
{
	return '\'' . $str . '\'';
}

/**
 * 二维数组排序
 * @param $multi_array 需要排序的数组
 * @param $sort_key  排序的key
 * @param $sort 排序顺序  SORT_ASC , SORT_DESC
 * @return array or false
 */
function multi_array_sort($multi_array,$sort_key,$sort=SORT_ASC){  
	$key_array = array();
    if(is_array($multi_array)){  
        foreach ($multi_array as $row_array){  
            if(is_array($row_array)){  
                $key_array[] = $row_array[$sort_key];  
            }else{  
                return false;  
            }  
        }  
    }else{  
        return false;  
    }  
    array_multisort($key_array,$sort,$multi_array);  
    return $multi_array;  
} 

/**
 * 求目标时间距现在的差值(例:5秒前，10分钟前)
 * @param $lastTime 时间，以秒为单位
 * @return unknown_type
 */
function time_show_differ($lastTime){
	$nowTime = time();
	strlen($lastTime)>strlen($nowTime) && $lastTime = $lastTime/1000;
	if($nowTime - $lastTime < 60*60*24*30){
		$differ = $nowTime - $lastTime;
		$month = intval($differ/(60*60*24*30));
		$day = intval($differ/(60*60*24));
		$hour = intval($differ/(60*60));
		$minute = intval($differ/60);
		$second = intval($differ);
		$result = $month==0?$day==0?$hour==0?$minute==0?$second.'秒前':$minute.'分钟前':$hour.'小时前':$day.'天前':$month.'个月前';
	}else{
		$result = date('Y-m-d',$lastTime);
	}
	return $result;
}

function getCurrentURL(){
	return 'http://'.$_SERVER['SERVER_NAME']. $_SERVER['REQUEST_URI'];
}

function modifyCurrentURLByDeleteParam($param){
	$currentURL = getCurrentURL();
	$currentURLArray = explode('?', $currentURL);
	$currentURLParamArray = explode('&', $currentURLArray[1]);
	foreach($currentURLParamArray as $key => $value){
		if(strpos($value,$param) !== false){
			unset($currentURLParamArray[$key]);
		}
	};
	$currentURLArray[1] = implode('&',$currentURLParamArray);
	$url = implode('?', $currentURLArray);
	return $url;
}

function shortURL($originURL , $iGroup = 0){
	$aBase62 = array ( 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5' , '6', '7', '8', '9' );

	$sHex = md5( $originURL );
	$sHexLen = strlen( $sHex );
	$subHexLen = $sHexLen/8;
	$aOutput = array();

	for ( $i = 0; $i < $subHexLen; $i++ ) {
		$subHex = substr( $sHex, $i * 8, 8 );
		$int = 0x3FFFFFFF & ( 1*( '0x' . $subHex ) );
		$out = '';

		for ( $j = 0; $j < 6; $j++ ) {
			$val = 0x0000003D & $int;
			$out .= $aBase62[$val];
			$int = $int >> 5;
		}
		$aOutput[] = $out;
	}

	return $aOutput[$iGroup];
}

function create_guid() {
	$charid = strtoupper(md5(uniqid(mt_rand(), true)));
	$hyphen = chr(45);// "-"
//	$uuid = chr(123)// "{"
	$uuid = substr($charid, 0, 8).$hyphen
	.substr($charid, 8, 4).$hyphen
	.substr($charid,12, 4).$hyphen
	.substr($charid,16, 4).$hyphen
	.substr($charid,20,12);
//	.chr(125);// "}"
	return $uuid;
}

function getip(){
	if($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]){
	$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
	}
	elseif($HTTP_SERVER_VARS["HTTP_CLIENT_IP"]){
	$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
	}
	elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"]){
	$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
	}
	elseif (getenv("HTTP_X_FORWARDED_FOR")){
	$ip = getenv("HTTP_X_FORWARDED_FOR");
	}
	elseif (getenv("HTTP_CLIENT_IP")){
	$ip = getenv("HTTP_CLIENT_IP");
	}
	elseif (getenv("REMOTE_ADDR")){
	$ip = getenv("REMOTE_ADDR");
	}
	else{
	$ip = "Unknown";
	}
	return  $ip;
}

/**
 * 创建文件夹
 * @param $fpath
 */
function cmk($fpath){
	$dir = explode('/',$fpath);
	$dirs = array();
	foreach($dir as $key => $val){
		$dirs[] = $val;
		$inpath = implode('/',$dirs);
		if(!is_dir($inpath) && $inpath){
			if(false == mkdir($inpath)){
				return false;
			}
		}
	} 
	return $path;
}
/**
 * object to array 
 */
	function std_class_object_to_array($stdclassobject)
	{
	    $_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;
	
	    foreach ($_array as $key => $value) {
	        $value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
	        $array[$key] = $value;
	    }
	
	    return $array;
	}
?>