<?php
class tbl_edu_question_type extends db_basic{
	protected function _define(){
		$this->tableName = 'edu_question_type';
		$this->key = 'id';
		
// 		$this->linkCFG->host = '192.168.1.61';
// 		$this->linkCFG->user = 'huhu';
// 		$this->linkCFG->password = '123456';
// 		$this->linkCFG->dbname = 'hx_curriculumn';
		
	}
	
	//按照科目查询题目类型
	public function get_question_types($subject_id , $section_id){
		$sql = <<<SQL
			SELECT a.type_name , a.id AS question_type_id , a.section_id ,  a.objective_flag , b.template_id , b.default , c.name AS template_name , c.combine_flag 
			FROM edu_question_type a 
			LEFT JOIN relation_type2template b ON a.id=b.question_type_id 
			LEFT JOIN template_question c ON b.template_id=c.id 
			WHERE a.subject_id=$subject_id AND a.section_id=$section_id 
			ORDER BY order_index ASC
		
SQL;
		$data =$this->query($sql);
		
		$result = array();
		
		foreach($data as $v){
			if(!$result[$v['question_type_id']] ){
				$result[$v['question_type_id']] = array();
				$result[$v['question_type_id']]['template'] = array();
			}
			
			$result[$v['question_type_id']]['question_type_id'] = $v['question_type_id'];
			$result[$v['question_type_id']]['objective_flag'] = $v['objective_flag'];
			$result[$v['question_type_id']]['type_name'] = $v['type_name'];
			$result[$v['question_type_id']]['section_id'] = $v['section_id'];
			
			if($v['template_id']){
				$result[$v['question_type_id']]['template'][$v['template_id']] = array(
					'template_id'=>$v['template_id'],
					'template_name'=>$v['template_name'],
					'default'=>$v['default'],
					'combine_flag'=>$v['combine_flag']
				);
			}
			
		}
		
		return array_values($result);
	}
	
}