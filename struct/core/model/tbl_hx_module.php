<?php
class tbl_hx_module extends db_basic{
	protected function _define(){
		$this->tableName = 'hx_module';
		$this->key = 'id';
		
	}
	
	//获取所有省
	public function get_modules(){
		$where = 'visible=1';
		$order = 'level ASC , idx ASC';
		$result = $this->select( null , $where , null , $order);
		return $result;
	}
	
	public function get_modules_by_control($user_id){
		
		$sqlGroup = <<<SQL
		
				SELECT module_id , privilege FROM hx_user_role_privilege t1 JOIN hx_user t2 ON t1.role_id=t2.role_id AND t2.id=$user_id
		
SQL;
		
		$groupPrivilege = $this->query($sqlGroup);
		
		$sqlUser = <<<SQL
				
				SELECT module_id , privilege FROM hx_user_privilege WHERE user_id=$user_id;
		
SQL;
		
		$userPrivilege = $this->query($sqlUser);
		
		$_modules = array();
		
		foreach($groupPrivilege as $p){
			$_modules[$p['module_id']] = $p['privilege'];
		}
		
		foreach($userPrivilege as $p){
			$_modules[$p['module_id']] = $p['privilege'];
		}
		
		$allowModules = array();
		
		foreach($_modules as $k => $p){
			if($p > 0){
				$allowModules[] = $k;
			}
		}
		
		$where = 'visible=1 AND id IN ('.implode(',', $allowModules).')';
		
		$order = 'level ASC , idx  ASC';
		$result = $this->select( null , $where , null , $order);
		return $result;
		
	}
}