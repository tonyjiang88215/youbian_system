<?php
class tbl_exam_question_index extends db_basic{
	protected function _define(){
//		$this->tableName = 'hx_edu_source';
		$this->key = 'id';
		
// 		$this->linkCFG->host = '192.168.1.61';
// 		$this->linkCFG->user = 'huhu';
// 		$this->linkCFG->password = '123456';
// 		$this->linkCFG->dbname = 'hx_curriculumn';
		
	}
	
	//获取未入库的试题列表，建表
	public function get_exam_names($subject_id , $section_id){
		$this->tableName = 'in_exam_question_index';
		
		$sql = <<<SQL
			SELECT DISTINCT in_exam_question_index.exam_name ,in_exam_question_index.source ,setin_exam_name.id
			FROM in_exam_question_index 
			LEFT JOIN edu_grade ON in_exam_question_index.grade_id=edu_grade.id 
			LEFT JOIN setin_exam_name ON in_exam_question_index.exam_name=setin_exam_name.exam_name 
			WHERE in_exam_question_index.subject_id=$subject_id AND edu_grade.section_id=$section_id
		
SQL;
		
		$result = $this->query($sql);
//		$result = $this->select('DISTINCT exam_name ,source ' , null , null , null);
		return $result;
	}
	
	//查询没有入库到试卷中的题目
	public function get_question_for_exam($setin_exam_id , $offset , $step){
	
		$tblQuestionIndex = array(
			'modify_exam_question_index',
			'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' , 
			'option_count' , 'group_count' , 'question_type' , 'question_template' , 'setin_exam_id', 'exam_name' , 'subject_id' , 'source' ,
			'time' , 'keyword' 
			
		);
		
		$tblQuestion = array(
			'modify_exam_question',
			'content' , 'column_content' , 'answer' , 'analysis'
		);
		
		$tblCondition = array(
			'modify_exam_question_index.gid=modify_exam_question.gid',
			'where'=>'modify_exam_question_index.setin_exam_id="'.$setin_exam_id.'" AND modify_exam_question_index.gid NOT IN (SELECT question_id FROM exam_examination_to_question)',
			'limit'=>$offset.','.$step
		);
		
		$countSQL = 'SELECT MAX(gid) as gid FROM modify_exam_question_index WHERE modify_exam_question_index.setin_exam_id="'.$setin_exam_id.'" AND gid NOT LIKE "%undefined%" ';
		
		$result['data'] = $this->withQueryMaker($tblQuestionIndex , $tblQuestion , $tblCondition);
		
		$result['count'] = $this->withQueryMakerOfNum($tblQuestionIndex , $tblQuestion , $tblCondition);
		
		$totalCount = $this->query($countSQL);
		$result['max_gid'] = $totalCount[0]['gid'];
		
		$ids = array();
		
		foreach($result['data'] as $question){
			$ids[] = $question['gid'];
		}
		
		$tblChildQuestionIndex = array(
			'modify_sub_exam_question_index',
			'gid' , 'score' , 'objective_flag' , 'option_count' , 'question_type' , 'question_template' , 'parent_gid',
			'knowledge_id' , 'knowledge_text' , 'time' , 'keyword' , 'difficulty'
			
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
	
	//查询已经入库到试卷中的题目
	public function get_question_by_exam_id($exam_id , $offset , $step){
		
		$tblRelation = array(
			'exam_examination_to_question',
		);
		
		$tblQuestionIndex = array(
			'modify_exam_question_index',
			'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' , 
			'option_count' , 'group_count' , 'question_type' , 'question_template' , 'setin_exam_id' , 'exam_name' , 'subject_id' , 'source' ,
			'time' , 'keyword'
			
		);
		
		$tblQuestion = array(
			'modify_exam_question',
			'content' , 'column_content' , 'answer' , 'analysis'
		);
		
		
		$tblCondition = array(
			'exam_examination_to_question.question_id=modify_exam_question_index.gid AND exam_examination_to_question.exam_id='.$exam_id,
			'modify_exam_question_index.gid=modify_exam_question.gid',
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
			'gid' , 'score' , 'objective_flag' , 'option_count' , 'question_type' , 'question_template' , 'parent_gid',
			'knowledge_id' , 'knowledge_text' , 'time' , 'keyword' , 'difficulty'
			
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
	
	//查询已经入库到试卷中的再库题目
	public function get_question_by_exam_id_instore($version_id , $suject_id , $exam_id , $offset , $step){
		
		
	}

	//查询没有入库到章节中的题目
	public function get_question_for_chapter($subject_id , $setin_exam_id , $offset , $step){
		
		global $CFG;
		
		$tableName = $CFG['subject'][$subject_id].'_edu_chapter2question';
	
		$tblQuestionIndex = array(
				'modify_exam_question_index',
				'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' ,
				'option_count' , 'group_count' , 'question_type' , 'question_template' , 'setin_exam_id', 'exam_name' , 'subject_id' , 'source',
				'time' , 'keyword'
		
		);
	
		$tblQuestion = array(
				'modify_exam_question',
				'content' , 'column_content' , 'answer' , 'analysis'
		);
	
		$tblCondition = array(
				'modify_exam_question_index.gid=modify_exam_question.gid',
				'where'=>'modify_exam_question_index.setin_exam_id="'.$setin_exam_id.'" AND modify_exam_question_index.gid NOT IN (SELECT question_id FROM '.$tableName.')',
				'limit'=>$offset.','.$step
		);
	
		$countSQL = 'SELECT MAX(gid) as gid FROM modify_exam_question_index WHERE modify_exam_question_index.setin_exam_id="'.$setin_exam_id.'" AND gid NOT LIKE "%undefined%" ';
	
		$result['data'] = $this->withQueryMaker($tblQuestionIndex , $tblQuestion , $tblCondition);
	
		$result['count'] = $this->withQueryMakerOfNum($tblQuestionIndex , $tblQuestion , $tblCondition);
	
		$totalCount = $this->query($countSQL);
		$result['max_gid'] = $totalCount[0]['gid'];
	
		$ids = array();
	
		foreach($result['data'] as $question){
			$ids[] = $question['gid'];
		}
	
		$tblChildQuestionIndex = array(
				'modify_sub_exam_question_index',
				'gid' , 'score' , 'objective_flag' , 'option_count' , 'question_type' , 'question_template' , 'parent_gid',
				'knowledge_id' , 'knowledge_text' , 'time' , 'keyword' , 'difficulty'
		
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
	
	//查询已经入库到章节中的题目
	public function get_question_by_chapter_id($user_id , $subject_id , $chapter_id , $offset , $step){
		global $CFG;
		$tableName = $CFG['subject'][$subject_id].'_edu_chapter2question';
		
		$tblRelation = array(
				$tableName,
		);
	
		$tblQuestionIndex = array(
				'modify_exam_question_index',
				'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' ,
				'option_count' , 'group_count' , 'question_type' , 'question_template' , 'setin_exam_id' , 'exam_name' , 'subject_id' , 'source',
				'time' , 'keyword' , 'modify_time'
		
		);
	
		$tblQuestion = array(
				'modify_exam_question',
				'content' , 'column_content' , 'answer' , 'analysis'
		);
		
		$tblSetin =array(
				'setin_exam'
		);
	
	
		$tblCondition = array(
				$tableName.'.question_id=modify_exam_question_index.gid AND '.$tableName.'.chapter_id='.$chapter_id,
				'modify_exam_question_index.gid=modify_exam_question.gid',
				'modify_exam_question_index.setin_exam_id=setin_exam.id',
				'limit'=>$offset.','.$step
		);
	
		$result['data'] = $this->withQueryMaker($tblRelation , $tblQuestionIndex , $tblQuestion , $tblSetin , $tblCondition);
// 			$result['data'] = $this->withQueryMaker($tblRelation , $tblQuestionIndex , $tblQuestion ,$tblCondition);
		
		
		$result['count'] = $this->withQueryMakerOfNum($tblRelation , $tblQuestionIndex , $tblQuestion , $tblSetin , $tblCondition);
// 			$result['count'] = $this->withQueryMakerOfNum($tblRelation , $tblQuestionIndex , $tblQuestion ,$tblCondition);
			
	
		$ids = array();
	
		foreach($result['data'] as $question){
			$ids[] = $question['gid'];
		}
	
		$tblChildQuestionIndex = array(
				'modify_sub_exam_question_index',
				'gid' , 'score' , 'objective_flag' , 'option_count' , 'question_type' , 'question_template' , 'parent_gid',
				'knowledge_id' , 'knowledge_text' , 'time' , 'keyword' , 'difficulty'
		
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
	
	//查询已经入库到章节中的再库题目
	public function get_question_id_by_chapter_id_instore($subject_id , $filter_id){
		global $CFG;
		$relationName= $CFG['subject'][$subject_id].'_edu_chapter2question';
		$questionName = $CFG['subject'][$subject_id].'_exam_question';
		$questionIndexName = $CFG['subject'][$subject_id].'_exam_question_index';
		
		$filterChapterName = $CFG['subject'][$subject_id].'_edu_chapter';
		$filterRelationName = $CFG['subject'][$subject_id].'_edu_chapter2question';
		
// 		print_r($CFG['data']['curriculumn']);
		
		$where = '';
		
		$tmp = array();
		
			$sql = <<<SQL
			SELECT question_id FROM $filterRelationName t1 WHERE t1.chapter_id=$filter_id;
			
SQL;
// 			echo $sql;
			$result = $this->query($sql);
			foreach($result as $v){
				$tmp[] = $v['question_id'];
			}
			$where = '"'.implode('","' , $tmp).'"';
		
		return $tmp;
		
// 		if($where != ''){
// 			$where = $questionIndexName.'.gid NOT IN ('.$where.')';
// 		}
		
// 		$tblRelation = array(
// 				$relationName,
// 		);
		
// 		$tblQuestionIndex = array(
// 				$questionIndexName , 
// 				'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' ,
// 				'option_count' , 'group_count' , 'question_type' , 'question_template' , 'exam_name' , 'subject_id' , 'source'
				
		
// 		);
		
// 		$tblQuestion = array(
// 				$questionName ,
// 				'content' , 'column_content' , 'answer' , 'analysis'
// 		);
		
		
// 		$tblCondition = array(
// 				$relationName.'.question_id='.$questionIndexName.'.gid AND '.$relationName.'.chapter_id='.$chapter_id,
// 				$questionIndexName.'.gid='.$questionName.'.gid',
// 				'where'=>$where,
// 				'limit'=>$offset.','.$step
// 		);
		
// 		$result = array();
		
// 		$result['data'] = $this->withQueryMaker($tblRelation , $tblQuestionIndex , $tblQuestion , $tblCondition);
// 		$result['count'] = $this->withQueryMakerOfNum($tblRelation , $tblQuestionIndex , $tblQuestion , $tblCondition);
//字体目前不需要	

// 		$ids = array();
		
// 		foreach($result['data'] as $question){
// 			$ids[] = $question['gid'];
// 		}
		
// 		$tblChildQuestionIndex = array(
// 				'modify_sub_exam_question_index',
// 				'gid' , 'score' , 'objective_flag' , 'option_count' , 'question_type' , 'question_template' , 'parent_gid',
//					'knowledge_id' , 'knowledge_text' , 'time' , 'keyword' , 'difficulty'
		
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
		
		
		return $result;
	}
	
	//查询没有入库到知识点的题目
	public function get_question_for_knowledge($subject_id , $setin_exam_id , $offset , $step){
		global $CFG;
		
		$tableName = $CFG['subject'][$subject_id].'_edu_knowledge2question';
		
		$tblQuestionIndex = array(
				'modify_exam_question_index',
				'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' ,
				'option_count' , 'group_count' , 'question_type' , 'question_template' , 'setin_exam_id', 'exam_name' , 'subject_id' , 'source',
				'time' , 'keyword'
		
		);
		
		$tblQuestion = array(
				'modify_exam_question',
				'content' , 'column_content' , 'answer' , 'analysis'
		);
		
		$tblCondition = array(
				'modify_exam_question_index.gid=modify_exam_question.gid',
				'where'=>'modify_exam_question_index.setin_exam_id="'.$setin_exam_id.'" AND modify_exam_question_index.gid NOT IN (SELECT question_id FROM '.$tableName.')',
				'limit'=>$offset.','.$step
		);
		
		$countSQL = 'SELECT MAX(gid) as gid FROM modify_exam_question_index WHERE modify_exam_question_index.setin_exam_id="'.$setin_exam_id.'" AND gid NOT LIKE "%undefined%" ';
		
		$result['data'] = $this->withQueryMaker($tblQuestionIndex , $tblQuestion , $tblCondition);
		
		$result['count'] = $this->withQueryMakerOfNum($tblQuestionIndex , $tblQuestion , $tblCondition);
		
		$totalCount = $this->query($countSQL);
		$result['max_gid'] = $totalCount[0]['gid'];
		
		$ids = array();
		
		foreach($result['data'] as $question){
			$ids[] = $question['gid'];
		}
		
		$tblChildQuestionIndex = array(
				'modify_sub_exam_question_index',
				'gid' , 'score' , 'objective_flag' , 'option_count' , 'question_type' , 'question_template' , 'parent_gid',
				'knowledge_id' , 'knowledge_text' , 'time' , 'keyword' , 'difficulty'
		
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
	
	//查询已经入库到知识点的题目
	public function get_question_by_knowledge_id($subject_id , $knowledge_id , $offset , $step){
		global $CFG;
		$tableName = $CFG['subject'][$subject_id].'_edu_knowledge2question';
		
// 		$tblRelation = array(
// 				$tableName,
// 		);
		
		$tblQuestionIndex = array(
				'modify_exam_question_index',
				'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' ,
				'option_count' , 'group_count' , 'question_type' , 'question_template' , 'setin_exam_id' , 'exam_name' , 'subject_id' , 'source' ,
				'time' , 'keyword'
		
		);
		
		$tblQuestion = array(
				'modify_exam_question',
				'content' , 'column_content' , 'answer' , 'analysis'
		);
		
		$tblCondition = array(
// 				$tableName.'.question_id=modify_exam_question_index.gid AND '.$tableName.'.knowledge_id='.$knowledge_id,
				'modify_exam_question_index.gid=modify_exam_question.gid',
				'where'=>'concat(",",modify_exam_question_index.knowledge_id,",") like "%,'.$knowledge_id.',%"',
				'limit'=>$offset.','.$step
		);
		
		$result['data'] = $this->withQueryMaker($tblQuestionIndex , $tblQuestion , $tblCondition);
		
		$result['count'] = $this->withQueryMakerOfNum($tblQuestionIndex , $tblQuestion , $tblCondition);
		
		
		$ids = array();
		
		foreach($result['data'] as $question){
			$ids[] = $question['gid'];
		}
		
		$tblChildQuestionIndex = array(
				'modify_sub_exam_question_index',
				'gid' , 'score' , 'objective_flag' , 'option_count' , 'question_type' , 'question_template' , 'parent_gid',
				'knowledge_id' , 'knowledge_text' , 'time' , 'keyword' , 'difficulty'
		
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
	
	//查询没有入库到专题的题目
	public function get_question_for_zhuanti($subject_id , $setin_exam_id , $offset , $step){
		global $CFG;
	
		$tableName = $CFG['subject'][$subject_id].'_edu_zhuanti2question';
		
		$tblQuestionIndex = array(
				'modify_exam_question_index',
				'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' ,
				'option_count' , 'group_count' , 'question_type' , 'question_template' , 'setin_exam_id', 'exam_name' , 'subject_id' , 'source',
				'time' , 'keyword'
	
		);
	
		$tblQuestion = array(
				'modify_exam_question',
				'content' , 'column_content' , 'answer' , 'analysis'
		);
	
		$tblCondition = array(
				'modify_exam_question_index.gid=modify_exam_question.gid',
				'where'=>'modify_exam_question_index.setin_exam_id="'.$setin_exam_id.'" AND modify_exam_question_index.gid NOT IN (SELECT question_id FROM '.$tableName.')',
				'limit'=>$offset.','.$step
		);
	
		$countSQL = 'SELECT MAX(gid) as gid FROM modify_exam_question_index WHERE modify_exam_question_index.setin_exam_id="'.$setin_exam_id.'" AND gid NOT LIKE "%undefined%" ';
	
		$result['data'] = $this->withQueryMaker($tblQuestionIndex , $tblQuestion , $tblCondition);
	
		$result['count'] = $this->withQueryMakerOfNum($tblQuestionIndex , $tblQuestion , $tblCondition);
	
		$totalCount = $this->query($countSQL);
		$result['max_gid'] = $totalCount[0]['gid'];
	
		$ids = array();
	
		foreach($result['data'] as $question){
			$ids[] = $question['gid'];
		}
	
		$tblChildQuestionIndex = array(
				'modify_sub_exam_question_index',
				'gid' , 'score' , 'objective_flag' , 'option_count' , 'question_type' , 'question_template' , 'parent_gid',
				'knowledge_id' , 'knowledge_text' , 'time' , 'keyword' , 'difficulty'
	
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
	
	//查询已经入库到知识点的题目
	public function get_question_by_zhuanti_id($subject_id , $zhuanti_id , $offset , $step){
		global $CFG;
		$tableName = $CFG['subject'][$subject_id].'_edu_zhuanti2question';
	
		$tblRelation = array(
				$tableName,
		);
	
		$tblQuestionIndex = array(
				'modify_exam_question_index',
				'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' ,
				'option_count' , 'group_count' , 'question_type' , 'question_template' , 'setin_exam_id' , 'exam_name' , 'subject_id' , 'source' ,
				'time' , 'keyword'
	
		);
	
		$tblQuestion = array(
				'modify_exam_question',
				'content' , 'column_content' , 'answer' , 'analysis'
		);
	
		$tblCondition = array(
				$tableName.'.question_id=modify_exam_question_index.gid AND '.$tableName.'.zhuanti_id='.$zhuanti_id,
				'modify_exam_question_index.gid=modify_exam_question.gid',
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
				'gid' , 'score' , 'objective_flag' , 'option_count' , 'question_type' , 'question_template' , 'parent_gid',
				'knowledge_id' , 'knowledge_text' , 'time' , 'keyword' , 'difficulty'
	
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
	
	
	public function get_question_by_id($subject_id , $idArray){
		global $CFG;
		$questionName = 'modify_exam_question';
		$questionIndexName = 'modify_exam_question_index';
		
		
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
		
		$result = array();
		
		$result['data'] = $this->withQueryMaker($tblQuestionIndex , $tblQuestion , $tblCondition);
		
		$ids = array();
		
		foreach($result['data'] as $question){
			$ids[] = $question['gid'];
		}
		
		$tblChildQuestionIndex = array(
				'modify_sub_exam_question_index',
				'gid' , 'score' , 'objective_flag' , 'option_count' , 'question_type' , 'question_template' , 'parent_gid' , 
				'knowledge_id' , 'knowledge_text' , 'time' , 'keyword' , 'difficulty'
		
		);
		
		$tblChildQuestion = array(
				'modify_sub_exam_question',
				'content' , 'column_content' , 'answer' , 'analysis'
		);
		
		$tblChildCondition = array(
				'modify_sub_exam_question_index.gid=modify_sub_exam_question.gid',
				'where'=>'modify_sub_exam_question_index.parent_gid IN ("'.implode('","' , $ids).'")',
				'order' => 'sub_index ASC , gid ASC'
		);
		
		$result['children'] = $this->withQueryMaker($tblChildQuestionIndex , $tblChildQuestion , $tblChildCondition);
		return $result;
		
		
	}
	
	public function post_modify_question($questions){
		
// 		ini_set('display_errors','On');
		global $CFG;
		$grade = array('1'=>'66','2'=>'77','3'=>'88');
	
		//插入question和question_index表的SQL
		$insertSQL = 'INSERT INTO modify_exam_question (gid , content , column_content , answer , analysis) VALUES ';
		$insertIndexSQL = 'INSERT INTO modify_exam_question_index (
				gid , subject_id , grade_id, section_id ,  knowledge_id , knowledge_text , difficulty , score , 
				objective_flag , combine_flag ,  option_count , group_count , question_type , question_template , 
				setin_exam_id , exam_name , source , time , keyword
		) VALUES ';
		
		//插入子题表的SQL
		$insertChildSQL = 'INSERT INTO modify_sub_exam_question (gid , content , column_content , answer , analysis) VALUES';
		$insertChildIndexSQL = 'INSERT INTO modify_sub_exam_question_index (gid , score , objective_flag , option_count , question_type , question_template , exam_name , source , parent_gid , setin_exam_id , knowledge_id , knowledge_text , time , keyword , difficulty) VALUES ';
		
		$insertSons = array();
		
		//内容里有单引号，用两个单引号代替
		foreach($questions as $question){
			$insertSQL .= '("'.$question['gid'].'" , \''.str_replace('\'',"\'",$question['question_content']).'\' , \''.str_replace('\\', '\\\\', str_replace('\'',"\'", json_encode($question['column']))).'\' , \''.str_replace('\'',"\'",$question['answer_content']).'\' , \''.str_replace('\'',"\'",$question['analysis_content']).'\'),';
			$insertIndexSQL .= '("'.$question['gid'].'" , '.$question['subject_id'].' , ' . ($question['grade_id'] ? $question['grade_id'] : $grade[$question['section_id']]) . ' , '.$question['section_id'].' , "'.implode(',' , $question['knowledge']).'" , "'.implode(',' , $question['knowledge_text']).'" , "'.$question['difficulty'].'" , "'.$question['score'].'" , '.$question['objective_flag'].' , '.$question['combine_flag'].' , '.$question['column_count'].' , '.(count($question['children'])+1).' , "'.$question['question_type'].'" , '.$question['question_template'].' ,  "'.$question['setin_exam_id'].'" , "'.str_replace('\'',"\'",$question['exam_name']).'" , "'.$question['source'].'" , "'.$question['time'].'" , "'.str_replace('\'',"\'",$question['keyword']).'" ),';
			
			foreach($question['children'] as $child){
					$insertSons[] = array(
						'gid'=>$child['gid'],
						'question_content'=>str_replace('\'',"\'", $child['question_content'])  , 
// 						'column'=>str_replace('\'',"\'", implode('@hx_column@',$child['column'])),
						'column'=>str_replace('\\', '\\\\', str_replace('\'',"\'", json_encode($child['column']))),
						'answer_content'=>str_replace('\'',"\'",$child['answer_content']),
						'analysis_content'=>str_replace('\'',"\'",$child['analysis_content']),
						'source'=>$question['source'],
					
						'score'=>$child['score'],
						'objective_flag'=>$child['objective_flag'],
						'option_count'=>$child['column_count'],
						'question_type'=>$child['question_type'],
						'question_template'=>$child['question_template'],
						'exam_name'=>$question['exam_name'],
						'source'=>$question['source'],
						'parent_gid'=>$child['parent_gid'],
						'setin_exam_id' => $child['setin_exam_id'],
							
						'knowledge_id' => implode(',' , $child['knowledge']),
						'knowledge_text' => implode(',' , $child['knowledge_text']),
						'time' => $child['time'],
						'keyword' => $child['keyword'],
						'difficulty' => $child['difficulty']
					);
					
			}
		}
		
		foreach($insertSons as $sons){
			$insertChildSQL .= '("'.$sons['gid'].'" , \''.$sons['question_content'].'\' , \''.$sons['column'].'\' , \''.$sons['answer_content'].'\' , \''.$sons['analysis_content'].'\'),';
			$insertChildIndexSQL .= '("'.$sons['gid'].'" , "'.$sons['score'].'" , '.$sons['objective_flag'].' , "'.$sons['option_count'].'" , "'.$sons['question_type'].'" , '.$sons['question_template'].' , "'.$sons['exam_name'].'" , "'.$sons['source'].'"  , "' . $sons['parent_gid'] . '" , "'.$sons['setin_exam_id'].'" , "'.$sons['knowledge_id'].'"  , "'.$sons['knowledge_text'].'"  , "'.$sons['time'].'"  , "'.$sons['keyword'].'"  , "'.$sons['difficulty'].'"),';
		}
		
		$insertSQL = substr($insertSQL , 0 , strlen($insertSQL) - 1);
		$insertIndexSQL = substr($insertIndexSQL , 0 , strlen($insertIndexSQL) - 1);
		
		$insertChildSQL = substr($insertChildSQL , 0 , strlen($insertChildSQL) - 1);
		$insertChildIndexSQL = substr($insertChildIndexSQL , 0 , strlen($insertChildIndexSQL) - 1);
		
		$insertSQL .= ' ON DUPLICATE KEY UPDATE content=VALUES(content) , column_content=VALUES(column_content) , answer=VALUES(answer) , analysis=VALUES(analysis) , modify_count=modify_count+1';
		$insertIndexSQL .= 'ON DUPLICATE KEY UPDATE 
				grade_id=VALUES(grade_id) , knowledge_id=VALUES(knowledge_id) , knowledge_text=VALUES(knowledge_text) , difficulty=VALUES(difficulty) , 
				score=VALUES(score) , objective_flag=VALUES(objective_flag) , combine_flag=VALUES(combine_flag) , 
				option_count=VALUES(option_count) , group_count=VALUES(group_count) , question_type=VALUES(question_type) , 
				question_template=VALUES(question_template) , exam_name=VALUES(exam_name) , 
				setin_exam_id=VALUES(setin_exam_id) , source=VALUES(source) , time=VALUES(time) , keyword=VALUES(keyword) , 
				modify_time=unix_timestamp()';
		
		
		$insertChildSQL .= ' ON DUPLICATE KEY UPDATE content=VALUES(content) , column_content=VALUES(column_content) , answer=VALUES(answer) , analysis=VALUES(analysis)';
		$insertChildIndexSQL .= 'ON DUPLICATE KEY UPDATE score=VALUES(score) , objective_flag=VALUES(objective_flag) , option_count=VALUES(option_count) , question_type=VALUES(question_type) , question_template=VALUES(question_template) , exam_name=VALUES(exam_name) , source=VALUES(source) , setin_exam_id=VALUES(setin_exam_id) , knowledge_id=VALUES(knowledge_id) , knowledge_text=VALUES(knowledge_text) , time=VALUES(time) , keyword=VALUES(keyword) , difficulty=VALUES(difficulty)';
		
		$result1 = $this->exec($insertSQL);
		
		$result2 = $this->exec($insertIndexSQL);
// 		echo $insertIndexSQL;
		
		
		if(count($insertSons) > 0){
			$result3 = $this->exec($insertChildSQL) === false ? false : true;
			
			$result4 = $this->exec($insertChildIndexSQL) === false ? false : true;
		}else{
			$result3 = true;
			$result4 = true;
		}
		
// 		//将知识关系插入关系表中
// 		$knowledgeTableName = $CFG['subject'][$questions[0]['subject_id']].'_edu_knowledge2question';
		
// 		$insertKnowledgeRelationSQL = <<<SQL
		
// 				INSERT INTO $knowledgeTableName (knowledge_id , question_id) VALUES
		
// SQL;
		
// 		foreach($questions as $question){
			
// 		}
		
		
// 		$result5 = false;
		
		return ($result1 || $result2) && ($result3 || $result4);
		
	}
	
	public function post_exam_reset($subject_id , $version_id , $exam_id){
		
		global $CFG;
		
		$prefix = $CFG['subject'][$subject_id];
		
		$chapterTableName = $prefix.'_edu_chapter2question';
		$knowledgeTableName = $prefix.'_edu_knowledge2question';
		$zhuantiTableName = $prefix.'_edu_zhuanti2question';
		
		
		//删除已经拆出来的题
		
		$deleteSQL = <<<SQL
		
		DELETE modify_exam_question , modify_exam_question_index , exam_examination_to_question 
		FROM 
		modify_exam_question_index JOIN modify_exam_question ON modify_exam_question_index.gid=modify_exam_question.gid 
		LEFT JOIN exam_examination_to_question ON modify_exam_question_index.gid=exam_examination_to_question.question_id 
		WHERE modify_exam_question_index.setin_exam_id=$exam_id
		
SQL;

		
		//删除子题
		$deleteSubSQL = <<<SQL
		
		DELETE modify_sub_exam_question , modify_sub_exam_question_index 
		FROM 
		modify_sub_exam_question_index JOIN modify_sub_exam_question ON modify_sub_exam_question_index.gid=modify_sub_exam_question.gid 
		WHERE modify_sub_exam_question_index.setin_exam_id=$exam_id
		
SQL;
		
		//删除已经入库试卷的关系
		$deleteExamSQL = <<<SQL
			DELETE b 
			FROM 
			modify_exam_question_index a LEFT JOIN exam_examination_to_question b ON a.gid=b.question_id 
			WHERE a.setin_exam_id=$exam_id 
		
SQL;
		
		//删除已经入库的章节关系
		
// 		$chapterTableName = $prefix.'_edu_chapter2question';
		
		$deleteChapterSQL = <<<SQL
		
			DELETE b
			FROM
			modify_exam_question_index a LEFT JOIN $chapterTableName b ON a.gid=b.question_id
			WHERE a.setin_exam_id=$exam_id
		
SQL;
		
		//删除已经入库的知识关系

// 		$knowledgeTableName = $prefix.'_edu_knowledge2question';

		$deleteKnowledgeSQL = <<<SQL
		
			DELETE b 
			FROM 
			modify_exam_question_index a LEFT JOIN $knowledgeTableName b ON a.gid=b.question_id 
			WHERE a.setin_exam_id=$exam_id 
		
SQL;
		
// 		$zhuantiTableName = $prefix.'_edu_zhuanti2question';
		
		$deleteZhuantiSQL = <<<SQL
		
			DELETE b
			FROM
			modify_exam_question_index a LEFT JOIN $zhuantiTableName b ON a.gid=b.question_id
			WHERE a.setin_exam_id=$exam_id
		
SQL;
		
		
		
		$_result3 = $this->exec($deleteExamSQL);
// 		echo $deleteExamSQL;
		$_result4 = $this->exec($deleteKnowledgeSQL);
// 		echo $deleteKnowledgeSQL;
		$_result5 = $this->exec($deleteChapterSQL);
		
		$_result6 = $this->exec($deleteZhuantiSQL);
		
// 		echo $deleteChapterSQL;
		$_result1 = $this->exec($deleteSQL);
		
		$_result2 =$this->exec($deleteSubSQL);

		$result = $_result1 || $_result2 || $_result3 || $_result4 || $_result5 || $_result6;
		
		if(true){
			
			$insertSQL = <<<SQL
			INSERT INTO modify_exam_question 
			(gid , content , source) 
			SELECT in_exam_question.gid , content , in_exam_question.source FROM in_exam_question 
			LEFT JOIN in_exam_question_index ON in_exam_question.gid=in_exam_question_index.gid 
			WHERE in_exam_question_index.setin_exam_id=$exam_id ;
SQL;
			$insertIndexSQL = <<<SQL
			INSERT INTO modify_exam_question_index 
			(gid , source , subject_id , grade_id , setin_exam_id) 
			SELECT  gid , source , subject_id , grade_id , setin_exam_id FROM in_exam_question_index 
			WHERE in_exam_question_index.setin_exam_id=$exam_id ;
SQL;
			
			$updateSQL = <<<SQL
		
			UPDATE setin_exam SET finish_flag=0 WHERE id=$exam_id;			
SQL;
			
			$_result4 = $this->exec($insertSQL);
			$_result5 = $this->exec($insertIndexSQL) ;
			$_result6 = $this->exec($updateSQL);

			$result = $_result4 && $_result5 || $_result6;
			
		}
		
		return $result;
		
	}

	public function post_remove_question($question_id , $type){
		
		if($type == 'parent'){
		
			$deleteSQL = <<<SQL
			
			DELETE modify_exam_question , modify_exam_question_index 
			FROM 
			modify_exam_question_index JOIN modify_exam_question ON modify_exam_question_index.gid=modify_exam_question.gid 
			WHERE modify_exam_question_index.gid='$question_id'
			
SQL;
	
			$deleteSubSQL = <<<SQL
			
			DELETE modify_sub_exam_question , modify_sub_exam_question_index 
			FROM 
			modify_sub_exam_question_index JOIN modify_sub_exam_question ON modify_sub_exam_question_index.gid=modify_sub_exam_question.gid 
			WHERE modify_sub_exam_question_index.parent_gid='$question_id'
			
			
SQL;
	
			$result = $this->exec($deleteSQL) || $this->exec($deleteSubSQL);
		
		}else{
			
			$deleteSQL =<<<SQL
			
			DELETE modify_sub_exam_question , modify_sub_exam_question_index 
			FROM 
			modify_sub_exam_question_index JOIN modify_sub_exam_question ON modify_sub_exam_question_index.gid=modify_sub_exam_question.gid 
			WHERE modify_sub_exam_question_index.gid='$question_id'
			
SQL;
			
			$result = $this->exec($deleteSQL);
			
		}
		
		return $result;
	}


}