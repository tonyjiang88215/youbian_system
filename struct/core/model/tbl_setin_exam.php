<?php
class tbl_setin_exam extends db_basic{
	protected function _define(){
		$this->tableName = 'setin_exam';
		$this->key = 'id';
		
		
	}
	
	//获取未入库的试题列表，建表
	public function get_exam_names($subject_id , $section_id){
		$sql = <<<SQL
	
			 SELECT setin_exam.id , exam_name ,exam_code , source ,
			 IFNULL(exam_finish , 0) as exam_finish , IFNULL(tongbu_finish , 0) as tongbu_finish , IFNULL(zhuanti_finish , 0) as zhuanti_finish   
			 FROM setin_exam 
			 LEFT JOIN setin_exam_complete ON setin_exam.id=setin_exam_complete.setin_exam_id 
			 WHERE setin_exam.subject_id=$subject_id AND setin_exam.section_id=$section_id  
			 ORDER BY setin_exam.id DESC;
SQL;
		$result = $this->query($sql);
		//		$result = $this->select('DISTINCT exam_name ,source ' , null , null , null);
		return $result;
	}
	
	
	public function post_finish_exam($exam_id , $type){
		
		$columnArray = array('1'=>'exam_finish', '2'=>'tongbu_finish' , '3'=>'zhuanti_finish');
		
		$column = $columnArray[$type];
		
		$sql = <<<SQL
		
				INSERT INTO setin_exam_complete (setin_exam_id , $column) VALUES ($exam_id , 1) 
				ON DUPLICATE KEY UPDATE $column=VALUES($column);
		
SQL;
		
		$result = $this->exec($sql);
		if($result !== false){
			return true;
		}else{
			return false;
		}
		
	}
	
	public function post_insert_word($subject_id , $section_id , $version_id , $content){
		global $CFG;
		$gradeArray = array('1'=>66,'2'=>77,'3'=>88);
		
		$time = time();
		$grade_id = $gradeArray[$section_id];
		
		//先添加setin_exam的信息
		$source = $CFG['subject'][$subject_id].date('YmdHis' , $time);
		
// 		$exam_code_prefix = substr($source , 0 , 10);

		$exam_code_prefix = $source;
		
		$check = $this->select('max(exam_code) as code' , 'exam_code like "'.$exam_code_prefix.'%"', null , null);
		
		if(count($check) > 0){
			$tmp = explode('_' , $check[0]['code']);
			$index = intval($tmp[1]) + 1;
			
			$exam_code = $exam_code_prefix.'_'.str_pad($index, 6 , '0' , STR_PAD_LEFT);
		}else{
			$exam_code = $exam_code_prefix.'_000001';
		}
		
		$insertArray = array(
			'exam_name' => date('Y-m-d H:i:s' , $time).'上传的Word',
			'exam_code' => $exam_code,
			'source'=>$source,
			'subject_id' => $subject_id,
			'section_id' => $section_id,
			'version_id' => $version_id
		);
		
		$result = $this->insert($insertArray);
		
		if($result){
			//成功后 在将内容写入表中
			$setin_exam_id =  $this->lastInsertId();
			
			$gid_prefix = $CFG['subject'][$subject_id].date('YmdHis' , $time);
			
			$this->tableName = 'in_exam_question_index';
			
			$sql = <<<SQL
			
					select max(gid) as gid from in_exam_question_index where  gid like "$gid_prefix%";
			
SQL;
			
			$check = $this->query($sql);
			
			if(count($check) > 0){
				$tmp = explode('_' , $check[0]['code']);
				$index = intval($tmp[1]) + 1;
			
				$gid = $gid_prefix.'_'.str_pad($index, 6 , '0' , STR_PAD_LEFT);
			}else{
				$gid = $gid_prefix.'_000001';
			}
			
			$content =str_replace('\'',"\'",$content);
			
			$questionSQL = <<<SQL
			
				INSERT INTO in_exam_question (gid , content ,source) VALUES ('$gid' , '$content' , '$source');
				INSERT INTO in_exam_question_index(gid , subject_id , grade_id , source , setin_exam_id) VALUES ('$gid' , $subject_id , $grade_id , '$source' , $setin_exam_id);
				INSERT INTO modify_exam_question (gid , content ,source) VALUES ('$gid' , '$content' , '$source');
				INSERT INTO modify_exam_question_index(gid , subject_id , grade_id , source , setin_exam_id) VALUES ('$gid' , $subject_id , $grade_id , '$source' , $setin_exam_id);
				
SQL;
			
			$result = $this->exec($questionSQL);
			
			if($result !== false){
				return true;
			}else{
				return false;
			}
			
			
			
		}else{
			return false;
		}
		
	}
	
	public function post_setout_exam($version_id , $subject_id , $type , $exam_id){
		global $CFG;
		
		$prefix = $CFG['subject'][$subject_id];
		foreach($CFG['data']['curriculumn'] as $curriculumn){
			if($curriculumn['id'] == $version_id){
				$extends = $curriculumn['extends'];
			}
		}
		
		switch($type){
			case 1://试卷
				
				$tableName = 'exam_examination_to_question';
				
				break;
				
			case 2://章节
				
				$tableName = $prefix . '_edu_chapter2question_' . $extends;
				
				break;
				
			case 3://专题
	
				$tableName = $prefix . '_edu_zhuanti2question_' . $extends;
				
				break;
		}
		
		
		
		
		$sql = <<<SQL
		
		delete b FROM
		       modify_exam_question_index a JOIN $tableName b ON a.gid=b.question_id  
		       WHERE a.setin_exam_id=$exam_id;
       
SQL;
		
		$result = $this->exec($sql);
		
		return $result;
		
		
	}

	
}