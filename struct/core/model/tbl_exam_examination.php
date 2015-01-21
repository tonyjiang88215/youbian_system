<?php
class tbl_exam_examination extends db_basic{
	protected function _define(){
		$this->tableName = 'exam_examination';
		$this->key = 'id';
		
// 		$this->linkCFG->host = '192.168.1.61';
// 		$this->linkCFG->user = 'huhu';
// 		$this->linkCFG->password = '123456';
// 		$this->linkCFG->dbname = 'hx_curriculumn';
		
	}
	
	//获取所有年份
	public function get_years(){
		$result = $this->select('DISTINCT year as name , year as id',null,null,'year DESC');
		return $result;
	}
	
	public function get_examinations($section_id , $subject_id , $year , $area , $zhentiFlag){
		
		$tblExam = array(
			'exam_examination',
			'id' , 'name'
		);
		
// 		$tblGrade = array(
// 			'edu_grade'
// 		);
		
// 		$tblCondition = array(
// 			'exam_examination.grade_id=edu_grade.id'
// 		);
		
		$where = array();
		if($section_id){
			$where[] = 'exam_examination.section_id='.$section_id;
		}
		if($subject_id){
			$where[] = 'exam_examination.subject_id='.$subject_id;
		}
		if($year){
			$where[] = 'exam_examination.year like "%'.$year.'%"';
		}
		if($area){
			$where[] = 'exam_examination.province_id='.$area;
		}
		if($zhentiFlag){
			if($zhentiFlag == 1){//是真题
				$where[] = 'exam_examination.exam_type=1';
			}else if($zhentiFlag == 2){
				$where[] = 'exam_examination.exam_type!=1';
			}
		}
		
		$_where = implode(' AND ' , $where);
		
		$result = $this->select('id,name' , $_where , null , null);
// 		$result = $this->withQueryMakerLeft($tblExam , $tblGrade , $tblCondition);
		return $result;
	}
	
	public function new_exam($examInfo){
		$result = $this->insert($examInfo);
		return $result;
		
	}
	
	public function get_exam_info($exam_id){
		$result = $this->findById($exam_id);
		return $result;
	}
	
	public function modify_exam_info($examInfo){
		$result = $this->update($examInfo);
		return $result;
	}
	
}