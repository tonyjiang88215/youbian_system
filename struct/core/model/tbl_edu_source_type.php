<?php
class tbl_edu_source_type extends db_basic{
	protected function _define(){
		$this->tableName = 'edu_source_type';
		$this->key = 'id';
		
	}
	
	//获取所有省
	public function get_source_types(){
		$result = $this->select('id , name',null,null,null);
		return $result;
	}
	
}