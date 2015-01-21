<?php
class tbl_exam_question_index_0911 extends db_basic{
	protected function _define(){
//		$this->tableName = 'hx_edu_source';
		$this->key = 'id';
		
		$this->linkCFG->host = '192.168.1.41';
		$this->linkCFG->user = 'huhu';
		$this->linkCFG->password = '123456';
		$this->linkCFG->dbname = 'hx_curriculumn_0911';
		
	}
	
	//查询已经入库到章节中的题目
	public function get_question_by_chapter_id($subject_id , $chapter_id , $offset , $step){
	
		global $CFG;
		$tableName = $CFG['subject'][$subject_id].'_edu_chapter2question';
		$questionName = $CFG['subject'][$subject_id].'_exam_question';
		$questionIndexName = $CFG['subject'][$subject_id].'_exam_question_index';
	
		$tblRelation = array(
				$tableName,
		);
	
		$tblQuestionIndex = array(
				$questionIndexName,
				'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' ,
				'option_count' , 'group_count' , 'question_type' , 'question_template' , 'exam_name' , 'subject_id' , 'source'
					
		);
	
		$tblQuestion = array(
				$questionName,
				'content' , 'column_content' , 'answer' , 'analysis'
		);
	
	
		$tblCondition = array(
				$tableName.'.question_id='.$questionIndexName.'.gid AND '.$tableName.'.chapter_id='.$chapter_id,
				$questionIndexName.'.gid='.$questionName.'.gid',
				'limit'=>$offset.','.$step
		);
	
		$result['data'] = $this->withQueryMaker($tblRelation , $tblQuestionIndex , $tblQuestion , $tblCondition);
	
		$result['count'] = $this->withQueryMakerOfNum($tblRelation , $tblQuestionIndex , $tblQuestion , $tblCondition);
	
	
		$ids = array();
	
		foreach($result['data'] as $question){
			$ids[] = $question['gid'];
		}
	
		$tblChildQuestionIndex = array(
				'modify_sub_exam_question_index',
				'gid' , 'score' , 'objective_flag' , 'option_count' , 'question_type' , 'question_template' , 'parent_gid'
	
		);
	
		$tblChildQuestion = array(
				'modify_sub_exam_question',
				'content' , 'column_content' , 'answer' , 'analysis'
		);
	
		$tblChildCondition = array(
				'modify_sub_exam_question_index.gid=modify_sub_exam_question.gid',
				'where'=>'modify_sub_exam_question_index.parent_gid IN ("'.implode('","' , $ids).'")'
		);
	
		$result['children'] = $this->withQueryMaker($tblChildQuestionIndex , $tblChildQuestion , $tblChildCondition);
	
	
		return $result;
	}
	
	//查询没有入库到试卷中的题目
	public function get_question_for_subject($subject_id , $offset , $step){
		
		global $CFG;
		
		$tableName = $CFG['subject'][$subject_id] . '_exam_question';
		$tableIndexName = $CFG['subject'][$subject_id] . '_exam_question_index';
		
		$this->tableName = $tableName;
		
// 		$where = 'repeat_gid=""';
$where = '';
		
		$limit = $offset.','.$step;
		$order = 'question_text ASC';
		
		$result['data'] = $this->select('*' , $where , $limit , null);
		
		$result['count'] = $this->count($where);
		

		return $result;
		
		$tblQuestionIndex = array(
			$tableIndexName ,
			'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' , 
			'option_count' , 'group_count' , 'question_type' , 'question_template' , 'setin_exam_id', 'exam_name' , 'subject_id' , 'source' ,
			'time' , 'keyword' 
		);
		
		$tblQuestion = array(
			$tableName ,
			'content' , 'column_content' , 'answer' , 'analysis' , 'question_text'
		);
		
		$tblCondition = array(
			$tableName.'.gid='.$tableIndexName.'.gid',
			'where' => 'repeat_gid=""',
			'order'=>'question_text ASC',
			'limit'=>$offset.','.$step
		);
		
		$result['data'] = $this->withQueryMaker($tblQuestionIndex , $tblQuestion , $tblCondition);
		
		$result['count'] = $this->withQueryMakerOfNum($tblQuestionIndex , $tblQuestion , $tblCondition);
		
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
				'gid' , 'subject_id' , 'grade_id' , 'difficulty' , 'score' , 'objective_flag' ,
				'option_count' , 'group_count' , 'question_type' , 'exam_name' , 'subject_id' , 'source' , 'question_type',
// 				'knowledge_id' ,'knowledge_text' , 'combine_flag' ,'question_template' , 
				
	
		);
	
		$tblCondition = array(
				$questionName.'.gid='.$questionIndexName.'.gid',
				'where'=>$questionIndexName.'.gid IN ("'.implode('","' , $idArray).'")'
		);
	
		$result = array();
		
		$result['data'] = $this->withQueryMaker($tblQuestionIndex , $tblQuestion , $tblCondition);
		
// 		$ids = array();
		
// 		foreach($result['data'] as $question){
// 			$ids[] = $question['gid'];
// 		}
		
// 		$tblChildQuestionIndex = array(
// 				'modify_sub_exam_question_index',
// 				'gid' , 'score' , 'objective_flag' , 'option_count' , 'question_type' , 'question_template' , 'parent_gid'
		
// 		);
		
// 		$tblChildQuestion = array(
// 				'modify_sub_exam_question',
// 				'content' , 'column_content' , 'answer' , 'analysis'
// 		);
		
// 		$tblChildCondition = array(
// 				'modify_sub_exam_question_index.gid=modify_sub_exam_question.gid',
// 				'where'=>'modify_sub_exam_question_index.parent_gid IN ("'.implode('","' , $ids).'")'
// 		);
		
// 		$result['children'] = $this->withQueryMaker($tblChildQuestionIndex , $tblChildQuestion , $tblChildCondition);
		$result['children'] = array();
		return $result;
	
	
	}
	
	public function get_question_by_chapter_not_in_id($subject_id , $idArray , $chapter_id , $offset , $step){
		
		global $CFG;
		$tableName = $CFG['subject'][$subject_id].'_edu_chapter2question';
		$questionName = $CFG['subject'][$subject_id].'_exam_question';
		$questionIndexName = $CFG['subject'][$subject_id].'_exam_question_index';
		
		$tblRelation = array(
				$tableName,
		);
		
		$tblQuestionIndex = array(
				$questionIndexName,
				'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' ,
				'option_count' , 'group_count' , 'question_type' , 'question_template' , 'exam_name' , 'subject_id' , 'source'
			
		);
		
		$tblQuestion = array(
				$questionName,
				'content' , 'column_content' , 'answer' , 'analysis'
		);
		
		
		$where = '';
		
		if(count($idArray) > 0){
			$where = $questionIndexName.'.gid NOT IN ("'.implode('","' , $idArray).'")';
		}
		
		$tblCondition = array(
				$tableName.'.question_id='.$questionIndexName.'.gid AND '.$tableName.'.chapter_id='.$chapter_id,
				$questionIndexName.'.gid='.$questionName.'.gid',
				'where'=>$where,
				'limit'=>$offset.','.$step
		);
		
		$result['data'] = $this->withQueryMaker($tblRelation , $tblQuestionIndex , $tblQuestion , $tblCondition);
		
		$result['count'] = $this->withQueryMakerOfNum($tblRelation , $tblQuestionIndex , $tblQuestion , $tblCondition);
		
		return $result;
		//子题目前产品库不存在
		$ids = array();
		
		foreach($result['data'] as $question){
			$ids[] = $question['gid'];
		}
		
		$tblChildQuestionIndex = array(
				'modify_sub_exam_question_index',
				'gid' , 'score' , 'objective_flag' , 'option_count' , 'question_type' , 'question_template' , 'parent_gid'
		
		);
		
		$tblChildQuestion = array(
				'modify_sub_exam_question',
				'content' , 'column_content' , 'answer' , 'analysis'
		);
		
		$tblChildCondition = array(
				'modify_sub_exam_question_index.gid=modify_sub_exam_question.gid',
				'where'=>'modify_sub_exam_question_index.parent_gid IN ("'.implode('","' , $ids).'")'
		);
		
		$result['children'] = $this->withQueryMaker($tblChildQuestionIndex , $tblChildQuestion , $tblChildCondition);
		
		
		return $result;
		
	}
	
	public function get_question_not_in_id($subject_id , $idArray , $offset , $step){
		global $CFG;
		$questionName = $CFG['subject'][$subject_id].'_exam_question';
		$questionIndexName = $CFG['subject'][$subject_id].'_exam_question_index';
		
		
		$tblQuestion = array(
				$questionName,
				'content' , 'column_content' , 'answer' , 'analysis'
		);
		
		$tblQuestionIndex = array(
				$questionIndexName,
				'gid' , 'subject_id' , 'grade_id' ,  'difficulty' , 'score' , 'objective_flag' , 
				'option_count' , 'group_count' , 'question_type' , 'question_template' , 'exam_name' , 'subject_id' , 'source'
// 		 'knowledge_id' ,'knowledge_text' ,'combine_flag' ,
		
		);
		
		$tblCondition = array(
				$questionName.'.gid='.$questionIndexName.'.gid',
				'where'=>$questionIndexName.'.gid NOT IN ("'.implode('","' , $idArray).'")',
				'limit' => $offset . ',' .$step
		);
		
		$result = array();
		$result['data'] = $this->withQueryMaker($tblQuestionIndex , $tblQuestion , $tblCondition);
		$result['count'] = $this->withQueryMakerOfNum($tblQuestionIndex , $tblQuestion , $tblCondition);
		return $result;
	}
	
	//题目去重
	public function duplicate_questions($subject_id , $gid , $gidArray){
		global $CFG;
		
		$tableName = $CFG['subject'][$subject_id] . '_exam_question';
		
		$gidStr = implode('","' , $gidArray);
		
		$updateSQL = <<<SQL
		
			UPDATE $tableName SET repeat_gid='$gid' WHERE gid IN ("$gidStr");
SQL;
// 		echo $updateSQL;
		$result = $this->exec($updateSQL);
		return $result;
		
		
	}


}