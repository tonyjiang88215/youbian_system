<?php
class tbl_edu_source extends db_basic{
	protected function _define(){
		$this->tableName = 'edu_source';
		$this->key = 'id';
		
// 		$this->linkCFG->host = '192.168.1.61';
// 		$this->linkCFG->user = 'huhu';
// 		$this->linkCFG->password = '123456';
// 		$this->linkCFG->dbname = 'hx_curriculumn';
		
	}
	
	//获取所有科目
	public function get_batchs($subject_id , $section_id){
		$where = 'section_id=' . $section_id . ' AND subject_id IN (' . $subject_id . ' , 0) AND deal_flag!=1';
		$result = $this->select( '*' , $where , null , null );
		return $result;
	}
	
	public function get_exams(){
		
	}
	
}