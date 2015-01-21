<?php
class tbl_edu_year extends db_basic{
	protected function _define(){
		$this->tableName = 'edu_year';
		$this->key = 'id';
		
// 		$this->linkCFG->host = '192.168.1.61';
// 		$this->linkCFG->user = 'huhu';
// 		$this->linkCFG->password = '123456';
// 		$this->linkCFG->dbname = 'hx_curriculumn';
		
	}
	
	//获取所有科目
	public function get_years(){
		$result = $this->select('year as id , year as name' , null , null , null);
		return $result;
	}
	
}