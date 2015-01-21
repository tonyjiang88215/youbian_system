<?php
class tbl_hx_user_group_privilege extends db_basic{
	protected function _define(){
		$this->tableName = 'hx_user_group_privilege';
		$this->key = 'id';
		
	}
	
	public function get_privileges($group_id){
		
		$tblModule = array(
			'hx_module',
			'*'
		);
		
		$tblUserGroupPrivilege = array(
			'hx_user_group_privilege',
			'privilege'
		);
		
		$tblCondition = array(
			'hx_module.id=hx_user_group_privilege.module_id AND hx_user_group_privilege.group_id='.$group_id,
// 			'where'=>'group_id='.$group_id
		);
		
		$result = $this->withQueryMakerLeft($tblModule , $tblUserGroupPrivilege , $tblCondition);
		return $result;
	}
	
	public function get_privileges_by_control($group_id , $user_id){
		
		$sql = <<<SQL
		
				SELECT t1.* , IFNULL(t4.privilege,0) as privilege FROM hx_module t1 JOIN hx_user_group_privilege t2 ON t1.id=t2.module_id 
				JOIN hx_user t3 ON t3.group_id=t2.group_id AND t2.privilege>0 AND t3.id=$user_id 
				LEFT JOIN hx_user_group_privilege t4 ON t1.id=t4.module_id AND t4.group_id=$group_id
		
SQL;
		$result = $this->query($sql);
		return $result;
		
	}
	
	public function update_privileges($group_id , $modules){
		$resultDelete = $this->delete('group_id='.$group_id);
		
		$insertArray = array();
		foreach($modules as $module_id){
			$insertArray[] = array('group_id'=>$group_id , 'module_id'=>$module_id , 'privilege'=>3);
		}
		
		$result = $this->insert_batch($insertArray);
		return $result;
	}
	
}