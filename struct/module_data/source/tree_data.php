<?php
$Views = array();



$treeData = array(
	array(
		'id'=>-0,
		'name'=>'暂无数据',
		'children'=>array(
		)
	)
);

$treeHandler = new tree_handler($treeData);

$Views['type'] = 'js';

if($Views['type'] == 'php'){
	$Views['treeHTML'] = $treeHandler->getTreeRenderHTML();
}else{
	$Views['treeClass'] = 'treeClass';
	$Views['treeGroup'] = 'origin_tree';
}
