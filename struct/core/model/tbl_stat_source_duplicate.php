<?php
class tbl_stat_source_duplicate extends db_basic{
	protected function _define(){
		$this->tableName = 'stat_source_duplicate';
		$this->key = 'id';

	}

	//添加记录
	public function add_record($subject_id , $gidArray){
		$insertArray = array();
		$time = time();
		foreach($gidArray as $gid){
			$insertArray[] = array('user_id'=>$_SESSION['user_id'] , 'gid'=>$gid , 'subject_id'=>$subject_id , 'time'=>$time);
		}
		$result = $this->insert_batch($insertArray);
		return $result;
	}
	
	
	public function get_duplicate_list($subject_id){
		$sql = <<<SQL
		SELECT user_id , COUNT(*) AS count FROM stat_source_duplicate WHERE subject_id=$subject_id group by user_id 
SQL;
		
		$result = $this->query($sql);
		return $result;
	}
}