<?php
class tbl_edu_subject extends db_basic{
	protected function _define(){
		$this->tableName = 'edu_subject';
		$this->key = 'id';
		
// 		$this->linkCFG->host = '192.168.1.61';
// 		$this->linkCFG->user = 'huhu';
// 		$this->linkCFG->password = '123456';
// 		$this->linkCFG->dbname = 'hx_curriculumn';
		
	}
	
	//获取所有科目
	public function get_subjects(){
		$result = $this->select('id , name',null,null,null);
		return $result;
	}
	
	public function get_subjects_with_section(){
		$sql = <<<SQL
		   SELECT t1.id as subject_id , t2.id as section_id , t1.name as subject_name , t2.name as section_name FROM edu_subject t1 , edu_section t2;
   
SQL;
		
		$result = $this->query($sql);
		return $result;
	}
	
	
	public function get_subjects_by_control($user_id){
		$sql = <<<SQL
			SELECT t2.subject_id as id , t2.section_id ,t3.name FROM hx_user t1 
			JOIN hx_workset_source t2 ON t1.workset_id=t2.workset_id AND t1.id=$user_id 
			JOIN edu_subject t3 ON t2.subject_id=t3.id ;
		
SQL;
		$result = $this->query($sql);
		
		$_subject_final = array();
		foreach( $result as $s){
			if(!$_subject_final[$s['id']]){
				$_subject_final[$s['id']] = array('id'=>$s['id'] , 'name'=>$s['name'] , 'attr'=>array());
			}
		
			$_subject_final[$s['id']]['attr'][] = $s['section_id'];
		
		}
		
		return $_subject_final;
	}
	
}