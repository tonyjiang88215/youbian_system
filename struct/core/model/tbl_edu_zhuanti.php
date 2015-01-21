<?php
class tbl_edu_zhuanti extends db_basic{
	protected function _define(){
//		$this->tableName = 'area_province';
		$this->key = 'id';
		
// 		$this->linkCFG->host = '192.168.1.61';
// 		$this->linkCFG->user = 'huhu';
// 		$this->linkCFG->password = '123456';
// 		$this->linkCFG->dbname = 'hx_curriculumn';
		
	}
	
	protected function _getTableName($subject_id){
		global $CFG;
		$this->tableName = $CFG['subject'][$subject_id].'_edu_zhuanti';
		
	}
	
	//获取所有知识点
	public function get_zhuantis($subject_id  ,  $section_id = null){
		$this->_getTableName($subject_id);
		
		$column = 'id , name , level , parent_id , subject_id , grade_id , section_id , sort_id';
		$where = '';
		if($section_id){
			$where = 'section_id='.$section_id;	
		}
		if($version_id){
			$where .= ' AND version_id='.$version_id;
		}
		
		$result = $this->select($column,$where,null,'level ASC , sort_id ASC');
		return $result;
		
	}
	
	//插入知识点
	public function insert_zhuanti($data){
		$this->_getTableName($data['subject_id']);
		
		$result = $this->insert($data);
		
		return $result;
	}
	
	public function modify_zhuanti($subject_id , $zhuanti){
		$this->_getTableName($subject_id);
		$result = $this->update($zhuanti);
		return $result;
	}
	
	public function drag_zhuanti($subject_id , $zhuanti , $levelDiff , $childs){
		$this->_getTableName($subject_id);
		$tableName = $this->tableName;
		$id = $zhuanti['id'];
		
		$updateSiblings = <<<SQL
			UPDATE $tableName as t1 
				JOIN $tableName as t2 ON t1.id=$id AND t2.level=t1.level AND t2.parent_id=t1.parent_id AND t2.sort_id>t1.sort_id
				SET t2.sort_id=t2.sort_id-1; 
SQL;
		
		$this->exec($updateSiblings);
		
		$result1 = $this->update($zhuanti);
		
		$result2 = true;
		
		if($childs && count($childs) > 0){
			$child_id = implode(',' , $childs);
			
			if($levelDiff > 0){
				$updateChildSQL ='UPDATE '.$tableName.' SET level=level+'.$levelDiff.' WHERE id IN ('.$child_id.');';
			}else{
				$updateChildSQL ='UPDATE '.$tableName.' SET level=level-'. abs($levelDiff).' WHERE id IN ('.$child_id.');';
					
			}
			
			$result2 =$this->exec($updateChildSQL);
				
		}
		
		
		
		return $result1 && $result2;
	}
	
	public function delete_zhuanti($subject_id , $zhuanti_id){
		$this->_getTableName($subject_id);
		
		$result = $this->deleteById($zhuanti_id);
		return $result;
	}
	
	public function move_up_zhuanti($subject_id , $id , $id2){
		$this->_getTableName($subject_id);
		$tableName = $this->tableName;
		
		//设置当前ID和当前ID在同一层的上一个元素互换sort_id
		$sql = <<<SQL
			UPDATE $tableName as t1 
			JOIN $tableName as t2 ON t1.id=$id and t2.parent_id=t1.parent_id and t2.level=t1.level and t2.sort_id=t1.sort_id-1 
			SET t1.sort_id=t2.sort_id , t2.sort_id=t1.sort_id
SQL;
		
		$result = $this->exec($sql);
		return $result;
		
	}
	
	public function move_down_zhuanti($subject_id , $id , $id2){
		$this->_getTableName($subject_id);
		$tableName = $this->tableName;
		
		//设置当前ID和当前ID在同一层的上一个元素互换sort_id
		$sql = <<<SQL
			UPDATE $tableName as t1
			JOIN $tableName as t2 ON t1.id=$id and t2.parent_id=t1.parent_id and t2.level=t1.level and t2.sort_id=t1.sort_id+1
			SET t1.sort_id=t2.sort_id , t2.sort_id=t1.sort_id
SQL;
		
		$result = $this->exec($sql);
		return $result;
	}
	
	//将一个版本的知识点数据复制到另一个版本表里去
	public function copyData($toVersion , $toSubject , $toSection , $fromVersion , $fromSubject , $fromSection){
		global $CFG;
		
		foreach($CFG['data']['curriculumn'] as $curriculumn){
			if($curriculumn['id'] == $toVersion){
				$toName = 'curriculumn_source_'.$curriculumn['extends'].'.'.$CFG['subject'][$toSubject].'_edu_zhuanti';
			}
			if($curriculumn['id'] == $fromVersion){
				$fromName = 'curriculumn_source_'.$curriculumn['extends'].'.'.$CFG['subject'][$fromSubject].'_edu_zhuanti';
			}
		}
		
		$sql = <<<SQL
		
		INSERT INTO $toName (ref_id , name , level , parent_id , subject_id , sort_id , section_id ,  knowledge_id , knowledge_list , version_id) 
				SELECT id , name , level , parent_id , $toSubject as subject_id , sort_id , $toSection as section_id , knowledge_id , knowledge_list , $toVersion as version_id FROM $fromName WHERE section_id=$fromSection;
		
		UPDATE $toName t1 JOIN $toName t2 ON t1.parent_id=t2.ref_id and t2.ref_id>0		
				SET t1.parent_id=t2.id;
				
		UPDATE $toName SET ref_id=0-ref_id WHERE ref_id>0;
				
SQL;
		
		$result = $this->exec($sql);
		if($result !== false){
			return true;
		}else{
			return false;
		}
		
	}
	
	//按照学段删除知识点
	public function clearData($subject , $section){
		$this->_getTableName($subject);
		$where = 'section_id='.$section .' AND subject_id='.$subject;
		$result = $this->delete($where);
		if($result !== false){
			return true;
		}else{
			return false;
		}
	}
	
}