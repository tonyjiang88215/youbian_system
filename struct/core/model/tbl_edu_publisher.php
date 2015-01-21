<?php
class tbl_edu_publisher extends db_basic{
	protected function _define(){
		$this->key = 'id';
		$this->tableName = 'edu_publisher';
	}
	
	public function get_publishers(){
		
		$result = $this->select(null , null, null, null);
		return $result;
	}
	
	public function add_publisher($name){
		$insertArray = array('name'=>$name);
		
		$result = $this->insert($insertArray);
		return $result;
		
	}
	
	public function modify_publisher($publisher_id , $publisher_name){
		$updateArray = array('id'=>$publisher_id , 'name'=>$publisher_name);
		$result = $this->update($updateArray);
		return $result;
	}
	
	public function remove_publisher($publisher_id){
		global $CFG;
		$sqlCount = 'SELECT COUNT(*) as count FROM (';
		
		foreach($CFG['subject'] as $s => $pre){
			$sqlCount .= 'SELECT * FROM '.$pre.'_edu_book union ';
		}
		
		$sqlCount = substr($sqlCount , 0 , strlen($sqlCount) - 7);

		$sqlCount .= ') a';

		$sqlCount .= ' WHERE publisher_id='.$publisher_id;

		$tmp = $this->query($sqlCount);
		
		$count = $tmp[0]['count'];
		
		if($count > 0){
			return array('result'=>false , 'reason'=>'1');
		}else{
			return array('result'=>$this->deleteById($publisher_id));
		}
		

	}
}