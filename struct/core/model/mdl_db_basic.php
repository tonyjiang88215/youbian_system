<?php
/**
 * 数据表基本操作类
 * @package model
 * @copyright 2009-11-26 
 * @author Tony<yanglin21@yeah.net>
 */
abstract class db_basic implements i_model {
	//定义表名
	protected $tableName;
	//定义主键
	protected $key;
	//是否允许select
	protected $isAllowSelect = true;
	//是否允许insert
	protected $isAllowInsert = true;
	//是否允许update
	protected $isAllowUpdate = true;
	//是否允许delete
	protected $isAllowDelete = true;
	
	protected $failedReason = '';
	
	protected $linkCFG = null;
	
	public function __construct() {
		
		$this->linkCFG = new stdClass();
		
		$this->linkCFG->host = db_config::$host;
		$this->linkCFG->user = db_config::$user;
		$this->linkCFG->password = db_config::$password;
		$this->linkCFG->dbname = db_config::$dbname;
// 		$this->linkCFG->dbname = 'juren_curriculumn';
		
		$this->_define ();
		
		factory::DB ($this->linkCFG->dbname , $this->linkCFG);
	}
	
	protected function _define() {
	
	}
	
	protected function getReason(){
		return $this->failedReason;
	}
	
	public function select($colums, $where, $limit, $order) {
		if (! $this->isAllowSelect) {
			factory::debug ( $this->tableName . '不可执行select' );
		}
		
		$sql = 'SELECT ';
		if (empty ( $colums )) {
			$sql .= '*';
		} else {
			$sql .= $colums;
		}
		
		$sql .= ' FROM ' . $this->tableName;
		
		if (! empty ( $where )) {
			$sql .= ' WHERE ' . $where;
		}
		
		if (! empty ( $order )) {
			$sql .= ' ORDER BY ' . $order;
		}
		
		if (! empty ( $limit )) {
			$sql .= ' LIMIT ' . $limit;
		}
// 		echo $sql;
		$query = factory::DB ($this->linkCFG->dbname)->query ( $sql );
		if ($query) {
			return $query->fetchAll ( PDO::FETCH_ASSOC );
		} else {
			return false;
		}
	
	}
	
	public function insert($recorderArray, $replace = false) {
		if (! $this->isAllowInsert) {
			factory::debug ( $this->tableName . '不可执行insert()' );
		}
		
		if (! $this->verify ( $recorderArray )) {
			return false;
		}
		
		if ($replace) {
			$sql = "REPLACE INTO ";
		} else {
			$sql = "INSERT INTO ";
		}
		
		$sql .= $this->tableName . "(";
		$cols = @implode ( ',', array_keys ( $recorderArray ) );
		$values = @implode ( ',', array_map ( 'string_add_quo', $recorderArray ) );
		
		$sql .= $cols . ") VALUES(" . $values . ")";
//		echo $sql;
		$query = factory::DB ($this->linkCFG->dbname)->exec ( $sql );
		if ($query) {
			return true;
		}
		
		return false;
	}
	
	//批量插入
	public function insert_batch($recorderArray , $limit = 100 , $condition = null){
		if(count($recorderArray) == 0){
			return 0;
		}
		$i = 0;
		$sql .= "INSERT INTO ";
		$sql .= $this->tableName . "(";
		$cols = @implode ( ',', array_keys ( $recorderArray[0] ) );
		$sql .= $cols .") VALUES ";
		foreach($recorderArray as $record){
			$values = @implode ( ',', array_map ( 'string_add_quo', $record ) );
			$sql .= "(" . $values . "),";
			
			if(false && $limit == $i++){
				if(!factory::DB ($this->linkCFG->dbname)->exec ( substr($sql , 0 , strlen($sql) - 1) . ($condition == null ? '' : $condition) )){
					return false;
				}
				$i = 0;
				$sql = '';
			}
		}
		/*ON DUPLICATE KEY UPDATE count=count+VALUES(count) 解释：
			当一个服务中心有多个应用服务器时，需要考虑多台服务器向数据库提交许可使用情况，
			所以如果已经提交过，则在原值上进行累加，如果不存在，则新增一条数据	
		 */
		$sql = substr($sql , 0 , strlen($sql) - 1);
		if($condition != null){
			$sql .= $condition;
		}
		$sql .= ';';
// 		echo $sql;
		if($sql != ''){
			$rs = factory::DB ($this->linkCFG->dbname)->exec ( $sql );
			if($rs !== false){
				return true;
			}else{
				return false;
			}
		}
		
		return true;
		
	}
	
	public function delete($where) {
		if (! $this->isAllowDelete) {
			factory::debug ( $this->tableName . "不可delete()" );
		}
		
		if (empty ( $where )) {
			return false;
		}
		
		$sql = "DELETE FROM " . $this->tableName . " WHERE " . $where;
		
		$query = factory::DB ($this->linkCFG->dbname)->exec ( $sql );
		
		if ($query !== false) {
			return true;
		}
		
		return false;
	}
	
	public function update($recorderArray, $key = '') {
		if (! $this->isAllowUpdate) {
			factory::debug ( $this->tableName . '不可update()' );
		}
		if (! $recorderArray [$this->key] && ! $key) {
			factory::debug ( '失败:' . $this->tableName . '执行update()失败，没有传递相应主键:' . $this->key );
		}
		
		if (! $this->verify ( $recorderArray )) {
			return false;
		}
		if (! empty ( $key )) {
			$key_value = $recorderArray [$key];
			$condition = $key;
			unset ( $recorderArray [$key] );
		} else {
			$key_value = $recorderArray [$this->key];
			$condition = $this->key;
			unset ( $recorderArray [$this->key] );
		}
		
		$sql = '';
		$sql .= "UPDATE " . $this->tableName . " SET ";
		
		foreach ( $recorderArray as $k => $value ) {
			$sql .= $k . "='" . $value . "',";
		}
		
		$sql = substr ( $sql, 0, - 1 );
		
		$sql .= " WHERE {$condition} ='{$key_value}'";
// 		echo $sql;	
		if (factory::DB ($this->linkCFG->dbname)->exec ( $sql )) {
			return true;
		}
		return false;
	}
	
	public function verify($recorderArray) {
		/*
		if (sizeof ( $this->require )) {
			foreach ( $this->require as $require ) {
				if (! isset ( $recorderArray [$require] ) || $recorderArray [$require] === '') {
					throw new Exception ( $require . "必须值没有被传递" );
					break;
				}
			}
		
		}
		*/
		return true;
	}
	
	public function findById($id) {
		$result = $this->select ( "", $this->key . "='" . $id . "'", "", "" );
		return $result [0];
	}
	
	public function findAll($order) {
		return $this->select ( '', '', '', $order );
	}
	
	public function deleteById($id) {
		return $this->delete ( $this->key . "='" . $id . "'" );
	}
	
	public function lastInsertId() {
		return factory::DB ($this->linkCFG->dbname)->lastInsertId ();
	}
	
	public function getCount($where) {
		$result = $this->select ( 'COUNT(*)', $where, null, null );
		return $result [0];
	}
	
	/*
	 * 判断时候存在相应数据
	 */
	public function recExist($query) {
		$sql = 'SELECT COUNT(*) FROM ' . $this->tableName . ' WHERE ' . $query;
		$res = factory::DB ($this->linkCFG->dbname)->query ( $sql );
		if ($res) {
			return $res->fetch ( PDO::FETCH_COLUMN ) > 0 ? true : false;
		}
		return false;
	}
	
	/**
	 * 连表查询基本方法
	 * 可变参数的连表查询，可根据不同参数 进行不同个数表的链接查询
	 * 参数1~n-1：每个表的信息为一个数组，array("表名","查询字段1","查询字段2"......"查询字段n");
	 * 参数n：作为连接查询的条件数组，
	 * array(
	 * "表1与表2的连接条件",
	 * "表1或表2与表3的连接条件"
	 * ......
	 * "表1或表2或...表n-2与表n-1的连接条件",
	 * "where"=>"where条件",
	 * "order"=>"排列条件",
	 * "limit"=>"限制条件"
	 * );
	 * @return sql语句
	 */
	public function withQueryMakerLeft() {
		$numOfTables = func_num_args () - 1;
		$tables = func_get_args ();
		$conditions = $tables [$numOfTables];
		$sql = "SELECT ";
		
		for($i = 0; $i < $numOfTables; $i ++) {
			$tableArgs = $tables [$i];
			for($j = 1; $j < count ( $tableArgs ); $j ++) {
				$sql .= $tableArgs [0] . "." . $tableArgs [$j] . ",";
			}
		}
		$sql = substr ( $sql, 0, - 1 );
		$sql .= " FROM ";
		$temp = 0;
		$sql .= $tables [$temp] [0];
		foreach ( $conditions as $key => $value ) {
			if (in_array($key,array('where','order','limit') ,true)) {
				continue;
			}
			$sql .= " LEFT JOIN " . $tables [$temp + 1] [0] . " ON " . $conditions [$key];
			$temp ++;
		}
		! is_null ( $conditions ['where'] ) && ! empty ( $conditions ['where'] ) && $sql .= " WHERE " . $conditions ['where'];
		! is_null ( $conditions ['order'] ) && ! empty ( $conditions ['order'] ) && $sql .= " ORDER BY " . $conditions ['order'];
		! is_null ( $conditions ['limit'] ) && ! empty ( $conditions ['limit'] ) && $sql .= " LIMIT " . $conditions ['limit'];
		
		$query = factory::DB ($this->linkCFG->dbname)->query ( $sql );
// 		echo $sql;
// 		exit;
		if ($query) {
			return $query->fetchAll ( PDO::FETCH_ASSOC );
		} else {
			return array();
		}
	}
	
	public function withQueryMaker() {
		$numOfTables = func_num_args () - 1;
		$tables = func_get_args ();
		$conditions = $tables [$numOfTables];
		$sql = "SELECT ";
		
		for($i = 0; $i < $numOfTables; $i ++) {
			$tableArgs = $tables [$i];
			for($j = 1; $j < count ( $tableArgs ); $j ++) {
				$sql .= $tableArgs [0] . "." . $tableArgs [$j] . ",";
			}
		}
		$sql = substr ( $sql, 0, - 1 );
		$sql .= " FROM ";
		$temp = 0;
		$sql .= $tables [$temp] [0];
		foreach ( $conditions as $key => $value ) {
			if (in_array($key,array('where','order','limit') ,true)) {
				continue;
			}
			$sql .= " JOIN " . $tables [$temp + 1] [0] . " ON " . $conditions [$key];
			$temp ++;
		}
		! is_null ( $conditions ['where'] ) && ! empty ( $conditions ['where'] ) && $sql .= " WHERE " . $conditions ['where'];
		! is_null ( $conditions ['order'] ) && ! empty ( $conditions ['order'] ) && $sql .= " ORDER BY " . $conditions ['order'];
		! is_null ( $conditions ['limit'] ) && ! empty ( $conditions ['limit'] ) && $sql .= " LIMIT " . $conditions ['limit'];
		
// 		echo $sql.'<br/>';
		
		
// 		$link = mysql_connect('192.168.1.61','huhu','123456');
// 		mysql_select_db('hx_curriculumn' , $link);
// 		$rs = mysql_query($sql , $link);
// 		$result = array();
// 		while($row = mysql_fetch_assoc($rs)){
// 			$result[] = $row;
// 		}
// 		return $result;
		
		$query = factory::DB ($this->linkCFG->dbname)->query ( $sql );
		
		if ($query) {
			return $query->fetchAll ( PDO::FETCH_ASSOC );
		} else {
			return array();
		}
	}
	
	/**
	 * 连表查询基本方法，给withQueryMaker提供查询个数
	 * 可变参数的连表查询，可根据不同参数 进行不同个数表的链接查询
	 * 参数1~n-1：每个表的信息为一个数组，array("表名","查询字段1","查询字段2"......"查询字段n");
	 * 参数n：作为连接查询的条件数组
	 * array(
	 * "表1与表2的连接条件",
	 * "表1或表2与表3的连接条件"
	 * ......
	 * "表1或表2或...表n-2与表n-1的连接条件",
	 * "where"=>"where条件"
	 * );
	 * @return sql语句
	 */
	public function withQueryMakerOfNum() {
		$numOfTables = func_num_args () - 1;
		$tables = func_get_args ();
		$conditions = $tables [$numOfTables];
		$sql = "SELECT COUNT(*) FROM ";
		$temp = 0;
		$sql .= $tables [$temp] [0];
		foreach ( $conditions as $key => $value ) {
			if (in_array($key,array('where','order','limit') ,true)) {
				continue;
			}
			$sql .= " JOIN " . $tables [$temp + 1] [0] . " ON " . $conditions [$key];
			$temp ++;
		}
		! is_null ( $conditions ['where'] ) && ! empty ( $conditions ['where'] ) && $sql .= " WHERE " . $conditions ['where'];
//		echo $sql;
		$query = factory::DB ($this->linkCFG->dbname)->query ( $sql );
		if ($query) {
			$result = $query->fetchAll ( PDO::FETCH_ASSOC );
			return $result [0] ['COUNT(*)'];
		} else {
			return false;
		}
	}
	
	public function withQueryMakerOfNumLeft() {
		$numOfTables = func_num_args () - 1;
		$tables = func_get_args ();
		$conditions = $tables [$numOfTables];
		$sql = "SELECT COUNT(*) FROM ";
		$temp = 0;
		$sql .= $tables [$temp] [0];
		foreach ( $conditions as $key => $value ) {
			if (in_array($key,array('where','order','limit') ,true)) {
				continue;
			}
			$sql .= " LEFT JOIN " . $tables [$temp + 1] [0] . " ON " . $conditions [$key];
			$temp ++;
		}
		! is_null ( $conditions ['where'] ) && ! empty ( $conditions ['where'] ) && $sql .= " WHERE " . $conditions ['where'];
//		echo $sql;
		$query = factory::DB ($this->linkCFG->dbname)->query ( $sql );
		if ($query) {
			$result = $query->fetchAll ( PDO::FETCH_ASSOC );
			return $result [0] ['COUNT(*)'];
		} else {
			return false;
		}
	}
	
	/**
	 * 查询给定条件所符合的记录条数
	 * @param $where
	 * @return unknown_type
	 */
	public function count($where) {
		if (! $this->isAllowSelect) {
			factory::debug ( $this->tableName . '不可执行select' );
		}
		
		$sql = 'SELECT  COUNT(*) ';
		
		$sql .= ' FROM ' . $this->tableName;
		
		if (! empty ( $where )) {
			$sql .= ' WHERE ' . $where;
		}
		$query = factory::DB ($this->linkCFG->dbname)->query ( $sql );
		if ($query) {
			$result = $query->fetchAll ( PDO::FETCH_ASSOC );
			return $result [0] ['COUNT(*)'];
		} else {
			return false;
		}
	}
	
	/**
	 * 扩展的query方法
	 * 支持逻辑层独特的唯一的数据库操作
	 * @param $sql
	 * @return 
	 */
	public function query($sql) {
		$result = factory::DB ($this->linkCFG->dbname)->query ( $sql );
		if ($result) {
			return $result->fetchAll ( PDO::FETCH_ASSOC );
		} else {
			return false;
		}
	}
	
	public function exec($sql){
// 		ini_set('display_errors' , 'On');
		$result = factory::DB($this->linkCFG->dbname)->exec($sql);
// 		$result->fetchAll(PDO::FETCH_ASSOC );
		return $result;
	}
	
	public function getName() {
		return $this->tableName;
	}
	
	public function switchDB($host , $user , $passwd , $dbname){
		$this->linkCFG = new stdClass();
		
		$this->linkCFG->host = $host;
		$this->linkCFG->user = $user;
		$this->linkCFG->password = $password;
		$this->linkCFG->dbname = $dbname;
		
		factory::DB ($this->linkCFG->dbname , $this->linkCFG);
		
	}

}
?>