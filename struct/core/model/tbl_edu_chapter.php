<?php
class tbl_edu_chapter extends db_basic{
	protected function _define(){
		$this->key = 'id';
		
// 		$this->linkCFG->host = '192.168.1.61';
// 		$this->linkCFG->user = 'huhu';
// 		$this->linkCFG->password = '123456';
// 		$this->linkCFG->dbname = 'hx_curriculumn';
		
	}
	
	protected function _getTableName($subject_id){
		global $CFG;
		$this->tableName = $CFG['subject'][$subject_id].'_edu_chapter';
	
	}
	
	//根据教材查询
	public function get_chapters_by_bookid($subject_id , $book_id){
		$this->_getTableName($subject_id);
		
		$result = $this->select('id , chapter_name , chapter_index , unit_id','book_id='.$book_id,null,'chapter_index ASC');
		return $result;
	}
	
	//根据学段和版本进行查询
	public function get_chapters($subject_id , $section_id , $version_id){
		global $CFG;
		$this->tableName = $CFG['subject'][$subject_id].'_edu_chapter';
		$where = 'section_id=' . $section_id . ' AND version_id=' . $version_id;
		
		$result = $this->select('id , chapter_name , chapter_index , unit_id' , $where , null , 'chapter_index ASC');
		return $result;
	}
	
	public function modify_chapter($subject_id , $info){
		$this->_getTableName($subject_id);
	
		$result = $this->update($info);
		return $result;
	
	}
	
	public function insert_chapter($data){
		$this->_getTableName($data['subject_id']);
		
		unset($data['subject_id']);
		
		$data['chapter_name'] = str_ireplace('\'', '\'\'', $data['chapter_name']);
		
		$result = $this->insert($data);
		return $result;
	}
	
	public function remove_chapter($subject_id , $id){
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
			JOIN $tableName as t2 ON t1.id=$id and t2.unit_id=t1.unit_id AND t2.chapter_index=t1.chapter_index-1
			SET t1.chapter_index=t2.chapter_index , t2.chapter_index=t1.chapter_index 
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
			JOIN $tableName as t2 ON t1.id=$id and t2.unit_id=t1.unit_id AND t2.chapter_index=t1.chapter_index+1
			SET t1.chapter_index=t2.chapter_index , t2.chapter_index=t1.chapter_index 
SQL;
	
		$result = $this->exec($sql);
			return $result;
		}
		
	public function drag_knowledge($subject_id , $chapter){
		$this->_getTableName($subject_id);
		$tableName = $this->tableName;
		
		$id = $chapter['id'];
		
		$updateSiblings = <<<SQL
			UPDATE $tableName as t1
			JOIN $tableName as t2 ON t1.id=$id AND t2.unit_id=t1.unit_id AND t2.chapter_index>t1.chapter_index
			SET t2.chapter_index=t2.chapter_index-1
SQL;
			
		$this->exec($updateSiblings);
		
		$result = $this->update($chapter);
		
		return $result;
		
	}
	
	//将一个表里的章节数据拷贝到另一个表里去
	public function copyData($toVersion , $toSubject , $toBook , $fromVersion , $fromSubject , $fromBook){
		
		global $CFG;
		
		foreach($CFG['data']['curriculumn'] as $curriculumn){
			if($curriculumn['id'] == $toVersion){
				$toName = 'curriculumn_source_'.$curriculumn['extends'].'.'.$CFG['subject'][$toSubject].'_edu_chapter';
				$unitName = 'curriculumn_source_'.$curriculumn['extends'].'.'.$CFG['subject'][$toSubject].'_edu_unit';
			}
			if($curriculumn['id'] == $fromVersion){
				$fromName = 'curriculumn_source_'.$curriculumn['extends'].'.'.$CFG['subject'][$fromSubject].'_edu_chapter';
			}
		}
		
		//从源章节表中将数据插入到目标章节 ， 把 book_id , subject , version_id 改成目标表的值
		$sql = <<<SQL
		
			INSERT INTO $toName (ref_id,chapter_name,chapter_index,book_id,unit_id,visible,version_id ) 
			SELECT t1.id,t1.chapter_name,t1.chapter_index, $toBook as book_id,t2.id,t1.visible,$toVersion as version_id 
			FROM $fromName t1 JOIN $unitName t2 ON t1.unit_id =t2.ref_id
			WHERE t1.book_id=$fromBook 
		
SQL;
		
		$result = $this->exec($sql);
		
		if($result !== false){
			return true;
		}else{
			return false;
		}
		
	}
	
	//将一个表里的指定章节数据删除
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