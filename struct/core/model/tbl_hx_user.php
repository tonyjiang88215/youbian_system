<?php
class tbl_hx_user extends db_basic{
	protected function _define(){
		$this->tableName = 'hx_user';
		$this->key = 'id';
		
	}
	
	public function login($account , $passwd){
		
		$where = 'username="'.$account.'" AND passwd="'.$passwd.'" AND disable=0';
		$result = $this->select('*' , $where , null , null);
		
		if($result !== false){
			
			$result[0]['version_info'] = $this->query_init_data($result[0]['id']);
			
		}
		
		return $result;
		
	}
	
	public function query_init_data($user_id){
		$sql = <<<SQL
		
		SELECT  t3.id , t3.name , t3.extends FROM hx_user t1 
		JOIN hx_workset_version t2 ON t1.workset_id=t2.workset_id AND t1.id=$user_id AND t2.privilege=3 
		JOIN edu_curriculumn_version t3 ON t2.version_id=t3.id ;
		
SQL;
		
		$result = $this->query($sql);
		return $result;
		
	}
	
	//获取所有用户
	public function get_users($offset , $step){
		
		$tblUser = array(
			'hx_user',
			'*'
		);
		
		$tblUserGroup = array(
			'hx_user_group',
			'name as group_name'
		);
		
		$tblUserWorkSet = array(
			'hx_workset',
			'name as workset_name'
		);
		
		$tblCondition = array(
			'hx_user.group_id=hx_user_group.id',
			'hx_user.workset_id=hx_workset.id',
			'limit' => $offset . ' , ' . $step
		);
		
		$result = array();
		$result['data'] = $this->withQueryMakerLeft($tblUser , $tblUserGroup , $tblUserWorkSet , $tblCondition);
		$result['count'] = $this->withQueryMakerOfNumLeft($tblUser , $tblUserGroup , $tblUserWorkSet , $tblCondition);
		return $result;
	}
	
	//根据user_id ，查询可以管理的用户列表
	public function get_users_by_control($user_id , $role_id , $workset_id, $offset , $step){
		$where = 't1.id!='.$user_id;
// 		echo $role_id .' _ '.$workset_id;
		if($role_id){
			$where .= ' AND t1.role_id='.$role_id;
		}
		
		if($workset_id){
			$where .= ' AND t1.workset_id='.$workset_id;
		}
		
		$sql = <<<SQL
		
				SELECT t1.* , t2.name as workset_name , t4.name as role_name FROM hx_user t1 JOIN hx_workset t2 ON t1.workset_id=t2.id 
				JOIN (
					SELECT hx_workset.ancestor_id,hx_workset.id FROM hx_user 
				    JOIN hx_workset ON hx_user.workset_id=hx_workset.id WHERE hx_user.id=$user_id) t3 
	    		ON t2.ancestor_id LIKE IF(length(t3.ancestor_id)>0 ,concat(t3.ancestor_id , '_' , t3.id , '%') , '%')   
	    		LEFT JOIN hx_user_role t4 ON t1.role_id=t4.id 
	    		WHERE $where  
				LIMIT $offset , $step
		
SQL;
// 		echo $sql;
// 		exit;
		/*
		 
		  SELECT t1.* , t2.name as workset_name , t4.name as role_name FROM hx_user t1 JOIN hx_workset t2 ON t1.workset_id=t2.id 
				LEFT JOIN (
					SELECT hx_workset.ancestor_id,hx_workset.id FROM hx_user 
				    JOIN hx_workset ON hx_user.workset_id=hx_workset.id WHERE hx_user.id=$user_id) t3 
	    		ON t2.ancestor_id LIKE IF(LENGTH(t3.ancestor_id)>0 , concat(t3.ancestor_id ,'_' , t3.id , '%') , concat(t3.id,'%')) 
	    		LEFT JOIN hx_user_role t4 ON t1.role_id=t4.id 
				LIMIT $offset , $step
		
		 * */
		
		$sqlCount = <<<SQL
				SELECT COUNT(*) as count FROM hx_user t1 JOIN hx_workset t2 ON t1.workset_id=t2.id 
				JOIN (
					SELECT hx_workset.ancestor_id,hx_workset.id FROM hx_user 
				    JOIN hx_workset ON hx_user.workset_id=hx_workset.id WHERE hx_user.id=$user_id) t3 
	    		ON t2.ancestor_id LIKE IF(length(t3.ancestor_id)>0 ,concat(t3.ancestor_id , '_' , t3.id , '%') , '%')       
				WHERE $where 
		
SQL;
		
		$result = array();
		$result['data'] = $this->query($sql);
		$count = $this->query($sqlCount);
		$result['count'] = $count[0]['count'];
		return $result;
		
	}
	
	public function add_user($username , $realname , $passwd , $role , $workset , $user_id){
		
		$insertArray = array(
			'username' => $username ,
			'realname' => $realname , 
			'passwd' => $passwd,
			'role_id' => $role,
			'workset_id'=>$workset,
			'create_time' => time(),
			'creator_id' => $user_id
		);
		
		$result = $this->insert($insertArray);
		return $result;
		
	}
	
	//获取当前用户所在工作组的父工作组
	public function get_user_workset_parent($user_id){
		$sql = <<<SQL
				SELECT  t1.parent_id FROM hx_workset t1 JOIN hx_user t2 ON t2.workset_id=t1.id
SQL;
		
		$result = $this->query($sql);
		if($result){
			return $result[0]['parent_id'];
		}else{
			return false;
		}
		
	}
	
}