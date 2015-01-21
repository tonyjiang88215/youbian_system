<?php
class tbl_hx_user_role extends db_basic{
	protected function _define(){
		$this->tableName = 'hx_user_role';
		$this->key = 'id';
		
	}
	
	//获取所有角色
	public function get_roles($offset , $step){
		
		$limit = $offset .',' . $step;
		
		$result = array();
		$result['data'] = $this->select(null , null , $limit , null);
		$result['count'] = $this->count(null);
		return $result;
	}
	
	public function get_roles_for_search(){
		$result = $this->select(null , null , null , null);
		return $result;
	}
	
	public function get_roles_by_control($user_id , $offset , $step){
		$dataSQL =<<<SQL
		
		  SELECT t4.* FROM hx_user t1 JOIN hx_user_role t2 ON t1.role_id=t2.id AND t1.id=$user_id 
        	JOIN hx_user_role_create_privilege t3 ON t2.id=t3.role_id 
        	JOIN hx_user_role t4 ON t3.create_role_id=t4.id;
        
SQL;
		
		$countSQL = <<<SQL
		SELECT COUNT(*) as count FROM hx_user t1 JOIN hx_user_role t2 ON t1.role_id=t2.id AND t1.id=$user_id 
        	JOIN hx_user_role_create_privilege t3 ON t2.id=t3.role_id 
        	JOIN hx_user_role t4 ON t3.create_role_id=t4.id;
SQL;
		
		
		$result = array();
		$result['data'] = $this->query($dataSQL);
		$count = $this->query($countSQL);
		
		$result['count'] = $count[0]['count'];
		
		return $result;
		
		
	}
	
	
	//将新用户组添加到创建用户所属组的下边
	public function add_role($role_name){

		$insertArray = array(
			'name'=>$role_name
		);
		
		$result = $this->insert($insertArray);
		return $result;
	}
	
}