<?php
class tbl_edu_chapter_to_question extends db_basic{
	protected function _define(){
		$this->key = 'id';
		
// 		$this->linkCFG->host = '192.168.1.61';
// 		$this->linkCFG->user = 'huhu';
// 		$this->linkCFG->password = '123456';
// 		$this->linkCFG->dbname = 'hx_curriculumn';
		
	}
	
	protected function _getTableName($subject_id){
		global $CFG;
		$this->tableName = $CFG['subject'][$subject_id].'_edu_chapter2question';
	
	}
	
	
	public function get_questions_by_chapter($subject_id , $chapter_id , $offset , $step){
		$this->_getTableName($subject_id);
		
		$where = 'chapter_id='.$chapter_id;
		$limit = $offset . ',' . $step;
		
		$result = array();
		$result['data'] = $this->select('question_id' , $where , $limit , null);
		$result['count'] = $this->count($where);
		
		return $result;
		
		
	}
	
	
	public function get_question_by_id($subject_id , $idArray){
		global $CFG;
		$questionName = $CFG['subject'][$subject_id].'_exam_question';
		$questionIndexName = $CFG['subject'][$subject_id].'_exam_question_index';
	
	
		$tblQuestion = array(
				$questionName,
				'content' , 'column_content' , 'answer' , 'analysis'
		);
	
		$tblQuestionIndex = array(
				$questionIndexName,
				'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' ,
				'option_count' , 'group_count' , 'question_type' , 'question_template' , 'setin_exam_id' , 'exam_name' , 'subject_id' , 'source' ,
				'time' , 'keyword'
	
		);
	
		$tblCondition = array(
				$questionName.'.gid='.$questionIndexName.'.gid',
				'where'=>$questionIndexName.'.gid IN ("'.implode('","' , $idArray).'")'
		);
	
		$result = $this->withQueryMaker($tblQuestionIndex , $tblQuestion , $tblCondition);
		return $result;
	
	
	}
	
	public function get_question_count_by_bookid($subject_id , $book_id){
		$this->_getTableName($subject_id);
		
		global $CFG;
		$chapterName = $CFG['subject'][$subject_id].'_edu_chapter';
		
		$tableName = $this->tableName;
		
		$sql = <<<SQL
		
				SELECT COUNT(*) as count , b.id  FROM $tableName a JOIN $chapterName b ON a.chapter_id=b.id GROUP BY b.id;
		
SQL;
		
		$result = $this->query($sql);
		
		return $result;
		
	}
	
	//插入记录
	public function insert_relations($subject_id , $insertArray , $chapter_id){
		$this->_getTableName($subject_id);
		
		$inserts = array();
		foreach($insertArray as $question_id){
			$inserts[] = array('question_id'=>$question_id , 'chapter_id'=>$chapter_id);
		}
		
		$result = $this->insert_batch($inserts);
		return $result;
	}
	
	public function insert_relations_version($subject_id , $insertArray , $chapter_id){
		$this->_getTableName($subject_id);
	
		$inserts = array();
		foreach($insertArray as $question_id){
			$inserts[] = array('question_id'=>$question_id , 'chapter_id'=>$chapter_id);
		}
	
		$result = $this->insert_batch($inserts);
		return $result;
	}
	
	//移除记录
	public function remove_relations($subject_id , $removeArray , $chapter_id){
		$this->_getTableName($subject_id);
		
		$where = 'chapter_id='.$chapter_id.' AND question_id IN ("'. implode('","' , $removeArray ) .'")';
		$result = $this->delete($where);
		return $result;
		
	}
	
	//从一个表将某个教材中的题目关系复制到另一个表里去
	public function copyData($toVersion , $toSubject , $toBook , $fromVersion , $fromSubject , $fromBook){
		
		global $CFG;
		
		foreach($CFG['data']['curriculumn'] as $curriculumn){
			if($curriculumn['id'] == $toVersion){
				$toName = 'curriculumn_source_'.$curriculumn['extends'].'.'.$CFG['subject'][$toSubject].'_edu_chapter2question';
				$chapterName = 'curriculumn_source_'.$curriculumn['extends'].'.'.$CFG['subject'][$toSubject].'_edu_chapter';
			}
			if($curriculumn['id'] == $fromVersion){
				$fromName = 'curriculumn_source_'.$curriculumn['extends'].'.'.$CFG['subject'][$fromSubject].'_edu_chapter2question';
				$bookName = 'curriculumn_source_'.$curriculumn['extends'].'.'.$CFG['subject'][$fromSubject].'_edu_book';
			}
		}
	
		//从源单元表中将数据插入到目标单元 ， 把 book_id , subject , version_id 改成目标表的值
		$sql = <<<SQL
	
			INSERT INTO $toName (chapter_id , question_id)
			SELECT $chapterName.id as chapter_id , $fromName.question_id 
			FROM $fromName JOIN $chapterName ON $fromName.chapter_id=abs($chapterName.ref_id)  
			JOIN $bookName ON $chapterName.book_id=$bookName.id AND $bookName.id=$fromBook 
	
SQL;
		
		$result = $this->exec($sql);
		
		if($result !== false){
			return true;
		}else{
			return false;
		}
	}
	
	//从一个表将某个教材中的题目关系删除
	public function clearData($subject , $book){
		global $CFG;
		
		$this->_getTableName($subject);
		$relationName = $this->tableName;
		
		$chapterName = $CFG['subject'][$subject] . '_edu_chapter';
		
		$sql = <<<SQL
		
			DELETE a 
			FROM 
			$relationName a JOIN $chapterName b ON a.chapter_id=b.id 
			WHERE b.book_id=$book 
		
SQL;
		
		$result = $this->exec($sql);
		if($result !== false){
			return true;
		}else{
			return false;
		}
		
	}
	
}