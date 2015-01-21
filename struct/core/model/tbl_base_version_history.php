<?php
class tbl_base_version_history extends db_basic{
	protected function _define(){
		$this->tableName = 'base_version_history';
		$this->key = 'id';

	}

	//
	public function insert_history($source_type , $entity_type , $subject_id , $section_id , $action_id , $element_id , $user_id , $old_value = null , $new_value = null , $comment = null){
		$insertArray = array(
			'source_type'=>$source_type ,
			'entity_type' =>$entity_type , 
			'subject_id'   =>$subject_id , 
			'section_id'    =>$section_id , 
			'action_id'      =>$action_id ,
			'element_id'   =>$element_id,
			'user_id'			=>$user_id,
			'create_time'				=>time(),
			'old_value'		=>$old_value,
			'new_value'		=>$new_value,
			'note'		=>$comment
		);
		
		$result = $this->insert($insertArray);
		return $result;
	}
	
	public function get_history_list(){
		global $History;
		
		$result = array();
		
		foreach($History['type'] as $label => $type){
			$sql = <<<SQL
			
			SELECT t1.*, 
			t5.username , 	t4.name as type_name , t2.name as action_name , t3.name as entity_name , t1.note , t1.old_value , t1.new_value 
			FROM base_version_history t1 
			JOIN base_history_action t2 ON t1.action_id=t2.id 
			JOIN edu_entity_type t3 ON t1.entity_type=t3.id 
			JOIN edu_source_type t4 ON t1.source_type=t4.id
			JOIN hx_curriculumn.hx_user t5 ON t1.user_id=t5.id
			WHERE t1.source_type=$type;
			
SQL;
			
			$result[$type] = $this->query($sql);
		}
		
		
		return $result;
	}
	
	
	//先显示导入和导出的
	public function get_history_list_tongbu(){
		
		global $History;
		
		$type = $History['type']['tongbu'];
		
		$sql = <<<SQL
		
		SELECT t1.* ,
		t5.username ,	t4.name as type_name , t2.name as action_name , t3.name as entity , 
		t1.note , t1.old_value , t1.new_value , t6.book_name as entity_name
		FROM base_version_history t1
		JOIN base_history_action t2 ON t1.action_id=t2.id
		JOIN edu_entity_type t3 ON t1.entity_type=t3.id
		JOIN edu_source_type t4 ON t1.source_type=t4.id
		JOIN hx_curriculumn.hx_user t5 ON t1.user_id=t5.id
		JOIN edu_total_book t6 ON t1.element_id=t6.id AND t1.entity_type=10 
		WHERE t1.action_id IN (1,5) AND t1.source_type=$type;
		
SQL;
		
		$result = $this->query($sql);
		return $result;
		
	}
	
	public function get_history_list_knowledge(){
		
		global $History;
		
		$type = $History['type']['knowledge'];
		
		$sql = <<<SQL
		
		SELECT t1.* ,
		t5.username ,	t4.name as type_name , t2.name as action_name , t3.name as entity ,
		t1.note , t1.old_value , t1.new_value 
		FROM base_version_history t1
		JOIN base_history_action t2 ON t1.action_id=t2.id
		JOIN edu_entity_type t3 ON t1.entity_type=t3.id
		JOIN edu_source_type t4 ON t1.source_type=t4.id
		JOIN hx_curriculumn.hx_user t5 ON t1.user_id=t5.id
		WHERE t1.action_id IN (1,5) AND t1.source_type=$type;
		
SQL;
		
		$result = $this->query($sql);
		return $result;
		
	}
	
	public function get_history_list_zhuanti(){
		global $History;
		
		$type = $History['type']['zhuanti'];
		
		$sql = <<<SQL
		
		SELECT t1.* ,
		t5.username ,	t4.name as type_name , t2.name as action_name , t3.name as entity ,
		t1.note , t1.old_value , t1.new_value
		FROM base_version_history t1
		JOIN base_history_action t2 ON t1.action_id=t2.id
		JOIN edu_entity_type t3 ON t1.entity_type=t3.id
		JOIN edu_source_type t4 ON t1.source_type=t4.id
		JOIN hx_curriculumn.hx_user t5 ON t1.user_id=t5.id
		WHERE t1.action_id IN (1,5) AND t1.source_type=$type;
		
SQL;
		
		$result = $this->query($sql);
		return $result;
	}
	

}