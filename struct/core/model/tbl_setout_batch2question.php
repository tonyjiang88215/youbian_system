<?php
class tbl_setout_batch2question extends db_basic{
	protected function _define(){
		$this->tableName = 'setout_batch2question';
		$this->key = 'id';

	}
	
	public function getQuestionsTotal($batch_id){
		$sql = <<<SQL
				select count(*) as count,type from setout_batch2question where batch_id=$batch_id group by type;
SQL;
		
		$_rs = $this->query($sql);
		
		$result = array();
		
		foreach($_rs as $v){
			$result[$v['type']] = $v['count'];
		}
		
		return $result;
	}

	public function addQuestions($batch_id , $type , $questions){
		$insertArray = array();
		foreach($questions as $q){
			$insertArray[] = array('gid'=>$q['gid'] , 'batch_id'=>$batch_id , 'type'=>$type);
		}
		
		$result = $this->insert_batch($insertArray);
		return $result;
	}
	
}