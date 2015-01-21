<?php
$url = $_SERVER ['PHP_SELF'];
$filename = end ( explode ( '/', $url ) );
$names = explode('_' , $filename);

$Views =array();

$Views ['current_file'] = $filename;
$Views ['names'] = $names ;

$Views ['manage'] = array ();

$userInfo = json_decode($_SESSION['user_info'] , true);

// $_modules = factory::getModel('hx_module')->get_modules();
$_modules = factory::getModel('hx_module')->get_modules_by_control($userInfo['id']);

$maxLevel = 0;

$manageLevelObject = array();

//统计导航层数，并按层重新分类导航元素
foreach($_modules as $k => $_mod){
	$maxLevel = max($maxLevel , $_mod['level']);
	if(!$manageLevelObject[$_mod['level']]){
		$manageLevelObject[$_mod['level']] = array();
	}
	$manageLevelObject[$_mod['level']][] = $_modules[$k];
// 	$manageLevelObject[$_mod['level']][] = array('name'=>$_modules[$k]['name'] , 'link'=>$_modules[$k]['link'] , 'key'=>$_modules[$k]['key'] , 'children'=>array());
	$_modules[$k]['children'] = array();
}

//从末层开始，当每一个元素的指针放到其父类的children里
for($i = $maxLevel ; $i > 1 ; $i--){
	foreach($manageLevelObject[$i] as $ks => $moduleSon){
		foreach($manageLevelObject[$i - 1] as $kp => $moduleParent){
			//如果当前的父ID相等，并且当前ID在允许列表里
			if($moduleParent['id'] == $moduleSon['parent_id']){
				$manageLevelObject[$i - 1][$kp]['children'][$moduleSon['key']] = $manageLevelObject[$i][$ks];
				break;
			}
			
		}
	}
}

$nav = $manageLevelObject;

//只需要第一层的结果集即可
foreach($manageLevelObject as $level => $array){
	if($level == 1){
		foreach($array as $key => $element){
			$Views['manage'] [$element['key']] = $manageLevelObject[$level][$key];
		}
	}
}

// $Views ['manage'] ['user'] = array ( 'name'=>'用户管理' , 'children' =>array());

// $Views ['manage'] ['user'] ['children'] ['member'] = array('name'=>'用户列表' ,  'link'=>'manage_user_member.php');

// $Views ['manage'] ['user'] ['children'] ['group'] = array('name'=>'用户组管理' ,  'link'=>'manage_user_group.php');

// $Views ['manage'] ['user'] ['children'] ['privilege'] = array('name'=>'权限管理' ,  'link'=>'manage_user_privilege.php');


// $Views ['manage'] ['nsource'] = array ( 'name'=>'入库资源管理' , 'children' =>array());

// $Views ['manage'] ['nsource'] ['children'] ['setin'] = array('name'=>'题目入库' ,  'link'=>'manage_nsource_setin.php');

// $Views ['manage'] ['nsource'] ['children'] ['proof'] = array('name'=>'题目校对' ,  'link'=>'manage_nsource_proof.php');


// $Views ['manage'] ['isource'] = array ( 'name'=>'在库资源管理' , 'children' =>array());

// $Views ['manage'] ['isource'] ['children'] ['setin'] = array('name'=>'题目导入' ,  'link'=>'manage_isource_setin.php');

// $Views ['manage'] ['isource'] ['children'] ['duplicate'] = array('name'=>'题目去重' ,  'link'=>'manage_isource_duplicate.php');

// $Views ['manage'] ['isource'] ['children'] ['maintain'] = array('name'=>'题目维护' ,  'link'=>'manage_isource_maintain.php');


// $Views ['manage'] ['base'] = array ( 'name'=>'基础数据管理' , 'children' =>array());

// $Views ['manage'] ['base'] ['children'] ['curriculumn'] = array('name'=>'版本管理' ,  'link'=>'manage_base_curriculumn.php');

// $Views ['manage'] ['base'] ['children'] ['publisher'] = array('name'=>'出版社管理' ,  'link'=>'manage_base_publisher.php');

// $Views ['manage'] ['base'] ['children'] ['unit_chapter'] = array('name'=>'同步教材管理' ,  'link'=>'manage_base_unit_chapter.php');

// $Views ['manage'] ['base'] ['children'] ['zhuanti'] = array('name'=>'专题管理' ,  'link'=>'manage_base_zhuanti.php');

// $Views ['manage'] ['base'] ['children'] ['knowledge'] = array('name'=>'知识点管理' ,  'link'=>'manage_base_knowledge.php');

// $Views ['manage'] ['base'] ['children'] ['question_type'] = array('name'=>'题型管理' ,  'link'=>'manage_base_question_type.php');

// $Views ['manage'] ['setout'] = array ( 'name'=>'数据导出' , 'children' =>array());

// $Views ['manage'] ['setout'] ['children'] ['setout_batch'] = array( 'name'=>'创建更新包' ,  'link'=>'manage_setout_batch.php' );

// $Views ['manage'] ['setout'] ['children'] ['question_setout'] = array ( 'name'=>'题目导出' ,  'link'=>'manage_setout_question.php');

// $Views ['manage'] ['setout'] ['children'] ['exam_setout'] = array ( 'name'=>'试卷导出' ,  'link'=>'manage_setout_exam.php');

// $Views ['manage'] ['setout'] ['children'] ['zhuanti_setout'] = array ( 'name'=>'专题导出' ,  'link'=>'manage_setout_zhuanti.php');

// $Views ['manage'] ['setout'] ['children'] ['tongbu_setout'] = array ( 'name'=>'同步导出' ,  'link'=>'manage_setout_tongbu.php');

// $Views ['manage'] ['stat'] = array ( 'name'=>'统计管理' , 'children' =>array());

// $Views ['manage'] ['stat'] ['children'] ['duplicate'] = array ( 'name'=>'资源去重统计管理' ,  'link'=>'manage_stat_duplicate.php');
// $Views ['manage'] ['setout'] ['children'] ['relation_setout'] = array ( 'name'=>'知识点导出' ,  'link'=>'manage_setout_relation.php');

