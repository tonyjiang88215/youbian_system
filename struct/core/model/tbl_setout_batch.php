<?php
class tbl_setout_batch extends db_basic{
	protected function _define(){
		$this->tableName = 'setout_batch';
		$this->key = 'id';

	}

	//获取所有批次信息
	public function get_batchs(){
		$result = $this->select('*',null,null,null);
		return $result;
	}
	
	public function post_add_batch($name){
		$insertArray = array(
			'name'=>$name,
			'time'=>time()
		);
		$result = $this->insert($insertArray);
		return $result;
	}
	
}