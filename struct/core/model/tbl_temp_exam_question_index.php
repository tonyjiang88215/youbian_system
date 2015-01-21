<?php
class tbl_temp_exam_question_index extends db_basic{
	protected function _define(){
		
		$this->key = 'id';
		
	}
	
	public function get_question_without_knowledge($subject_id , $section_id){
		
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
			'order' => 'gid ASC'
		);
		
		$result['data'] = $this->withQueryMaker($tblQuestionIndex , $tblQuestion , $tblFilter , $tblCondition);
		
		$result['count'] = $this->withQueryMakerOfNum($tblQuestionIndex , $tblQuestion , $tblFilter , $tblCondition);

		return $result;
		
	}
	
	public function get_question_by_id($question_ids){
		
		
		$questionName = 'modify_exam_question';
		$questionIndexName = 'modify_exam_question_index';
		
		
		$tblQuestionIndex = array(
				$questionIndexName,
				'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' ,
				'option_count' , 'group_count' , 'question_type' , 'question_template' , 'setin_exam_id' , 'exam_name' , 'subject_id' , 'source' ,
				'time' , 'keyword'
		
		);
		
		$tblCondition = array(
				'where'=>$questionIndexName.'.gid IN ("'.implode('","' , $question_ids).'")'
		);
		
		$result = array();
		
		$result['data'] = $this->withQueryMaker($tblQuestionIndex , $tblQuestion , $tblCondition);
		
		return $result;
		
	}
	
	public function get_question_count($subject_id , $section_id){
		$sql = 'select count(*) as count from temp_question_no_knowledge t1 join modify_exam_question_index t2 on t1.gid=t2.gid WHERE subject_id='.$subject_id.' AND section_id='.$section_id.';';
		$result = $this->query($sql);
		return $result;
	}
	
	
	public function post_modify_question_knowledge($questions){
	
		// 		ini_set('display_errors','On');
		global $CFG;
	
		//插入question和question_index表的SQL
		$insertIndexSQL = 'INSERT INTO modify_exam_question_index (gid , knowledge_id , knowledge_text , subject_id , section_id) VALUES ';
	
		//插入子题表的SQL
		$insertChildIndexSQL = 'INSERT INTO modify_sub_exam_question_index (gid ,knowledge_id , knowledge_text , subject_id , section_id) VALUES ';
	
		$insertSons = array();
	
		//内容里有单引号，用两个单引号代替
		foreach($questions as $question){
			$insertIndexSQL .= '("'.$question['gid'].'" , "'.implode(',' , $question['knowledge']).'" , "'.implode(',' , $question['knowledge_text']).'" , "'.$question['subject_id'].'" , "'.$question['section_id'].'"),';
				
			foreach($question['children'] as $child){
				$insertSons[] = array(
						'gid'=>$child['gid'],
						'knowledge_id' => implode(',' , $child['knowledge']),
						'knowledge_text' => implode(',' , $child['knowledge_text']),
						'subject_id' => $child['subject_id'],
						'section_id' => $child['section_id']
				);
					
			}
		}
	
		foreach($insertSons as $sons){
			$insertChildIndexSQL .= '("'.$sons['gid'].'" , "'.$sons['knowledge_id'].'"  , "'.$sons['knowledge_text'].'" , "'.$sons['subject_id'].'" , "'.$sons['section_id'].'"),';
		}
	
		$insertIndexSQL = substr($insertIndexSQL , 0 , strlen($insertIndexSQL) - 1);
	
		$insertChildIndexSQL = substr($insertChildIndexSQL , 0 , strlen($insertChildIndexSQL) - 1);
	
		$insertIndexSQL .= 'ON DUPLICATE KEY UPDATE knowledge_id=VALUES(knowledge_id) , knowledge_text=VALUES(knowledge_text) , subject_id=VALUES(subject_id) , section_id=VALUES(section_id) , modify_time=unix_timestamp()';
	
		$insertChildIndexSQL .= 'ON DUPLICATE KEY UPDATE knowledge_id=VALUES(knowledge_id) , knowledge_text=VALUES(knowledge_text) , , subject_id=VALUES(subject_id) , section_id=VALUES(section_id) ';	
	
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