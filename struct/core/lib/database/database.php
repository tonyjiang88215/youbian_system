<?php
/**
 * 数据库处理类
 * @uses db_abstract 
 * @author 粟超
 *
 */

class database{
    protected static $db;    
    protected static $error = array();
    protected static $links = array();
    private function __construct()
    {
    }
    
     /**
     * 获取一个db_abstract实例.
     * 
     * @param stdClass $cfg 数据库连接配置,将直接传给db_abstract. 当$cfg不为空，而且为合法的配置对象时,新建一个PDO对象，否则返回当前PDO对象
     *        如果$cfg为空则将使用系统配置Cfg;如果$cfg的配置错误 将返回NULL
     * @param  array $driver_options 数据库驱动选项
     * @return db_abstract
     */
    public static function getDb($cfg = null,$driver_options=array())
    {   
        $hasInst = false;
        foreach(self::$links as $l)
        {
            if($l['cfg'] == $cfg)
            {
                $hasInst = true;
                return $l['link'];
            }
        }       
        if(!$hasInst)
        {
            return self::createDbObj($cfg,$driver_options);
        }               
    }
    
     /**
     * 创建一个PDO对象
     * @param stdClass $cfg 数据库连接配置对象 
     * @param array $driver_options 数据库驱动选项
     * @return db_abstract
     */
    protected static function createDbObj($cfg,$driver_options)
    {
        require_once('db_abstract.php');
        $link = new db_abstract($cfg,$driver_options);
        $link->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        
        self::$links[] = array('cfg'=>$cfg,'link'=>$link);  
        return $link; 
    }
}