<?php
class tbl_edu_curriculumn_version_active extends db_basic{
	protected function _define(){
		$this->tableName = 'edu_curriculumn_version_active';
		$this->key = 'id';
		
	}
	
	public function get_actives($version_id){
		$where = 'version_id='.$version_id;
		$result = $this->select(null , $where , null , null);
		return $result;
	}
	
	public function post_active($version_id , $activeList){
		global $CFG;
		
		foreach($CFG['data']['curriculumn'] as $c){ 
			if($c['id'] == $version_id){
				$extends = $c['extends'];
			}
		}
		
		$deleteWhere = 'version_id='.$version_id;
		
		$deleteRes = $this->delete($deleteWhere);
		
		
		foreach($activeList as $v){
			
			$prefix = $CFG['subject'][$v['subject_id']];
			
// 			switch($v['type_id']){
// 				case 1://同步
					
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

			$createChapterResult = $this->exec($chapterSQL);
			
			if($createChapterResult === false){
				return array( 'result' => false , 'reason'=>'chapterFail');
			}
					
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
					
			
			$createRelationResult = $this->exec($chapterRelationSQL);
			
			if($createRelationResult === false){
				return array( 'result' => false , 'reason'=>'chapterRelationFail' );
			}
			
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
					
			$createUnitResult = $this->exec($unitSQL);
			
			if($createUnitResult === false){
				return array( 'result' => false , 'reason'=>'unitFail' );
			}
			
// 					break;
					
// 				case 2://知识点
					
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
			
			$createKnowledgeResult =  $this->exec($knowledgeSQL);
			
			if($createKnowledgeResult === false){
				return array( 'result' => false , 'reason'=>'knowledgeFail' );
			}
					
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
					
			
			$createRelationResult = $this->exec($relationSQL);
			
			if($createRelationResult === false){
				return array( 'result' => false , 'reason'=>'knowledgeRelationFail' );
			}
					
// 					break;
					
// 				case 3://专题
					
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
					
			$createZhuantiResult =  $this->exec($zhuantiSQL);
			
			if($createZhuantiResult === false){
				return array( 'result' => false , 'reason'=>'zhuantiFail' );
			}
			
			
			$relationSQL = <<<SQL
					
			CREATE TABLE IF NOT EXISTS `${prefix}_edu_zhuanti2question_$extends` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `zhuanti_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
			  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `knowledge_id` (`zhuanti_id`,`question_id`),
			  KEY `chapter_id` (`zhuanti_id`),
			  KEY `qid` (`question_id`)
			) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';
SQL;
					
			$createRelationResult = $this->exec($relationSQL);
			
			if($createRelationResult === false){
				return array( 'result' => false , 'reason'=>'zhuantiRelationFail' );
			}
			
// 					break;
// 			}
		}
		
		
		$result = $this->insert_batch($activeList);
		
		return array('result'=>$result);
		
	}
	
}