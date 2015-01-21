<?php
class tbl_temp_exam_question_index_0911 extends db_basic{
	protected function _define(){
		
		$this->key = 'id';
		
		$this->linkCFG->host = '192.168.1.41';
		$this->linkCFG->user = 'huhu';
		$this->linkCFG->password = '123456';
		$this->linkCFG->dbname = 'hx_curriculumn_0911';

	}
	
	public function get_question_without_knowledge($subject_id , $section_id , $offset , $step){
		
		global $CFG;
		$indexName = $CFG['subject'][$subject_id].'_exam_question_index';
		$questionName = $CFG['subject'][$subject_id].'_exam_question';
		
		
		$where = "subject_id=".$subject_id.' AND section_id='.$section_id;
		
		$tblQuestionIndex = array(
			$indexName,
			'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' , 
			'option_count' , 'group_count' , 'question_type' , 'question_template' , 'exam_name' , 'subject_id' , 'source' 
			
		);
		
		$tblQuestion = array(
			$questionName,
			'content' , 'column_content' , 'answer' , 'analysis'
		);
		
		$tblFilter = array(
			'temp_question_no_knowledge'
		);
		
		$tblCondition = array(
			$tblQuestionIndex[0].'.gid='.$tblQuestion[0].'.gid',
			$tblQuestionIndex[0].'.gid='.$tblFilter[0].'.gid',
			'where'=>$where,
			'order' => 'gid ASC',
			'limit'   =>  $offset.','.$step
		);
		
		$result['data'] = $this->withQueryMaker($tblQuestionIndex , $tblQuestion , $tblFilter , $tblCondition);
		
		$result['count'] = $this->withQueryMakerOfNum($tblQuestionIndex , $tblQuestion , $tblFilter , $tblCondition);

		return $result;
		
	}
	
	public function get_question_without_knowledge_filter($subject_id , $section_id , $offset , $step){
	
		global $CFG;
		$indexName = $CFG['subject'][$subject_id].'_exam_question_index';
		$questionName = $CFG['subject'][$subject_id].'_exam_question';
	
	
		$where = "subject_id=".$subject_id.' AND section_id='.$section_id.' AND '.$indexName.'.gid NOT IN (SELECT gid FROM '.db_config::$sourcename .'_'. $_SESSION['select_version']['extends'].'.modify_exam_question_index)';
	
		$tblQuestionIndex = array(
				$indexName,
				'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' ,
				'option_count' , 'group_count' , 'question_type' , 'question_template' , 'exam_name' , 'subject_id' , 'source'
		
		);
	
		$tblQuestion = array(
				$questionName,
				'content' , 'column_content' , 'answer' , 'analysis'
		);
	
		$tblFilter = array(
				'temp_question_no_knowledge'
		);
	
		$tblCondition = array(
				$tblQuestionIndex[0].'.gid='.$tblQuestion[0].'.gid',
				$tblQuestionIndex[0].'.gid='.$tblFilter[0].'.gid',
				'where'=>$where,
				'order' => 'gid ASC',
				'limit'   =>  $offset.','.$step
		);
	
		$result['data'] = $this->withQueryMaker($tblQuestionIndex , $tblQuestion , $tblFilter , $tblCondition);
	
		$result['count'] = $this->withQueryMakerOfNum($tblQuestionIndex , $tblQuestion , $tblFilter , $tblCondition);
	
		return $result;
	
	}
	
	
	
	
	public function post_modify_question_knowledge($questions){
	
		// 		ini_set('display_errors','On');
		global $CFG;
	
		//插入question和question_index表的SQL
		$insertIndexSQL = 'INSERT INTO modify_exam_question_index (gid , knowledge_id , knowledge_text) VALUES ';
	
		//插入子题表的SQL
		$insertChildIndexSQL = 'INSERT INTO modify_sub_exam_question_index (gid ,knowledge_id , knowledge_text) VALUES ';
	
		$insertSons = array();
	
		//内容里有单引号，用两个单引号代替
		foreach($questions as $question){
			$insertIndexSQL .= '("'.$question['gid'].'" , "'.implode(',' , $question['knowledge']).'" , "'.implode(',' , $question['knowledge_text']).'"),';
				
			foreach($question['children'] as $child){
				$insertSons[] = array(
						'gid'=>$child['gid'],
						'knowledge_id' => implode(',' , $child['knowledge']),
						'knowledge_text' => implode(',' , $child['knowledge_text'])
				);
					
			}
		}
	
		foreach($insertSons as $sons){
			$insertChildIndexSQL .= '("'.$sons['gid'].'" , "'.$sons['knowledge_id'].'"  , "'.$sons['knowledge_text'].'"),';
		}
	
		$insertIndexSQL = substr($insertIndexSQL , 0 , strlen($insertIndexSQL) - 1);
	
		$insertChildIndexSQL = substr($insertChildIndexSQL , 0 , strlen($insertChildIndexSQL) - 1);
	
		$insertIndexSQL .= 'ON DUPLICATE KEY UPDATE knowledge_id=VALUES(knowledge_id) , knowledge_text=VALUES(knowledge_text) ,	modify_time=unix_timestamp()';
	
		$insertChildIndexSQL .= 'ON DUPLICATE KEY UPDATE knowledge_id=VALUES(knowledge_id) , knowledge_text=VALUES(knowledge_text) ';	
	
		$result1 = $this->exec($insertIndexSQL);
		// 		echo $insertIndexSQL;
	
	
		if(count($insertSons) > 0){
			$result2 = $this->exec($insertChildIndexSQL) === false ? false : true;
		}else{
			$result2 = true;
		}
	
		return $result1 && $result2;
	
	}
	
	
}