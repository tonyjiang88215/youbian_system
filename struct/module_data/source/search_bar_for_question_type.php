<?php

$Views = array();

$Views ['search'] = array ();

$Views ['search'] ['section'] = array ('show'=>false );

$Views ['search'] ['subject'] = array ('show'=>false );

$Views ['search'] ['year'] = array ('show'=>false );

$Views ['search'] ['area'] = array ('show'=>false );

$Views ['search'] ['zhenti_flag'] = array ('show'=>false );

$Views ['search'] ['publisher'] = array ('show'=>false );

$Views ['search'] ['book'] = array ('show'=>false );

$Views ['search'] ['section'] ['data'] = array(
	array('id'=>1 , 'name'=>'小学'),
	array('id'=>2 , 'name'=>'初中'),
	array('id'=>3 , 'name'=>'高中')
);

$Views ['search'] ['subject'] ['data'] = factory::getModel('edu_subject')->get_subjects();

$Views ['search'] ['subject'] ['show'] = true;
