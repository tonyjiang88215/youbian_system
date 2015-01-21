<?php
class tbl_hx_user_role_privilege extends db_basic{
	protected function _define(){
		$this->tableName = 'hx_user_role_privilege';
		$this->key = 'id';
		
	}
	
	public function get_privileges($role_id){
		
		$tblModule = array(
			'hx_module',
			'*'
		);
		
		$tblUserRolePrivilege = array(
			'hx_user_role_privilege',
			'privilege'
		);
		
		$tblCondition = array(
			'hx_module.id=hx_user_role_privilege.module_id AND hx_user_role_privilege.role_id='.$role_id,
// 			'where'=>'group_id='.$group_id
		);
		
		$result = $this->withQueryMakerLeft($tblModule , $tblUserRolePrivilege , $tblCondition);
		return $result;
	}
	
	
	public function update_privileges($role_id , $modules){
		$resultDelete = $this->delete('role_id='.$role_id);
		
		$insertArray = array();
		foreach($modules as $module_id){
			$insertArray[] = array('role_id'=>$role_id , 'module_id'=>$module_id , 'privilege'=>3);
		}
		
		$result = $this->insert_batch($insertArray);
		return $result;
	}
	
}