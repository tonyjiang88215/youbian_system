<?php
class tbl_exam_examination_to_question extends db_basic{
	protected function _define(){
		$this->tableName = 'exam_examination_to_question';
		$this->key = 'id';
		
	}
	
	//插入记录
	public function insert_relations($insertArray , $exam_id){
		$inserts = array();
		foreach($insertArray as $question_id){
			$inserts[] = array('question_id'=>$question_id , 'exam_id'=>$exam_id);
		}
		
		$result = $this->insert_batch($inserts);
		return $result;
	}
	
	//移除记录
	public function remove_relations($removeArray , $exam_id){
		
		$where = 'exam_id='.$exam_id.' AND question_id IN ("'. implode('","' , $removeArray ) .'")';
		$result = $this->delete($where);
		return $result;
		
	}
	
	public function get_count_by_examid($idArray){
		$where = 'exam_id in ('.implode(',',$idArray).')';
		$tableName = $this->tableName;
		$sql = <<<SQL
		
				SELECT COUNT(*) as count , exam_id FROM $tableName WHERE $where GROUP BY exam_id;
		
SQL;
		$result = $this->query($sql);
		return $result;
	}
	
}