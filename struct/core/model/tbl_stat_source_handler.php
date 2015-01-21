<?php
class tbl_stat_source_handler extends db_basic{
	protected function _define(){
		$this->tableName = 'stat_source_handler';
		$this->key = 'id';

	}

	//添加记录
	public function add_record($subject_id , $section_id , $gidArray , $action , $module_id){
		$sql = '';
		$time = time();
		
		$userInfo = json_decode($_SESSION['user_info'] , true);
		
		foreach($gidArray as $gid){
			$sql .= 'INSERT INTO '.$this->tableName.' (user_id , gid , subject_id , section_id , time , action , module_id) '.
			'VALUES (' . $userInfo['id'] . ' , "' . $gid . '" , '.$subject_id.' , '.$section_id.' , '.$time.' , '.$action.' , '.$module_id.') ON DUPLICATE KEY UPDATE '.
			'user_id=VALUES(user_id) , time=VALUES(time) , action=VALUES(action) , module_id=VALUES(module_id) ;';
		}
			
		$result = $this->exec($sql);
		return $result;
	}
	
	
	public function get_list_by_subject($subject_id){
		$sql = <<<SQL
		SELECT user_id , COUNT(*) AS count FROM '.$this->tableName.' WHERE subject_id=$subject_id group by user_id 
SQL;
		
		$result = $this->query($sql);
		return $result;
	}
	
	public function get_list_count_by_type($subject_id , $section_id , $type , $offset , $step){
		$where ='action='.$type.' AND '.$this->tableName.'.section_id='.$section_id;
		$limit = $offset.','.$step;
		switch($type){
			case 1:
			case 2:
				
				
				$tblRelation = array(
					$this->tableName
				);
				
				$tblQuestion = array(
						'modify_exam_question',
						'content' , 'column_content' , 'answer' , 'analysis'
				);
				
				$tblQuestionIndex = array(
						'modify_exam_question_index',
						'gid' , 'subject_id' , 'grade_id' , 'knowledge_id' , 'knowledge_text' , 'difficulty' , 'score' , 'objective_flag' , 'combine_flag' ,
						'option_count' , 'group_count' , 'question_type' , 'question_template' , 'setin_exam_id' , 'exam_name' , 'subject_id' , 'source' ,
						'time' , 'keyword'
				
				);
				
				$tblCondition = array(
						$this->tableName.'.gid='.$tblQuestionIndex[0].'.gid',
						$tblQuestion[0].'.gid='.$tblQuestionIndex[0].'.gid',
						'where'=>$where,
						'limit'=> $limit
				);
				
				$result = array();
				$result['data'] = $this->withQueryMaker($tblRelation , $tblQuestionIndex , $tblQuestion , $tblCondition);
				$result['count'] = $this->withQueryMakerOfNum($tblRelation , $tblQuestionIndex , $tblQuestion , $tblCondition);
				
				break;
				
			case 3:
				
				$question_id = $this->select('gid' , $where , $limit , null);
				$gidArray = array();
				foreach($question_id as $q){
					$gidArray[] = $q['gid'];
				}
				
				$result['data'] = factory::getModel('exam_question_index_0911')->get_question_by_id($subject_id , $gidArray);
				$result['count'] = $this->count($where);
				
				
				break;
		}
		return $result;
		
		
		
	}
	
	public function get_list_by_question($question_ids){
		$idCondition = implode('","', $question_ids);
		
		$sql = <<<SQL
		SELECT * FROM (
          SELECT * FROM stat_source_handler WHERE gid IN ("$idCondition") ORDER BY time DESC
   		) t1 GROUP BY t1.gid
		
SQL;
// 		$where = 'gid IN ("'.implode('","', $question_ids).'")';
// 		$result = $this->select('*' , $where ,null, null);
		$result = $this->query($sql);
		return $result;
	}
	
	//根据类别查询所有GID
	public function get_gid_by_action($action){
		$where = 'action='.$action;
		$result = $this->select('gid' , $where , null , null);
		return $result;
	}
	
	//根据类别、学科和学段查询GID
	public function get_gid_by_subjectSection($action , $subject , $section){
		$where = 'action='.$action .' AND subject_id='.$subject .' AND section_id='.$section;
		$result = $this->select('gid' , $where , null , null);
		return $result;
	}
}