<?php
$Views = array();

$Views['batch_array'] = array();

/*

$batch_data = factory::getModel('edu_source')->get_batchs(4,2);

$exam_name = factory::getModel('exam_question_index')->get_exam_names(4,2);

$batch_array = array();

foreach($batch_data as $batch){
	$batch_array[$batch['source']] = array();
}

foreach($exam_name as $k => $name){
	$batch_array[$name['source']][] = $name['exam_name'];
	
}

$Views['batch_array'] = $batch_array;

*/