<?php
class tbl_setout_batch_detail extends db_basic{
	protected function _define(){
		$this->tableName = 'setout_batch_detail';
		$this->key = 'id';

	}
	
	public function get_detail($batch_id){
		$tblBatch = array(
			$this->tableName
		);
		
		$tblDetail = array(
			'edu_curriculumn_version_detail',
			'*'
		);
		
		$tblVersion = array(
			'edu_curriculumn_version',
			'name as curriculumn_name'
		);
		
		$tblCondition = array(
			$tblBatch[0].'.detail_id='.$tblDetail[0].'.id',
			$tblDetail[0].'.version_id='.$tblVersion[0].'.id',
			'where'=>$tblBatch[0].'.batch_id='.$batch_id
		);
		
		$result = $this->withQueryMaker($tblBatch , $tblDetail , $tblVersion , $tblCondition);
		return $result;
		
	}

	public function post_add_detail($batch , $detail){
		
		$insertArray = array();
		
		foreach($detail as $v){
			$insertArray[] = array('batch_id'=>$batch , 'detail_id'=>$v);
		}
		
		$result = $this->insert_batch($insertArray);
		return $result;
	}
	
	public function post_remove_detail($batch , $detail){
	
		$where = 'batch_id='.$batch.' AND detail_id='.$detail;
		$result = $this->delete($where);
		return $result;
	}
	
}