<?php
//定义常用数据

//科目
$CFG['subject'] = array(
		1=>'yw',//语文
		2=>'sx',
		3=>'yy',
		4=>'wl',
		5=>'hx',
		6=>'sw',
		7=>'dl',
		8=>'ls',
		9=>'zz'
);

$CFG['data'] = array();

$CFG['data'] ['subject'] = $CFG['subject'];

//版本信息
$CFG['data'] ['curriculumn'] = factory::getModel('edu_curriculumn_version')->get_curriculumn_versions();






