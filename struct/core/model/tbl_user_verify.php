<?php
class tbl_user_verify extends db_basic{
	protected function _define(){
		$this->key = 'id';

		$this->linkCFG->host = '192.168.1.41';
		$this->linkCFG->user = 'huhu';
		$this->linkCFG->password = '123456';
		$this->linkCFG->dbname = 'ticoolv2';

	}

	public function tokenVerify($tokenInfo){
		
		//身份认证模式
		switch($tokenInfo['logintype']){
			case 1:
				//token模式
				$sql = "select id,usr_type,yanzheng,realname,nickname,passwd from tbluser where token='".$tokenInfo['token']."' and username='".$tokenInfo['username']."'";
				$result = $this -> query($sql);
		
				break;
			case 2:
				//密码模式
				$sql = "select id,usr_type,yanzheng,realname,nickname,passwd from tbluser where username='".$tokenInfo['username']."' and passwd='".$tokenInfo['password']."'";
				$result = $this -> query($sql);
				
				break;
		}
		
		if($result){
			return $result[0];
		}else{
			return array();
		}
	}
	
	public function queryLevel($user_id){
		$sql = 'SELECT level FROM tblteacher WHERE user_id=' . $user_id;
		$result = $this->query($sql);
		if($result){
			return $result[0];
		}else{
			return array();
		}
		
		
	}

}