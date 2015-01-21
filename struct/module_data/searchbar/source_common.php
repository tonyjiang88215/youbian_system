<?php
include_once 'base.php';

$type = $_GET['type'] ? $_GET['type'] : 2;

if($type == 1){//试卷

	//设置显示内容
	$Views ['search'] ['section'] ['show'] = true;
	$Views ['search'] ['subject'] ['show'] = true;
	$Views ['search'] ['year'] ['show'] = true;
	$Views ['search'] ['area'] ['show'] = true;
	$Views ['search'] ['zhenti_flag'] ['show'] = true;




}else if($type == 2){//同步

	$Views ['search'] ['section'] ['show'] = true;
	$Views ['search'] ['grade'] ['show'] = true;
	$Views ['search'] ['subject'] ['show'] = true;
	$Views ['search'] ['publisher'] ['show'] = true;
	$Views ['search'] ['book'] ['show'] = true;

}else if($type == 3){//专题

	$Views ['search'] ['section'] ['show'] = true;
	$Views ['search'] ['subject'] ['show'] = true;

}else if($type == 4){

	$Views ['search'] ['section'] ['show'] = true;
	$Views ['search'] ['subject'] ['show'] = true;

}else if($type==5){
	$Views ['search'] ['subject'] ['show'] = true;
	$Views ['search'] ['curriculumn_version'] ['show'] = false;
	$Views['search'] ['gid'] ['show'] = true;

}