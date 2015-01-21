<?php
//数据基本操作类和各个表类
include_once $CFG ['path'] ['core'] ['model'] . DIRECTORY_SEPARATOR . 'interface' . DIRECTORY_SEPARATOR . 'i_model.php';
include_once $CFG ['path'] ['core'] ['model'] . DIRECTORY_SEPARATOR . 'mdl_db_basic.php';

//include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'xxx.php';

include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_area_province.php';

include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_base_version_history.php';

include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_user_verify.php';

include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_hx_workset.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_hx_workset_source.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_hx_workset_version.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_hx_module.php';

include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_hx_user.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_hx_user_role.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_hx_user_role_privilege.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_hx_user_role_create_privilege.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_hx_user_group.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_hx_user_group_privilege.php';

include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_subject.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_section.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_grade.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_publisher.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_source.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_source_type.php';

include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_year.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_question_type.php';

include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_curriculumn_version.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_curriculumn_version_detail.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_curriculumn_version_active.php';

include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_book.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_unit.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_chapter.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_chapter_to_question.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_knowledge.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_knowledge_to_question.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_zhuanti.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_edu_zhuanti_to_question.php';

include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_setin_exam.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_setin_exam_name.php';


include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_setout_batch.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_setout_batch_detail.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_setout_batch2question.php';


include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_stat_source_duplicate.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_stat_source_handler.php';

include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_exam_examination.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_exam_examination_to_question.php';
include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_exam_question_index.php';

include_once $CFG['path']['core']['model'] . DIRECTORY_SEPARATOR . '0911' . DIRECTORY_SEPARATOR .'tbl_exam_question_index_0911.php';

include_once $CFG['path']['core']['model'] . DIRECTORY_SEPARATOR . '0911' . DIRECTORY_SEPARATOR .'tbl_temp_exam_question_index_0911.php';

include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_temp_exam_question_index.php';

include_once $CFG['path']['core']['model'].DIRECTORY_SEPARATOR.'tbl_template_question.php';
