<?php
class tbl_template_question extends db_basic{
	protected function _define(){
		$this->tableName = 'template_question';
		$this->key = 'id';
		
	}
	
	
	//获取所有模版
	public function get_templates(){
		$result = $this->select(null,null,null,null);
		return $result;
	}
	
}