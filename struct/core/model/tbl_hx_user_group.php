<?php
class tbl_hx_user_group extends db_basic{
	protected function _define(){
		$this->tableName = 'hx_user_group';
		$this->key = 'id';
		
	}
	
	//获取所有省
	public function get_groups(){
		
		$sql = <<<SQL
		
		SELECT 
				t1.* , IFNULL(t2.member_count , 0) as member_count 
		FROM hx_user_group t1 
		LEFT JOIN (
			SELECT group_id , count(*) as member_count FROM hx_user GROUP BY group_id
		) t2 ON t1.id=t2.group_id;
				
		
SQL;
		
		$result = $this->query($sql);
		
		return $result;
	}
	
	
	//只能管理用户所在用户组的 子用户组
	public function get_groups_by_control($user_id , $offset , $step){
		$sql = <<<SQL
		
		SELECT t1.* , IFNULL(t3.member_count , 0) as member_count , t4.username FROM hx_user_group t1 
		JOIN (
				SELECT hx_user_group.ancestor_id,hx_user_group.id,hx_user_group.parent_id FROM hx_user 
			    JOIN hx_user_group ON hx_user.group_id=hx_user_group.id WHERE hx_user.id=$user_id
		) t2 ON t1.ancestor_id LIKE IF(t2.parent_id=0 , '%' , IF(LENGTH(t2.ancestor_id)>0 , concat(t2.ancestor_id ,'_' , t2.id , '%') , concat(t2.id , '%'))) 		
		LEFT JOIN (
			SELECT group_id , count(*) as member_count FROM hx_user GROUP BY group_id
		) t3 ON t1.id=t3.group_id  
	    LEFT JOIN hx_user t4 ON t1.creator_id=t4.id
		ORDER BY t1.ancestor_id ASC 
		LIMIT $offset,$step;
		
SQL;
		
		
		
		$sqlCount = <<<SQL
		
		SELECT COUNT(*) as count FROM hx_user_group t1 
		JOIN (
				SELECT hx_user_group.ancestor_id,hx_user_group.id,hx_user_group.parent_id FROM hx_user 
			    JOIN hx_user_group ON hx_user.group_id=hx_user_group.id WHERE hx_user.id=$user_id
		) t2 ON t1.ancestor_id LIKE IF(t2.parent_id=0 , '%' , IF(LENGTH(t2.ancestor_id)>0 , concat(t2.ancestor_id ,'_' , t2.id , '%') , concat(t2.id , '%')));		
		
SQL;
		
		$result = array();
		$result['data'] = $this->query($sql);
		$count = $this->query($sqlCount);
		$result['count'] = $count[0]['count'];
		
		
		return $result;
		
	}
	
	//将新用户组添加到创建用户所属组的下边
	public function add_group($group_name , $user_id){

		$querySQL = <<<SQL
		
				SELECT t2.* FROM hx_user t1 JOIN hx_user_group t2 ON t1.group_id=t2.id AND t1.id=$user_id;
		
SQL;
		
		$group_info = $this->query($querySQL);
		
		$group_info = $group_info[0];
		
		$insertArray = array(
			'name'=>$group_name,
			'level'=>intval($group_info['level'])+1,
			'parent_id'=>$group_info['id'],
			'ancestor_id'=>$group_info['ancestor_id'] ? $group_info['ancestor_id'].'_'.$group_info['id'] : $group_info['id'],
			'creator_id'=>$user_id,
			'create_time'=>time()
		);
		$result = $this->insert($insertArray);
		return $result;
	}
	
}