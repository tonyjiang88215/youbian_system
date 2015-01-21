<?php
class tbl_hx_workset_source extends db_basic{
	protected function _define(){
		$this->tableName = 'hx_workset_source';
		$this->key = 'id';
		
	}
	
	public function get_workset_sources($workset_id){
		$sql = <<<SQL
		
				SELECT t1.* , t2.name as subject_name , t3.name as section_name FROM hx_workset_source t1 JOIN edu_subject t2 ON t1.subject_id=t2.id 
				JOIN edu_section t3 ON t1.section_id=t3.id 
				WHERE t1.workset_id=$workset_id
		
SQL;
		
		$result = $this->query($sql);
		return $result;
		
	}
	
	public function update_workset_sources($workset_id , $source){
		$deleteWhere = 'workset_id='.$workset_id;
		
		$this->delete($deleteWhere);
		
		$insertArray = array();
		
		foreach($source as $s){
			$insertArray[] = array(
				'workset_id'=>$workset_id,
				'subject_id'=>$s['subject_id'],
				'section_id'=>$s['section_id']
			);
		}
		
		$result = $this->insert_batch($insertArray);
		return $result;
		
	}
	
}