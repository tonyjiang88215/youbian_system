<?php
class tbl_edu_knowledge_to_question extends db_basic{
	protected function _define(){
		$this->key = 'id';
		
// 		$this->linkCFG->host = '192.168.1.61';
// 		$this->linkCFG->user = 'huhu';
// 		$this->linkCFG->password = '123456';
// 		$this->linkCFG->dbname = 'hx_curriculumn';
		
	}
	
	protected function _getTableName($subject_id){
		global $CFG;
		$this->tableName = $CFG['subject'][$subject_id].'_edu_knowledge2question';
	
	}
	
	//插入记录
	public function insert_relations($subject_id , $insertArray , $knowledge_id){
		global $CFG;
		$this->tableName = $CFG['subject'][$subject_id].'_edu_knowledge2question';
		
		$inserts = array();
		foreach($insertArray as $question_id){
			$inserts[] = array('question_id'=>$question_id , 'knowledge_id'=>$knowledge_id);
		}
		
		$result = $this->insert_batch($inserts);
		return $result;
	}
	
	//移除记录
	public function remove_relations($subject_id , $removeArray , $knowledge_id){
		global $CFG;
		$this->tableName = $CFG['subject'][$subject_id].'_edu_knowledge2question';
		
		$where = 'knowledge_id='.$knowledge_id.' AND question_id IN ("'. implode('","' , $removeArray ) .'")';
		$result = $this->delete($where);
		return $result;
		
	}
	
	//从一个表将某知识点中的题目关系复制到另一个表里去
	public function copyData($toVersion , $toSubject , $toSection , $fromVersion , $fromSubject , $fromSection){
		global $CFG;
		
		foreach($CFG['data']['curriculumn'] as $curriculumn){
			if($curriculumn['id'] == $toVersion){
				$toName = 'curriculumn_source_'.$curriculumn['extends'].'.'.$CFG['subject'][$toSubject].'_edu_knowledge2question';
				$knowledgeName = 'curriculumn_source_'.$curriculumn['extends'].'.'.$CFG['subject'][$toSubject].'_edu_knowledge';
			}
			if($curriculumn['id'] == $fromVersion){
				$fromName = 'curriculumn_source_'.$curriculumn['extends'].'.'.$CFG['subject'][$fromSubject].'_edu_knowledge2question';
			}
		}
		
		$columns = '';
	
		//从源单元表中将数据插入到目标单元 ， 把 book_id , subject , version_id 改成目标表的值
		$sql = <<<SQL
	
			INSERT INTO $toName (knowledge_id , question_id)
		    SELECT t2.id as knowledge_id , t1.question_id 
		    FROM $fromName t1 JOIN $knowledgeName t2 ON t1.knowledge_id=t2.id
			AND t2.subject_id=$fromSubject 
			AND t2.section_id=$fromSection 
			AND t2.version_id=$fromVersion

SQL;
	
// 		echo $sql;
		
		$result = $this->exec($sql);
	
		if($result !== false){
		return true;
		}else{
		return false;
		}
	}
	
	//按学段清除题目对应关系
	public function clearData($subject , $section){
		global $CFG;
		
		$this->_getTableName($subject);
		$relationName = $this->tableName;
		
		$knowledgeName = $CFG['subject'][$subject] . '_edu_knowledge';
		
		$sql = <<<SQL
		
			DELETE a 
			FROM 
			$relationName a JOIN $knowledgeName b ON a.knowledge_id=b.id 
			WHERE b.section_id=$section AND b.subject_id=$subject;
		
SQL;
		
		$result = $this->exec($sql);
		if($result !== false){
			return true;
		}else{
			return false;
		}
	}
	
}