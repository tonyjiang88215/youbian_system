<?php
global $History;

$History= array();

$History ['action'] = array(
		'setin' 		=> 1,
		'insert'	=> 2,
		'modify'	=> 3,
		'delete'	=>	4,
		'clear'		=> 5
		
);

$History ['entity'] = array(
		'question'	=> 1,
		'jiaoan'		=> 2,
		'video'			=> 3,
		'audio'			=> 4,
		'unit'			=> 6,
		'chapter'		=> 5,
		'knowledge'	=> 7,
		'zhuanti'		=> 8,
		'exam'			=> 9,
		'book'			=> 10
		
);

$History ['type'] = array(
		'tongbu'		=> 1,
		'knowledge' => 2,
		'zhuanti'		=> 3,
		'exam'			=> 4
);