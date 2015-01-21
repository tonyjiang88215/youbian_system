<?php
class tbl_edu_unit extends db_basic{
	protected function _define(){
		$this->key = 'id';
		
// 		$this->linkCFG->host = '192.168.1.61';
// 		$this->linkCFG->user = 'huhu';
// 		$this->linkCFG->password = '123456';
// 		$this->linkCFG->dbname = 'hx_curriculumn';
		
	}
	
	protected function _getTableName($subject_id){
		global $CFG;
		$this->tableName = $CFG['subject'][$subject_id].'_edu_unit';
	}
	
	//根据教材查询
	public function get_units_by_bookid($subject_id , $book_id){
		$this->_getTableName($subject_id);
		
		$result = $this->select('id , unit_name , unit_index','book_id='.$book_id,null,'unit_index ASC');
		return $result;
	}
	
	//根据学段和版本查询
	public function get_units($subject_id , $section_id , $version_id){
		$this->tableName = $CFG['subject'][$subject_id].'_edu_unit';
		
		$where = 'section_id=' . $section_id . ' AND version_id=' . $version_id;
		$result = $this->select('id , unit_name , unit_index' , $where , null , 'unit_index ASC');
		return $result;
	}
	
	public function modify_unit($subject_id , $info){
		$this->_getTableName($subject_id);
		
		$result = $this->update($info);
		return $result;
		
	}
	
	public function insert_unit($data){
		$this->_getTableName($data['subject_id']);
		
		unset($data['subject_id']);
		
		$data['unit_name'] = str_ireplace('\'', '\'\'', $data['unit_name']);
		
		$result = $this->insert($data);
		return $result;
		
	}
	
	public function remove_unit($subject_id , $id){
		$this->_getTableName($subject_id);
		
		$result = $this->deleteById($id);
		
		return $result;
		
	}
	
	public function move_up($subject_id , $id){
		$this->_getTableName($subject_id);
		$tableName = $this->tableName;
	
		//设置当前ID和当前ID在同一层的上一个元素互换sort_id
		$sql = <<<SQL
			UPDATE $tableName as t1
			JOIN $tableName as t2 ON t1.id=$id and t2.book_id=t1.book_id AND t2.unit_index=t1.unit_index-1
			SET t1.unit_index=t2.unit_index , t2.unit_index=t1.unit_index
SQL;
	
		$result = $this->exec($sql);
		return $result;
	
	}
	
	public function move_down($subject_id , $id){
		$this->_getTableName($subject_id);
		$tableName = $this->tableName;
	
		//设置当前ID和当前ID在同一层的上一个元素互换sort_id
		$sql = <<<SQL
			UPDATE $tableName as t1
			JOIN $tableName as t2 ON t1.id=$id and t2.book_id=t1.book_id AND t2.unit_index=t1.unit_index+1
			SET t1.unit_index=t2.unit_index , t2.unit_index=t1.unit_index 
SQL;
	
		$result = $this->exec($sql);
		return $result;
	}
	
	//将一个表里的指定单元数据复制到另一个表里去
	public function copyData($toVersion , $toSubject , $toBook , $fromVersion , $fromSubject , $fromBook){
		
		global $CFG;
		
		foreach($CFG['data']['curriculumn'] as $curriculumn){
			if($curriculumn['id'] == $toVersion){
				$toName = 'curriculumn_source_'.$curriculumn['extends'].'.'.$CFG['subject'][$toSubject].'_edu_unit';
			}
			if($curriculumn['id'] == $fromVersion){
				$fromName = 'curriculumn_source_'.$curriculumn['extends'].'.'.$CFG['subject'][$fromSubject].'_edu_unit';
			}
		}
		
		//从源单元表中将数据插入到目标单元 ， 把 book_id , subject , version_id 改成目标表的值
		$sql = <<<SQL
	
			INSERT INTO $toName (ref_id , book_id , unit_name , unit_index , visible , version_id )
			SELECT id , $toBook as book_id , unit_name , unit_index , visible , $toVersion as version_id
			FROM $fromName
			WHERE book_id=$fromBook
	
SQL;
	
		$result = $this->exec($sql);
		
		if($result !== false){
			return true;
		}else{
			return false;
		}
	}
	
	//将一个表里的指定单元数据删除
	public function clearData($subject , $book){
		$this->_getTableName($subject);
		$where = 'book_id='.$book;
		$result = $this->delete($where);
		if($result !== false){
			return true;
		}else{
			return false;
		}
	}
	
	
	
}