<?php
class tbl_edu_book extends db_basic{
	protected function _define(){
		$this->key = 'id';
		
	}
	
	//获取所有科目
	public function get_publisher($subject_id , $grade_id){
		
		global $CFG;
		
		$tableName = $CFG['subject'][$subject_id].'_edu_book';
		
		$sql = <<<SQL
		
		SELECT DISTINCT edu_publisher. name , $tableName.publisher_id 
		FROM $tableName 
		LEFT JOIN edu_publisher ON $tableName.publisher_id=edu_publisher.id 
		WHERE $tableName.grade_id=$grade_id
SQL;
		
		$result = $this->query($sql);
		
		return $result;
	}
	
	public function get_all_books(){
		$sql = <<<SQL
		
select id , book_name as name , publisher_id , subject_id , section_id , grade_id from yw_edu_book union
select id , book_name as name , publisher_id , subject_id , section_id , grade_id from sx_edu_book union
select id , book_name as name , publisher_id , subject_id , section_id , grade_id from yy_edu_book union
select id , book_name as name , publisher_id , subject_id , section_id , grade_id from wl_edu_book union
select id , book_name as name , publisher_id , subject_id , section_id , grade_id from hx_edu_book union
select id , book_name as name , publisher_id , subject_id , section_id , grade_id from sw_edu_book union
select id , book_name as name , publisher_id , subject_id , section_id , grade_id from zz_edu_book union
select id , book_name as name , publisher_id , subject_id , section_id , grade_id from dl_edu_book union
select id , book_name as name , publisher_id , subject_id , section_id , grade_id from ls_edu_book ;
		
SQL;
		
		$result = $this->query($sql);
		return $result;
		
	}
	
	//根据参数，获取教材列表
	public function get_books($subject_id , $grade_id , $publisher_id){
		
		global $CFG;
		
		$this->tableName = $CFG['subject'][$subject_id].'_edu_book';
		
		$result = $this->select('id , book_name' , 'grade_id='.$grade_id.' AND publisher_id='.$publisher_id , null , null);
		return $result;
	}
	
	public function get_books_by_version($subject_id , $section_id , $version_id){
		global $CFG;
		
		$bookName = $CFG['subject'][$subject_id].'_edu_book';
		
		$unitName = $CFG['subject'][$subject_id].'_edu_unit_';
		
		foreach($CFG['data']['curriculumn'] as $curriculumn){
			if($curriculumn['id'] == $version_id){
				$unitName .= $curriculumn['extends'];
			}
		}
		
		$sql = <<<SQL
		
		SELECT DISTINCT t1.id , concat(t3.name , '---' , t1.book_name) as book_name , t1.grade_id , t1.publisher_id , t1.pub_id , t1.book_code 
			FROM $bookName t1 
			LEFT JOIN $unitName t2 ON t2.book_id=t1.id  
			LEFT JOIN edu_publisher t3 ON t1.publisher_id=t3.id 
			WHERE t1.section_id=$section_id AND t2.version_id=$version_id 
			ORDER BY book_code ASC;	
		
SQL;
		
		$result = $this->query($sql);
		return $result;
		
	}
	
	//根据学科，学段，出版社查询书籍
	public function get_books_with_ssp($subject , $section , $publisher){
		global $CFG;
		
		$this->tableName = $CFG['subject'][$subject].'_edu_book';
		$where = '';
		if($subject){
			$where .= 'subject_id='.$subject.' AND ';
		}
		
		if($section){
			$where .= ' section_id='.$section .' AND ';
		}
		
		
		$where .= ' publisher_id='.$publisher;
		$order = 'id ASC';
		
		$result = $this->select(null , $where , null , $order);
		return $result;
		
	}
	
	public function get_books_with_ssp2($subject , $section , $publisher){
		global $CFG;
		
		$sql = 'SELECT * FROM (';
		
// 		$sqlCount = 'SELECT COUNT(*) as count FROM (';
		
		foreach($CFG['subject'] as $s => $pre){
			$sql .= 'SELECT * FROM '.$pre.'_edu_book union ';	
// 			$sqlCount .= 'SELECT * FROM '.$pre.'_edu_book union ';	
		}
		
		$sql = substr($sql, 0 , strlen($sql)-7);
// 		$sqlCount = substr($sqlCount , 0 , strlen($sqlCount) - 7);
		
		$sql .= ') a ';
// 		$sqlCount .= ') a';
		
// 		$sqlCount .= ' WHERE pub_id='.$publisher;
		
		$sql .= ' WHERE ';
		
		if($subject){
			$sql .= 'subject_id='.$subject.' AND ';
		}
		
		if($section){
			$sql .= 'section_id='.$section.' AND ';
		}
		$sql .= 'publisher_id='.$publisher;
		
		$result= array();
		$result['data'] = $this->query($sql);
		
// 		$count = $this->query($sqlCount);
		
// 		$result['count'] = $count[0]['count'];
		return $result;
		
		
	}
	
	public function insert_book($subject , $section , $grade ,  $publisher , $name){
		global $CFG;
		
		$this->tableName = $CFG['subject'][$subject].'_edu_book';
		$insertArray = array(
			'book_name'=>$name,
			'subject_id'=>$subject,
			'section_id'=>$section,
			'grade_id'=>$grade,
			'publisher_id'=>$publisher
		);
		
		$result = $this->insert($insertArray);
		return $result;
		
	}
	
// 	public function modify_book($id , $subject , $section , $grade , $publisher , $name){
		
// 		global $CFG;
		
// 		$this->tableName = $CFG['subject'][$subject].'_edu_book';
// 		$updateArray = array(
// 				'id'=>$id,
// 				'book_name'=>$name,
// 				'subject_id'=>$subject,
// 				'section_id'=>$section,
// 				'grade_id'=>$grade,
// 				'publisher_id'=>$publisher,
// 				'pub_id'=>$publisher
// 		);
		
// 		$result = $this->update($updateArray);
// 		return $result;
		
		
// 	}
	
	public function modify_book($bookInfo){
		
		global $CFG;
		
		$this->tableName = $CFG['subject'][$bookInfo['subject_id']].'_edu_book';
		
		$result = $this->update($bookInfo);
		return $result;
		
		
	}
	
	public function delete_book($book_id , $subject_id){
		global $CFG;
		
		$this->tableName = $CFG['subject'][$subject_id].'_edu_book';
		
		$prefix = $CFG['data']['subject'][$subject_id];
		$sql = 'SELECT COUNT(*) as count FROM (';
		
		//在每个版本关系表里查，如果有当前教材的id出现，说明教材下有单元或者章节，则不能删除
		foreach($CFG['data']['curriculumn'] as $curriculumn){
			$sql .= 'SELECT book_id FROM curriculumn_source_'.$curriculumn['extends'].'.'.$prefix.'_edu_unit WHERE book_id='.$book_id.' union ';
		}
		
		$sql = substr($sql, 0 , strlen($sql) - 7);
		
		$sql .=') a';
		
		$result = $this->query($sql);
		
		$count = $result[0]['count'];
		
		if($count > 0){
			return array('result'=>false , 'reason'=>1);
		}else{
			return array('result'=>$this->deleteById($book_id));
		}
		
		
	}
	
}