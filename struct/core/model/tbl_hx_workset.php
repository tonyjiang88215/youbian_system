<?php
class tbl_hx_workset extends db_basic{
	protected function _define(){
		$this->tableName = 'hx_workset';
		$this->key = 'id';
		
	}
	
	//获取所有省
	public function get_worksets(){
		
	$sql = <<<SQL
		
		SELECT 
				t1.* , IFNULL(t2.member_count , 0) as member_count 
		FROM hx_workset t1 
		LEFT JOIN (
			SELECT workset_id , count(*) as member_count FROM hx_user GROUP BY workset_id
		) t2 ON t1.id=t2.workset_id;
				
		
SQL;
		
		$result = $this->query($sql);
		
		return $result;
	}
	
	//根据用户ID查询有权限的工作组，如果是管理员，查询所有的，如果不是查询当前组所创建的
	public function get_worksets_by_control($user_id){
		$sql = <<<SQL
		
		SELECT t1.* , IFNULL(t3.member_count , 0) as member_count , t4.username  FROM hx_workset t1  
		JOIN (
				SELECT hx_workset.ancestor_id,hx_workset.id,hx_workset.parent_id FROM hx_user 
			    JOIN hx_workset ON hx_user.workset_id=hx_workset.id WHERE hx_user.id=$user_id
		) t2 ON t1.ancestor_id LIKE IF(t2.parent_id=0 , '%' , concat(t2.ancestor_id ,'_' , t2.id , '%') ) 	
	    LEFT JOIN (
			SELECT workset_id , count(*) as member_count FROM hx_user GROUP BY workset_id
		) t3 ON t1.id=t3.workset_id
		LEFT JOIN hx_user t4 ON t1.creator_id=t4.id ;
		
SQL;
		
		/*
		 
		 SELECT t1.* , IFNULL(t3.member_count , 0) as member_count , t4.username  FROM hx_workset t1  
		JOIN (
				SELECT hx_workset.ancestor_id,hx_workset.id,hx_workset.parent_id FROM hx_user 
			    JOIN hx_workset ON hx_user.workset_id=hx_workset.id WHERE hx_user.id=$user_id
		) t2 ON t1.ancestor_id LIKE IF(t2.parent_id=0 , '%' , IF(LENGTH(t2.ancestor_id)>0 , concat(t2.ancestor_id ,'_' , t2.id , '%') , concat(t2.id , '%'))) 	
		
		) t2 ON t1.ancestor_id LIKE IF(t2.parent_id=0 , '%' , concat(t2.ancestor_id , '%') ) 	
		
	    LEFT JOIN (
			SELECT workset_id , count(*) as member_count FROM hx_user GROUP BY workset_id
		) t3 ON t1.id=t3.workset_id
		LEFT JOIN hx_user t4 ON t1.creator_id=t4.id 
		LIMIT $offset,$step;
		
		 
		 
		 * 
		 */
		
		$sqlCount = <<<SQL
		
		SELECT COUNT(*) as count FROM hx_workset t1  
		JOIN (
				SELECT hx_workset.ancestor_id,hx_workset.id,hx_workset.parent_id FROM hx_user 
			    JOIN hx_workset ON hx_user.workset_id=hx_workset.id WHERE hx_user.id=$user_id
		) t2 ON t1.ancestor_id LIKE IF(t2.parent_id=0 , '%' , concat(t2.ancestor_id ,'_' , t2.id , '%') ) 	
		
SQL;
		
		$result = array();
		$result['data'] = $this->query($sql);
		$count = $this->query($sqlCount);
		$result['count'] = $count[0]['count'];
		return $result;
		
	}
	
	//根据用户ID查询有权限直接子工作组
	public function get_worksets_by_control_direct($user_id , $offset , $step){
		$sql = <<<SQL
	
		SELECT t1.* , IFNULL(t3.member_count , 0) as member_count , t4.username  FROM hx_workset t1
		JOIN (
				SELECT hx_workset.ancestor_id,hx_workset.id,hx_workset.parent_id FROM hx_user
			    JOIN hx_workset ON hx_user.workset_id=hx_workset.id WHERE hx_user.id=$user_id
		) t2 ON t1.parent_id=t2.id
	    LEFT JOIN (
			SELECT workset_id , count(*) as member_count FROM hx_user GROUP BY workset_id
		) t3 ON t1.id=t3.workset_id
		LEFT JOIN hx_user t4 ON t1.creator_id=t4.id
		LIMIT $offset,$step;
	
SQL;
	
		/*
			
			 SELECT t1.* , IFNULL(t3.member_count , 0) as member_count , t4.username  FROM hx_workset t1
		JOIN (
				SELECT hx_workset.ancestor_id,hx_workset.id,hx_workset.parent_id FROM hx_user
				JOIN hx_workset ON hx_user.workset_id=hx_workset.id WHERE hx_user.id=$user_id
		) t2 ON t1.ancestor_id LIKE IF(t2.parent_id=0 , '%' , IF(LENGTH(t2.ancestor_id)>0 , concat(t2.ancestor_id ,'_' , t2.id , '%') , concat(t2.id , '%')))
	
		) t2 ON t1.ancestor_id LIKE IF(t2.parent_id=0 , '%' , concat(t2.ancestor_id , '%') )
	
		LEFT JOIN (
				SELECT workset_id , count(*) as member_count FROM hx_user GROUP BY workset_id
		) t3 ON t1.id=t3.workset_id
		LEFT JOIN hx_user t4 ON t1.creator_id=t4.id
		LIMIT $offset,$step;
	
			
			
		*
		*/
	
		$sqlCount = <<<SQL
	
		SELECT COUNT(*) as count FROM hx_workset t1
		JOIN (
				SELECT hx_workset.ancestor_id,hx_workset.id,hx_workset.parent_id FROM hx_user
			    JOIN hx_workset ON hx_user.workset_id=hx_workset.id WHERE hx_user.id=$user_id
		) t2 ON t1.parent_id=t2.id
	
SQL;
	
		$result = array();
		$result['data'] = $this->query($sql);
		$count = $this->query($sqlCount);
		$result['count'] = $count[0]['count'];
		return $result;
	
	}
	
	public function add_workset($name , $level , $parent_id){
		$insertArray = array(
				'name'=>$name , 
				'level'=>$level , 
				'parent_id'=>$parent_id , 
				'create_time'=>time() , 
				'creator_id'=>1
		);
		
		$result = $this->insert($insertArray);
		
		return $result;
		
	}
	
	public function add_workset_by_control($name , $user_id){
		$querySQL = <<<SQL
		
				SELECT t1.* FROM hx_workset t1 JOIN hx_user t2 ON t1.id=t2.workset_id AND t2.id=$user_id;
		
SQL;
		
		$parent_info = $this->query($querySQL);
		
		$parent_info = $parent_info[0];
		
		$insertArray = array(
				'name'=>$name , 
				'level'=>intval($parent_info['level'])+1 , 
				'parent_id'=> $parent_info['id'] ,  
				'ancestor_id'=>$parent_info['ancestor_id'] ? $parent_info['ancestor_id'].'_'.$parent_info['id'] : $parent_info['id'],
				'create_time'=>time() , 
				'creator_id'=>$user_id 
		);
		
		$result = $this->insert($insertArray);
		
		return $result;
		
	}
	
}