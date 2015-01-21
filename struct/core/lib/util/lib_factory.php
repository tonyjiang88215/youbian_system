<?php
/*
 * S8S 工厂类.可获取各类实例;或实现某些基本方法
 * 
 * 
 */
class factory
{
	private static $DB = array();
	private static $cache = false;
	private static $memcache = false;
	private static $instance = false;
	private static $user = false;
	private static $webuser = false;
	private static $encrypt = false;
	
	protected static $error = '';
	protected $members = array();
	//定义数据操作对象
	private static $MODELS = array();
	//定义视图操作对象
	private static $VIEWS = array();

	private function __construct(){
		
	}
	/** 获取一个S8S单例
	 * 
	 */
	public function GetInstance(){
		if(!self::$instance)
		{
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	 /**
     * 获取一个PDO实例.
     * 
     * @param stdClass $cfg 数据库连接配置,将直接传给Db_Abstract. 当$cfg不为空，而且为合法的配置对象时,新建一个PDO对象，否则返回当前PDO对象
     *        如果$cfg为空则将使用系统配置Cfg;如果$cfg的配置错误 将返回NULL
     * @param  array $driverOptions 数据库驱动选项
     * @return Db_Abstract
     */	
	public static function DB($name , $cfg=null,$driverOptions=array()){
		if(! self::$DB[$name] instanceof Db_Abstract)
		{			
			self::$DB[$name] = Database::getDb($cfg,$driverOptions);			
		}
		return self::$DB[$name];
	}
	
	public static function cache(){
		
	}
	
	public static function debug($error){
		if( $error instanceof Exception ){
			$output = $error->__toString();
		}else{
			$output = $error;
		}
		if(true){
		     die('<center>		   '.$output.'		    </center>');
		}else{
			die('系统运行错误!');
		}
	}
	
	public function lastError(){
	    return self::$error;
	}
	
	/**
	 * 根据不同需求，获取到不同的数据操作对象
	 * 数据库操作类类名
	 * @param $modelName (source_base,comment,notice)
	 * @return 
	 */
	public static function getModel($modelName){
		$className = 'tbl_'.$modelName;
		if(!self::$MODELS[$modelName] instanceof $className){
			self::$MODELS[$modelName] = new $className();
		}
		return self::$MODELS[$modelName];
	}
	
	/**
	 * 根据不同需求，获取到不同的视图操作对象
	 * 数据库操作类类名
	 * @param $viewName (post_collect)
	 * @return 
	 */
	public static function getDBView($viewName){
		$className = $viewName;
		if(!self::$VIEWS[$viewName] instanceof $className){
			self::$VIEWS[$viewName] = new $className();
		}
		return self::$VIEWS[$viewName];
	}
	
	/**
	 * 获取memcache对象
	 * @return 
	 */
	public static function getMemcache(){
		if(!self::$memcache instanceof Memcache){
			self::$memcache = new Memcache();
			self::$memcache->connect('192.168.1.103',11211);
		}
		return self::$memcache;
	}
	
	/**
	 * 获取加密对象
	 * @return unknown_type
	 */
	public static function getEncrypt(){
		if(!self::$encrypt instanceof Encrypt3des){
			self::$encrypt = new Encrypt3des();
		}
		return self::$encrypt;
	}
	
//	public static function getUser($type){
//		if($type == 'person'){
//			if(!self::$user instanceof user){
//				self::$user = new user();
//			}
//			return self::$user;
//		}else if($type == 'web'){
//			if(!self::$webuser instanceof webuser){
//				self::$webuser = new webuser();
//			}
//			return self::$webuser;
//		}else{
//			return false;
//		}
//	}
	
	

}
?>