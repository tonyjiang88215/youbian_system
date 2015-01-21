<?php
class tbl_setin_exam_name extends db_basic{
	protected function _define(){
		$this->tableName = 'setin_exam_name';
		$this->key = 'id';
		
// 		$this->linkCFG->host = '192.168.1.61';
// 		$this->linkCFG->user = 'huhu';
// 		$this->linkCFG->password = '123456';
// 		$this->linkCFG->dbname = 'hx_curriculumn';
		
	}
	
	public function add_finish_exam_name($exam_name){
		$insertArray = array(
			'exam_name'=>$exam_name
		);
		
		$result = $this->insert($insertArray);
		return $result;
		
	}
	
}