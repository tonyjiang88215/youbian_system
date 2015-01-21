/**
 * 
 * 
 * 																						链接表
 * 
 * 
 */

CREATE TABLE `area_province` (
  `id` varchar(6) NOT NULL COMMENT '编号',
  `Name` varchar(32) NOT NULL COMMENT '省份-直辖市名称',
  `country_id` varchar(6) NOT NULL COMMENT '国家ID',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='省份表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/area_province';
  

CREATE TABLE `edu_subject` (
  `id` int(11) NOT NULL COMMENT '编号',
  `name` varchar(64) NOT NULL COMMENT '名称',
  `subject_code` char(2) DEFAULT NULL,
  `subject_index` int(11) DEFAULT NULL,
  `abbr` varchar(8) NOT NULL DEFAULT '' COMMENT '缩写',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8 
COMMENT='学科表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/edu_subject';


CREATE TABLE `edu_grade` (
  `id` int(11) NOT NULL COMMENT '编号 编号决定显示顺序，幼儿为1，小学1年为2，以此类推',
  `name` varchar(64) NOT NULL COMMENT '名称',
  `code` char(2) DEFAULT NULL,
  `grade_index` tinyint(4) DEFAULT NULL,
  `display_flag` int(11) NOT NULL COMMENT '显示标记 1显示，0不显示',
  `section_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8 
COMMENT='年级表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/edu_grade';


CREATE TABLE `edu_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `abbr` varchar(8) NOT NULL DEFAULT '' COMMENT '缩写',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='学段表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/edu_section';


CREATE TABLE `edu_source_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL COMMENT '资源类型名称',
  `abbr` varchar(8) NOT NULL DEFAULT '' COMMENT '缩写名称',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='资源类型表，描述目前都有哪些类型的资源'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/edu_source_type';



CREATE TABLE `edu_question_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '学科ID',
  `type_name` varchar(64) NOT NULL DEFAULT '' COMMENT '类型',
  `objective_flag` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0:主观题, 1:客观题',
  `order_index` tinyint(3) NOT NULL DEFAULT '0' COMMENT '题型排序',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='题型表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/edu_question_type';



CREATE TABLE `edu_publisher` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(64) NOT NULL COMMENT '名称',
  `s_abbr` varchar(10) DEFAULT NULL,
  `pub_code` char(3) DEFAULT NULL,
  `pub_index` tinyint(4) DEFAULT NULL,
  `notes` varchar(4000) DEFAULT NULL COMMENT '介绍性文字 JSON格式存储的介绍性文字，图片保存在common_image表',
  `abbr` varchar(8) NOT NULL DEFAULT '' COMMENT '缩写',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='出版社表 也是教材版本'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/edu_publisher';



CREATE TABLE `edu_year` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(32) NOT NULL DEFAULT '' COMMENT '年份',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='出版社表 也是教材版本'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/edu_year';



CREATE TABLE `dl_edu_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `book_name` varchar(64) NOT NULL COMMENT '名称',
  `publisher_id` int(11) NOT NULL COMMENT '出版社ID',
  `subject_id` char(2) NOT NULL COMMENT '所属学科',
  `grade_id` char(2) NOT NULL COMMENT '所属年级',
  `section_id` char(2) DEFAULT NULL,
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `cover_pic` varchar(128) NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='地理教材表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/dl_edu_book';



CREATE TABLE `hx_edu_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `book_name` varchar(64) NOT NULL COMMENT '名称',
  `publisher_id` int(11) NOT NULL COMMENT '出版社ID',
  `subject_id` char(2) NOT NULL COMMENT '所属学科',
  `grade_id` char(2) NOT NULL COMMENT '所属年级',
  `section_id` char(2) DEFAULT NULL,
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `cover_pic` varchar(128) NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='化学教材表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/hx_edu_book';


CREATE TABLE `yw_edu_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `book_name` varchar(64) NOT NULL COMMENT '名称',
  `publisher_id` int(11) NOT NULL COMMENT '出版社ID',
  `subject_id` char(2) NOT NULL COMMENT '所属学科',
  `grade_id` char(2) NOT NULL COMMENT '所属年级',
  `section_id` char(2) DEFAULT NULL,
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `cover_pic` varchar(128) NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='语文教材表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/yw_edu_book';


CREATE TABLE `sx_edu_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `book_name` varchar(64) NOT NULL COMMENT '名称',
  `publisher_id` int(11) NOT NULL COMMENT '出版社ID',
  `subject_id` char(2) NOT NULL COMMENT '所属学科',
  `grade_id` char(2) NOT NULL COMMENT '所属年级',
  `section_id` char(2) DEFAULT NULL,
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `cover_pic` varchar(128) NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='数学教材表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/sx_edu_book';



CREATE TABLE `yy_edu_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `book_name` varchar(64) NOT NULL COMMENT '名称',
  `publisher_id` int(11) NOT NULL COMMENT '出版社ID',
  `subject_id` char(2) NOT NULL COMMENT '所属学科',
  `grade_id` char(2) NOT NULL COMMENT '所属年级',
  `section_id` char(2) DEFAULT NULL,
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `cover_pic` varchar(128) NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='英语教材表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/yy_edu_book';


CREATE TABLE `wl_edu_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `book_name` varchar(64) NOT NULL COMMENT '名称',
  `publisher_id` int(11) NOT NULL COMMENT '出版社ID',
  `subject_id` char(2) NOT NULL COMMENT '所属学科',
  `grade_id` char(2) NOT NULL COMMENT '所属年级',
  `section_id` char(2) DEFAULT NULL,
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `cover_pic` varchar(128) NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='物理教材表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/wl_edu_book';
   
   
   
CREATE TABLE `sw_edu_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `book_name` varchar(64) NOT NULL COMMENT '名称',
  `publisher_id` int(11) NOT NULL COMMENT '出版社ID',
  `subject_id` char(2) NOT NULL COMMENT '所属学科',
  `grade_id` char(2) NOT NULL COMMENT '所属年级',
  `section_id` char(2) DEFAULT NULL,
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `cover_pic` varchar(128) NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='生物教材表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/sw_edu_book';
   
   
CREATE TABLE `zz_edu_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `book_name` varchar(64) NOT NULL COMMENT '名称',
  `publisher_id` int(11) NOT NULL COMMENT '出版社ID',
  `subject_id` char(2) NOT NULL COMMENT '所属学科',
  `grade_id` char(2) NOT NULL COMMENT '所属年级',
  `section_id` char(2) DEFAULT NULL,
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `cover_pic` varchar(128) NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='政治教材表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/zz_edu_book';


CREATE TABLE `ls_edu_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `book_name` varchar(64) NOT NULL COMMENT '名称',
  `publisher_id` int(11) NOT NULL COMMENT '出版社ID',
  `subject_id` char(2) NOT NULL COMMENT '所属学科',
  `grade_id` char(2) NOT NULL COMMENT '所属年级',
  `section_id` char(2) DEFAULT NULL,
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `cover_pic` varchar(128) NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='历史教材表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/ls_edu_book';   

CREATE TABLE `edu_total_book` (
  `id` int(11) NOT NULL COMMENT '编号',
  `book_name` varchar(64) NOT NULL COMMENT '名称',
  `publisher_id` int(11) NOT NULL COMMENT '出版社ID',
  `subject_id` char(2) NOT NULL COMMENT '所属学科',
  `grade_id` char(2) NOT NULL COMMENT '所属年级',
  `section_id` char(2) DEFAULT NULL,
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `cover_pic` varchar(128) NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) 
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='历史教材表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/edu_total_book';   


CREATE TABLE `base_history_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '操作名称',
  PRIMARY KEY (`id`)
)
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='历史教材表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/base_history_action';   


CREATE TABLE `edu_entity_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '0' COMMENT '实体名称',
  PRIMARY KEY (`id`)
)
ENGINE=FEDERATED 
DEFAULT CHARSET=utf8
COMMENT='历史教材表'
CONNECTION='mysql://hhu:hx3edc1qaz@localhost/hx_curriculumn/edu_entity_type';   



/**
 * 
 * 
 * 																						实际表
 * 
 * 
 */ 

/** 操作历史表 */
CREATE TABLE `base_version_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_type` int(11) NOT NULL DEFAULT '0' COMMENT '资源类型,同步、知识点',
  `entity_type` int(11) NOT NULL DEFAULT '0' COMMENT '题目、教案、视频、音频 (0: 说明没对实体数据进行修改)',
  `subject_id` int(11) NOT NULL DEFAULT '0' COMMENT '学科',
  `section_id` int(11) NOT NULL DEFAULT '0' COMMENT '学段',
  `action_id` int(11) NOT NULL DEFAULT '0' COMMENT '所执行的操作',
  `element_id` int(11) NOT NULL DEFAULT '0' COMMENT '具体被操作对象',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户',
  `note` varchar(256) DEFAULT NULL,
  `create_time` varchar(16) NOT NULL DEFAULT '' COMMENT '时间',
  `old_value` varchar(128) NOT NULL DEFAULT '',
  `new_value` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='版本历史';

/** 统计题目修改表 */
CREATE TABLE `stat_source_handler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `gid` varchar(32) NOT NULL DEFAULT '' COMMENT '资源GID',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '执行时间',
  `subject_id` int(11) NOT NULL DEFAULT '0' COMMENT '学科',
  `section_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1:小学，2：初中，3：高中',
  `action` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1.新增，2.修改，3.删除',
  `module_id` int(11) NOT NULL DEFAULT '0' COMMENT '所使用的模块',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='资源去重统计';





/** 导入表 */
CREATE TABLE `setin_exam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exam_code` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `source` varchar(32) NOT NULL DEFAULT '',
  `finish_flag` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否完成',
  `content` text NOT NULL,
  `subject_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '学科ID',
  `section_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '学段',
  `content_copy` text NOT NULL,
  `memo` varchar(256) NOT NULL DEFAULT '' COMMENT '备注',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '版本ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

/** 导入完成状态表 */
CREATE TABLE `setin_exam_complete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setin_exam_id` int(11) NOT NULL DEFAULT '0' COMMENT '入库批次ID',
  `exam_finish` tinyint(3) NOT NULL DEFAULT '0' COMMENT '试卷入库是否完成',
  `tongbu_finish` tinyint(3) NOT NULL DEFAULT '0' COMMENT '同步入库是否完成',
  `zhuanti_finish` tinyint(3) NOT NULL DEFAULT '0' COMMENT '专题入库是否完成',
  PRIMARY KEY (`id`),
  UNIQUE KEY `setin_exam_id` (`setin_exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='入库完成关系表';


/** 入库备份表 */
CREATE TABLE `in_exam_question` (
  `gid` varchar(128) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `source` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`gid`),
  UNIQUE KEY `gid` (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


CREATE TABLE `in_exam_question_index` (
  `gid` varchar(128) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `grade_id` int(6) DEFAULT NULL,
  `source` varchar(32) NOT NULL DEFAULT '',
  `setin_exam_id` int(11) NOT NULL DEFAULT '0' COMMENT '入库时试卷ID',
  PRIMARY KEY (`gid`),
  UNIQUE KEY `gid` (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


/** 修改题目主题、子题表 */
CREATE TABLE `modify_exam_question` (
  `gid` varchar(128) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `column_content` longtext COMMENT '选项内容，如果是选择题，则存在值',
  `objective_answer` varchar(64) DEFAULT NULL,
  `answer` longtext,
  `analysis` longtext NOT NULL COMMENT '解析',
  `image` longtext,
  `source` varchar(50) DEFAULT NULL,
  `question_text` varchar(5000) DEFAULT NULL,
  `modify_count` tinyint(1) NOT NULL DEFAULT '0',
  `setin_exam_id` int(11) NOT NULL DEFAULT '0' COMMENT '入库时试卷ID',
  PRIMARY KEY (`gid`),
  UNIQUE KEY `gid` (`gid`),
  KEY `question_text` (`question_text`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


CREATE TABLE `modify_exam_question_index` (
  `gid` varchar(128) NOT NULL,
  `knowledge_id` varchar(128) DEFAULT NULL,
  `knowledge_text` varchar(512) DEFAULT NULL,
  `zh_knowledge` varchar(128) NOT NULL,
  `difficulty` int(11) NOT NULL,
  `score` float(7,2) NOT NULL DEFAULT '0.00',
  `objective_flag` int(11) NOT NULL,
  `combine_flag` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否是主子题',
  `option_count` int(11) NOT NULL DEFAULT '0',
  `group_count` int(11) DEFAULT NULL,
  `question_type` int(11) NOT NULL DEFAULT '0',
  `question_template` int(11) NOT NULL DEFAULT '0' COMMENT '题目模版',
  `exam_name` varchar(128) DEFAULT NULL,
  `subject_id` int(11) NOT NULL,
  `section_id` tinyint(1) NOT NULL DEFAULT '0' COMMENT '学段ID',
  `grade_id` int(6) DEFAULT NULL,
  `source` varchar(32) NOT NULL DEFAULT '',
  `modify_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `setin_exam_id` int(11) NOT NULL DEFAULT '0' COMMENT '入库时试卷ID',
  `time` varchar(16) DEFAULT NULL COMMENT '时长',
  `keyword` varchar(128) NOT NULL DEFAULT '' COMMENT '关键字',
  `setin_type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1：新入库，2：产品库修改',
  PRIMARY KEY (`gid`),
  UNIQUE KEY `gid` (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


CREATE TABLE `modify_sub_exam_question` (
  `gid` varchar(128) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `column_content` longtext COMMENT '选项内容，如果是选择题，则存在值',
  `objective_answer` varchar(64) DEFAULT NULL,
  `answer` longtext,
  `analysis` longtext NOT NULL COMMENT '解析',
  `image` longtext,
  `source` varchar(50) DEFAULT NULL,
  `question_text` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


CREATE TABLE `modify_sub_exam_question_index` (
  `gid` varchar(50) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `objective_flag` int(11) NOT NULL,
  `option_count` int(11) DEFAULT NULL,
  `question_type` varchar(50) NOT NULL,
  `question_template` int(11) NOT NULL DEFAULT '0' COMMENT '题目模版',
  `exam_name` varchar(128) DEFAULT NULL,
  `source` longtext,
  `parent_gid` varchar(128) NOT NULL DEFAULT '0' COMMENT '主子题的父ID',
  `setin_exam_id` int(11) NOT NULL DEFAULT '0' COMMENT '入库时试卷ID',
  `knowledge_id` varchar(128) DEFAULT NULL,
  `knowledge_text` varchar(512) DEFAULT NULL,
  `time` varchar(16) DEFAULT NULL COMMENT '时长',
  `keyword` varchar(128) NOT NULL DEFAULT '' COMMENT '关键字',
  `difficulty` int(11) NOT NULL,
  `sub_index` int(11) NOT NULL,
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;





/** 语文  章节、单元、知识点、专题及各关系表 */

CREATE TABLE  IF NOT EXISTS `yw_edu_chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_name` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '章节名，来自志鸿单元',
  `chapter_index` int(11) DEFAULT NULL COMMENT '章节排序号',
  `book_id` int(11) NOT NULL DEFAULT '0' COMMENT '教材编号',
  `unit_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属单元ID',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='章节';


CREATE TABLE  IF NOT EXISTS `yw_edu_chapter2question` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	  `chapter_id` int(11) NOT NULL DEFAULT '0' COMMENT '章节ID',
	  `question_id` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '0' COMMENT '题目ID',
	  PRIMARY KEY (`id`),
	  KEY `chapter_id` (`chapter_id`),
	  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';


CREATE TABLE  IF NOT EXISTS `yw_edu_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL COMMENT '教材ID',
  `unit_name` varchar(500) DEFAULT NULL COMMENT '单元名称',
  `unit_index` tinyint(3) DEFAULT NULL COMMENT '单元索引顺序',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4033 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


CREATE TABLE IF NOT EXISTS `yw_edu_knowledge` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `yw_edu_knowledge2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `knowledge_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  KEY `chapter_id` (`knowledge_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';

CREATE TABLE IF NOT EXISTS `yw_edu_zhuanti` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  `cover_pic` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `yw_edu_zhuanti2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zhuanti_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `knowledge_id` (`zhuanti_id`,`question_id`),
  KEY `chapter_id` (`zhuanti_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';



/** 数学  章节、单元、知识点、专题及各关系表 */

CREATE TABLE  IF NOT EXISTS `sx_edu_chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_name` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '章节名，来自志鸿单元',
  `chapter_index` int(11) DEFAULT NULL COMMENT '章节排序号',
  `book_id` int(11) NOT NULL DEFAULT '0' COMMENT '教材编号',
  `unit_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属单元ID',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',.
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='章节';


CREATE TABLE  IF NOT EXISTS `sx_edu_chapter2question` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	  `chapter_id` int(11) NOT NULL DEFAULT '0' COMMENT '章节ID',
	  `question_id` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '0' COMMENT '题目ID',
	  PRIMARY KEY (`id`),
	  KEY `chapter_id` (`chapter_id`),
	  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';


CREATE TABLE  IF NOT EXISTS `sx_edu_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL COMMENT '教材ID',
  `unit_name` varchar(500) DEFAULT NULL COMMENT '单元名称',
  `unit_index` tinyint(3) DEFAULT NULL COMMENT '单元索引顺序',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4033 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


CREATE TABLE IF NOT EXISTS `sx_edu_knowledge` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `sx_edu_knowledge2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `knowledge_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  KEY `chapter_id` (`knowledge_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';

CREATE TABLE IF NOT EXISTS `sx_edu_zhuanti` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  `cover_pic` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `sx_edu_zhuanti2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zhuanti_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `knowledge_id` (`zhuanti_id`,`question_id`),
  KEY `chapter_id` (`zhuanti_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';



/** 英语  章节、单元、知识点、专题及各关系表 */

CREATE TABLE  IF NOT EXISTS `yy_edu_chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_name` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '章节名，来自志鸿单元',
  `chapter_index` int(11) DEFAULT NULL COMMENT '章节排序号',
  `book_id` int(11) NOT NULL DEFAULT '0' COMMENT '教材编号',
  `unit_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属单元ID',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='章节';


CREATE TABLE  IF NOT EXISTS `yy_edu_chapter2question` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	  `chapter_id` int(11) NOT NULL DEFAULT '0' COMMENT '章节ID',
	  `question_id` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '0' COMMENT '题目ID',
	  PRIMARY KEY (`id`),
	  KEY `chapter_id` (`chapter_id`),
	  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';


CREATE TABLE  IF NOT EXISTS `yy_edu_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL COMMENT '教材ID',
  `unit_name` varchar(500) DEFAULT NULL COMMENT '单元名称',
  `unit_index` tinyint(3) DEFAULT NULL COMMENT '单元索引顺序',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4033 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


CREATE TABLE IF NOT EXISTS `yy_edu_knowledge` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `yy_edu_knowledge2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `knowledge_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  KEY `chapter_id` (`knowledge_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';

CREATE TABLE IF NOT EXISTS `yy_edu_zhuanti` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  `cover_pic` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `yy_edu_zhuanti2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zhuanti_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `knowledge_id` (`zhuanti_id`,`question_id`),
  KEY `chapter_id` (`zhuanti_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';



/** 物理  章节、单元、知识点、专题及各关系表 */

CREATE TABLE  IF NOT EXISTS `wl_edu_chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_name` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '章节名，来自志鸿单元',
  `chapter_index` int(11) DEFAULT NULL COMMENT '章节排序号',
  `book_id` int(11) NOT NULL DEFAULT '0' COMMENT '教材编号',
  `unit_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属单元ID',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='章节';


CREATE TABLE  IF NOT EXISTS `wl_edu_chapter2question` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	  `chapter_id` int(11) NOT NULL DEFAULT '0' COMMENT '章节ID',
	  `question_id` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '0' COMMENT '题目ID',
	  PRIMARY KEY (`id`),
	  KEY `chapter_id` (`chapter_id`),
	  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';


CREATE TABLE  IF NOT EXISTS `wl_edu_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL COMMENT '教材ID',
  `unit_name` varchar(500) DEFAULT NULL COMMENT '单元名称',
  `unit_index` tinyint(3) DEFAULT NULL COMMENT '单元索引顺序',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4033 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


CREATE TABLE IF NOT EXISTS `wl_edu_knowledge` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `wl_edu_knowledge2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `knowledge_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  KEY `chapter_id` (`knowledge_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';

CREATE TABLE IF NOT EXISTS `wl_edu_zhuanti` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  `cover_pic` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `wl_edu_zhuanti2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zhuanti_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `knowledge_id` (`zhuanti_id`,`question_id`),
  KEY `chapter_id` (`zhuanti_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';



/** 化学  章节、单元、知识点、专题及各关系表 */

CREATE TABLE  IF NOT EXISTS `hx_edu_chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_name` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '章节名，来自志鸿单元',
  `chapter_index` int(11) DEFAULT NULL COMMENT '章节排序号',
  `book_id` int(11) NOT NULL DEFAULT '0' COMMENT '教材编号',
  `unit_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属单元ID',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='章节';


CREATE TABLE  IF NOT EXISTS `hx_edu_chapter2question` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	  `chapter_id` int(11) NOT NULL DEFAULT '0' COMMENT '章节ID',
	  `question_id` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '0' COMMENT '题目ID',
	  PRIMARY KEY (`id`),
	  KEY `chapter_id` (`chapter_id`),
	  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';


CREATE TABLE  IF NOT EXISTS `hx_edu_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL COMMENT '教材ID',
  `unit_name` varchar(500) DEFAULT NULL COMMENT '单元名称',
  `unit_index` tinyint(3) DEFAULT NULL COMMENT '单元索引顺序',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4033 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


CREATE TABLE IF NOT EXISTS `hx_edu_knowledge` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `hx_edu_knowledge2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `knowledge_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  KEY `chapter_id` (`knowledge_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';

CREATE TABLE IF NOT EXISTS `hx_edu_zhuanti` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  `cover_pic` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `hx_edu_zhuanti2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zhuanti_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `knowledge_id` (`zhuanti_id`,`question_id`),
  KEY `chapter_id` (`zhuanti_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';



/** 生物  章节、单元、知识点、专题及各关系表 */

CREATE TABLE  IF NOT EXISTS `sw_edu_chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_name` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '章节名，来自志鸿单元',
  `chapter_index` int(11) DEFAULT NULL COMMENT '章节排序号',
  `book_id` int(11) NOT NULL DEFAULT '0' COMMENT '教材编号',
  `unit_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属单元ID',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='章节';


CREATE TABLE  IF NOT EXISTS `sw_edu_chapter2question` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	  `chapter_id` int(11) NOT NULL DEFAULT '0' COMMENT '章节ID',
	  `question_id` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '0' COMMENT '题目ID',
	  PRIMARY KEY (`id`),
	  KEY `chapter_id` (`chapter_id`),
	  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';


CREATE TABLE  IF NOT EXISTS `sw_edu_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL COMMENT '教材ID',
  `unit_name` varchar(500) DEFAULT NULL COMMENT '单元名称',
  `unit_index` tinyint(3) DEFAULT NULL COMMENT '单元索引顺序',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4033 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


CREATE TABLE IF NOT EXISTS `sw_edu_knowledge` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `sw_edu_knowledge2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `knowledge_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  KEY `chapter_id` (`knowledge_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';

CREATE TABLE IF NOT EXISTS `sw_edu_zhuanti` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  `cover_pic` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `sw_edu_zhuanti2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zhuanti_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `knowledge_id` (`zhuanti_id`,`question_id`),
  KEY `chapter_id` (`zhuanti_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';





/** 政治  章节、单元、知识点、专题及各关系表 */

CREATE TABLE  IF NOT EXISTS `zz_edu_chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_name` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '章节名，来自志鸿单元',
  `chapter_index` int(11) DEFAULT NULL COMMENT '章节排序号',
  `book_id` int(11) NOT NULL DEFAULT '0' COMMENT '教材编号',
  `unit_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属单元ID',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='章节';


CREATE TABLE  IF NOT EXISTS `zz_edu_chapter2question` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	  `chapter_id` int(11) NOT NULL DEFAULT '0' COMMENT '章节ID',
	  `question_id` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '0' COMMENT '题目ID',
	  PRIMARY KEY (`id`),
	  KEY `chapter_id` (`chapter_id`),
	  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';


CREATE TABLE  IF NOT EXISTS `zz_edu_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL COMMENT '教材ID',
  `unit_name` varchar(500) DEFAULT NULL COMMENT '单元名称',
  `unit_index` tinyint(3) DEFAULT NULL COMMENT '单元索引顺序',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4033 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


CREATE TABLE IF NOT EXISTS `zz_edu_knowledge` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `zz_edu_knowledge2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `knowledge_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  KEY `chapter_id` (`knowledge_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';

CREATE TABLE IF NOT EXISTS `zz_edu_zhuanti` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  `cover_pic` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `zz_edu_zhuanti2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zhuanti_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `knowledge_id` (`zhuanti_id`,`question_id`),
  KEY `chapter_id` (`zhuanti_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';



/** 地理  章节、单元、知识点、专题及各关系表 */

CREATE TABLE  IF NOT EXISTS `dl_edu_chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_name` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '章节名，来自志鸿单元',
  `chapter_index` int(11) DEFAULT NULL COMMENT '章节排序号',
  `book_id` int(11) NOT NULL DEFAULT '0' COMMENT '教材编号',
  `unit_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属单元ID',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='章节';


CREATE TABLE  IF NOT EXISTS `dl_edu_chapter2question` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	  `chapter_id` int(11) NOT NULL DEFAULT '0' COMMENT '章节ID',
	  `question_id` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '0' COMMENT '题目ID',
	  PRIMARY KEY (`id`),
	  KEY `chapter_id` (`chapter_id`),
	  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';


CREATE TABLE  IF NOT EXISTS `dl_edu_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL COMMENT '教材ID',
  `unit_name` varchar(500) DEFAULT NULL COMMENT '单元名称',
  `unit_index` tinyint(3) DEFAULT NULL COMMENT '单元索引顺序',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4033 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


CREATE TABLE IF NOT EXISTS `dl_edu_knowledge` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `dl_edu_knowledge2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `knowledge_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  KEY `chapter_id` (`knowledge_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';

CREATE TABLE IF NOT EXISTS `dl_edu_zhuanti` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  `cover_pic` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `dl_edu_zhuanti2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zhuanti_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `knowledge_id` (`zhuanti_id`,`question_id`),
  KEY `chapter_id` (`zhuanti_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';



/** 历史  章节、单元、知识点、专题及各关系表 */

CREATE TABLE  IF NOT EXISTS `ls_edu_chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_name` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '章节名，来自志鸿单元',
  `chapter_index` int(11) DEFAULT NULL COMMENT '章节排序号',
  `book_id` int(11) NOT NULL DEFAULT '0' COMMENT '教材编号',
  `unit_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属单元ID',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='章节';


CREATE TABLE  IF NOT EXISTS `ls_edu_chapter2question` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	  `chapter_id` int(11) NOT NULL DEFAULT '0' COMMENT '章节ID',
	  `question_id` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '0' COMMENT '题目ID',
	  PRIMARY KEY (`id`),
	  KEY `chapter_id` (`chapter_id`),
	  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';


CREATE TABLE  IF NOT EXISTS `ls_edu_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL COMMENT '教材ID',
  `unit_name` varchar(500) DEFAULT NULL COMMENT '单元名称',
  `unit_index` tinyint(3) DEFAULT NULL COMMENT '单元索引顺序',
  `visible` tinyint(3) NOT NULL DEFAULT '0' COMMENT '章节对题时的隐藏标识:0可见，1不可见',
  `version_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识体系ID',
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4033 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


CREATE TABLE IF NOT EXISTS `ls_edu_knowledge` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `ls_edu_knowledge2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `knowledge_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  KEY `chapter_id` (`knowledge_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';

CREATE TABLE IF NOT EXISTS `ls_edu_zhuanti` (
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
  `ref_id` int(11) NOT NULL DEFAULT '0' COMMENT '如果是导入数据，此处保存导入前原始ID',
  `cover_pic` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '封面图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1208 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='知识表';

CREATE TABLE IF NOT EXISTS `ls_edu_zhuanti2question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zhuanti_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点ID',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '题目ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `knowledge_id` (`zhuanti_id`,`question_id`),
  KEY `chapter_id` (`zhuanti_id`),
  KEY `qid` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT COMMENT='单元知识关系表';


CREATE TABLE `exam_examination` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(128) NOT NULL COMMENT '名称',
  `exam_type` int(11) NOT NULL COMMENT '1,真题  2,大纲3,新课标',
  `subject_id` int(11) NOT NULL COMMENT '科目ID',
  `section_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '学段ID',
  `grade_id` int(11) NOT NULL COMMENT '年级ID',
  `creat_date` datetime DEFAULT NULL COMMENT '创建日期',
  `creator_id` int(11) DEFAULT NULL COMMENT '创建用户ID',
  `province_id` varchar(6) DEFAULT NULL COMMENT '省市ID 针对 高考 ',
  `city_id` varchar(6) DEFAULT NULL COMMENT '城市 针对 中考',
  `year` varchar(50) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `source` varchar(200) DEFAULT NULL,
  `exam_time` int(11) NOT NULL DEFAULT '0' COMMENT '考试时长，单位为分',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='考卷表';


CREATE TABLE `exam_examination_to_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL DEFAULT '0',
  `question_id` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `index` tinyint(3) NOT NULL DEFAULT '0' COMMENT '题目顺序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='试卷试题表';



