<?php
class tbl_edu_grade extends db_basic{
	protected function _define(){
		$this->tableName = 'edu_grade';
		$this->key = 'id';
		
// 		$this->linkCFG->host = '192.168.1.61';
// 		$this->linkCFG->user = 'huhu';
// 		$this->linkCFG->password = '123456';
// 		$this->linkCFG->dbname = 'hx_curriculumn';
		
	}
	
	//获取所有科目
	public function get_grades(){
		$result = $this->select('id , name , section_id','id>0 and id<12',null,null);
		return $result;
	}
	
}