<?php
class tbl_hx_user_role_create_privilege extends db_basic{
	protected function _define(){
		$this->tableName = 'hx_user_role_create_privilege';
		$this->key = 'id';
		
	}
	
	public function get_privileges($role_id){
		
		$tblRole = array(
			'hx_user_role',
			'*'
		);
		
		$tblUserRoleCreatePrivilege = array(
			'hx_user_role_create_privilege',
			'create_role_id'
		);
		
		$tblCondition = array(
			'hx_user_role.id=hx_user_role_create_privilege.create_role_id AND hx_user_role_create_privilege.role_id='.$role_id,
// 			'where'=>'group_id='.$group_id
		);
		
		$result = $this->withQueryMakerLeft($tblRole , $tblUserRoleCreatePrivilege , $tblCondition);
		return $result;
	}
	
	
	public function update_privileges($role_id , $roleArray){
		$resultDelete = $this->delete('role_id='.$role_id);
		
		$insertArray = array();
		foreach($roleArray as $id){
			$insertArray[] = array('role_id'=>$role_id , 'create_role_id'=>$id);
		}
		
		$result = $this->insert_batch($insertArray);
		return $result;
	}
	
}