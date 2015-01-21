<?php

$userInfo = json_decode($_SESSION['user_info'] , true);

$Views = array();

$Views ['search'] = array ();

$Views ['search'] ['curriculumn_version'] = array ('show' => false);

$Views ['search'] ['subject'] = array ('show'=>false );

$Views ['search'] ['section'] = array ('show'=>false );

$Views ['search'] ['grade'] = array ('show' => false);

$Views ['search'] ['year'] = array ('show'=>false );

$Views ['search'] ['area'] = array ('show'=>false );

$Views ['search'] ['zhenti_flag'] = array ('show'=>false );

$Views ['search'] ['publisher'] = array ('show'=>false );

$Views ['search'] ['book'] = array ('show'=>false );

$Views['search'] ['role'] = array('show'=>false );

$Views['search'] ['workset'] = array('show'=>false );

$Views ['search'] ['curriculumn_version'] ['data'] = factory::getModel('edu_curriculumn_version')->get_curriculumn_versions_visible($userInfo['id']);

$Views ['search'] ['subject'] ['data'] = factory::getModel('edu_subject')->get_subjects_by_control($userInfo['id']);

$Views ['search'] ['section'] ['data'] = factory::getModel('edu_section')->get_sections();

$Views ['search'] ['grade'] ['data'] = factory::getModel('edu_grade')->get_grades();

$Views ['search'] ['year'] ['data'] = factory::getModel('edu_year')->get_years();

$Views ['search'] ['area'] ['data'] = factory::getModel('area_province')->get_provinces();

$Views ['search'] ['publisher'] ['data'] = factory::getModel('edu_publisher')->get_publishers();

$Views ['search'] ['book'] ['data'] = factory::getModel('edu_book')->get_all_books();

$Views['search'] ['role'] ['data'] = factory::getModel('hx_user_role')->get_roles_for_search();

$workset = factory::getModel('hx_workset')->get_worksets_by_control($userInfo['id']);
$Views['search'] ['workset'] ['data'] = $workset['data'];
