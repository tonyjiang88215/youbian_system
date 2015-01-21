<?php
class tbl_edu_curriculumn_version extends db_basic{
	protected function _define(){
		$this->tableName = 'edu_curriculumn_version';
		$this->key = 'id';
		
	}
	
	//获取知识体系版本
	public function get_knowledge_versions(){
		$result = $this->select('*' , 'type=1' , null , null );
		return $result;
	}
	
	//获取所有体系版本
	public function get_curriculumn_versions(){
		
		$result = $this->select('*' , null , null , null );
		return $result;
		
	}
	
	public function get_curriculumn_versions_limit($offset , $step){
		$limit = $offset.','.$step;
		$result = array();
		$result['data'] = $this->select('*' , null , null , $limit );
		$result['count'] = $this->count(null);
		return $result;
	}
	
	public function get_curriculumn_versions_by_control($user_id){
		$sql = <<<SQL
		SELECT t1.* FROM edu_curriculumn_version t1 
		JOIN hx_workset_version t2 ON t1.id=t2.version_id AND t2.privilege=3 
		JOIN hx_user t3 ON t2.workset_id=t3.workset_id AND t3.id=$user_id;
SQL;
		
		$result = $this->query($sql);
		return $result;
		
	}
	
	public function get_curriculumn_versions_visible($user_id){
		$sql = <<<SQL
		SELECT t1.* FROM edu_curriculumn_version t1
		JOIN hx_workset_version t2 ON t1.id=t2.version_id 
		JOIN hx_user t3 ON t2.workset_id=t3.workset_id AND t3.id=$user_id;
SQL;
		
		$result = $this->query($sql);
		return $result;
	}
	
	public function get_curriculumn_versions_by_control_list($user_id , $offset , $step){
		$sql = <<<SQL
		SELECT t1.* , IFNULL(t4.detail_count,0) as detail_count FROM edu_curriculumn_version t1
		JOIN hx_workset_version t2 ON t1.id=t2.version_id
		JOIN hx_user t3 ON t2.workset_id=t3.workset_id AND t3.id=$user_id 
		LEFT JOIN (SELECT version_id , COUNT(*) as detail_count FROM edu_curriculumn_version_detail GROUP BY version_id) t4 ON t1.id=t4.version_id 
		LIMIT $offset , $step;
SQL;
		
		$countSQL = <<<SQL
		
		SELECT COUNT(*) as count FROM edu_curriculumn_version t1
		JOIN hx_workset_version t2 ON t1.id=t2.version_id
		JOIN hx_user t3 ON t2.workset_id=t3.workset_id AND t3.id=$user_id;
		
SQL;
		
		$result = array();
		$result['data'] = $this->query($sql);
		$countRes = $this->query($countSQL);
		$result['count'] = $countRes[0]['count'];
		return $result;
	}
	
	public function get_curriculumn_versions_with_subject(){
		$tableName = $this->tableName;
		
		$sql = <<<SQL
		SELECT a.* , support_subject FROM $tableName a JOIN 
		(SELECT GROUP_CONCAT(DISTINCT subject_id) as support_subject ,version_id FROM edu_curriculumn_version_detail GROUP BY version_id) b ON a.id=b.version_id;
SQL;
		
		$result = $this->query($sql);
		return $result;
		
	}
	
	public function get_curriculumn_versions_with_subject_by_control($user_id){
		
		$tableName = $this->tableName;
		
		$sql = <<<SQL
		SELECT a.* , support_subject FROM $tableName a JOIN
		(SELECT GROUP_CONCAT(DISTINCT subject_id) as support_subject ,version_id FROM edu_curriculumn_version_detail GROUP BY version_id) b ON a.id=b.version_id 
		JOIN hx_workset_version d ON a.id=d.version_id 
		JOIN hx_user c ON d.workset_id=c.workset_id AND c.id=$user_id
		;
SQL;
		
		$result = $this->query($sql);
		return $result;
		
	}
	
	public function get_curriculumn_versions_by_active($type){
		$where = $type.'=1';
		$result = $this->select('*' , $where , null , null );
		return $result;
	}
	
	//获取知识体系版本
	public function get_chapter_versions(){
		$result = $this->select('*' , 'type=2' , null , null );
		return $result;
	}
	
	//添加新版本 
	public function post_new_curriculumn($name , $version , $extends , $ref , $workset_id){
		
		global $CFG;
		
		$olddbname = $this->linkCFG->dbname;
		
		$newdbname = 'curriculumn_source_'.$extends;
		
		$createSQL = 'CREATE DATABASE IF NOT EXISTS `'.$newdbname.'`;';
		
		$resultCreate = $this->exec($createSQL);
		
		if($resultCreate === false){
			return array('result'=>false , 'reason'=>'createDBFail');
		}

		
		
		$this->switchDB($this->linkCFG->host , $this->linkCFG->user , $this->linkCFG->password , $newdbname );
		
// 		$testSQL = 'show tables';
		
// 		print_r($this->query($testSQL));
// 		exit;
		
		
		$initSQL = file_get_contents($CFG['path']['sql'].'/version_init.sql');
		
		$resultInit = $this->exec($initSQL);
		
// 		$initSQL = 'source \''.$CFG['path']['sql'].'/version_init.sql\';';
		
// 		$conn = mysql_connect($this->linkCFG->host , $this->linkCFG->user , $this->linkCFG->password);
		
// 		echo $initSQL;
		
// 		mysql_select_db($dbname,$conn);
// 		$resultInit = mysql_query($initSQL , $conn);
// 		mysql_close($conn);
		
		if($resultInit === false){
			return array('result'=>false , 'reason'=>'initDBFail');
		}
		
		$this->switchDB($this->linkCFG->host , $this->linkCFG->user , $this->linkCFG->password , $olddbname );
		
		$resultInsert = $this->insert(array('name'=>$name , 'version'=>$version , 'ref_id'=>$ref , 'extends'=>$extends , 'workset_id'=>$workset_id));
		
		if($resultInsert === false){
			return array('result'=>false , 'reason'=>'inertDBFail');
		}
		
		return array('result'=>true , 'lastid'=>$this->lastInsertId());
		
	}
	
	
	
	//对新版本激活同步
	public function post_active_tongbu($version){
		
		$selectWhere = 'id='.$version;
		
		$updateResult = $this->update(array('id'=>$version , 'tongbu'=>1));
		
		return $updateResult;
		
		
	}
	
	//对新版本激活知识点
	public function post_active_knowledge($version){
	
		$selectWhere = 'id='.$version;
	
		$updateResult = $this->update(array('id'=>$version , 'knowledge'=>1));
	
		return $updateResult;
	
	
	}
	
	//对新版本激活专题
	public function post_active_zhuanti($version){
	
		$selectWhere = 'id='.$version;
	
		$updateResult = $this->update(array('id'=>$version , 'zhuanti'=>1));
	
		return $updateResult;
	}
	
	//需要建立章节、单元、关系表
	public function post_create_tongbu($version , $subject){
		global $CFG;
		
		$prefix = $CFG['subject'][$subject];
		
		$selectWhere = 'id='.$version;
		
		$version_info = $this->select('*' , $selectWhere , null , null);
		
		if(!$version_info || $version_info[0]['tongbu'] == 0){
			return false;
		}
		
		$extends = $version_info[0]['extends'];
		
		
		//章节
		$chapterSQL = <<<SQL
		
		CREATE TABLE  IF NOT EXISTS `${prefix}_edu_chapter_$extends` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `chapter_name` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '章节名，来自志鸿单元',
		  `chapter_code` varchar(10) COLLATE utf8_bin DEFAULT NULL COMMENT '章节编码',
		  `chapter_index` int(11) DEFAULT NULL COMMENT '章节排序号',
		  `book_id` int(11) NOT NULL DEFAULT '0' COMMENT '教材编号',
		  `unit_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属单元ID',
		  `knowledge_tag` varchar(500) COLLATE utf8_bin DEFAULT NULL COMMENT '知识点标签 可多个，逗号分开',
		  `ti_count` int(11) DEFAULT NULL,
		  `content` longtext COLLATE utf8_bin COMMENT '当前章节所拥有的题目ID集合',
		  `book_code` varchar(10) COLLATE utf8_bin DEFAULT NULL COMMENT '所属教材编码',
		  `unit_code` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '所属单元编码',
		  `pub_id` char(2) COLLATE utf8_bin DEFAULT NULL COMMENT '所属出版社ID',
		  `subject_id` char(2) COLLATE utf8_bin DEFAULT NULL COMMENT '学科ID',
		  `grade_id` char(2) COLLATE utf8_bin DEFAULT NULL COMMENT '年级ID',
		  `section_id` char(2) COLLATE utf8_bin DEFAULT NULL COMMENT '学段ID',
		  `source` varchar(256) COLLATE utf8_bin DEFAULT NULL COMMENT '所属源库',
		  `flagid` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
		  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='章节';
		
SQL;
		
		
		//章节和题目关系表
		$chapterRelationSQL = <<<SQL
		
		CREATE TABLE  IF NOT EXISTS `${prefix}_edu_chapter2question_$extends` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		  `chapter_id` int(11) NOT NULL DEFAULT '0' COMMENT '章节ID',
		  `question_id` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '0' COMMENT '题目ID',
		  PRIMARY KEY (`id`),
		  KEY `chapter_id` (`chapter_id`),
		  KEY `qid` (`question_id`)
		) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';
SQL;
		
		//单元
		$unitSQL = <<<SQL
		
		CREATE TABLE  IF NOT EXISTS `${prefix}_edu_unit_$extends` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `pub_id` char(2) DEFAULT NULL COMMENT '出版社ID',
		  `book_id` int(11) DEFAULT NULL COMMENT '教材ID',
		  `book_code` varchar(10) DEFAULT NULL COMMENT '教材编码',
		  `unit` varchar(500) DEFAULT NULL COMMENT '单元名称',
		  `unit_code` varchar(10) DEFAULT NULL COMMENT '单元编码',
		  `unit_index` tinyint(3) DEFAULT NULL COMMENT '单元索引顺序',
		  `subject_id` char(2) DEFAULT NULL COMMENT '学科ID',
		  `grade_id` char(2) DEFAULT NULL COMMENT '年级ID',
		  `section_id` char(2) DEFAULT NULL COMMENT '学段ID',
		  `source` varchar(100) DEFAULT NULL COMMENT '所属源库',
		  `flagid` varchar(50) DEFAULT NULL,
		  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
		  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=4033 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
SQL;
		
		$sql = $unitSQL . $chapterSQL . $chapterRelationSQL;
// 		echo $sql;
// 		$createResult = $this->exec($sql);

		$createUnitResult = $this->exec($unitSQL);
		
		$createChapterResult = $this->exec($chapterSQL);
		
		$createRelationResult = $this->exec($chapterRelationSQL);
		
		if($createUnitResult !== false && $createChapterResult !== false && $createRelationResult !== false){
			$createResult = true;
		}else{
			$createResult = false;
		}
		
		return $createResult;
		
	}

	//需要建立知识点表和关系表
	public function post_create_knowledge($version , $subject){
		global $CFG;
		
		$prefix = $CFG['subject'][$subject];
		
		$selectWhere = 'id='.$version;
		
		$version_info = $this->select('*' , $selectWhere , null , null);
		
		if(!$version_info || $version_info[0]['tongbu'] == 0){
			return false;
		}
		
		$extends = $version_info[0]['extends'];
		
		$knowledgeSQL = <<<SQL
		
			CREATE TABLE IF NOT EXISTS `${prefix}_edu_knowledge_$extends` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(32) COLLATE utf8_bin NOT NULL COMMENT '名称 应该不可重复',
			  `level` int(11) NOT NULL COMMENT '知识点级别 1是第一级，2是第二级，以此类推',
			  `parent_id` int(11) DEFAULT NULL COMMENT '上级知识点 如果已经是根，则可以空',
			  `subject_id` int(11) NOT NULL COMMENT '所属科目',
			  `grade_id` int(11) NOT NULL COMMENT '所属年级',
			  `sort_id` smallint(6) NOT NULL DEFAULT '0',
			  `section_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '学段',
			  `knowledge_id` int(11) NOT NULL DEFAULT '0',
			  `match_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:为匹配；1：已匹配',
			  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';
SQL;
		
		$relationSQL = <<<SQL
		
			CREATE TABLE IF NOT EXISTS `${prefix}_edu_knowledge2question_$extends` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `knowledge_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
			  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
			  PRIMARY KEY (`id`),
			  KEY `chapter_id` (`knowledge_id`),
			  KEY `qid` (`question_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';
SQL;
		
		$createKnowledgeResult =  $this->exec($knowledgeSQL);
		$createRelationResult = $this->exec($relationSQL);
		
		if($createKnowledgeResult !== false && $createRelationResult !== false ){
			return true;
		}else{
			return false;
		}
		
	}
	
	public function post_create_zhuanti($version , $subject){
		
		global $CFG;
		
		$prefix = $CFG['subject'][$subject];
		
		$selectWhere = 'id='.$version;
		
		$version_info = $this->select('*' , $selectWhere , null , null);
		
		if(!$version_info || $version_info[0]['tongbu'] == 0){
			return false;
		}
		
		$extends = $version_info[0]['extends'];
		
		$zhuantiSQL = <<<SQL
		
			CREATE TABLE IF NOT EXISTS `${prefix}_edu_zhuanti_$extends` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(32) COLLATE utf8_bin NOT NULL COMMENT '名称 应该不可重复',
			  `level` int(11) NOT NULL COMMENT '知识点级别 1是第一级，2是第二级，以此类推',
			  `parent_id` int(11) DEFAULT NULL COMMENT '上级知识点 如果已经是根，则可以空',
			  `subject_id` int(11) NOT NULL COMMENT '所属科目',
			  `grade_id` int(11) NOT NULL COMMENT '所属年级',
			  `sort_id` smallint(6) NOT NULL DEFAULT '0',
			  `section_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '学段',
			  `knowledge_id` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT '关联知识点集合',
			  `knowledge_list` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '',
			  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
			  `cover_pic` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '封面图片',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';
SQL;
		
		$relationSQL = <<<SQL
		
			CREATE TABLE `${prefix}_edu_zhuanti2question_$extends` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `zhuanti_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
			  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `knowledge_id` (`zhuanti_id`,`question_id`),
			  KEY `chapter_id` (`zhuanti_id`),
			  KEY `qid` (`question_id`)
			) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';
SQL;
		
		$createZhuantiResult =  $this->exec($zhuantiSQL);
		$createRelationResult = $this->exec($relationSQL);
		
		if($createZhuantiResult !== false && $createRelationResult !== false){
			return true;
		}else{
			return false;
		}
		
	}
	
	


}