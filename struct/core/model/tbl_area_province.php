<?php
class tbl_area_province extends db_basic{
	protected function _define(){
		$this->tableName = 'area_province';
		$this->key = 'id';
		
	}
	
	//获取所有省
	public function get_provinces(){
		$result = $this->select('id , Name as name',null,null,null);
		return $result;
	}
	
}