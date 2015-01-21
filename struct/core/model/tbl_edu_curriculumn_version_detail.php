<?php
class tbl_edu_curriculumn_version_detail extends db_basic{
	protected function _define(){
		$this->tableName = 'edu_curriculumn_version_detail';
		$this->key = 'id';
		
	}
	
	public function post_new_detail($infos){
		$result = $this->insert_batch($infos);
		return $result;
		
	}
	
	public function get_details($version_id){
		$where = 'version_id='.$version_id;
		$result = $this->select(null , $where , null , null);
		return $result;
	}
	
	public function get_curriculumn_by_bookid($book_id){
		$relationTable = array(
			$this->tableName
		);
		
		$curriculumnTable = array(
			'edu_curriculumn_version' , 
			'id' , 'name'
		);
		
		$tblCondition = array(
			$relationTable[0].'.version_id='.$curriculumnTable[0].'.id',
			'where'=>'type=1 AND book_id='.$book_id
		);
		
		$result = $this->withQueryMaker($relationTable , $curriculumnTable , $tblCondition);
		return $result;
		
	}
	
	public function get_curriculumn_support_subject($subject_id){
		
		$where = 'subject_id='.$subject_id;
		$result = $this->select('DISTINCT version_id' , $where , null , null);
		return $result;
		
	}
	
	//导入数据成功后，更新状态值
	public function post_setin_success($detail_id , $ref){
		$updateArray = array('id'=>$detail_id , 'step'=>1 , 'ref'=>$ref);
		$result = $this->update($updateArray);
		return $result;
	}
	
	//清除数据成功后，更新状态值
	public function post_clear_success($detail_id){
		$updateArray = array('id'=>$detail_id , 'step'=>0 , 'ref'=>'');
		$result = $this->update($updateArray);
		return $result;
	}
	
	public function post_complete($detail_id){
		$updateArray = array('id'=>$detail_id , 'step'=>3);
		$result = $this->update($updateArray);
		return $result;
	}
	
}