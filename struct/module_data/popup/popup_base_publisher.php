<?php
$Views = array();

$Views['grade'] = factory::getModel('edu_grade')->get_grades();
