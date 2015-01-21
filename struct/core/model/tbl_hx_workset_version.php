<?php
class tbl_hx_workset_version extends db_basic{
	protected function _define(){
		$this->tableName = 'hx_workset_version';
		$this->key = 'id';
		
	}
	
	public function get_workset_versions($workset_id){
		$result = $this->select('version_id , privilege' , 'workset_id='.$workset_id , null , null);
		return $result;
	}
	
	public function add_workset_versions($workset_id , $version_id){
		$insertArray = array(
				'workset_id'=>$workset_id,
				'version_id'=>$version_id
		);
		$result = $this->insert($insertArray);
		return $result;
	}
	
	public function update_workset_versions($workset_id , $version){
		$deleteWhere = 'workset_id='.$workset_id;
		
		$this->delete($deleteWhere);
		
		$insertArray = array();
		
		foreach($version as $v){
			$insertArray[] = array(
				'workset_id'=>$workset_id,
				'version_id'=>$v['version_id'],
				'privilege'=>$v['privilege']
			);
		}
		$result = $this->insert_batch($insertArray);
		return $result;
		
	}
	
}