<?php
/**
 * 数据库处理抽象层
 * @package database
 * @uses DbCfg
 * @author 粟超
 *
 */
class db_abstract extends PDO
{
	protected $curSql;
	protected $initError = array();
	protected $cfg;
	/**
     * 
     * @param stdClass $cfg 数据库连接配置对象
     * @param $driver_options
     * @param Array $driver_options 数据库驱动选项
     */
 public function __construct($cfg,$driver_options=array())
    {
    	
    	if(!$driver_options[PDO::MYSQL_ATTR_MAX_BUFFER_SIZE]){
//     		$driver_options[PDO::MYSQL_ATTR_MAX_BUFFER_SIZE] = db_config::driver_options['buffer_size'];
    		$driver_options[PDO::MYSQL_ATTR_MAX_BUFFER_SIZE] = 10240000;
    	}
    	
        if(!$this->setCfg($cfg))
        {
        	$this->LogError(new PDOException('数据库连接配置不正确'));
        	trigger_error('db_abstract 初始化失败,数据库连接配置不正确,请检查错误日志',E_USER_ERROR);
        }
    	switch($this->cfg->driver)
        {
            case 'mysql' :
                $dsn = 'mysql:dbname=' . $this->cfg->dbname . '; host='. $this->cfg->host;
                continue;
        }
        try{
            parent::__construct($dsn, $this->cfg->user, $this->cfg->password, $driver_options);
            parent::exec("SET NAMES ".$this->cfg->charset);
        }
        catch(PDOException $e)
        {
            self::logError($e);
            return null;
        }
        return true;

     }

	/**
	 * 数据库查询
	 * @param String $sql SQL
	 * @return 成功，返回PDOStatement, 出错返回false
     */
    public function query($sql)
    {
        $this->curSql = $sql;       
        $stm = parent::query($sql);
        if(!$stm)
        {
            $errorInfo = $this->errorInfo();
            self::logError(new PDOException($errorInfo[2], $errorInfo[1]));
        }
        return $stm;
    }

 	/**
	 * 执行查询语句
	 * @param String $sql SQL
	 * @return 成功，返回影响的记录条数, 出错返回false
     */
    public function exec($sql)
    {
        $this->curSql = $sql;
        $stm = parent::exec($sql);
        if($stm === false)
        {
            $errorInfo = $this->errorInfo();
            self::logError(new PDOException($errorInfo[2], $errorInfo[1]));
        }
        return intval($stm);
    }

	public function setCfg($cfg)
	{
		if(!$cfg instanceof PDO)//判断 如果有的话 就用设置值
		{
			$tmp = new stdClass();
			$tmp->dbname = $cfg->dbname ? $cfg->dbname : db_config::$dbname;
			$tmp->host = $cfg->host ? $cfg->host :  db_config::$host;
			$tmp->user = $cfg->user ? $cfg->user : db_config::$user;
			$tmp->password = $cfg->password ? $cfg->password : db_config::$password;
			$tmp->charset = $cfg->charset ? $cfg->charset : db_config::$charset;
			$tmp->driver = $cfg->driver ? $cfg->driver : db_config::$driver;
			$cfg = $tmp;
		}
		else
		{
			$cfg=$this->isValidCfg($cfg);
			if(!$cfg)
			{
				return false;
			}
		}
		$this->cfg = new stdClass();
		foreach($cfg as $k=>$v)
		{
			$this->cfg->$k = $v;
		}
		return true;
	}
	
	 /**
     * 检查$cfg的合法性,对部分属性进行设置默认值
     * @param stdClass $cfg
     * @return mixed 正确返回$cfg对象,错误 返回false
     */
	public function isValidCfg(strClass $cfg)
	{
		$error = array();
        if(!isset($cfg->host))
        {
            $error[] = '配置主机地址未设置';
        }
        if(!isset($cfg->user))
        {
            $error[] = '配置用户名称未设置';
            
        }
        if(!isset($cfg->password))
        {
            $error[] = '配置用户密码未设置';
        } 
        if(!isset($cfg->driver))
        {
            $error[] = '配置数据库类型未设置';
        }   
		if(!isset($cfg->charset))
		{
			$cfg->charset = 'uft8';
		}
		if(!empty($error))
		{
			$this->initError = array_merge($this->initError,$error);
			return false;
		}
		else
		{
			return $cfg;
		}
		
	}
	
	
	/**
     * 记录错误日志
     * @param PDOException $e  PDO错误对象
     * @return unknown_type
     */
	 public function logError($e)
    {
        if($e instanceof PDOException)
        {
            $sql = '';
            if(!empty($this->curSql)) $sql = 'SQL: '.$this->curSql;            
            $msg =  date('Y-m-d H:i:s')."\n$sql\nErrorInfo: ".$e->getMessage()."\nTrace:\n".$e->getTraceAsString();
            $sep = "\n----------------------------------------------------\n";
            $msg .= $sep;
            if(db_config::$debug)
            {
                echo $msg;
            }
            if(db_config::$logerror)
            {
                $logFile = db_config::logfile();
                if(empty($logFile) || (!file_exists($logFile) && !file_exists(dirname($logFile)) ) )
                {
                    $logFile = 'sql_error.log';

                }
                file_put_contents($logFile, $msg, FILE_APPEND);
            }
        }
    }
    


	/**
	 * 
	 * @return array();
	 */
	public function getInitError()
	    {
	        return $this->initError;
	    }
}
?>